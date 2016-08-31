<?php

namespace App\Exception;

use App\Entity\Token;
use Slim\Http\Request;
use Slim\Http\Response;

class UnknownCredentialsException extends \Exception {}