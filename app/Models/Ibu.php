<?php
namespace App\Models;

use App\Models\Kehamilan;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ibu extends Authenticatable
{
    protected $guarded = ['id'];

    public function kehamilans(){
        return $this->hasMany(Kehamilan::class);
    }
}
