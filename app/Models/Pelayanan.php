<?php
namespace App\Models;

use App\Models\Kehamilan;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    protected $guarded = ['id'];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
}
