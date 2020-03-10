<?php
namespace Xnocken\Controller;

class SessionController
{
    public function createSession()
    {
        if (!isset($_SESSION["user"])) {
            session_start();
        }
    }

    public static function destroySession()
    {
        $data = [];
        if (isset($_SESSION["user"])) {
            session_destroy();

            $data = [
                'type' => 'success',
                'msg'  => TranslationController::translate('logout.success'),
            ];
        } else {
            $data = [
                'type' => 'error',
                'msg'  => TranslationController::translate('logout.error'),
            ];
        }
    }
}
