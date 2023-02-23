<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function cryptString( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'my_lara_svm_secret_key';
        $secret_iv = 'my_lara_svm_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        return $output;
    }

    public function delete($id, $tablename){
        try {
            if(!$this->isPresentOnAnotherTable($id, $tablename)){
                if($tablename == 'employees'){
                    DB::table($tablename)->where('id', $id)->update(['status' => 0]);
                    DB::table('users')->where('employee_id', $id)->update(['status' => 0]);
                    Session::flash('success', 'Deleted Successfully!!!');
                    return Redirect::back();
                }elseif(DB::table($tablename)->where('id', $id)->update(['status' => 0])){
                    Session::flash('success', 'Deleted Successfully!!!');
                    return Redirect::back();
                }else{
                    Session::flash('danger', 'Failed To Delete Try Again!!!');
                    return Redirect::back();
                }
            }else{
                Session::flash('warning', 'Cannot Delete this entity, It is used in another table !!!');
                return Redirect::back();
            }
        }catch (\Exception $e) {
           return Redirect::back()->with('warning', $e->getMessage());
        }
    }

    protected function isPresentOnAnotherTable($id, $tablename){
        $status = false;
        switch ($tablename) {
            case 'roles':
                $status = DB::table('role_users')->where(['role_id' => $id])->exists();
                return $status;
            break;
            case 'countries':
                $status = DB::table('states')->where(['country_id' => $id, 'status' => 1])->exists();
                return $status;
            break;
            case 'states':
                $status = DB::table('cities')->where(['state_id' => $id, 'status' => 1])->exists();
                return $status;
            break;
            
            default:
               return $status;
            break;
        }
    }
}
