<?php

namespace App\Service;


class CloneDirectory
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function clonePimDirectory()
    {
        $clone = sprintf('git clone git@github.com:%s.git', $this->repository);

        return $clone;
    }
}