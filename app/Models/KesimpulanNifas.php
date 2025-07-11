<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesimpulanNifas extends Model
{
    protected $guarded = ['id'];
    public function persalinan()
    {
        return $this->belongsTo(Persalinan::class);
    }
}
