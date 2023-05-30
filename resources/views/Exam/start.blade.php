@php
$url = URL::to('/');
$general_settings= DB::table('general_setting')->find(1);

$exam_id = $examId ;
$exam = $exam ;

@endphp

@extends('Frontend.layouts.master')
@section('content')
<start-exam-page url={{$url}} address="{{$general_settings->address}}"
    phone="{{$general_settings->phone}}"
    email_text="{{$general_settings->company_email}}"
    facebook_link="{{$general_settings->facebook_link}}"
    twitter_link="{{$general_settings->twitter_link}}"
    linkden_link="{{$general_settings->linkden_link}}"
    about_company="{{$general_settings->about_company}}"
    exam_id = {{$exam_id}}
    total_duration = "{{$exam->total_duration}}"
    total_question = " {{$exam->total_questions}}"
    
    > </start-exam-page>

@endsection