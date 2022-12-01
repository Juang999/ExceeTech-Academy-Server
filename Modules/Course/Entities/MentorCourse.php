<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class MentorCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function newFactory()
    {
        return \Modules\Course\Database\factories\MentorCourseFactory::new();
    }
}
