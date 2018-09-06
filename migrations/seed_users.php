<?php
require_once "config.php";

$faker = Faker\Factory::create();

class User extends Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['login', 'name', 'password', 'age', 'description'];//разрешено редактировать только это, остальное запрещено
    protected $table = 'users';
//    protected $guarded = ['id']; //запрещено редактировать только это, все остальное разрешено
    //created_at - дата создания
    //update_at - дата последнего редактирования
//    public $timestamps = false;
//    protected $primaryKey = 'id';
//
//    public function posts()
//    {
//        //users.id == posts.user_id
//        return $this->hasMany('Post', 'user_id', 'id');
//    }
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


