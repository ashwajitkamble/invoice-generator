@extends('layouts.dash')
@section('title', 'Invoice-Add')  

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<form action="{{ route('invoice-edit', ['id' => isset($invoiceLists->id) ? App\Http\Controllers\Controller::cryptString($invoiceLists->id, 'e') : '']) }}" method="POST"  autocomplete="off" enctype="multipart/form-data">
    @csrf
    @php
        $reqLabel = '<sup class="text-danger">*</sup>'; 
    @endphp
    <div class="card-header">
        <h3 class="card-title"><a href="{{route('invoice')}} " type="button" class="btn btn-block btn-info">Back</a></h3>
    </div>
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Company Details</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Select Company<?php echo $reqLabel; ?></label>
                <select name="seller_id" id="seller_id" class="form-control">
                    <option value="">Select..</option>
                    @if(!empty($seller))
                        @foreach ($seller as $item)
                            <option value="{{$item->id}}"@if(!empty($invoiceLists->seller_id) && $item->id == $invoiceLists->seller_id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    @endif
                  </select>
            </div>
            <div class="col-4">
                @php
                    $code = ['INR'=>'₹','USD'=>'$', 'EUR'=>'€'];
                @endphp
                <label for="">Select Currancy Code<?php echo $reqLabel; ?></label>
                <select name="currancy_code" id="currancy_code" class="form-control">
                    <option value="">Select..</option>
                    @if(!empty($code))
                        @foreach ($code as $key => $item)
                            <option value="{{$key}}"@if(!empty($invoiceLists->currancy_code) && $key == $invoiceLists->currancy_code) selected @endif>{{$key}}</option>
                        @endforeach
                    @endif
                  </select>
            </div>
        </div>
    </div>
    {{-- customer form --}}
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Client Details</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Client Name<?php echo $reqLabel; ?></label>
                <input type="text" name="name" class="form-control" placeholder="name" value="{{ old('name', isset($customerDetails->name) ? $customerDetails->name : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Client Email<?php echo $reqLabel; ?></label>
                <input type="email" name="email" class="form-control" placeholder="email" value="{{ old('email', isset($customerDetails->email) ? $customerDetails->email : '' ) }}">
            </div>
            <div class="col-4">
                <label for="exampleInputEmail1">Client Contact</label>
                <input type="number" name="contact" class="form-control" placeholder="Contact numbers" value="{{ old('contact', isset($customerDetails->contact) ? $customerDetails->contact : '' ) }}">
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1">Client Address</label>
                <textarea class="form-control" id="address" name="address" rows="4" cols="50"value="{{ old('address', isset($customerDetails->address) ? $customerDetails->address : '' ) }}">{{ old('note', isset($customerDetails->address) ? $customerDetails->address : '' ) }}</textarea>
            </div>
        </div>
    </div>
    {{-- invoice form --}}
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Invoice</h2>
        </div>
        @php //invoice number
            $invoiceList = \App\Models\InvoiceList::orderBy('invoice_no', 'DESC')->where('status', 1)->first();
            $no = '00001';
            if(!empty($invoiceList->invoice_no)){
                $no = str_pad($invoiceList->invoice_no + 1, 5, 0, STR_PAD_LEFT);
                // $no = $receiptRecord->receipt_no;
            }
            
        @endphp
        <div class="row">
            <div class="col-4">
                <label for="">Invoice No.</label>
                <input type="text" name="invoice_no" class="form-control" placeholder="Invoice No." value="{{ old('invoice_no', isset($invoiceLists->invoice_no) ? $invoiceLists->invoice_no : $no ) }}" readonly>
            </div>
            <div class="col-4">
                <label for="">Invoice Date<?php echo $reqLabel; ?></label>
                <input type="date" name="invoice_date" class="form-control" placeholder="Invoice Date" value="{{ old('invoice_date', isset($invoiceLists->invoice_date) ? $invoiceLists->invoice_date : '' ) }}">
            </div>
        </div>
    </div>
    {{-- sevices form --}}
    <div class="card-body">
        
        <table id="table">
            <tr>
                <td>
                    <div class="card-header">
                        <h2 class="card-title">sevices</h2>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-4">
                            <label for="">sevices<?php echo $reqLabel; ?></label>
                            <input type="text" name="inputs[0][sevice_name]" class="form-control" placeholder="sevices Name" value="{{ old('inputs[0][sevice_name]', isset($seviceDetail->sevice_name) ? $seviceDetail->sevice_name : '' ) }}">
                        </div>
                        <div class="col-6">
                            <label for="">Description</label>
                            <textarea class="form-control" id="description" name="inputs[0][description]" rows="4" cols="50"value="{{ old('description', isset($seviceDetail->description) ? $seviceDetail->description : '' ) }}">{{ old('note', isset($seviceDetail->description) ? $seviceDetail->description : '' ) }}</textarea>
                        </div>
                        <div class="col-4">
                            <label for="">Hour<?php echo $reqLabel; ?></label><span class="text-danger">(for fix price services select 1)</span>
                            <input type="number" min="1" name="inputs[0][quantity]" class="form-control" placeholder="sevices hour" value="{{ old('quantity', isset($seviceDetail->quantity) ? $seviceDetail->quantity : '' ) }}">
                        </div>
                        <div class="col-4">
                            <label for="">Price<?php echo $reqLabel; ?></label>
                            <input type="number" name="inputs[0][prize]" class="form-control" placeholder="sevices Price" value="{{ old('prize', isset($seviceDetail->prize) ? $seviceDetail->prize : '' ) }}">
                        </div>
                        <div class="col-4">
                            <label for="">Discount in Price<?php echo $reqLabel; ?></label>
                            <input type="number" name="inputs[0][discount]" class="form-control" placeholder="sevices Discount" value="{{ old('discount', isset($seviceDetail->discount) ? $seviceDetail->discount : '' ) }}">
                        </div>  
                    </div>
                </td>
                <td><button id="add" class="btn btn-info "type="button">Add</button></td>
            </tr>
            <br><br>
        </table>
        
        <div class="card-footer">
            <button  class="btn btn-success "type="submit">Submit</button>
            <button  class="btn btn-dark "type="reset">Cancel</button>
        </div>
    </div>
</form>

<script>
    var i=0;
    $('#add').click(function(){
        ++i;
        $('#table').append(
            `   <tr>
                    <td>
                        <div class="row">
                        <div class="col-4">
                            <label for="">sevices<?php echo $reqLabel; ?></label>
                            <input type="text" name="inputs[`+i+`][sevice_name]" class="form-control" placeholder="sevices Name" value="{{ old('sevice_name', isset($seviceDetail->sevice_name) ? $seviceDetail->sevice_name : '' ) }}">
                        </div>
                        <div class="col-6">
                            <label for="">Description</label>
                            <textarea class="form-control" id="description" name="inputs[`+i+`][description]" rows="4" cols="50"value="{{ old('description', isset($seviceDetail->description) ? $seviceDetail->description : '' ) }}">{{ old('note', isset($seviceDetail->description) ? $seviceDetail->description : '' ) }}</textarea>
                        </div>
                        <div class="col-4">
                            <label for="">Hour<?php echo $reqLabel; ?></label><span class="text-danger">(for fix price services select 1)</span>
                            <input type="number" min="1" name="inputs[`+i+`][quantity]" class="form-control" placeholder="sevices hour" value="{{ old('quantity', isset($seviceDetail->quantity) ? $seviceDetail->quantity : '' ) }}">
                        </div>
                        <div class="col-4">
                            <label for="">Price<?php echo $reqLabel; ?></label>
                            <input type="number" name="inputs[`+i+`][prize]" class="form-control" placeholder="sevices Price" value="{{ old('prize', isset($seviceDetail->prize) ? $seviceDetail->prize : '' ) }}">
                        </div>
                        <div class="col-4">
                            <label for="">Discount in Price<?php echo $reqLabel; ?></label>
                            <input type="number" name="inputs[`+i+`][discount]" class="form-control" placeholder="sevices Discount" value="{{ old('discount', isset($seviceDetail->discount) ? $seviceDetail->discount : '' ) }}">
                        </div>  
                    </div>
                    </td>
                    <td>
                        <button name="remove" class ="btn btn-danger remove">Remove</button>
                    </td>
                </tr>
            `
        );
    });
    $(document).on('click','.remove',function(){
        $this.parent('tr').remove();
    });
</script>
@endsection
