<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlumniModel extends Model
{
    use HasFactory;
    protected $table = 'tb_alumni';
    protected $primaryKey = 'id_alumni';
    public $timestamps = false;

    protected $fillable = [
        'id_student',
        'alumni_email',
        'alumni_pob',
        'alumni_dob',
        'alumni_nim',
        'alumni_name',
        'alumni_img',
        'alumni_npwp',
        'alumni_password',
        'alumni_address',
        'alumni_phone',
        'current_company_name',
        'current_company_field',
        'current_company_address',
        'alumni_position',
        'work_duration',
        'alumni_wage',
        'campus_building',
        'campus_facility',
        'teacher_quality',
        'campus_curriculum',
        'student_activity',
        'alumni_created_at',
        'alumni_updated_at',
        'alumni_softdel'
    ];

    public function Student()
    {
        return $this->hasOne('StudentModel', 'id_student');
    }

    public function FormAlumni()
    {
        return $this->belongsTo('FormAlumniModel','id_form_alumni');
    }

    // public function get_data_alumni($id_alumni){
    //     return StudentModel::leftjoin('ediis.tb_leads','tb_leads.id_leads','=','tb_student.id_leads')
    //                         ->leftjoin('jic_tracer.tb_alumni','tb_alumni.id_student','=','tb_student.id_student')
    //                         ->where('tb_student.id_leads',$id_alumni)->first();
    // }

    public function get_province(){
        return DB::table('tb_province')->get();
    }

    public function get_regency(){
        return DB::table('tb_regency')->get();
    }
}
