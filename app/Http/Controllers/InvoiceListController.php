<?php

namespace App\Http\Controllers;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Services\PayUService\Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Category;
use Session;
use Carbon\Carbon;


use App\Models\InvoiceList;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Seller;


class InvoiceListController extends Controller
{
    public $invoiceList;
    public $service;
    public $customer;
    public $seller;

    public function __construct(InvoiceList $invoiceList, Service $service, Customer $customer, Seller $seller){
        $this->middleware('auth');
        $this->exceptionRoute       = 'dashboard';
        $this->invoiceList          = $invoiceList;
        $this->service              = $service;
        $this->customer             = $customer;
        $this->seller               = $seller;
    }
    public function index(){
        try{
            $invoiceLists = $this->invoiceList->getAllInvoiveLists();
            return view('invoices.index', compact('invoiceLists'));
        }catch (\Exception $e) {
            return redirect()->route($this->exceptionRoute)->with('warning', $e->getMessage());
        }
    }

    public function add(Request $request){
        //try{
            $this->invoiceList->id = $this->cryptString($request->route()->parameter('id'), "d");
            if(!empty($this->invoiceList->id)){
                $sucMsg  = 'Invoice List Successfully Updated !!!';
                $dangMsg = 'Unable to Updated Invoice List..! Try Again';
            }else{
                $sucMsg  = 'Invoice List Successfully Created !!!';
                $dangMsg = 'Unable to Saved Invoice List..! Try Again';
            }
            if($request->isMethod('post')){
                
                $validator = $this->getValidateInvoices($this->invoiceList, $request->all());
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $customer   = $request->only('name','email','contact','address');
                $invoceData = $request->only('invoice_no','invoice_date', 'seller_id','currancy_code',);
                $seviceData = $request->only('sevice_name','description','quantity','prize','discount');
                //Customers
                $code = ['INR'=>'₹','USD'=>'$', 'EUR'=>'€'];
                foreach ($code as $key => $value) {
                    if ($invoceData['currancy_code'] == $key) {
                        
                        $invoceData['currancy_symbol'] = $value ; 
                    }
                }
                $saveCust = $this->customer->saveCustomer($this->customer, $customer);
                if($saveCust){
                    $invoceData['customer_id']  = $saveCust['id'] ;
                    Session::flash('success', $sucMsg);
                    $saveServ = $this->invoiceList->saveInvoiceList($this->invoiceList, $invoceData);
                    if($saveServ){
                        Session::flash('success', $sucMsg);
                        foreach($request->inputs as $key => $value){
                            $value['invoice_id'] = $saveServ['id'];
                            if($this->service->saveServices($this->service, $value)){
                                //Session::flash('success', $sucMsg);
                                
                                //return redirect()->route('invoice');
                            }
                        }
                        
                        return redirect()->route('invoice');
                    }
                    return redirect()->route('invoice');
                }else{
                    Session::flash('danger', $dangMsg);
                }
            }
            $seviceDetail = '';
            $customerDetails = '';
            $seller = $this->seller->getAllSeller();
            $invoiceLists = $this->invoiceList->getInvoiceListDetail($this->invoiceList);
            if ($invoiceLists) {
                $customerDetails = $this->customer->getCustomerDetailWithId($invoiceLists->customer_id);
                $seviceDetail = $this->service->getServiceDetailWithInvId($invoiceLists->id);
            }         
            return view('invoices.add', compact('invoiceLists', 'seviceDetail', 'customerDetails','seller'));
        // }catch (\Exception $e) {
        //     return redirect()->back()->with('warning', $e->getMessage());
        // }
    }

