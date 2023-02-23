<?php

namespace App\Models;

use Illuminate\Http\Request;
use Config;
use Auth;
use DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'permissions'];
    
    public function users(){
        return $this->belongsToMany('App\Models\User', 'role_users');
    }

    public function getRolesList(){
        return Role::orderBy('id', 'ASC')->where('status', 1)->pluck('name', 'id');
    }

    public function getListOfAllRoles(){
        return Role::select(['id', 'name', 'permissions'])->where('status', 1)->orderBy('id', 'ASC')->paginate(Config::get('constant.datalength'));
    }

    public function hasAccess(array $permissions){
        foreach ($permissions as $permission) {
            if($this->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission){
        $permissions = json_decode($this->permissions,true);
        return $permissions[$permission] ?? false;
    }

    public function saveRole(Role $role, $data){
        $saveResult = false;
        $saveResult = Role::updateOrCreate(['id' => isset($role->id) ? $role->id : 0], $data);
        return $saveResult;
    }

    public function getRoleDetail(Role $role){
        $roleDetail = false;
        $roleDetail = Role::where('id', isset($role->id) ? $role->id : 0)->first();
        return $roleDetail;
    }

    public function getRolewithID($id){
        $roleDetail = false;
        $roleDetail = Role::where('id', isset($id) ? $id : 0)->first();
        return $roleDetail;
    }
}
