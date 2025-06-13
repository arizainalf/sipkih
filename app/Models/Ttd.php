<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ttd extends Model
{
    protected $guarded = ['id'];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
}
