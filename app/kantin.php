<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kantin extends Model
{
    protected $table="kantin";
    protected $fillable=['nama_kantin','id_penjual'];
    public $timestamps = false;
}
