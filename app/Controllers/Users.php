<?php
namespace App\Controllers;

use App\Core\AController;

class Users extends AController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        echo "Saving user \n";
    }
}