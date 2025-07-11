<?php
namespace App\Models;

use App\Models\BayiBaruLahir;
use App\Models\Kehamilan;
use App\Models\KesimpulanNifas;
use App\Models\KunjunganNifas;
use Illuminate\Database\Eloquent\Model;

class Persalinan extends Model
{
    protected $guarded = ['id'];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
    public function bayi()
    {
        return $this->hasOne(Bayi::class);
    }
    public function kesimpulanNifas()
    {
        return $this->hasOne(KesimpulanNifas::class);
    }
    public function kunjunganNifas()
    {
        return $this->hasOne(KunjunganNifas::class);
    }
}
