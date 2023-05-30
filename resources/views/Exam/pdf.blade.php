<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $exam['title'] }} Screen First Report</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;1,300&display=swap');
        body {
            width: 100%;
            color: #444;
            font-family: 'Open Sans', sans-serif
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
            /*height: 35px*/
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
            text-align: left;
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
        
    </style>
</head>

<body>
    <div class="report">
        <table>
            <thead>
                <tr>
                    <th colspan="1" class="logo-block">
                        <img class="logo" src="{{ url('/assets/images/pdf/logo.jpg')}}" alt="Logo" />
                    </th>
                    <th colspan="3" class="heading-block">
                        <h2>Screen First Report</h2>
                        <h3>{{ $exam['title'] }}</h3>
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
                        <span class="list-item">{{ $exam['title'] }}</span>
                        <span class="heading-item"><strong>Completed on:</strong></span>
                        <span class="list-item">Wed, May 10, 2023 6:16 PM</span>
                        <span class="heading-item"><strong>Session ID:</strong></span>
                        <span class="list-item">{{ $session['code']}}</span>
                        <br>
                    </td>
                    <td colspan="2" class="w-50">
                        <span class="heading-item"><strong>Patient :</strong></span>
                        <span class="list-item">{{$user['name']}}</span>
                        <span class="heading-item"><strong>E-Mail:</strong></span>
                        <span class="list-item">{{ $user['email']}}</span>
                        <span class="heading-item"><strong>IP & Device:</strong></span>
                        <span class="list-item">{{$ip}}</span>
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
                        <span class="list-item">Total Questions:</span>
                    </td>
                    <td class="w-25">
                        <span class="list-item"><strong>{{$examInfo['totalQuestionCount']}}</strong></span>
                    </td>

                    <td class="w-25">
                        <span class="list-item"><strong>Exam Time:</strong></span>
                    </td>
                    <td class="w-25">
                        <span class="list-item">30 min</span>
                    </td>

                </tr>
                <tr>

                    <td class="w-25">
                        <span class="list-item">Answered:</span>
                    </td>
                    <td class="w-25">
                        <span class="list-item"><strong>{{$examInfo['answered']}}</strong></span>
                    </td>

                    <td class="w-25">
                        <span class="list-item"><strong>Time Taken:</strong></span>
                    </td>
                    <td class="w-25">
                        <span class="list-item">1 min</span>
                    </td>

                </tr>
                <tr>

                    <td class="w-25">
                        <span class="list-item">Not Visited:</span>
                    </td>
                    <td class="w-25">
                        <span class="list-item"><strong>{{$examInfo['notVisted']}}</strong></span>
                    </td>

                    <!-- <td class="w-25">
                        <span class="list-item"><strong>Total Weightage:</strong></span>
                    </td>
                    <td class="w-25">
                        <span class="list-item">10 Point</span>
                    </td> -->

                </tr>
                <tr>

                    <td class="w-25">
                        <span class="list-item">Not Answered:</span>
                    </td>
                    <td class="w-25">
                        <span class="list-item"><strong>{{$examInfo['notAnswered']}}</strong></span>
                    </td>

                    <td class="w-25">
                        <span class="list-item"><strong>Result Weightage:</strong></span>
                    </td>
                    <td class="w-25">
                        <span class="list-item">{{$weight}} Point</span>
                    </td>

                </tr>

                <tr>


                    <td colspan="2" class="w-50 result-block">
                        <br>
                       
                        <h2  class="uppercase" style="color:<?php echo $status ?>"><b>{{$status}}</b></h2>
                        
                        
                        <br>
                        Final Result
                    </td>
                    <td colspan="2" class="signature-block w-50">Authorized by :- Mastishq.co</td>

                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <p class="footer-note">*</b> Report Generated from <b>Mastishq.co</b> by  <b>{{$user['name']}} </b> on Wed, May 10, 2023 6:17 PM</p>
    </footer>
</body>

</html>