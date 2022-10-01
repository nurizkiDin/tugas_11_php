<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pekerja extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_pekerja';
    protected $fillable = ['nama', 'jabatan', 'umur', 'alamat', 'foto'];
}
