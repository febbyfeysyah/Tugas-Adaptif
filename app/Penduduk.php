<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    protected $fillable = ['noKtp','nama','tglLahir','tmptLahir','jk','agama','alamat','no_telp', 'file_url', 'image_url'];

    // Method Accepted
    public function getJK(){
        return $this->jk == 1 ? "Laki-laki" : "Perempuan";
    }
    
    public function user() {
        return $this->hasOne('App\User', 'noKtp', 'noKtp');
    }
}
