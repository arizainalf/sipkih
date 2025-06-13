<?php
namespace App\Models;

use App\Models\Ibu;
use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    protected $guarded = ['id'];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class);
    }
}
