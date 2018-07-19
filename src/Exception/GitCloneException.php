<?php

namespace App\Exception;

use Exception;

class GitCloneException extends Exception
{
    public $message;

    public function __construct()
    {
        parent::__construct();
        $this->message = "Error with git clone";
    }

    public function __toString()
    {
        return $this->message;
    }
}

//use App\Exception\GitCloneException;
//catch (GitCloneException $e) {return new JsonResponse(['status' => 'errorException', 'message' => $e->getMessage(),]);}
