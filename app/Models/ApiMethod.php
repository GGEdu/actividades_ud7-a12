<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'api_id', 
        'documentation'
    ];
    public function api()
    {
        return $this->belongsTo(API::class);
    }
}
