<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizController extends Controller
{
    public function getQuiz(){

         $quizs = Quiz::all();
         return view('new_admin.quiz.list',compact('quizs'));
    }


    public function addQuiz(){

        $questions = Question::all();

        // dd( $questions);

        return view('new_admin.quiz.add',compact('questions'));

    }

    public function createQuiz(Request $request){

         $request->validate([
            'title' => 'required',
            'description' => 'required',
            'questions' => 'required',
            'totaltime' => 'required',

        ]);

        $data = [
            'title' =>$request->title,
            'description' => $request->description,
            'question' => $request->questions,
            'total_duration' => $request->totaltime,
            'is_active' => true,
            'total_questions' => count($request->questions)
        ];

        $quizInfo = Quiz::create($data);

        // check if questions exist
        if(count($request->questions) > 0){
            foreach($request->questions as $questionId){
                QuizQuestion::create([
                    'quiz_id' => $quizInfo->id,
                    'question_id' => $questionId
                ]);
            }
        }
        // QuizQuestion::create([''])

        return redirect()->route('admin.quiz.list')->with('successMessage', 'Details saved successfully!');

        // dd($request->all());

    }
}
