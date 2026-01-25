<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'role_name',
    ];

    /**
     * Relasi ke tabel users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
