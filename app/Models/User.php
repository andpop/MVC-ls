<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['login', 'password', 'name', 'age', 'description'];

    public static function createUser($login, $password, $name, $age, $description)
    {
        $user = User::create(['login'=>$login,'password'=>$password,'name'=>$name, 'age'=>$age, 'description'=>$description]);
        return $user;
    }

    public static function getUserByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        return $user;
    }

    public static function isUserExists($login)
    {
        $user = User::getUserByLogin($login);

        if ($user) return true;
        return false;
    }

    public static function getUserPassword($login)
    {
        $user = User::where('login', '=', $login)->first();
        return $user->password;
    }

}
