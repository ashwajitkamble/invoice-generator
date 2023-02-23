<?php

namespace App\Models;
use Config;
use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceList extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_no', 'invoice_date', 'ammount','customer_id', 'seller_id', 'currancy_code','currancy_symbol'];

    public function custemers()
    {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function sellers()
    {
        return $this->belongsTo('App\Models\Seller','seller_id');
    }

    public function getAllInvoiveLists(){
        return InvoiceList::orderBy('id', 'DESC')->where('status', 1)->with('custemers')->paginate(Config::get('constant.datalength'));
    }

    public function getInvoiceList(){
        return InvoiceList::where('status',1)->pluck('test_name', 'id');
    }

    public function saveInvoiceList(InvoiceList $invoiceList, $data){
        $saveResult = false;
        $saveResult = InvoiceList::updateOrCreate(['id' => isset($invoiceList->id) ? $invoiceList->id : 0], $data);
        return $saveResult;
    }

    public function getInvoiceListDetail(InvoiceList $invoiceList){
        $invoiceListDetail = false;
        $invoiceListDetail = InvoiceList::where('id', isset($invoiceList->id) ? $invoiceList->id : 0)->first();
        return $invoiceListDetail;
    }

    public function invoiceNo(){
        $invoiceList = InvoiceList::orderBy('invoice_no', 'DESC')->where('status', 1)->first('invoice_no');
        $no = '001';
        if(!empty($invoiceList)){
            $no = str_pad($invoiceList->receipt_no + 1, 3, 0, STR_PAD_LEFT);
            // $no = $receiptRecord->receipt_no;
        }
        return $no;
    }

    
}
