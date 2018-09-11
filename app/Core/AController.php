<?php
namespace App\Core;

abstract class AController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

}