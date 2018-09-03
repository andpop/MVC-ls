<?php
namespace App\Models;

class User
{
    public function __construct()
    {
        echo "New object User\n";
    }

    public function getData()
    {
        echo "Getting user data from DB\n";
    }
}
