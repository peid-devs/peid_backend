<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dni extends Model
{
    protected $fillable = ['dni_number_pet','dni_type_pet', 'lastname_pet', 'name_pet', 'url_image_pet', 'birthday_pet','date_enrollment_pet','date_issue_pet','date_expiry_pet','gender_pet', 'specie_type_pet', 'breed_pet', 'lastname_owner', 'name_owner','country_code', 'cellphone_owner' ,'email_owner'];

}



