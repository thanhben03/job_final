<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Career extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function detail()
    {
        return $this->hasOne(CareerDetail::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'career_skills', 'career_id', 'skill_id');
    }

    public function location()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function scopeHasSkills($query, array $skillIds)
    {
        return $query->whereHas('skills', function($q) use ($skillIds) {
            $q->whereIn('skill_id', $skillIds);  // Kiểm tra nếu skill_id nằm trong mảng
        });
    }

    public function user_career()
    {
        return $this->hasOne(UserCareer::class, 'career_id', 'id');
    }

}
