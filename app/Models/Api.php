<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'base_url',
    ];
    public function methods()
    {
        return $this->hasMany(APIMethod::class);
    }
}


