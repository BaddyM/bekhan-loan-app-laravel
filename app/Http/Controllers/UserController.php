<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function add_user_index(){
        return view('users.add');
    }

    public function user_accounts_index(){
        return view('users.accounts');
    }

    public function add_user(Request $req){
        $lname = strtolower($req->lname);
        $fname = strtolower($req->fname);
        $username = $lname." ".$fname;
        $email = strtolower($req->email);
        $password = strtolower($req->password);
        $gender = strtolower($req->gender);
        
        info([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'gender' => $gender
        ]);

        $exists = User::where("email",$email)->exists();
        if($exists != 1){
            try{
                User::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'gender' => $gender
                ]);
                $response = "Account Created Successfully";
            }catch(Exception $e){
                info($e);
                $response = "Failed to Add User";
            }
        }else{
            $response = "Account Already Exists!";
        }

        return response($response);
    }

    public function login_user(Request $req)
    {
        $mobile_number = $req->contact;
        $pin = $req->my_user_pin;
        $nin = $req->nin;
        $token = $req->user_token;

        $data = DB::table("loan_users")->where(['contact' => $mobile_number, 'nin' => $nin])->first();

        if (Hash::check($pin, $data->password)) {
            $pin_check = 1;
        } else {
            $pin_check = 0;
        }

        return response()->json([
            'pin' => $pin_check,
            'data' => $data
        ]);
    }

    public function register_user(Request $req)
    {
        $contact = $req->mobile_number;
        $pin = $req->pin;
        $nin = strtolower($req->nin_number);
        $username = strtolower($req->lname_feedback . " " . $req->fname_feedback);
        $current_year = date("Y", strtotime(now()));

        $nin_exists = DB::table("loan_users")->where(['nin' => $nin])->exists();
        $contact_exists = DB::table("loan_users")->where(['contact' => $contact])->exists();

        if ($nin_exists != 1 && $contact_exists != 1) {
            try {
                DB::table('loan_users')->insert([
                    'username' => $username,
                    'contact' => $contact,
                    'nin' => $nin,
                    'password' => Hash::make($pin),
                    'token' => Str::random(16),
                    'created_at' => now()
                ]);

                $user_id = DB::table("loan_users")->select("id")->where(['nin' => $nin])->first();

                DB::table('loans_' . $current_year . '')->insert([
                    'user_id' => $user_id->id,
                    'loan_status' => 'no loan',
                    'loan_limit' => 10000,
                    'created_at' => now()
                ]);
                $response = "Registration SuccessFull";
            } catch (Exception $e) {
                info($e);
                $response = "Registration Failed";
            }
        } else {
            $response = "Account Already Exists!";
        }

        $data = DB::table("loan_users")->select('id', 'username', 'contact', 'nin', 'token')->where(['nin' => $nin])->first();

        return response()->json([
            "response" => $response,
            "data" => $data
        ]);
    }

    public function fetch_support_data()
    {
        $data = DB::table('support')->where('id', 1)->get();
        return response()->json([
            'support' => $data
        ]);
    }

    public function change_user_pin(Request $req)
    {
        $id = $req->user_id;
        $old_user_pin = $req->oldPassword;
        $new_user_pin = $req->newPassword;

        $old_pin = DB::table('loan_users')->select('password')->where('id', $id)->first();

        if (Hash::check($old_user_pin, $old_pin->password)) {
            $response = "Pin Changed Successfully.";
            DB::table("loan_users")->where('id', $id)->update([
                'password' => Hash::make("" . $new_user_pin . "")
            ]);
        } else {
            $response = "Invalid Old Pin!";
        }

        $data = DB::table("loan_users")->select('id', 'username', 'contact', 'nin', 'token')->where(['id' => $id])->first();

        return response()->json([
            'response' => $response,
            'data' => $data
        ]);
    }

    //Upload Loan Documents
    public function upload_documents(Request $req)
    {
        $user_id = $req->user_id;
        $image = $req->file->getClientOriginalName();
        $nin = (DB::table("loan_users")->select('nin')->where('id', $user_id)->first())->nin;
        $new_filename = Str::random(16) . "." . (explode(".", $image)[1]);

        //Check if directory exists
        $dir_exists = file_exists(public_path("assets/images/loan_documents"));

        if ($dir_exists != 1) {
            mkdir(public_path("assets/images/loan_documents"), 0754);
        }

        DB::statement("
            CREATE TABLE IF NOT EXISTS `loan_documents` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `national_id` varchar(255) NOT NULL,
                `personal_photo` varchar(255) DEFAULT NULL,
                `phone_contacts` varchar(255) DEFAULT NULL,
                `phone_details` varchar(255) DEFAULT NULL,
                `sms_details` varchar(255) DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
                )
            ");
        $exists = DB::table('loan_documents')->where("user_id", $user_id)->exists();

        if ($exists != 1) {
            $req->file->move(public_path("assets/images/loan_documents"), $new_filename);
            try {
                DB::table('loan_documents')->insert([
                    'user_id' => $user_id,
                    'national_id' => $new_filename,
                    'created_at' => now()
                ]);
                $response = "Image Added successfully";
            } catch (Exception $e) {
                info($e);
                $response = "Failed to add Image";
            }
        } else {
            $old_image = (DB::table('loan_documents')->select('national_id')->where("user_id", $user_id)->first())->national_id;
            unlink(public_path("assets/images/loan_documents/" . $old_image . ""));
            $req->file->move(public_path("assets/images/loan_documents"), $new_filename);
            try {
                DB::table('loan_documents')->where("user_id", $user_id)->update([
                    'national_id' => $new_filename,
                    'updated_at' => now()
                ]);
                $response = "Document Updated Successfully";
            } catch (Exception $e) {
                info($e);
                $response = "Failed to Update Document!";
            }
        }

        $doc_image = DB::table('loan_documents')->select('national_id')->where("user_id", $user_id)->get();

        return response()->json([
            'response' => $response,
            'image' => $doc_image
        ]);
    }

    public function fetch_user_files(Request $req){
        $user_id = $req->user_id;
        $doc_image = DB::table('loan_documents')->select('national_id')->where("user_id", $user_id)->get();
        return response()->json([
            'image' => $doc_image
        ]);
    }
}
