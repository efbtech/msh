<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Mockery\Undefined;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use DB;

class HandleRedirectController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->email)) {
            $email = $request->email;
        }
        if (!empty($request->fname)) {
            $firstName = $request->fname ?? "";
        }
        if (!empty($request->lname)) {
            $lastName = $request->lname ?? "";
        }


        $userTable = User::where('email', $email)->first();

        if ($userTable) {
            $loginUser = $this->loginAttamp($email, 'password');
            return view('redirected-user', compact('loginUser'));
        }


        if (is_null($userTable)) {
            // register here 
            $loginUser =  $this->registerRedirectedUser($email, 'password', $firstName, $lastName);
            return view('redirected-user', compact('loginUser'));
        }
    }

    public function loginAttamp($email, $password)
    {


        $postData = '{
            "role": "Mentee",
            "email": "' . $email . '",
            "password": "' . $password . '"
            }';

        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://nictus.qwiktest.test/api/login-email',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        } catch (\Exception $e) {
            dd($e);
        }

        //if success 
        $resArr = json_decode($response, true);
        // dd($resArr);
        if ($resArr['success'] ==  true) {
            $firstName = $resArr['data']['user']['first_name'] ?? "";
            $lastName = $resArr['data']['user']['last_name'] ?? "";
            $fullName = $firstName . '' . $lastName;
            $user = [
                'role' => 'Mentee',
                'image' =>  $resArr['data']['user']['image_path'],
                'name' => $fullName,
                'user_id' => $resArr['data']['user']['id'],
                '_token' => '123',
                'AccessToken' => $resArr['AccessToken']
            ];

            return json_encode($user);

            // echo "<script>document.write(localStorage.setItem('User', '" . json_encode($user, true) . "'))</script>";
        }
    }


    public function registerRedirectedUser($email, $password, $firstName, $lastName)
    {
        $requestData = '{
            "role": "Mentee",
            "email": "' . $email . '",
            "password": "' . $password . '",
            "password_confirmation": "' . $password . '",
            "fb_id": "",
            "first_name": "' . $firstName . '",
            "last_name": "' . $lastName . '"
        }';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://nictus.qwiktest.test/api/signup-email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $requestData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $resArr = json_decode($response, true);
        // dd($resArr);
        if ($resArr['success'] ==  true) {
            $user = [
                'role' => 'Mentee',
                'user_id' => $resArr['data']['user']['id'],
                '_token' => '123',
                'AccessToken' => $resArr['AccessToken']
            ];

            // $rr =  "<script>document.write(localStorage.setItem('User', '" . json_encode($user, true) . "'))</script>";
            // echo $rr == 'undefined' ? 'please wait...' : 'please wait ...';
            // return json_encode(['success' => true, 'status' => 201], true);
            return json_encode($user);
        };
    }

    public function openQuiktest(Request $request)
    {

        $user = User::where('id', $request->userId)->first();
        //  window.location.href = "http://qwiktest.test/redirect-qwiktest?email=student1@yopmail.com"; //+response.data.data.user.email
        // $url = 'http://qwiktest.test/redirect-qwiktest?email=' . $user->email;
        // return \Redirect::away($url);
        return json_encode($user);
    }

    public function getReportLog(Request $request)
    {

        $user = User::where('id', $request->userId)->first();
        // dd($user);
        $quiktestUser = DB::connection('mysqlqwiktest')->Table('exam_sessions')
        ->where('user_id',$user->qwiktest_user_id)
        ->where('status', '=', 'completed')
        ->latest('completed_at')
        ->limit(5)
        ->get();

        return $quiktestUser;


        //list of given exam 
        // $sessions = ExamSession::with('exam:id,slug,title')
        //     ->where('user_id', auth()->user()->id)
        //     ->where('status', '=', 'completed')
        //     ->paginate(request()->perPage != null ? request()->perPage : 10);
        dd($quiktestUser);
    }
}
