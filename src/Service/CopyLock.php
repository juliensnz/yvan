<?php

namespace App\Service;


class CopyLock
{

    private $repository;
    private $type;

    public function __construct($type, $repository)
    {
        $this->type = $type;
        $this->repository = $repository;
    }

    public function copy()
    {
        if ($this->type !== "all") {

            $copy = " && cp " . $this->type . ".lock ../../public/lock/" . $this->repository;
            return $copy;
        }

        else {
            $copy1 = " && cp " . "composer.lock ../../public/lock/" . $this->repository;
            $copy2 = " && cp " . "yarn.lock ../../public/lock/" . $this->repository;

            $copy = $copy1 . $copy2;

            return $copy;
        }

    }
}