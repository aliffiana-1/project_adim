<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleLevelsModel extends Model
{
    use HasFactory;
    protected $table = 'article_levels';
    protected $primaryKey = 'id_article_level';
    public $timestamps = false;

    protected $fillable = [
        'id_article_level',
        'article_level_name',
        'created_at',
        'updated_at'
    ];

}
