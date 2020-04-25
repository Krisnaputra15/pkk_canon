<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = "transaksi";
    protected $fillable = ['id_pelanggan','id_kantin','tgl_transaksi','status'];
    public $timestamps = false;
}
