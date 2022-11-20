<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }
}
