<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesModel extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $primaryKey = 'id_article';
    public $timestamps = false;

    protected $fillable = [
        'id_article',
        'id_user',
        'id_category',
        'id_article_level',
        'slug',
        'title',
        'content',
        'published_at',
        'is_published',
        'created_at',
        'updated_at'
    ];
}
