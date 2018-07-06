<?php

namespace App\Service;


class ChangeDirectory
{

    private $path;

    public function __construct($repository)
    {
        $this->path = $repository;
    }

    public function cdWork()
    {
        $cd = "cd ../workdir && ";

        return $cd;
    }


    public function cdPimDirectory()
    {
        $cd = " && cd " . $this->path . " && ";

        return $cd;
    }
}