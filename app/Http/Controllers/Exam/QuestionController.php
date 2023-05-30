<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\GeneralSetting;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function getQuestions()
    {

        // $newsletters=NewsLetter::all();
        $questions = Question::all();
        // dd($newsletters);
        return view('new_admin.question.list', compact('questions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addQuestion()
    {
        return view('new_admin.question.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createQuestion(Request $request)
    {
        // dd($request->all());
        $validated =  $request->validate(
            [
                'question' => 'required',
                'option1' => 'required',
                'option2' => 'required',
                'option3' => 'required',
                'option4' => 'required',
                'weight1' => 'required',
                'weight2' => 'required',
                'weight3' => 'required',
                'weight4' => 'required',
                'question_weight' => 'required',
                // 'formula_green_less_than' => 'required',
                // 'formula_amber_greater_than' => 'required',
                // 'formula_amber_less_than' => 'required',
                // 'formula_red_greater_than' => 'required',
            ]

        );

        // $wCount = $request->weight1 + $request->weight2 + $request->weight3 + $request->weight4;
        // $general = GeneralSetting::first();
        // if ($wCount > $general->question_weight ||  $wCount < $general->question_weight) {
        //     return back()->withErrors(['msg' => 'count of all weightage should not be less than or grater from 10']);
        // }

        $option = [
            'opt1' => $request->option1,
            'opt2' => $request->option2,
            'opt3' => $request->option3,
            'opt4' => $request->option4,
        ];

        $weight = [
            'weight1' => $request->weight1,
            'weight2' => $request->weight2,
            'weight3' => $request->weight3,
            'weight4' => $request->weight4,
        ];

        $formula = array(
            'formula_green_less_than' => $request->formula_green_less_than,
            'formula_amber_greater_than' => $request->formula_amber_greater_than,
            'formula_amber_less_than' => $request->formula_amber_less_than,
            'formula_red_greater_than' => $request->formula_red_greater_than,
        );

        $data = array(
            'question' => $request->question,
            'question_type_id' => 1,
            'options' => $option,
            'default_time' => $request->time,
            'is_active' => true,
            'ans_weight' => $weight,
            'question_weight' => $request->question_weight,
            // 'formula'  => $formula
        );



        Question::create($data);

        return redirect()->route('admin.question.list')->with('successMessage', 'Details saved successfully!');
    }
}
