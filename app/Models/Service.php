<?php

namespace App\Models;
use Config;
use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['sevice_name', 'description', 'quantity','prize', 'discount', 'invoice_id','estimate_id','status'];

    // public function employees()
    // {
    //     return $this->belongsTo('App\Employee','employee_id');
    // }

    public function getAllIServices(){
        return Service::orderBy('id', 'DESC')->where('status', 1)->paginate(Config::get('constant.datalength'));
    }

    public function getServiceList(){
        return Service::where('status',1)->pluck('sevice_name', 'id');
    }

    public function saveServices(Service $service, $data){
        $saveResult = false;
        $saveResult = Service::updateOrCreate(['id' => isset($service->id) ? $service->id : 0], $data);
        return $saveResult;
    }

    public function getServiceDetail(Service $service){
        $serviceDetail = false;
        $serviceDetail = Service::where('id', isset($service->id) ? $service->id : 0)->first();
        return $serviceDetail;
    }

    public function getServiceDetailWithInvId($id){
        $serviceDetail = false;
        $serviceDetail = Service::where('invoice_id', isset($id) ? $id : 0)->get();
        return $serviceDetail;
    }

    public function getServiceDetailWithEstId($id){
        $serviceDetail = false;
        $serviceDetail = Service::where('estimate_id', isset($id) ? $id : 0)->get();
        return $serviceDetail;
    }
}
