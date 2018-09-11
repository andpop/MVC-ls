<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once "config.php";

Capsule::schema()->dropIfExists('files');

Capsule::schema()->create('files', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->string('file_path'); //varchar 255
    $table->timestamps(); //created_at&updated_at тип datetime
});
//=========================
