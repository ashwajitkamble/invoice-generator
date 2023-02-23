<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Config;
use DB;
use File;
use Hash;
use Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','role_users');
    }

    public function hasAccess(array $permissions){
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)){
                return true;
            }
        }
        return false;
    }

    public function inRole($roleSlug){
        return $this->roles()->where('slug',$roleSlug)->count() >= 1;
    }

    public function getAllUsers(){
       return User::orderBy('id', 'ASC')->where('status', 1)->with('roles')->paginate(Config::get('constant.datalength'));
    }

    public function getUserDetail(User $user){
        $userDetail = false;
        $userDetail = User::where('id', isset($user->id) ? $user->id : 0)->first();
        return $userDetail;
    }

    public function changePassword(User $user, $request){
        $saveResult = false;
        $saveResult = User::where('id', Auth::user()->id)->update(['password' => Hash::make($request['new_password'])]);
        return $saveResult;
    }

    public function saveUser(User $user, $data){
        $saveResult = false;
        $saveResult = User::updateOrCreate(['id' => isset($user->id) ? $user->id : 0], $data);
        return $saveResult;
    }
    
}
