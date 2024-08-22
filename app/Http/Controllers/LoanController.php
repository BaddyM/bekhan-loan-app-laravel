<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoanController extends Controller
{
    public function get_user_loan_details(Request $req)
    {
        $id = $req->user_id;
        $current_year = date("Y",strtotime(now()));

        $data = DB::table("loans_".$current_year."")->select('username','contact','password','nin')->join('loan_users','loan_users.id',"=","loans_".$current_year.".user_id")->where('user_id',$id)->get();

        $loan_history = DB::table("loans_".$current_year."")->select("loans_".$current_year.".id",'loan_amount','loan_limit','loan_status','loan_balance',"loans_".$current_year.".created_at")->join('loan_users','loan_users.id',"=","loans_".$current_year.".user_id")->where('user_id',$id)->orderBy("loans_".$current_year.".created_at",'desc')->limit(5)->get();

        $loan_status = DB::select("
            SELECT 
                loan_status
            FROM
                loans_".$current_year."
            WHERE
                user_id = ".$id."
            ORDER BY
                created_at
            DESC
            LIMIT 1
        ");
        
        $loan_limit = DB::table("loans_".$current_year."")->select('loan_limit')->join('loan_users','loan_users.id',"=","loans_".$current_year.".user_id")->where(['user_id' => $id])->orderBy("loans_".$current_year.".created_at","desc")->limit(1)->get();

        $loan_balance = DB::table("loans_".$current_year."")->select('loan_balance')->join('loan_users','loan_users.id',"=","loans_".$current_year.".user_id")->where(['user_id' => $id])->orderBy("loans_".$current_year.".created_at","desc")->limit(1)->get();

        $full_loan_history = DB::table("loans_".$current_year."")->select("loans_".$current_year.".id",'loan_amount','loan_limit','loan_status','loan_balance',"loans_".$current_year.".created_at")->join('loan_users','loan_users.id',"=","loans_".$current_year.".user_id")->where('user_id',$id)->orderBy("loans_".$current_year.".created_at",'desc')->get();

        $pending_loan = DB::select("
            SELECT 
                loan_status,
                loan_balance,
                loans_".$current_year.".created_at
            FROM
                loans_".$current_year."
            WHERE
                user_id = ".$id."
            ORDER BY
                created_at
            DESC
            LIMIT 1
        ");

        if(count($pending_loan) > 0){
            foreach($pending_loan as $p){
                $p->created_at = date("D, d M, Y H:i:s", strtotime($p->created_at));
            }
        }

        if(count($data) > 0){
            foreach($data as $d){
                $d->username = strtoupper((explode(" ",$d->username))[0]);
            }
        }

        return response()->json([
            'data' => $data,
            'loan_history' => $loan_history,
            'loan_status' => $loan_status,
            'loan_limit' => $loan_limit,
            'loan_balance' => $loan_balance,
            'full_loan_history' => $full_loan_history,
            'pending_loan' => $pending_loan
        ]);
    }

    public function request_loan(Request $req){
        $id = $req->user_id;
        $loan_amount = $req->loan_amount;
        $loan_limit = $req->loan_limit;
        $current_year = date("Y",strtotime(now()));

        $exists = DB::table("loans_".$current_year."")->where(['user_id' => $id, 'loan_status' => 'reviewing'])->exists();

        if($exists != 1){
            try{
                DB::table("loans_".$current_year."")->insert([
                    'user_id' => $id,
                    'loan_limit' => $loan_limit,
                    'loan_amount' => $loan_amount,
                    'loan_status' => 'reviewing',
                    'created_at' => now()
                ]);
                $response = "Loan Application Successful";
            }catch(Exception $e){
                $response = "Loan Application Failed, Try Again!";
            }
        }else{
            $response = "Loan in Review";
        }

        return response()->json([
            'response' => $response
        ]);
    }

    public function pay_loan(Request $req){
        $id = $req->user_id;
        $suscriber = $req->subscriber;
        $amount = str_replace(",","",$req->amount);
        $number = $req->mobile_number;
        $current_year = date("Y",strtotime(now()));

        DB::statement("
            CREATE TABLE IF NOT EXISTS `pending_payment_".$current_year."` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `amount_paid` int(11) NOT NULL,
                `contact` int(11) NOT NULL,
                `status` varchar(255) NOT NULL,
                `confirmed_by` varchar(255) NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
                )
            ");
        
        $exists = DB::table("pending_payment_".$current_year."")->where([
            'user_id' => $id,
            'status' => 'pending'
        ])->exists();

        if($exists != 1){
            try{
                DB::table("pending_payment_".$current_year."")->insert([
                    'user_id' => $id,
                    'amount_paid' => $amount,
                    'contact' => $number,
                    'status' => 'pending',
                    'created_at' => now()
                ]);
                $response = "Payment Pending!";
            }catch(Exception $e){
                $response = "Payment Failed!";
                info($e);
            }
        }else{
            $response = "Payment awaiting Confirmation!";
        }

        return response()->json([
            'response' => $response
        ]);
    }
}
