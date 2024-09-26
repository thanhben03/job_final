<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserCareer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    public function curriculum_vitae(): BelongsTo
    {
        return $this->belongsTo(CurriculumVitae::class, 'cv_id', 'id');
    }
}
