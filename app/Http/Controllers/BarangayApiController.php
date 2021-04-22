<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;

class BarangayApiController extends Controller
{
    //
    //--------------Barangay-----------------

    public function index()
    {
        //where I display alll the item in my todo list
        $barangay = Barangay::orderBy('created_at', 'Desc')->get();
        return $barangay;
    }

    public function store_barangay(Request $req)
    {
        //validate 
        $this->validate($req, [
            'brgy_name' => 'required',
            'brgy_city' => 'required',
        ]);

        $barangay = new Barangay;
        $barangay->brgy_name = $req->brgy_name;
        $barangay->brgy_city = $req->brgy_city;
        $barangay->save();

        // $barangay =  Barangay::create([
        //     'brgy_name' => $req->brgy_name,
        //     'brgy_city' => $req->brgy_city
        // ]);
        return $barangay;
    }
    //---------------BRGYAdmin-----------------
    public function store_barangayAdmin(Request $req)
    {
        //
        //validate 
        $this->validate($req, [
            'name' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'userType' => 'required',
            'barangay_id' => 'required'
        ]);
        $password  = bcrypt($req->password);


        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->userType = $req->userType;
        $user->password = $password;
        $user->barangay_id = $req->barangay_id;
        if ($user->save()) {
            return $user;
        } else {
            return "Something went wrong";
        }
    }
}
