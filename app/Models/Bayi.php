<?php
namespace App\Models;

use App\Models\Persalinan;
use Illuminate\Database\Eloquent\Model;

class Bayi extends Model
{
    protected $guarded = ['id'];
    public function persalinan()
    {
        return $this->belongsTo(Persalinan::class);
    }
}
