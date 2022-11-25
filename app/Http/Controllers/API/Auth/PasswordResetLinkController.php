<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Auth\SendPasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetLinkController extends Controller
{
    public function sendPasswordResetEmail(Request $request){
        // If email does not exist
        if(!$this->validEmail($request->email)) {
            return response()->json([
                'message' => 'Email does not exist.'
            ], Response::HTTP_NOT_FOUND);
        } else {
            // If email exists
            $this->sendMail($request->email);
            return response()->json([
                'message' => 'Check your inbox, we have sent a link to reset email.'
            ], Response::HTTP_OK);
        }
    }

    public function sendMail($email){
        $token = $this->generateToken($email);
        Mail::to($email)->send(new SendPasswordResetMail($token));
    }

    public function validEmail($email) {
        return !!User::where('email', $email)->first();
    }

    public function generateToken($email){
        $isOtherToken = DB::table('password_resets')->where('email', $email)->first();
        if($isOtherToken) {
            return $isOtherToken->token;
        }
        $token = Str::random(80);;
        $this->storeToken($token, $email);
        return $token;
    }
    public function storeToken($token, $email){
        DB::table('recover_password')->insert([
            'email' => $email,
            'token' => $token,
            'created' => Carbon::now()
        ]);
    }
}
