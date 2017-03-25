<?php
namespace Engine\traits;

trait TException
{
    public function writeToFile ($msg)
    {
        if (!config()->get('app.debug')) {
            return file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/resource/logs', $msg, FILE_APPEND );
        }
        dd($msg);
    }
}