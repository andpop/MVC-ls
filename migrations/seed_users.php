<?php
require_once "config.php";

$faker = Faker\Factory::create();

class User extends Illuminate\Database\Eloquent\Model
{
//    public $login, $password, $name, $age, $description, $created_at;
//    public $login = "1";
//    public $password, $name, $age, $description, $created_at;
//    protected $fillable = ['name', 'password', 'info'];//разрешено редактировать только это, остальное запрещено
//    protected $guarded = ['id']; //запрещено редактировать только это, все остальное разрешено
    //created_at - дата создания
    //update_at - дата последнего редактирования
//    public $timestamps = false;
//    public $table = "users";
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


