<?php

namespace App\Service;


class ActionInstall
{

    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function install()
    {
        if ($this->type !== "all") {

            if ($this->type == "composer") {
                $install = $this->type . " install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs";
            }
            else {
                $install = $this->type . " install";
            }

            return $install;
        }

        else {
            $install1 = "composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs";
            $install2 = "yarn install";

            $install = $install1 . " && " . $install2;

            return $install;
        }
        
    }
}