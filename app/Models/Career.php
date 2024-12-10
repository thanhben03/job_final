<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    //    public function categories(): BelongsToMany
    //    {
    //        return $this->belongsToMany(Category::class, );
    //    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'career_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function scopeHasSkills($query, array $skillIds)
    {
        return $query->whereHas('skills', function ($q) use ($skillIds) {
            $q->whereIn('skill_id', $skillIds);  // Kiểm tra nếu skill_id nằm trong mảng
        });
    }

    public function scopeHasCategory($query, $category)
    {
        return $query->whereHas('category', function ($q) use ($category) {
            $q->where('slug', $category);  // Kiểm tra nếu skill_id nằm trong mảng
        });
    }

    public function scopeSearchFulltext($query, $stringKeyword)
    {
        return $query
            ->join('career_details', 'careers.id', '=', 'career_details.career_id')
            ->select('careers.*') // Đảm bảo chỉ lấy cột từ bảng careers nếu cần
            ->whereRaw("
                (MATCH(careers.title) AGAINST(? IN NATURAL LANGUAGE MODE)
                OR MATCH(career_details.description, career_details.requirement) AGAINST(? IN NATURAL LANGUAGE MODE))
            ", [$stringKeyword, $stringKeyword]);
    }



    public function user_careers()
    {
        return $this->hasMany(UserCareer::class, 'career_id', 'id');
    }

    public function user_career()
    {
        return $this->hasOne(UserCareer::class, 'career_id', 'id');
    }

    public function reported()
    {
        return $this->hasMany(ReportedCareer::class, 'career_id', 'id');
    }

    public function spam()
    {
        return $this->hasMany(ReportedCareer::class, 'career_id', 'id')->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
