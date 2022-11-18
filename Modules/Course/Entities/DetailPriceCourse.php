<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPriceCourse extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }
}
