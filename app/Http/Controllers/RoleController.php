<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\Module;
use Session;

class RoleController extends Controller
{
    public $exceptionRoute;
    public $module;
    public $role;

    public function __construct(Module $module, Role $role)
    {
        $this->exceptionRoute = 'home';
        $this->module         = $module;
        $this->role           = $role;
    }

    public function index()
    {	
    	try{
	    	$allroles = $this->role->getListOfAllRoles();
	    	return view('roles.index', compact('allroles'));
	    }catch (\Exception $e) {
            return redirect()->route($this->exceptionRoute)->with('warning', $e->getMessage());
        }
    }

    public function add(Request $request)
    {	 
    	try{
            $this->role->id = $this->cryptString($request->route()->parameter('id'), "d");
	        if($request->isMethod('post')){
                $validator = $this->getValidateRole($this->role,$request->all());
	            if ($validator->fails()) {
	                return redirect()->back()->withErrors($validator)->withInput();
	            }
	            $data = $request->only('name', 'slug', 'permissions');
	            $permitData = !empty($request->checked) ? $request->checked : [];
		        foreach ($permitData as $key => $value) {
		            $permitData[$key] = true;
		        }
	            $data['slug']           = Str::slug($request->name);
	        	$data['permissions']    = json_encode($permitData);
	            if($this->role->saveRole($this->role, $data)){
	                Session::flash('success', 'Role Successfully Saved !');
	                return redirect()->route('role');
	            }else{
	                Session::flash('danger', 'Unable to Save Role..! Try Again');
	            }
	        }
	    	$modules = $this->module->getModuleAndMethod();
	    	$role = $this->role->getRoleDetail($this->role);
	    	return view('roles.add', compact('modules', 'role'));
	    }catch (\Exception $e) {
            return redirect()->back()->with(['alertclass' => 'alert-warning', 'msg' => $e->getMessage()]);
        }
    }

    protected function getValidateRole(Role $role, $data){
        $rules = [
            'name' => [
                'required','max:20','regex:/^[a-z0-9A-Z ]*$/',
                Rule::unique($role->getTable())->ignore($role->id)->where(function($query) {
                    $query->where('status', '=', 1);
                }),
            ]
        ];
        $errmsg = [
            'name.required' => 'Role name is required.',
            'name.regex'    => 'Please enter only characters.',
            'name.max'      => 'Role name can be up to 40 characters long.',
            'name.unique'   => 'Role name has been already exist.',
        ];
        return Validator::make($data, $rules, $errmsg);
    }
}
