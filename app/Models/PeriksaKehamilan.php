<?php
namespace App\Models;

use App\Models\FormPeriksaKehamilan;
use Illuminate\Database\Eloquent\Model;

class PeriksaKehamilan extends Model
{
    protected $guarded = ['id'];

    public function formPeriksaKehamilan()
    {
        return $this->belongsTo(FormPeriksaKehamilan::class);
    }
}
