<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterModel extends Model
{
    protected $table = 'tb_footer';
    protected $primaryKey = 'id_footer';
    public $timestamps = false;
}
