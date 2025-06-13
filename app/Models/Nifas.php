<?php
namespace App\Models;

use App\Models\Kehamilan;
use Illuminate\Database\Eloquent\Model;

class Nifas extends Model
{
    protected $guarded = ['id'];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }
}
