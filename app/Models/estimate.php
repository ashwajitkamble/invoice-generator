<?php

namespace App\Models;
use Config;
use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estimate extends Model
{
    use HasFactory;

    protected $fillable = ['estimate_no', 'estimate_date', 'ammount','customer_id', 'seller_id', 'currancy_code','currancy_symbol'];

    public function custemers()
    {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function sellers()
    {
        return $this->belongsTo('App\Models\Seller','seller_id');
    }

    public function getAllEstimateLists(){
        return estimate::orderBy('id', 'DESC')->where('status', 1)->with('custemers')->paginate(Config::get('constant.datalength'));
    }

    public function getEstimateList(){
        return estimate::where('status',1)->pluck('test_name', 'id');
    }

    public function saveEstimate(estimate $estimate, $data){
        $saveResult = false;
        $saveResult = estimate::updateOrCreate(['id' => isset($estimate->id) ? $estimate->id : 0], $data);
        return $saveResult;
    }

    public function getEstimateDetail(estimate $estimate){
        $estimateDetail = false;
        $estimateDetail = estimate::where('id', isset($estimate->id) ? $estimate->id : 0)->first();
        return $estimateDetail;
    }

    public function estimateNo(){
        $estimate = estimate::orderBy('estimate_no', 'DESC')->where('status', 1)->first('estimate_no');
        $no = '001';
        if(!empty($estimate)){
            $no = str_pad($invoiceList->receipt_no + 1, 3, 0, STR_PAD_LEFT);
            // $no = $receiptRecord->receipt_no;
        }
        return $no;
    }

}
