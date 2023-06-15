<?php


namespace App\Services;


use Abrigham\LaravelEmailExceptions\Exceptions\EmailHandler;
use Illuminate\Container\Container;

class SendErrorMailService extends EmailHandler
{

    public static function manualSend(\Exception $exception){
        $mailClass = (new self(new Container()));
        if($mailClass->shouldMail($exception)){
            $mailClass->mailException($exception);
        }
    }

}
