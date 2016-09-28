<?php

namespace App\View\Mail;

class ForgotPasswordMail {
    public static function parse($url, $token, $username) {
        $link = $url . $token;

        return <<<EOT
Geachte $username,

Hierbij de link waarmee u uw wachtwoord voor Tour Buzz dashboard kan resetten.

$link

Op deze mail kunt u niet reageren.

Tour Buzz

EOT;

    }
}