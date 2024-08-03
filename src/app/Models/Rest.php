<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start',
        'end',
        'total'
    ];

    public function works()
    {
        return $this->belongsTo(Work::class);
    }
}
