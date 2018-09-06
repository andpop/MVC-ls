<?php
require_once "config.php";

$faker = Faker\Factory::create();

class User extends Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['login', 'name', 'password', 'age', 'description'];//разрешено редактировать только это, остальное запрещено
    protected $table = 'users';
}

for($i=0;$i<30;$i++)
{
    $user = new User();
    $user->login = $faker->userName;
    $user->password = $faker->password;
    $user->name = $faker->name;
    $user->age = $faker->numberBetween(1, 120);
    $user->description = $faker->text;
    $user->created_at = $faker->dateTime;
    $user->save();
}


