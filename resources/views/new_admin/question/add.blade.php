<?php

use App\Models\GeneralSetting;

$general = GeneralSetting::first();
?>
@extends('new_admin.layouts.app')

@section('content')

<start-exam-page></start-exam-page>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Question</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Create Question</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Question</h3>
                        <!-- <a href="#" class="btn btn-primary float-sm-right  " role="button" aria-disabled="true">Add Question</a> -->

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- <add-question-form></add-question-form> -->

                        <!-- @if ($errors->any())
                        <div class="alert alert-danger">
                            There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif -->
                        <!-- <div class="row">
                            <h5>Note :-</h5><span style="color:olive;">Total Weightage of per Question :{{$general->question_weight}}</span>
                        </div> -->
                        <form action="{{ route('admin.question.create') }}" method="POST">
                            @csrf

                            <div class="form-group border" style="padding-top: 10px; padding-bottom: 10px;padding-right: 10px; padding-left: 10px;background-color:#DEE2D5;border-color:#ead75a">
                                <label for="exampleFormControlTextarea1" style="color:red"> Question</label>
                                <textarea class="form-control" name="question" id="question" rows="5" placeholder="Type Your Questin Here.."></textarea>
                                @if ($errors->has('question'))
                                <span style="color:red">
                                    <li>{{ $errors->first('question') }}</li>
                                </span>
                                @endif
                                <!-- <hr style="height:1px;border:none;color:#333;background-color:olive;"> -->
                                <!-- <label for="exampleFormControlTextarea1">Default time</label>
                                <input type="number" class="form-control" name="time" value="" placeholder="set time for this question like :- 1 (in minutes)"> -->
                                <br>
                                <label for="question_weight">Question Weight (percent)</label>
                                <input type="number" step="any" class="form-control" name="question_weight" placeholder="set question weight percentage">
                                @if ($errors->has('question_weight'))
                                <span style="color:red">
                                    <li>{{ $errors->first('question_weight') }}</li>
                                </span>
                                @endif
                                <br>

                                <!-- <div class="col-4">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="question_weight"> <span style="color:green">Green</span> - less than</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" step="any" class="form-control" name="formula_green_less_than" value="" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="row">

                                                <div class="col-4">
                                                    <label for="question_weight"> <span style="color:#FFBF00">Amber</span> - greater </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" step="any" class="form-control" name="formula_amber_greater_than" value="" placeholder="">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="question_weight"> Less than</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" step="any" class="form-control" name="formula_amber_less_than" value="" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="question_weight"><span style="color:red">Red</span> - greater</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" step="any" class="form-control" name="formula_red_greater_than" value="" placeholder="">
                                        </div>
                                    </div>
                                </div> -->

                            </div>

                            <div class="border border" style="padding-top: 10px; padding-bottom: 10px;padding-right: 10px; padding-left: 10px;background-color:#DEE2D5;border-color:#ead75a">
                                <div class=" form-group">
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Option 1</label>
                                    <textarea class="form-control" name="option1" id="question" placeholder="option first" rows="3"></textarea>
                                    @if ($errors->has('option1'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('option1') }}</li>
                                    </span>
                                    @endif
                                    <!-- <br> -->
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Weight</label>
                                    <input type="number" class="form-control" name="weight1" placeholder="first option weightage ">
                                    @if ($errors->has('weight1'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('weight1') }}</li>
                                    </span>
                                    @endif
                                    <br>
                                    <hr style="height:1px;border:none;color:#333;background-color:olive;">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Option 2</label>
                                    <textarea class="form-control" name="option2" id="question" rows="3" placeholder="option second"></textarea>
                                    @if ($errors->has('option2'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('option2') }}</li>
                                    </span>
                                    @endif
                                    <!-- <br> -->
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Weight</label>
                                    <input type="number" class="form-control" name="weight2" placeholder="option second weightage">
                                    @if ($errors->has('weight2'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('weight2') }}</li>
                                    </span>
                                    @endif
                                    <br>
                                    <hr style="height:1px;border:none;color:#333;background-color:olive;">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Option 3</label>
                                    <textarea class="form-control" name="option3" id="question" rows="3" placeholder="option third "></textarea>
                                    @if ($errors->has('question'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('question') }}</li>
                                    </span>
                                    @endif
                                    <!-- <br> -->
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Weight</label>
                                    <input type="number" class="form-control" name="weight3" placeholder="option third weightage">
                                    @if ($errors->has('weight3'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('weight3') }}</li>
                                    </span>
                                    @endif
                                    <br>
                                    <hr style="height:1px;border:none;color:#333;background-color:olive;">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Option 4</label>
                                    <textarea class="form-control" name="option4" id="question" rows="3" placeholder="option fourth"></textarea>
                                    @if ($errors->has('question'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('question') }}</li>
                                    </span>
                                    @endif
                                    <!-- <br> -->
                                    <label for="exampleFormControlTextarea1" style="color:darkgreen"> Weight</label>
                                    <input type="number" class="form-control" name="weight4" placeholder="option fourth  weightage">
                                    @if ($errors->has('weight4'))
                                    <span style="color:red">
                                        <li>{{ $errors->first('weight4') }}</li>
                                    </span>
                                    @endif

                                </div>

                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection