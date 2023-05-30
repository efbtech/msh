@php
$url = URL::to('/');
$general_settings= DB::table('general_setting')->find(1);

$result = $report;


@endphp
@extends('Frontend.layouts.master')
@section('content')

<section style="padding-top: 50px; padding-bottom: 200px;padding-left:150px;padding-right:150px;">
    <div class="row">
        <div class="col">
            <div class="row" style="margin-bottom: 100px; background-color:white;">
                <div class="col items-center " style="background-color:white">
                    <div class="row mt-4">
                        <div class="col"></div>
                        <div class="col text-center">
                            <a class="btn btn-success" href="{{ url('/exam/'.$result['session']['code'].'/download');}}"> Download report</a>
                            <a class="btn btn-success" href="{{ url('/exam/'.$result['session']['code'].'/send-email-pdf');}}"> send report on mail</a>
                        </div>

                    </div>
                    <div class="row" style="margin-top: 50px;margin-bottom: 50px;">
                        <div class="col text-center">
                            <img src="{{ url('/assets/images/main-img.png')}}" alt="profile Pic" height="200" width="200">
                        </div>
                        <div class="col text-center">
                            <h4 style="color:olive"><b>Screen First Report</b></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-center">
                            <h4>{{$result['exam']['title']}}</h4>
                        </div>
                    </div>
                    <hr>

                    <!-- details header -->
                    <div class="row " style="background-color:antiquewhite">
                        <div class="col  text-center ">
                            <h4>Test Detail</h4>
                        </div>
                        <div class="col  text-center">
                            <h4>client Detail</h4>
                        </div>
                    </div>

                    <!-- detail here -->
                    <div class="row">
                        <div class="col">
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>Test Name:</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>{{$result['exam']['title']}}</p>
                                </span>
                            </div>
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>Completed on:</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>Wed, May 10, 2023 6:16 PM</p>
                                </span>
                            </div>
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>Session ID:</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>{{$result['session']['code']}}</p>
                                </span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>Patient :</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>{{$result['user']['name']}}</p>
                                </span>
                            </div>
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>E-Mail:</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>{{$result['user']['email']}}</p>
                                </span>
                            </div>
                            <div class="col" style="margin-left:50px">
                                <span>
                                    <h4><b>IP & Device:</b></h4>
                                </span>
                                <span style="color:green;">
                                    <p>{{$result['ip']}}, Desktop, Windows 10.0, Chrome</p>
                                </span>
                            </div>
                        </div>



                    </div>
                    <hr>
                    <div class="row " style="background-color:antiquewhite">
                        <div class="col  text-center ">
                            <h4>Test Result</h4>
                        </div>

                    </div>

                    <!-- result section -->

                    <div class="row">
                        <div class="col-6">

                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Total Questions:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>{{ $result['exam-info']['totalQuestionCount']}}</h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Answered:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>{{ $result['exam-info']['answered']}}</h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Not Visited:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>{{ $result['exam-info']['notVisted']}}</h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Not Answered:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>{{ $result['exam-info']['notAnswered']}}</h4>
                                </div>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Exam Time:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>30 min</h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Time Taken:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>1 min</h4>
                                </div>
                            </div>
                            <!-- <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Total Weightage:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>10 Point</h4>
                                </div>
                            </div> -->
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Your Weightage:</b></h4>
                                </div>
                                <div class="col">
                                    <h4>{{$result['weight']}} Point</h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col" style="text-align:center;">
                                    <h4><b>Final Result</b></h4>
                                </div>
                                <div class="col ">
                                    
                                    <h3 style="color: <?php echo $result['status'] ?>"><b>{{$result['status']}}</b></h3>
                                   
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-2" style="text-align: center;">
                            <h4>AI Suggestion :</h4>
                        </div>
                        <div class="col" style="text-align: left;">
                            <h4><i>share this auto generated report with your doctor.</i></h4>
                        </div>
                    </div>

                    <div class="row" style="    margin-top: 100px;">
                        <div class="col-8"></div>
                        <div class="col" style="text-align:center">
                            <h4>Authorized By</h4>
                            <span style="color:green">Mastisq.co</span>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col" style="text-align: center;margin-top:100px;">
                            <span><b class="text-danger">*</b> Report Generated from <b>Mastishq.co</b> by <b>{{$result['user']['name']}} </b> on Wed, May 10, 2023 6:17 PM</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>



