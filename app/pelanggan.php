<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = "pelanggan";
    protected $fillable = ['nama_pelanggan','nis','kelas','jenis_kelamin','username','password','level'];
    public $timestamps = false;
}
