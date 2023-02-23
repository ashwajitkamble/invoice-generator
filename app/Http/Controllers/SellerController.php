<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Seller;

use Session;
use Hash;
use auth;

class SellerController extends Controller
{
    public $exceptionRoute;
    public $role;
    public $user;
    public $seller;

    public function __construct(Role $role, User $user, Seller $seller){
        $this->exceptionRoute 	 = 'home';
        $this->role 	         =  $role;
        $this->user 			 =  $user;
        $this->seller 			 =  $seller;
    }

    public function index(){
        try{
            $seller = $this->seller->getAllSeller();
            return view('sellers.index', compact('seller'));
        }catch (\Exception $e) {
            return redirect()->route($this->exceptionRoute)->with('warning', $e->getMessage());
        }
    }

    public function add(Request $request){	 
        //try{
            $this->seller->id = $this->cryptString($request->route()->parameter('id'), "d");
            if(!empty($this->seller->id)){
                $sucMsg  = 'Seller List Successfully Updated !!!';
                $dangMsg = 'Unable to Updated Seller..! Try Again';
            }else{
                $sucMsg  = 'Seller Successfully Created !!!';
                $dangMsg = 'Unable to Saved Seller..! Try Again';
            }
            if($request->isMethod('post')){
                $validator = $this->getValidateSellers($this->seller, $request->all());
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $data   = $request->only('image' ,'name', 'email', 'contact', 'address', 'pan', 'lut', 'gst', 'bank_name', 'bank_branch','account_holder', 'bank_account', 'bank_IFSC', 'bank_swift','due_day', 'note');
                //Customers
                $saveData = $this->seller->saveSeller($this->seller, $data);
                if($saveData){
                    Session::flash('success', $sucMsg);
                    return redirect()->route('seller');
                }else{
                    Session::flash('danger', $dangMsg);
                }
            }
            $seller = $this->seller->getSellerDetail($this->seller);         
            return view('sellers.add', compact('seller'));
        // }catch (\Exception $e) {
        //     return redirect()->back()->with(['alertclass' => 'alert-warning', 'msg' => $e->getMessage()]);
        // }
    }

    protected function getValidateSellers(Seller $seller, $data){
        $rules = [
            'name'              =>  'required|max:80|regex:/^[a-zA-Z ]*$/',
        ];
        $errmsg = [
            'name.required'              =>  'Name is required.',
            'name.regex'                 =>  'Please enter only characters.',
            'name.max'                   =>  'Name can be up to 80 characters long.',
        ];
        return Validator::make($data, $rules, $errmsg);
    }
        
}
