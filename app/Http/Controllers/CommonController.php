<?php

namespace App\Http\Controllers;

use Helpers;
use Mail;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{
    public function check_access(Request $request){
        // $found_key = array_search("32", array_column($_SESSION['rapidx_user_accesses'], 'module_id')); // * 32 is the id of this module on RAPIDX
        // $found_key = in_array("32", array_column($_SESSION['rapidx_user_accesses'], 'module_id')); // * 32 is the id of this module on RAPIDX
        // return $found_key;
        // if($found_key == ""){
        if(!in_array("32", array_column($_SESSION['rapidx_user_accesses'], 'module_id'))){
            return response()->json(['msg' => 'User Dont Have Access', 'access' => $_SESSION['rapidx_user_accesses']], 401);
        }
        else{
            $user_system_access_check = DB::connection('mysql')->table('user_accesses')
            ->where('rapidx_emp_no', $_SESSION['rapidx_user_id'])
            ->whereNull('deleted_at')
            ->select('*')
            ->first();

            // return $user_system_access_check;

            if($user_system_access_check != ""){
                $exploded_category =  explode(",", $user_system_access_check->category_id);

                $uAccessArray = [];
                for ($i=0; $i <count($exploded_category) ; $i++) {
                    array_push($uAccessArray, $exploded_category[$i]);
                }

                $encrypt_id = Helpers::encryptId($user_system_access_check->id);

                return response()->json([
                    'uAccess' => $uAccessArray,
                    'uName' => $_SESSION['rapidx_name'],
                    'appid' => $encrypt_id,
                    'uType' => $user_system_access_check->user_type,
                    'isAuth' => $user_system_access_check->is_auth ]);
            }
            else{
                return response()->json(['msg' => 'User Dont Have Access '], 401);

            }


        }
    }

    public function decryptVariable(Request $request){
        
    }
    public function decrypt_id(Request $request){
        return Helpers::decryptId($request->Id);
    }

    public function send_mail($mail_filename, $data, $request, $admin_email, $user_email, $subject){
        Mail::send("mail.{$mail_filename}", $data, function($message) use ($request, $admin_email, $user_email, $subject){
            $message->to($admin_email);
            $message->cc($user_email);
            $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('iggarcia@pricon.ph');
            $message->subject($subject);
        });
    }
}
