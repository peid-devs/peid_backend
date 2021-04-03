<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertipeidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type_certipeid' => 'free', 'subtype_certipeid' => 'inscription','lastname_pet' => 'Hernandez', 'name_pet' => 'Lucas', 'url_image_pet' => '/assets/images/generate/dni/78206913.jpg', 'birthday_pet' => '2021-03-18', 'gender_pet' => 'Machito', 'specie_type_pet' => 'gato', 'breed_pet' => 'Ragdoll', 'lastname_owner' => 'Hernandez Florez', 'name_owner' => 'Miguel Juan','country_code' => '+51', 'cellphone_owner' => '+51985400951'  ,'email_owner' => 'hernandezf@gmail.com','dni_number_pet' => '78206913','dni_type_pet' => 'free','date_enrollment_pet' => '2021-03-21','date_issue_pet' => '2021-03-25','date_expiry_pet' => '2025-03-21']
        ];

        foreach ($data as $value) {
            DB::table('certipeids')->insert(
                [
                    'type_certipeid' => $value['type_certipeid'],
                    'subtype_certipeid' => $value['subtype_certipeid'],
                    'lastname_pet' => $value['lastname_pet'],
                    'name_pet' => $value['name_pet'],
                    'url_image_pet' =>  $value['url_image_pet'],
                    'birthday_pet' => $value['birthday_pet'],
                    'gender_pet' => $value['gender_pet'],
                    'specie_type_pet' => $value['specie_type_pet'],
                    'breed_pet' => $value['breed_pet'],
                    'lastname_owner' => $value['lastname_owner'],
                    'name_owner' => $value['name_owner'],
                    'country_code' => $value['country_code'],
                    'cellphone_owner' => $value['cellphone_owner'],
                    'email_owner' => $value['email_owner'],
                    'dni_number_pet' => $value['dni_number_pet'],
                     'dni_type_pet' => $value['dni_type_pet'],
                    'date_enrollment_pet' => $value['date_enrollment_pet'],
                    'date_issue_pet' => $value['date_issue_pet'],
                    'date_expiry_pet' => $value['date_expiry_pet'],
                ]
            );
        }

    }
}


