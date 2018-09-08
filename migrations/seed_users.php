<?php
require_once "config.php";

$faker = Faker\Factory::create();

class User extends Illuminate\Database\Eloquent\Model
{
    //разрешено редактировать только это, остальное запрещено
    protected $fillable = ['login', 'password', 'name', 'age', 'avatar_path', 'description'];
    protected $table = 'users';
}

for($i=0;$i<10;$i++)
{
    $user = new User();
    $user->login = $faker->userName;
    $user->password = password_hash('123', PASSWORD_DEFAULT);;
    $user->name = $faker->name;
    $user->age = $faker->numberBetween(1, 120);
    $user->description = $faker->text;
    $user->avatar_path = 'http://mvc/img/avatars/work-1.png';
    $user->created_at = $faker->dateTime;
    $user->save();
}


