<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Session;
use Hash;
use auth;

class UserController extends Controller
{
    public $exceptionRoute;
    public $role;
    public $user;

    public function __construct(Role $role, User $user){
        $this->exceptionRoute 	 = 'home';
        $this->role 	         =  $role;
        $this->user 			 =  $user;
    }

    public function index(){
        try{
            $users = $this->user->getAllUsers();
            return view('users.index', compact('users'));
        }catch (\Exception $e) {
            return redirect()->route($this->exceptionRoute)->with('warning', $e->getMessage());
        }
    }

    public function add(Request $request){	 
        //try{
            $this->user->id = $this->cryptString($request->route()->parameter('id'), "d");
            $user = $this->user->getuserDetail($this->user);
            if($request->isMethod('post')){
                $validator = $this->getValidateUsers($this->user, $request->all());
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if($this->user->id == 0){
                    $sucMsg = 'User Successfully Saved !!!';
                    $dangMsg = 'Unable to Save User..! Try Again';
                }else{
                    $sucMsg = 'User Successfully Updated !!!';
                    $dangMsg = 'Unable to Update User..! Try Again';
                }
                $data = $request->only('name', 'email', 'password');
                $data['password'] = !empty($request->password) ? Hash::make($request->password) : $user->password;
                $data['is_active']  = !empty($request->is_active) ? true : false;
                if($this->user->id != 0){
                    $this->user->roles()->sync([$request->only('role_id')]);
                }
                if($newuser = $this->user->saveUser($this->user, $data)){
                    $newuser->roles()->attach($request->role_id);
                    Session::flash('success', $sucMsg);
                    return redirect()->route('user');
                }else{
                    Session::flash('danger', $dangMsg);
                }
            }
            $roles = $this->role->getRolesList();
            return view('users.add', compact('roles', 'user'));
        // }catch (\Exception $e) {
        //     return redirect()->back()->with(['alertclass' => 'alert-warning', 'msg' => $e->getMessage()]);
        // }
    }

    protected function getValidateUsers(User $user, $data){
        $rules = [
            'name'              =>  'required|max:80|regex:/^[a-zA-Z ]*$/',
            'email'             =>  'required|email',
            'password'          =>  !empty($user->id) && empty($data['password']) ? '' : 'required|min:6|required_with:confirm_password|same:confirm_password',
            'role_id'           =>  'required',
            'confirm_password'  =>  !empty($user->id) && empty($data['confirm_password']) ? '' :'required|min:6',
        ];
        $errmsg = [
            'name.required'              =>  'Name is required.',
            'name.regex'                 =>  'Please enter only characters.',
            'name.max'                   =>  'Name can be up to 80 characters long.',
            'email.required'             =>  'Email address is required.',
            'email.email'                =>  'Email address must be a valid email address.',
            'password.required'          =>  'Password is required.',
            'role_id.required'           =>  'Please select role.',
            'password.same'              =>  'Password and confirm password must match.',
            'password.min'               =>  'Password must be at least 6 characters.',
            'confirm_password.required'  =>  'Confirm password is required.',
            'confirm_password.min'       =>  'Confirm password must be at least 6 characters.'
        ];
        return Validator::make($data, $rules, $errmsg);
    }

    public function profile(){
        $users = Auth::user();
        $role = $this->role->getRolewithID($users->id);
        return view('profiles.index', compact('users','role'));
    }
}
