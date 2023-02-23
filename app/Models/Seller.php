<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Config;
use DB;
use File;
use Hash;
use Auth;

class Seller extends Model
{
    use HasFactory;
    protected $fillable = ['image','name', 'email', 'contact', 'address', 'pan', 'lut', 'gst', 'bank_name', 'bank_branch','account_holder', 'bank_account', 'bank_IFSC', 'bank_swift', 'due_day','note'];

    public function getAllSeller(){
        return Seller::orderBy('id', 'ASC')->where('status', 1)->paginate(Config::get('constant.datalength'));
    }

    public function saveSeller(Seller $seller, $data){
        $saveResult = false;
        if (!empty($data['image'])) {
            $saveFile = $data['image']->move(public_path('images/logo'), $data['image']->getClientOriginalName());
            $data['image']   = !empty($data['image']) ? $data['image']->getClientOriginalName() : $oldImg;
        }
        $saveResult = Seller::updateOrCreate(['id' => isset($seller->id) ? $seller->id : 0], $data);
        return $saveResult;
    }
 
    public function getSellerDetail(Seller $seller){
        $sellerDetail = false;
        $sellerDetail = Seller::where('id', isset($seller->id) ? $seller->id : 0)->first();
        return $sellerDetail;
    }
    public function getSellerDetailwithID($id){
        $sellerDetail = false;
        $sellerDetail = Seller::where('id', isset($id) ? $id : 0)->first();
        return $sellerDetail;
    }
}
