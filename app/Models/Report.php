<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model{
    use HasFactory;

    //Campos de la tabla reports para que se puedan llenar masivamente
    protected $fillable = [
        'user_id',
        'report_date',
        'expedient_number',

        'last_name',
        'mother_last_name',
        'first_name',
        'birth_date',
        'gender',
        'education',
        'birth_place',
        'age',
        'civil_status',
        'curp',
        'phone',
        'email',

        'state',
        'municipality',

        'residence_state',
        'residence_municipality',

        'residence_code_postal',
        'residence_colony',
        'residence_city',
        'incident_city',

        'street',
        'ext_number',
        'int_number',

        'incident_date_time',
        'incident_state',
        'incident_municipality',
        'incident_colony',
        'incident_code_postal',
        'incident_street',
        'incident_ext_number',
        'incident_int_number',
        'suffered_damage',

        'witnesses',
        'has_witnesses',


        'emergency_call',
        'emergency_number',
        'detailed_account',

        'category_id',
        'subcategory_id',
        'category_name',
        'subcategory_name',
        'pdf_path',
        'pdf_blob',

        'vehicle_related'
    ];

    public function getRouteKeyName()
    {
        return 'expedient_number';
    }
    protected $casts = [
        'witnesses' => 'array',
    ];



    //Relación con el modelo Category
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //Relación con el modelo Subcategory
    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function witnesses()
    {
        return $this->hasMany(Witness::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Asegúrate de que 'user_id' esté correcto
    }

}

