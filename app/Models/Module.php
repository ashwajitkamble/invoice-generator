<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function submodules()
    {
        return $this->hasMany('App\Models\Module', 'parent');
    }

    public function methods(){
    	return $this->hasMany('App\Models\Method');
    }

    public function getModuleAndMethod()
    {
        return Module::select(['id','name','parent'])
                    ->with(['submodules:id,name,parent','submodules.methods:id,module_id,route_name,display_name,published'])
                    ->where('parent',0)->get();
    }
}
