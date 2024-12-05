<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedCareer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