    protected function getValidateInvoices(InvoiceList $invoiceList, $data){
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'inputs.*.sevice_name' => 'required',
        ];
        $errmsg = [
            'name.required'          => 'Customer name is required.',
            'email.required'         => 'Customer email is required.',
            'inputs.*.sevice_name.required'   => 'Service Name is required.',
        ];
        return Validator::make($data, $rules, $errmsg);
    }

    public function generateInvoice(Request $request){
        $this->invoiceList->id = $request->route()->parameter('id');
        $seviceDetail = '';
        $customerDetails = '';
        $invoiceLists = $this->invoiceList->getInvoiceListDetail($this->invoiceList);
        if ($invoiceLists) {
            $customerDetails = $this->customer->getCustomerDetailWithId($invoiceLists->customer_id);
            $seviceDetail = $this->service->getServiceDetailWithInvId($invoiceLists->id);
            $SellerDetail = $this->seller->getSellerDetailwithID($invoiceLists->seller_id);
        } 
              
           // seller
           $client = new Party([
                'name'          => $SellerDetail->name,
                'Address'       => $SellerDetail->address,
                'custom_fields' => [
                    'Email'   => $SellerDetail->email,
                    'PAN'     => $SellerDetail->pan,
                    'LUT No'  => $SellerDetail->lut,
                    'GST No'  => $SellerDetail->gst,
                ],
            ]);
            //buyer
            $customer = new Party([
                'name'          => $customerDetails->name,
                'custom_fields' => [
                    'email'     => $customerDetails->email,
                ],
                
            ]);
            //service
            $items =[];
            foreach ($seviceDetail as $key => $value) {
                $items2 = (new InvoiceItem())
                ->title($value->sevice_name)
                ->description($value->description)
                ->pricePerUnit($value->prize)
                ->quantity($value->quantity)
                ->discount($value->discount);
                $items[] = $items2;
            };

            //Notes
            $notes = [
                'Bank Details:',
                'Bank Name -'. $SellerDetail->bank_name . '',
                'Branch: '.$SellerDetail->bank_branch.'',
                'Beneficiary Name - '.$SellerDetail->account_holder.'',
                'Account Number - '.$SellerDetail->bank_account.'',
                'IFSC Code - '.$SellerDetail->bank_IFSC.'',
                'Swift Code -'. $SellerDetail->bank_swift.'',
                'Notes-'. $SellerDetail->note.'',
            ];
            $notes = implode("<br>", $notes);
            //generate invoice
            $invoice = Invoice::make('Invoice')
            // ability to include translated invoice status
            // in case it was paid
                ->series('TTPL')
                ->sequence($invoiceLists->invoice_no)
                ->serialNumberFormat('{SERIES}-{SEQUENCE}')
                ->seller($client)
                ->buyer($customer)
                ->date(Carbon::create($invoiceLists->invoice_date))
                ->dateFormat('d/m/Y')
                ->payUntilDays($SellerDetail->due_day)
                ->currencySymbol($invoiceLists->currancy_symbol)
                ->currencyCode($invoiceLists->currancy_code)
                ->currencyFormat('{SYMBOL}{VALUE}')
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.')
                ->filename($client->name . ' ' . $customer->name)
                ->addItems($items)
                ->notes($notes)
                ->logo(asset('public/images/logo/'). '/' .$SellerDetail->image)
                // You can additionally save generated invoice to configured disk
                ->save('public');

            $link = $invoice->url();
            // Then send email to party with link

            // And return invoice itself to browser or have a different view
            return $invoice->stream();
    }  
    
    public function downloadInvoice(Request $request){
        $this->invoiceList->id = $request->route()->parameter('id');
        $seviceDetail = '';
        $customerDetails = '';
        $invoiceLists = $this->invoiceList->getInvoiceListDetail($this->invoiceList);
        if ($invoiceLists) {
            $customerDetails = $this->customer->getCustomerDetailWithId($invoiceLists->customer_id);
            $seviceDetail = $this->service->getServiceDetailWithInvId($invoiceLists->id);
            $SellerDetail = $this->seller->getSellerDetailwithID($invoiceLists->seller_id);
        } 
              
           // seller
           $client = new Party([
                'name'          => $SellerDetail->name,
                'Address'       => $SellerDetail->address,
                'custom_fields' => [
                    'Email'   => $SellerDetail->email,
                    'PAN'     => $SellerDetail->pan,
                    'LUT No'  => $SellerDetail->lut,
                    'GST No'  => $SellerDetail->gst,
                ],
            ]);
            //buyer
            $customer = new Party([
                'name'    => $customerDetails->name,
                'custom_fields' => [
                    'email'     => $customerDetails->email,
                ],
            ]);
            //service
            $items =[];
            foreach ($seviceDetail as $key => $value) {
                $items2 = (new InvoiceItem())
                ->title($value->sevice_name)
                ->description($value->description)
                ->pricePerUnit($value->prize)
                ->quantity($value->quantity)
                ->discount($value->discount);
                $items[] = $items2;
            };
            //Notes
            $notes = [
                'Bank Details:',
                'Bank Name -'. $SellerDetail->bank_name . '',
                'Branch: '.$SellerDetail->bank_branch.'',
                'Beneficiary Name - '.$SellerDetail->account_holder.'',
                'Account Number - '.$SellerDetail->bank_account.'',
                'IFSC Code - '.$SellerDetail->bank_IFSC.'',
                'Swift Code -'. $SellerDetail->bank_swift.'',
                'Notes-'. $SellerDetail->note.'',
            ];
            $notes = implode("<br>", $notes);
            //generate invoice
            $invoice = Invoice::make($invoiceLists->type)
            // ability to include translated invoice status
            // in case it was paid
                ->series('TTPL')
                ->sequence($invoiceLists->invoice_no)
                ->serialNumberFormat('{SERIES}-{SEQUENCE}')
                ->seller($client)
                ->buyer($customer)
                ->date(Carbon::create($invoiceLists->invoice_date))
                ->dateFormat('d/m/Y')
                ->payUntilDays($SellerDetail->due_day)
                ->currencySymbol($invoiceLists->currancy_symbol)
                ->currencyCode($invoiceLists->currancy_code)
                ->currencyFormat('{SYMBOL}{VALUE}')
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.')
                ->filename($client->name . ' ' . $customer->name)
                ->addItems($items)
                ->notes($notes)
                ->logo(asset('public/images/logo/'). '/' .$SellerDetail->image)
                // You can additionally save generated invoice to configured disk
                ->save('public');

            $link = $invoice->url();
            // Then send email to party with link

            // And return invoice itself to browser or have a different view
            return $invoice->download();
    }
     
}
