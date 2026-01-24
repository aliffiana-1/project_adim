<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsModel extends Model
{
    use HasFactory;
    protected $table = 'tb_events';
    protected $primaryKey = 'id_events';
    public $timestamps = false;

    protected $fillable = [
        'id_employee',
        'id_alumni',
        'events_type',
        'events_title',
        'events_desc',
        'events_img',
        'events_status',
        'events_date',
        'events_softdel',
        'events_inserted_at	',
        'events_updated_at'
    ];
}
