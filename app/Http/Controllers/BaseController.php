<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentMail;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BaseController extends Controller
{

    // 1. send success response
    public static function sendRes($msg, $result = '')
    {
        $res = [
            'status' => true,
            'msg'    => $msg,
        ];

        if ($result) {
            $res['data'] = $result;
        }
        return response()->json($res, 200);
    }

    // 2. send error response
    public static function sendErr($err, $errMsg = [], $code = 404)
    {
        $res = [
            'status' => false,
            'msg'    => $err,
        ];

        if (! empty($errMsg)) {
            $res['data'] = $errMsg;
        }
        return response()->json($res, $code);
    }

    // upload file
    public static function upload_file($file, $path = null)
    {
        if ($file) {
            $file_name = Str::random(20) . '.' . $file->extension();
            $path      = 'public/upload/' . $path;
            $file->move($path, $file_name);
            return asset($path . '/' . $file_name);
        }
    }

    // send email
    public static function sendMail($data, $mailClass)
    {
        config([
            'mail.mailers.smtp.transport'  => 'smtp',
            'mail.mailers.smtp.host'       => 'mail.smartmovefinancial.com.au',
            'mail.mailers.smtp.port'       => 465,
            'mail.mailers.smtp.encryption' => 'tls',
            'mail.mailers.smtp.username'   => 'admin@smartmovefinancial.com.au',
            'mail.mailers.smtp.password'   => '@smartmove2024',
            'mail.from.address'            => 'admin@smartmovefinancial.com.au',
            'mail.from.name'               => 'Smart Move Financial',
        ]);
        
        

        if($mailClass == 'AppointmentMail'){
            $client  = Mail::to($data['email'])->send(new AppointmentMail($data));
            $support = Mail::to('info.smartmovefinancial@gmail.com')->send(new AppointmentMail($data));
        }
        elseif($mailClass == 'ContactMail'){
            $client  = Mail::to($data['email'])->send(new ContactMail($data));
            $support = Mail::to('info.smartmovefinancial@gmail.com')->send(new ContactMail($data));
        }
    }
}
