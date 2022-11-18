<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function CategoryCourse()
    {
        return $this->belongsTo(CategoryCourse::class);
    }

    public function DetailPriceCourse()
    {
        return $this->hasMany(DetailPriceCourse::class);
    }

    public function MentorCourse()
    {
        return $this->hasMany(MentorCourse::class);
    }

    public function RequirementCourse()
    {
        return $this->hasMany(RequirementCourse::class);
    }
}
