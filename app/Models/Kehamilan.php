<?php
namespace App\Models;

use App\Models\Ibu;
use App\Models\Ttd;
use Illuminate\Database\Eloquent\Model;

class Kehamilan extends Model
{
    protected $guarded = ['id'];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class);
    }
    public function pelayanans()
    {
        return $this->hasMany(Pelayanan::class);
    }
    public function nifas()
    {
        return $this->hasMany(Nifas::class);
    }

    public function ttds()
    {
        return $this->hasMany(Ttd::class);
    }

    public function periksaKehamilans()
    {
        return $this->hasMany(PeriksaKehamilan::class);
    }

    protected static function booted()
    {
        static::created(function ($kehamilan) {
            $startDate = now(); // bisa pakai $kehamilan->tanggal_mulai kalau ada
            $endDate   = $startDate->copy()->addMonths(9);

            $dates = [];
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $dates[] = [
                    'kehamilan_id' => $kehamilan->id,
                    'status'       => false,
                    'tanggal'      => $date->format('Y-m-d'),
                ];
            }

            // Bulk insert untuk efisiensi
            \App\Models\Ttd::insert($dates);
        });
    }
}
