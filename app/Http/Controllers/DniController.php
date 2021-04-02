<?php

namespace App\Http\Controllers;

use App\Models\Certipeid;
use App\Models\Dni;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use claviska\SimpleImage;

class DniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }


    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules =
            [
                'email_owner' => 'required|email',
                'cellphone_owner' => 'required|regex:/^(9)[0-9]{1,8}$/|min:9',
                'url_image_pet' => 'required|image'
            ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['mesage' => $validator->errors()->all()],400);
        }
        $dni_number = $this->generateDni(8);
        $img_pet = $dni_number.'.jpg';
        $img_pet2 = $dni_number.'_1.jpg';
        $date_now = date('Y-m-d');
        $date_issue =date('Y-m-d',strtotime(date('Y-m-d')."+ 14 days"));
        $date_expiry=date('Y-m-d',strtotime(date('Y-m-d')."+ 4 years"));
        $phone_number = $request->country_code.$request->cellphone_owner;
       $path = storage_path() . '/app/public/images/dni/' . $img_pet;
       $path2 = storage_path() . '/app/public/images/dni/' . $img_pet2 ;
       Image::make($request->file('url_image_pet'))
           ->resize(150, 150)
           ->save($path);
        Image::make($request->file('url_image_pet'))
            ->resize(65, 65)
            ->save($path2);
        $dni =  Dni::create([
            'dni_number_pet' => $dni_number,
            'dni_type_pet' => $request->dni_type_pet,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => '/app/public/images/dni/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'date_enrollment_pet' => $date_now,
            'date_issue_pet' => $date_issue,
            'date_expiry_pet' => $date_expiry,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner
        ]);

        Certipeid::create([
            'type_certipeid' => 'free',
            'subtype_certipeid' => 'inscription',
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => '/app/public/images/dni/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner,
            'dni_number_pet' => $dni_number,
            'dni_type_pet' => $request->dni_type_pet,
            'date_enrollment_pet' => $date_now,
            'date_issue_pet' => $date_issue,
            'date_expiry_pet' => $date_expiry
        ]);
        return response()->json($dni,200);
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll() {
        $dni = Dni::all();
        return response()->json($dni,200);
    }

    public function getDniFront($dni_number){
        $dni = Dni::where('dni_number_pet' ,$dni_number)->get();
        if($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni not found'],404);
        }

        try {
            $dni_number_of = $dni[0]->dni_number_pet;
            $array_dni = str_split($dni_number_of);
            $array_numbers = ['0','1','2','3','4','5','6','7','8','9'];
            $result = array_intersect($array_dni,$array_numbers);
            $name_order = 'PER'.$dni[0]->dni_number_pet;
          //  $a = storage_path() . $dni[0]->url_image_pet;
           // return $a;
            $image = new SimpleImage();
            $image
                ->fromFile(storage_path() . '/app/public/images/generate/dni/background3.png')
                ->autoOrient()
                ->resize(630,379)
                ->text($name_order.' < < < < < < < < < < < < < < < < < <', [
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 18 ,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 40,
                        'yOffset' => 315,
                    ]
                )
                ->text(strtoupper($dni[0]->lastname_pet).' < < '.
                    strtoupper($dni[0]->name_pet).' < < < < < < < < ', [
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 18 ,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 40,
                        'yOffset' => 338,
                    ]
                )
                ->text('REPUBLICA DEL PERÚ', [
                        'fontFile' => storage_path() . '/app/public/fonts/montserratbold.ttf',
                        'size' => 22 ,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 86,
                        'yOffset' => 38,
                    ]
                )
                ///< Dni number
                ->text($dni[0]->dni_number_pet.' - 1', [
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 18 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 466,
                        'yOffset' => 42,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/field_front.png', 'top left',1,265,95) ///< dni field
                ->text($dni[0]->lastname_pet, [  ///< dni field input - lastname
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 278,
                        'yOffset' => 105,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/field_front.png', 'top left',1,265,145) ///< dni field
                ->text($dni[0]->name_pet, [  ///< dni field input - name
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',      ///< text-font
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 278,
                        'yOffset' => 155,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/mfield_front.png', 'top left',1,265,195) ///< dni field
                ->text($dni[0]->birthday_pet, [  ///< dni field input - date
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',      ///< text-font
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 278,
                        'yOffset' => 205,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/nfield_front.png', 'top left',1,390,195) ///< dni field
                ->text(ucwords($dni[0]->gender_pet), [  ///< dni field input - date
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 400,
                        'yOffset' => 205,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/mfield_front.png', 'top left',1,265,245) ///< dni field
                ->text(ucwords($dni[0]->specie_type_pet), [  // type of pet
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 278,
                        'yOffset' => 255,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/nfield_front.png', 'top left',1,390,245) ///< dni field
                ->text(ucwords($dni[0]->breed_pet), [  // breed of dog
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 400,
                        'yOffset' => 255,
                    ]
                )
                ///< Enrollment date
                ->text($dni[0]->date_enrollment_pet, [  // first date
                        'fontFile' => storage_path() . '/app/public/fonts/quickbold.ttf',
                        'size' => 10 ,               ///< text-size
                        'color' => '#FFFFFF',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 530,
                        'yOffset' => 108,
                    ]
                )
                ///< Date of issue
                ->text($dni[0]->date_issue_pet, [  // first date
                        'fontFile' => storage_path() . '/app/public/fonts/quickbold.ttf',
                        'size' => 10 ,               ///< text-size
                        'color' => '#FFFFFF',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 530,
                        'yOffset' => 152,
                    ]
                )
                ///< Date of expiry
                ->text($dni[0]->date_expiry_pet, [  ///< first date
                        'fontFile' => storage_path() . '/app/public/fonts/quickbold.ttf',
                        'size' => 10 ,               ///< text-size
                        'color' => '#FFFFFF',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 530,
                        'yOffset' => 198,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/generate/dni/panel2.png', 'top left',1,500,75) ///< dates panel
                ->overlay(storage_path() . '/app/public/images/dni/'.$dni[0]->dni_number_pet. '_1.jpg', 'top left',1,525,235) ///< dni image bottom
                ->overlay(storage_path() . '/app/public/images/dni/'.$dni[0]->dni_number_pet. '.jpg', 'top left',1,88,115)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[0] .'.png', 'top left',1,40,115)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[1] .'.png', 'top left',1,40,135)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[2] .'.png', 'top left',1,40,155)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[3] .'.png', 'top left',1,40,175)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[4] .'.png', 'top left',1,40,195)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[5] .'.png', 'top left',1,40,215)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[6] .'.png', 'top left',1,40,235)
                ->overlay(storage_path() . '/app/public/images/generate/dni/number/' . $result[7] .'.png', 'top left',1,40,255)
                ->toScreen();
           //-> toDownload('dni_front_'.$dni[0]->dni_number_pet.'.png', null, 100);
        } catch(Exception $err) {
            echo $err->getMessage();
        }


       // return $dni[0]->name_pet; https://www.php.net/manual/es/function.imagescale.php
    }

    public function getDniBack($dni_number) {
        $dni = Dni::where('dni_number_pet', $dni_number)->get();
        if ($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni not found'], 404);
        }

        $path_qr = storage_path() . '/app/public/images/generate/dni/qr/'.$dni[0]->dni_number_pet.'.jpg';

        if(@getimagesize($path_qr) == 0) {
         $this->createQrCode($dni[0]->dni_number_pet);
        }

        try {
            $image = new SimpleImage();
            $name_order = 'PER'.$dni[0]->dni_number_pet;
            $image
                ->fromFile(storage_path() . '/app/public/images/generate/dni/background3.png')
                ->autoOrient()                           ///<
                ->autoOrient()                           ///< adjust orientation
                ->resize(630, 379)
                ->text('REPUBLICA DEL PERÚ', [
                        'fontFile' => storage_path() . '/app/public/fonts/montserratbold.ttf',
                        'size' => 22 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 86,
                        'yOffset' => 38,
                    ]
                )
                ->overlay(storage_path().'/app/public/images/generate/dni/field_back.png', 'top left',1,85,95) ///< dni field
                ->text(ucwords($dni[0]->lastname_owner), [  // type of pet
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 108,
                        'yOffset' => 105,
                    ]
                )
                ->overlay(storage_path().'/app/public/images/generate/dni/field_back.png', 'top left',1,85,145) ///< dni field
                ->text(ucwords($dni[0]->name_owner), [  // type of pet
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 108,
                        'yOffset' => 155,
                    ]
                )
                ->overlay(storage_path().'/app/public/images/generate/dni/field_back.png', 'top left',1,85,195) ///< dni field
                ->text(ucwords($dni[0]->cellphone_owner), [  // type of pet
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 108,
                        'yOffset' => 205,
                    ]
                )
                ->overlay(storage_path().'/app/public/images/generate/dni/field_back.png', 'top left',1,85,245) ///< dni field
                ->text($dni[0]->email_owner, [  // type of pet
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 16 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 108,
                        'yOffset' => 255,
                    ]
                )
                ->overlay(storage_path() . '/app/public/images/dni/'.$dni[0]->dni_number_pet. '_1.jpg', 'top left',1,85,300) ///< dni field
                ->text($name_order.' < < < < < < < < < < < < < < < < < <', [
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 18 ,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 230,
                        'yOffset' => 315,
                    ]
                )
                ->text(strtoupper($dni[0]->lastname_pet).' < < '.
                    strtoupper($dni[0]->name_pet).' < < < < < < < < ', [  // first field
                        'fontFile' => storage_path() . '/app/public/fonts/quickmedium.ttf',
                        'size' => 18 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 230,
                        'yOffset' => 338,
                    ]
                )
                ->overlay(storage_path().'/app/public/images/generate/dni/qr/'.$dni[0]->dni_number_pet.'.jpg', 'top left',1,365,80) ///< dni field
                ->toScreen();
        } catch(Exception $err) {
            echo $err->getMessage();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param int $dni_number_pet
     * @return json
     */
    public function show(int $dni_number_pet) {
        $dni = Dni::where('dni_number_pet' ,$dni_number_pet)->get();
        if($dni->isEmpty()) {
            return response()->json(['mesage' => 'Not found'],404);
        }
        return response()->json($dni,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function generateDni($longitud) {
        $key = '';
        $pattern = '123456789';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[
            mt_rand(0,$max)];
        return $key;
    }

    public function createQrCode($dni_number) {
        $pet_qr_code = storage_path() . '/app/public/images/generate/dni/qr/'.$dni_number.'.jpg';
        $base_path_local = 'http://127.0.0.1:8000/api/certipeid/'.$dni_number;
        $base_path_server = 'https://pet-id.tk/api/dni/'.$dni_number;
        copy("https://api.qrserver.com/v1/create-qr-code/?size=214x214&data=$base_path_server", $pet_qr_code);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
