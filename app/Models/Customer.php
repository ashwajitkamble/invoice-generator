<?php

namespace App\Models;
use Config;
use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'contact','address','status'];

    // public function employees()
    // {
    //     return $this->belongsTo('App\Employee','employee_id');
    // }

    public function getAllICustomers(){
        return Customer::orderBy('id', 'DESC')->where('status', 1)->paginate(Config::get('constant.datalength'));
    }

    public function getCustomerList(){
        return Customer::where('status',1)->pluck('test_name', 'id');
    }

    public function saveCustomer(Customer $customer, $custData){
        $saveResult = false;
        $saveResult = Customer::updateOrCreate(['id' => isset($customer->id) ? $customer->id : 0], $custData);
        return $saveResult;
    }

    public function getCustomerDetail(Customer $customer){
        $testDetail = false;
        $testDetail = Customer::where('id', isset($customer) ? $customer : 0)->first();
        return $testDetail;
    }

    public function getCustomerDetailWithId($id){
        $testDetail = false;
        $testDetail = Customer::where('id', isset($id) ? $id : 0)->first();
        return $testDetail;
    }

    
}