<!-- <style>
    body {
        width: 100%;
        color: #444;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif
    }

    table {
        width: 100%;
        border: 1px solid transparent
    }

    table {
        border-collapse: collapse
    }

    table,
    th {
        border: 1px solid transparent;
        vertical-align: middle;
        padding: 5px
    }

    td {
        border: 1px solid transparent;
        padding: 5px
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px
    }

    .footer-note {
        padding-top: 10px;
        font-size: 12px
    }

    .logo-block {
        text-align: center;
        width: 30%
    }

    .heading-block {
        text-align: right;
        width: 70%
    }

    .logo {
        height: 35px
    }

    .heading {
        text-align: center;
        background: #dadada;
        font-weight: bold
    }

    .list-item {
        display: block;
        padding: 4px
    }

    .heading-item {
        display: block;
        padding: 4px;
        margin-top: 4px
    }

    .text-center {
        text-align: center
    }

    .uppercase {
        text-transform: uppercase
    }

    .signature-block {
        text-align: center;
        vertical-align: bottom
    }

    .green {
        color: green
    }

    .red {
        color: red
    }

    .w-25 {
        width: 25%
    }

    .w-50 {
        width: 50%
    }

    body {
        text-align: right;

    }

    .list-item {
        text-align: right;
    }

    .heading-item {
        text-align: right;
    }

    .footer-note {
        text-align: right;
    }

    .result-block {
        text-align: right;
    }
</style>


<body>
    <div class="report">
        <table>
            <thead>
                <tr>
                    <th colspan="1" class="logo-block">
                        <img class="logo" src="logo url" alt="Logo" />
                    </th>
                    <th colspan="3" class="heading-block">
                        <h2>Screen First Report</h2>
                        <h3>title name</h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="heading w-50">
                        Test Details
                    </td>
                    <td colspan="2" class="heading w-50">
                        User Details
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="w-50">
                        <span class="heading-item"><strong>Test Name:</strong></span>
                        <span class="list-item">Exam title</span>
                        <span class="heading-item"><strong>Completed on:</strong></span>
                        <span class="list-item">complet at</span>
                        <span class="heading-item"><strong>Session ID:</strong></span>
                        <span class="list-item">id</span>
                        <span class="heading-item"><strong>Test Weightage:</strong></span>
                        <span class="list-item">answere weight(80)</span>
                        <br>
                    </td>
                    <td colspan="2" class="w-50">
                        <span class="heading-item"><strong>Patient :</strong></span>
                        <span class="list-item">user name</span>
                        <span class="heading-item"><strong>E-Mail:</strong></span>
                        <span class="list-item">mohswaseem362@gmail.com</span>
                        <span class="heading-item"><strong>IP & Device:</strong></span>
                        <span class="list-item"> session ip address, device info, os , browser name </span>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="heading">
                        Test Results
                    </td>
                </tr>

                <tr>


                    <td class="w-25">
                        <span class="list-item">value</span>
                    </td>
                    <td class="w-25">
                        <span class="list-item"><strong>key</strong></span>
                    </td>

                    <td class="w-25">
                        <span class="list-item"><strong>key</strong></span>
                    </td>
                    <td class="w-25">
                        <span class="list-item">value</span>
                    </td>


                </tr>

                <tr>

                    <td colspan="2" class="signature-block w-50">Authorized by</td>
                    <td colspan="2" class="w-50 result-block">
                        <br>
                        <h2 class="uppercase red">status</h2>
                        <br>
                        Final Result
                    </td>

                    <td colspan="2" class="w-50 result-block">
                        <br>
                        <h2 class="uppercase green">status</h2>
                        <br>
                        Final Result
                    </td>
                    <td colspan="2" class="signature-block w-50">Authorized by</td>

                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <p class="footer-note">footer</p>
    </footer>
</body> -->


@endsection