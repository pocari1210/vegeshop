<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'price',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
