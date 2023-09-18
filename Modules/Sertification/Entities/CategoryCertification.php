<?php

namespace Modules\Sertification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryCertification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_name', 'is_active'];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Sertification\Database\factories\CategoryCertificationFactory::new();
    // }
}
