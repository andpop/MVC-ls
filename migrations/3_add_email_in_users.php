<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once "config.php";

Capsule::schema()->table('users', function (Blueprint $table) {
    $table->string('email');
});


//=========================
