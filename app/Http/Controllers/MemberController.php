<?php

namespace App\Http\Controllers;

use App\Models\member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        
        $data= member::all();
        // dd($TampungDataMember);
        return view('member',compact(['data']));
    }

    public function destroy($id){
        $data=member::find($id);
        $data->delete();
        // return view('localhost/member');
        session()->flash('success','delete successful');
       return redirect()->back();
    }

}
