<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Validator;
use App\pelanggan;
use Session;
use Auth;

class pelangganc extends Controller
{
    public function register(request $r){
        $validator = Validator::make($r->all(), [
            'nama_pelanggan' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jk' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
       
        $reg = pelanggan::create([
            'nama_pelanggan' => $r->nama_pelanggan,
            'nis' => $r->nis,
            'kelas' => $r->kelas,
            'jenis_kelamin' => $r->jk,
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'level' => 3
        ]);
        if($reg){
            return response('berhasil daftar pelanggan');
        }
        else{
            return response('gagal daftar pelanggan');
        }
    }
    public function login(request $r){
        $login = DB::table('pelanggan')->where('username','=',$r->username,'and','password','=',Hash::make($r->password))
                                       ->select('pelanggan.*')
                                       ->first();
        if($login){
            Session::put('id',$login->id);
            Session::put('nama',$login->nama_pelanggan);
            Session::put('nis',$login->nis);
            Session::put('kelas',$login->kelas);
            Session::put('jk',$login->jenis_kelamin);
            Session::put('username',$login->username);
            Session::put('level',$login->level);
            return response('berhasil login');
        }
        else{
            return response('login gagal');
        }
    }
    public function logout(){
        Session::flush();
        return response('berhasil logout');
    }
    public function tes(request $r){
        $isi[] = array(
            'id' => session('id'),
            'nama' => session('nama'),
            'nis' => session('nis'),
            'kelas' => session('kelas'),
            'jenis kelamin' => session('jk'),
            'username' => session('username'),
            'level' => session('level')
        );
        return response()->json(compact('isi'));
    }
}
