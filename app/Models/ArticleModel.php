<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;
    protected $table = 'tb_events';
    protected $primaryKey = 'id_events';
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
        'created_at',
        'updated_at'
    ];
}
