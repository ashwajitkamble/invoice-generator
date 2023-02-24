@extends('layouts.dash')
@section('title', 'Company-Add')  

@section('content')
<form action="{{ route('seller-edit', ['id' => isset($seller->id) ? App\Http\Controllers\Controller::cryptString($seller->id, 'e') : '']) }}" method="POST"  autocomplete="off" enctype="multipart/form-data">
    @csrf
    @php 
        $reqLabel = '<sup class="text-danger">*</sup>'; 
    @endphp
    {{-- Seller form --}}
    <div class="card-header">
        <h3 class="card-title"><a href="{{route('seller')}} " type="button" class="btn btn-block btn-info">Back</a></h3>
    </div>
    
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Company Logo</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Company Logo<?php echo $reqLabel; ?></label>
                <input type="file" name="image" class="form-control" value="{{ old('image', isset($seller->image) ? $seller->image : '' ) }}">
            </div>
        </div>
        {{-- seller Details --}}
        <div class="card-header">
            <h2 class="card-title">Company Details</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Company Name<?php echo $reqLabel; ?></label>
                <input type="text" name="name" class="form-control" placeholder="name" value="{{ old('name', isset($seller->name) ? $seller->name : '' ) }}">
                @if ($errors->has('name'))
                    <span class="text-danger">
                        <small>{{ $errors->first('name') }}</small>
                    </span>
                @endif
            </div>
            <div class="col-4">
                <label for="">Company Email</label>
                <input type="email" name="email" class="form-control" placeholder="email" value="{{ old('email', isset($seller->email) ? $seller->email : '' ) }}">
            </div>
            <div class="col-4">
                <label for="exampleInputEmail1">Company Contact</label>
                <input type="number" name="contact" class="form-control" placeholder="Contact numbers" value="{{ old('contact', isset($seller->contact) ? $seller->contact : '' ) }}">
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1">Company Address</label>
                <textarea class="form-control" id="address" name="address" rows="4" cols="50" value="{{ old('address', isset($seller->address) ? $seller->address : '' ) }}">{{ old('address', isset($seller->address) ? $seller->address : '' ) }}</textarea>
            </div>
        </div>
    </div>
    {{-- invoice form --}}
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Other Informations</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">PAN No.</label>
                <input type="text" name="pan" class="form-control" placeholder="PAN No." value="{{ old('pan', isset($seller->pan) ? $seller->pan : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">LUT No.</label>
                <input type="text" name="lut" class="form-control" placeholder="LUT No." value="{{ old('lut', isset($seller->lut) ? $seller->lut : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">GST No.</label>
                <input type="text" name="gst" class="form-control" placeholder="GST No." value="{{ old('gst', isset($seller->gst) ? $seller->gst : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Due Days<?php echo $reqLabel; ?></label>
                <input type="number" min ="1" name="due_day" class="form-control" placeholder="Due Day" value="{{ old('due_day', isset($seller->due_day) ? $seller->due_day : '' ) }}">
            </div>
            <div class="col-6">
                <label for="exampleInputEmail1">Notes</label>
                <textarea class="form-control" id="note" name="note" rows="4" cols="50"value="{{ old('note', isset($seller->note) ? $seller->note : '' ) }}">{{ old('note', isset($seller->note) ? $seller->note : '' ) }}</textarea>
            </div>
        </div>
    </div>
    {{--Bank form --}}
    <div class="card-body">
        <div class="card-header">
            <h2 class="card-title">Bank Information</h2>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="">Bank Name</label>
                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" value="{{ old('bank_name', isset($seller->bank_name) ? $seller->bank_name : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Branch</label>
                <input type="text" name="bank_branch" class="form-control" placeholder="Branch" value="{{ old('bank_branch', isset($seller->bank_branch) ? $seller->bank_branch : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Bank IFSC Code</label>
                <input type="text" name="bank_IFSC" class="form-control" placeholder="IFSC" value="{{ old('bank_IFSC', isset($seller->bank_IFSC) ? $seller->bank_IFSC : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Swift Code</label>
                <input type="text" name="bank_swift" class="form-control" placeholder="Swift Code" value="{{ old('bank_swift', isset($seller->bank_swift) ? $seller->bank_swift : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Beneficiary Name</label>
                <input type="text" name="account_holder" class="form-control" placeholder="Beneficiary Name" value="{{ old('account_holder', isset($seller->account_holder) ? $seller->account_holder : '' ) }}">
            </div>
            <div class="col-4">
                <label for="">Account Number</label>
                <input type="number" name="bank_account" class="form-control" placeholder="Account Number" value="{{ old('bank_account', isset($seller->bank_account) ? $seller->bank_account : '' ) }}">
            </div>
            
        </div>
        <div class="card-footer">
            <button  class="btn btn-success "type="submit">Submit</button>
            <button  class="btn btn-dark "type="reset">Cancel</button>
        </div>
    </div>
</form>
@endsection
