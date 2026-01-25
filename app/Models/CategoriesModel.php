<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'tb_categories';
    protected $primaryKey = 'id_category';
    public $timestamps = false;

    protected $fillable = [
        'id_category',
        'category_name',
        'created_at',
        'updated_at'
    ];

}
