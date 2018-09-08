<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['login', 'password', 'name', 'age', 'avatar_path', 'description', 'avatar_path'];

    public static function createUser($login, $password, $name, $age, $description, $avatarPath)
    {
        $user = User::create([
            'login' => $login,
            'password' => $password,
            'name' => $name,
            'age' => $age,
            'description' => $description,
            'avatar_path' => $avatarPath
        ]);
        return $user;
    }

    /**
     * Возвращает объект-пользователя по его логину
     * @param $login
     * @return mixed
     */
    public static function getByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        return $user;
    }

    /**
     * Возвращае id пользователя по его логину
     * @param $login
     * @return int
     */
    public static function getIdByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->id;
        } else {
            return 0;
        };
    }

    public static function isExists($login)
    {
        $user = User::getByLogin($login);

        if ($user) return true;
        return false;
    }

    public static function getPasswordHash($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->password;
        };
        return '';
    }

}
