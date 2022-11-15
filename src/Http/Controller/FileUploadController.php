<?php

namespace Xoxoday\Fileupload\Http\Controller;

use Config;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Xoxoday\Fileupload\Models\Xofile;
use Xoxoday\Fileupload\Models\Xouser;
use Xoxoday\Sms\Sms;

class FileUploadController extends Controller
{
    // function to add user and file entry in the database and send a OTP sms to the mobile shared in the params
    public function uploadFile(Request $request)
    {
        $params = $request->post();

        if(!isset($params['name'])){
            $params['name'] = '';
        }

        if(!isset($params['email'])){
            $params['email'] = '';
        }
        
        

        if (isset($params['mobile']) && $params['mobile'] != '' && $request->file()) {
            try {
                $user_exist = Xouser::where('mobile', $params['mobile'])->first();
            } catch (QueryException $ex) {
                $reponse_array = array('response' => 'Request Failed');
                echo json_encode($reponse_array);
                die();
            }

            $user_id = '';

            //checking if user exist 
            if ($user_exist) {

                $user_id = $user_exist['id'];
                try {
                    //updating user details
                    $user_result = Xouser::where('mobile', $params['mobile'])->update(['email' => $params['email'], 'name' => $params['name']]);
                } catch (QueryException $ex) {
                    $reponse_array = array('response' => 'Request Failed');
                    echo json_encode($reponse_array);
                    die();
                }
            } else {
                //creating new user
                try {
                    $user_result = Xouser::create([
                        'name' => $params['name'],
                        'email' => $params['email'],
                        'mobile' => $params['mobile'],
                    ]);

                } catch (QueryException $ex) {
                    $reponse_array = array('response' => 'Request Failed');
                    echo json_encode($reponse_array);
                    die();
                }
                $user_id = $user_result['id'];
            }

            $filename = time() . '_' . $request->file->getClientOriginalName();

            $file = explode('.', $filename);

            $ext = $file[1];

            $allowed_ext = Config('xofile.xoallowed_file_types');

            $allowed_ext = explode(',', $allowed_ext);

            $upload_path = Config('xofile.xostorage_folder');

            if (in_array($ext, $allowed_ext)) {

                $response_no = uniqid();

                $file_path = storage_path('app') . $upload_path;

                $otp = $this->generateUniqueNumber(Config('xofile.xostorage_otp_length'));

                try {
                    $file_entry = Xofile::create([
                        'xouser_id' => $user_id,
                        'response_no' => $response_no,
                        'file_name' => $filename,
                        'path' => $file_path,
                        'otp' => $otp,
                        'status' => 0, //default status as pending
                    ]);

                } catch (QueryException $ex) {
                    die('Request Failed');
                }

                if ($file_entry) {
                    $sms = new Sms();

                    $country = Config('xofile.xomobile_country_code');

                    $variables = array(
                        '1' => $otp,
                    );

                    $sms->postSmsRequest($country, $params['mobile'], Config('xofile.sms_message_otp'), $variables);
                    $filePath = $request->file('file')->storeAs($upload_path, $filename);
                    $reponse_array = array('response' => $response_no);
                    echo json_encode($reponse_array);
                    die();
                }

            } else {
                $reponse_array = array('response' => 'File type not allowed');
                echo json_encode($reponse_array);
                die();
            }

        }

        $reponse_array = array('response' => 'Request Failed');
        echo json_encode($reponse_array);
        die();
    }


    //function to generate random n difit OTP 
    private function generateUniqueNumber($length = 4)
    {
        $input = '0123456789'; //Allowed Char List
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)]; //Randonly pick char from the given input list.
            $random_string .= $random_character; //Append picked char to the final code.
        }
        return $random_string;
    }



    //function to verify OTP with respect the response no sent in the API parameters
    public function verifyOtp(Request $request)
    {
        $params = $request->post();

        if (isset($params['response_no']) && $params['response_no'] != '' && isset($params['otp']) && $params['otp'] != '') {
            $response_no_exist = '';
            try {
                $response_no_exist = Xofile::where('response_no', $params['response_no'])->first();
            } catch (QueryException $ex) {
                $reponse_array = array('response' => 'Request Failed');
                echo json_encode($reponse_array);
                die();
            }

            if ($response_no_exist != '') {

                if ($response_no_exist['status'] == 1) {
                    $reponse_array = array('response' => "OTP Already Verified");
                    echo json_encode($reponse_array);
                    die();
                }
                if ($response_no_exist['otp'] == $params['otp']) {
                    $update_status = '';
                    try {
                        $update_status = Xofile::where('response_no', $params['response_no'])->update(['status' => 1]);
                    } catch (QueryException $ex) {
                        $reponse_array = array('response' => 'Request Failed');
                        echo json_encode($reponse_array);
                        die();
                    }

                    if ($update_status != '') {
                        $reponse_array = array('response' => "OTP Verified");
                        echo json_encode($reponse_array);
                        die();
                    }
                }
            }
        }

        $reponse_array = array('response' => 'Request Failed');
        echo json_encode($reponse_array);
        die();
    }

}
