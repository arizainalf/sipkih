<?php
namespace App\Models;

use App\Models\PeriksaKehamilan;
use Illuminate\Database\Eloquent\Model;

class FormPeriksaKehamilan extends Model
{
    protected $guarded = ['id'];

    public function periksaKehamilans()
    {
        return $this->hasMany(PeriksaKehamilan::class);
    }
}
