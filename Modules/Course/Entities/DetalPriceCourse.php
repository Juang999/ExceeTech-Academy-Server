<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\RelationshipTraits\DetailPriceCourseTrait;

class DetalPriceCourse extends Model
{
    use HasFactory, DetailPriceCourseTrait;

    protected $fillable = [];
}
