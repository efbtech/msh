<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamQuestion;
use App\Models\ExamSession;
use App\Models\ExamSessionQuestion;
use Carbon\Carbon;
use DB;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Config;
use Mail;

use App\Models\NewsLetter;
use DateTime;
use Svg\Tag\Rect;

class ExamController extends Controller
{

    public function getExam()
    {
        $quizs = Exam::all();
        return view('new_admin.exam.list', compact('quizs'));
    }


    public function addExam()
    {
        $questions = Question::all();
        return view('new_admin.exam.add', compact('questions'));
    }

    public function createExam(Request $request)
    {



        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'questions' => 'required',
            'totaltime' => 'required',

        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'question' => $request->questions,
            'total_duration' => $request->totaltime,
            'is_active' => true,
            'total_questions' => count($request->questions)
        ];

        $examInfo = Exam::create($data);

        // check if questions exist
        if (count($request->questions) > 0) {
            foreach ($request->questions as $questionId) {
                ExamQuestion::create([
                    'exam_id' => $examInfo->id,
                    'question_id' => $questionId,
                    'exam_section_id' => 1
                ]);
            }
        }

        return redirect()->route('admin.exam.list')->with('successMessage', 'Details saved successfully!');
    }

    public function getRandomExam(Request $request)
    {
        $exams = Exam::inRandomOrder()->first();
        return json_encode(['code' => 200, 'data' => $exams]);
    }

    public function ExamInstruction(Request $request, $id)
    {
        $exam = Exam::find($id);
        // dd($exam);
        $examId = $id;
        return view('Exam.start', compact('examId', 'exam'));
    }

    public function ExamInit(Request $request)
    {

        //get current time 
        $now = Carbon::now();

        // $questions = $exam->questions()->withPivot('exam_section_id')->with(['questionType:id,name,code'])->get()->groupBy('pivot.exam_section_id');
        // $sections = $exam->examSections()->orderBy('section_order', 'asc')->get();
        $exam = Exam::where('id', $request->examId)->first();

        if ($exam) {

            $session = ExamSession::create([
                'exam_id' => $request->examId,
                'user_id' =>  $request->userId,
                'starts_at' => $now->toDateTimeString(),
                'ends_at' => $now->addSeconds($exam->total_duration)->toDateTimeString(),
                'status' => 'started'
            ]);
            //  Attach Question to this session
            if ($session) {
                $formattedQuestions = [];
                $qno = 1;
                $nowTime = Carbon::now();
                $ExamQuestionsIds = ExamQuestion::where('exam_id', $exam->id)->get();
                foreach ($ExamQuestionsIds as $eid) {
                    // dd($eid->question_id);
                    $question = Question::where('id', $eid->question_id)->first();
                    if ($question) {
                        $formattedQuestions[$question->id] = [
                            'exam_session_id' => $session->id,
                            'sno' => $qno,
                            'question_id' => $question->id,
                            'original_question' => $question->question,
                            'options' => serialize($question->options),
                            'correct_answer' => '',
                            'status' => 'not_visited',
                            'exam_section_id' => 1,
                            'default_time' => $question->default_time,
                        ];
                        $qno++;
                    }
                }
            }

            DB::transaction(function () use ($formattedQuestions) {
                ExamSessionQuestion::insert($formattedQuestions);
            });

            return $session;
        } else {
            return json_encode(['error' => "exam not found"]);
        }
    }


    public function ExamInitSession($examId, $sessionCode)
    {
        // dd("session started");
        // $session    = ExamSession::where('code',$sessionCode)->first();
        // $questions  = ExamSessionQuestion::where('exam_session_id',$session->id)->get();
        // dd( $session,$questions);
        $code = $sessionCode;
        return view('Exam.initExamSession', compact('code'));
    }

    public function fetchSessionQuestion(Request $request)
    {
        $session    = ExamSession::where('code', $request->sessionCode)->first();
        $questions  = ExamSessionQuestion::where('exam_session_id', $session->id)->get();

        $exam = Exam::find($session->exam_id);
        if (count($questions) > 0) {
            $examInfo = $this->getSessionExamInfo($questions);
            $getQuestion = $this->getQuestionBySN($questions, $request->questionNo);
            return json_encode(['error' => false, 'code' => 200, 'examInfo' => $examInfo, 'fetchQuestion' => $getQuestion, 'exam_time' => $exam->total_duration], true);
        } else {
            return json_encode(['error' => true, 'code' => 404, 'message' => 'No Question Added in this Exam. Please contact to admin'], true);
        }
    }

    public function fetchSessionNextQuestion(Request $request)
    {

        //submit answere 
        $session    = ExamSession::where('code', $request->sessionCode)->first();
        $saveAnswere = ExamSessionQuestion::where(['exam_session_id' => $session->id, 'sno' => $request->questionNo])
            ->update(['user_answer' => serialize($request->answered), 'status' => count($request->answered) == 0 ? 'not_answered' : 'answered']);

        //now fecth next question

        $sno = $request->questionNo + 1;
        $questions  = ExamSessionQuestion::where(['exam_session_id' => $session->id])->get();

        if (count($questions) >= $sno) {

            $examInfo = $this->getSessionExamInfo($questions);
            $getQuestion = $this->getQuestionBySN($questions, $sno);
            return json_encode(['error' => false, 'code' => 200, 'examInfo' => $examInfo, 'fetchQuestion' => $getQuestion, 'examCompleted' => false], true);
        } else {
            $session->status = 'completed';
            $session->completed_at = Carbon::now();
            $session->save();
            $examInfo = $this->getSessionExamInfo($questions);
            return json_encode(['error' => false, 'code' => 200, 'examInfo' => $examInfo, 'examCompleted' => true], true);
        }
    }

    public function getSessionExamInfo($questions)
    {
        $totalQuestionCount = 0;
        $notVistedQuestion = 0;
        $answeredSessionQuestion = 0;
        $notAnsweredSessionQuestion = 0;

        $totalQuestionCount = count($questions);

        foreach ($questions as $question) {
            //count not visited question
            if ($question->status == 'not_visited') {
                $notVistedQuestion = $notVistedQuestion + 1;
            }
            // count answered question
            if ($question->status == 'answered') {
                $answeredSessionQuestion = $answeredSessionQuestion + 1;
            }
            //count not answered question
            if ($question->status == 'not_answered') {
                $notAnsweredSessionQuestion = $notAnsweredSessionQuestion + 1;
            }
        }

        $examInfo = [
            'totalQuestionCount' =>  $totalQuestionCount,
            'notVisted' => $notVistedQuestion,
            'answered' => $answeredSessionQuestion,
            'notAnswered' => $notAnsweredSessionQuestion,
        ];

        return  $examInfo;
    }

    public function getQuestionBySN($questions, $sn)
    {
        //fetch question details
        $question = $questions->where('sno', $sn)->first();

        if ($question) {
            $originalQuestion = $question->original_question;
            $options = unserialize($question->options);
            $questionId = $question->question_id;
            $questionSn = $question->sno;
            return [
                'originalQuestion' => $originalQuestion,
                'options' => $options,
                'questionId' => $questionId,
                'questionSn' => $questionSn
            ];
        }
    }

    public function examSessionThankYou($sessionCode)
    {
        $code = $sessionCode;
        $examSession = ExamSession::where('code', $code)->first();
        $exam =  Exam::find($examSession->exam_id);
        $title =  $exam->title;
        return view('Exam.thanksYou', compact('code', 'title'));
    }

    public function examReport(Request $request, $sessionCode)
    {
        $session    = ExamSession::where('code', $sessionCode)->first();
        $user       = User::find($session->user_id);
        $exam       = Exam::find($session->exam_id);
        $questions  = ExamSessionQuestion::where('exam_session_id', $session->id)->get();
        $examInfo = $this->getSessionExamInfo($questions);
        $calculation = $this->calculateWeight($exam, $questions);


        $report = array(
            'user' => array(
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
            ),
            'session' => array(
                'code' => $session->code,
            ),
            'exam' => array(
                'title' => $exam->title,
                'total-dutation' => $exam->total_duration,
                'total-question' => $exam->total_questions,
            ),
            'exam-info' => $examInfo,
            'ip' => $request->ip(),
            'weight' =>  $calculation['weight'],
            'status' => $calculation['status'],
        );
        // dd($report);
        return view('Exam.examReportGenerate', compact('report'));
    }


    public function examReportDownload(Request $request, $sessionCode)
    {
        $session    = ExamSession::where('code', $sessionCode)->first();
        $user       = User::find($session->user_id);
        $exam       = Exam::find($session->exam_id);
        $questions  = ExamSessionQuestion::where('exam_session_id', $session->id)->get();
        $examInfo = $this->getSessionExamInfo($questions);

        //calculation (red,amber,green)
        $calculation = $this->calculateWeight($exam, $questions);

        $report = array(
            'user' => array(
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
            ),
            'session' => array(
                'code' => $session->code,
            ),
            'exam' => array(
                'title' => $exam->title,
                'total-dutation' => $exam->total_duration,
                'total-question' => $exam->total_questions,
            ),
            'examInfo' => $examInfo,
            'ip' => $request->ip(),
            'weight' =>  $calculation['weight'],
            'status' => $calculation['status'],
        );

        // dd($report);
        $pdf = PDF::loadView('Exam.pdf', $report);
        return $pdf->download("report-{$sessionCode}.pdf"); //stream

    }

    public function examReportSendMailWithPdf(Request $request, $sessionCode)
    {
        $session    = ExamSession::where('code', $sessionCode)->first();
        $user       = User::find($session->user_id);
        $exam       = Exam::find($session->exam_id);
        $questions  = ExamSessionQuestion::where('exam_session_id', $session->id)->get();
        $examInfo = $this->getSessionExamInfo($questions);

        //calculation (red,amber,green)
        $calculation = $this->calculateWeight($exam, $questions);

        $report = array(
            'user' => array(
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
            ),
            'session' => array(
                'code' => $session->code,
            ),
            'exam' => array(
                'title' => $exam->title,
                'total-dutation' => $exam->total_duration,
                'total-question' => $exam->total_questions,
            ),
            'examInfo' => $examInfo,
            'ip' => $request->ip(),
            'weight' =>  $calculation['weight'],
            'status' => $calculation['status'],
        );

        //send reprt by mail 
        $data["email"] = "mohdwaseem@yopmail.com.com";
        $data["title"] = "Attachment mail";
        $data["body"] = "This is Demo";
        // $pdf = PDF::loadView('emails.myTestMail', $data);
       
        // dd($report);
        $pdf = PDF::loadView('Exam.pdf', $report);
        // return $pdf->stream("report-{$sessionCode}.pdf"); //stream

        Mail::send('email.sendReport', $data, function ($message) use ($data, $pdf, $session) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "report-{$session->code}.pdf");
        });
        dd("mail send successfully");
    }


    public function calculateWeight($exam, $questions)
    {

        $config = Config::get('weight.screen_first_weight');

        $totalSumOfAllAnswereWeight = 0;
        $totalSumOfAllQuestionWeight = 0;
        $finalWeight = 0;
        $result = "";

        foreach ($questions as $sessionQuestion) {

            //find question
            $questionWeight = Question::find($sessionQuestion->question_id);
            //fecth given answere by user 
            $userGivenAnswere = unserialize($sessionQuestion->user_answer);
            //check if given answere is_array
            if (is_array($userGivenAnswere)) {
                $userAns = $userGivenAnswere;
                $currentAnswereWeight = 0;
                $ans_mapping = ['option1' => 'weight1', 'option2' => 'weight2', 'option3' => 'weight3', 'option4' => 'weight4'];

                foreach ($userAns as $ua) {
                    $val = $ans_mapping[$ua];
                    // dd($questionWeight->ans_weight[$val]);

                    $currentAnswereWeight = $currentAnswereWeight + $questionWeight->ans_weight[$val];
                }
                $totalSumOfAllAnswereWeight = $totalSumOfAllAnswereWeight + $currentAnswereWeight;

                $finalWeight = $finalWeight + ($totalSumOfAllAnswereWeight * $questionWeight->question_weight);
            } else {
                $userAns = [$userGivenAnswere];
            }
        }

        //calulated according formula
        if ($finalWeight <= $config['green_less_than_equal']) {
            $result = 'green';
        } elseif ($finalWeight > $config['amber_greater_than'] && $finalWeight <= $config['amber_less_than_equal']) {
            $result = 'amber';
        } elseif ($finalWeight > $config['red_greater_than']) {
            $result = 'red';
        }




        return ['status' => $result, 'weight' => $finalWeight];
    }

    // question weight (25) * ans (2)
    // red green amber
    // 0.25% -> 1 , 2 ,3 ,4
    // green(<) amber(<>) red (<) 

    public function getReportLog(Request $request)
    {
        $userId =  $request->userId;
        $session    = ExamSession::where('user_id', $userId)->where('status', 'completed')->latest()->limit(5)->get();
        return json_encode($session);
    }
}
