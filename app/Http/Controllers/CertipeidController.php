<?php

namespace App\Http\Controllers;

use App\Models\Certipeid;
use claviska\SimpleImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

/**
 * Class CertipeidController
 *
 * @package App\Http\Controllers
 *
 * Contains certipeid methods that return a json.
 */
class CertipeidController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created certipeid resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *   Return a json about the answer of it.
     */
    public function store(Request $request) {
        $rules =
            [
                'email_owner' => 'required|email',
                'cellphone_owner' => 'required|regex:/^(9)[0-9]{1,8}$/',
                'url_image_pet' => 'required|image'
            ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['mesage' => $validator->errors()->all()],400);
        }
        $phone_number = $request->country_code.$request->cellphone_owner;
        $lower_name = Str::lower($request->name_pet);
        $img_pet = $request->country_code.$request->cellphone_owner.'_'.$lower_name.'.jpg';
        $path = resource_path() . '/assets/images/certipeid/' . $img_pet;
        Image::make($request->file('url_image_pet'))
            ->resize(3368, 2380)
            ->save($path);
        $certipeid = Certipeid::create([
            'type_certipeid' => $request->type_certipeid,
            'subtype_certipeid' => $request->subtype_certipeid,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => '/assets/images/certipeid/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner,
            'dni_number_pet' => null,
            'dni_type_pet' => null,
            'date_enrollment_pet' => null,
            'date_issue_pet' => null,
            'date_expiry_pet' => null
        ]);
        return response()->json($certipeid,200);
    }

    /**
     * Display the specified resource about a specific certipeid.
     *
     * @param  string  $cellphone_owner
     * @return \Illuminate\Http\Response
     */
    public function show(string $cellphone_owner) {
        $certipeid = Certipeid::where('cellphone_owner',$cellphone_owner)->get();
        if($certipeid->isEmpty()) {
            return response()->json(['Message' => 'Not found'],404);
        }
        return response()->json($certipeid,200);
    }

    /**
     * @param $dni_number
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getCertipeid ($dni_number) {
        $certipeid = Certipeid::where('dni_number_pet',$dni_number)->get();
        if($certipeid->isEmpty()) {
            return response()->json(['Message' => 'Not found'],404);
        }
        try {
            $path_qr = resource_path() . '/assets/images/generate/certipeid/qr/'.$certipeid[0]->dni_number_pet.'.jpg';

            if(@getimagesize($path_qr) == 0) {
                $this->createQrCode($certipeid[0]->dni_number_pet);
            }

            $image = new SimpleImage();
            $image
                ->fromFile(resource_path() . '/assets/images/generate/certipeid/background.png')
                ->autoOrient()
                ->border('black', 5)
                ->text($certipeid[0]->name_pet.' '.$certipeid[0]->lastname_pet, [
                        'fontFile' => resource_path() . '/fonts/robottoregular.ttf',
                        'size' => 43.60 ,               ///< text-size
                        'color' => '#F15B5B',        ///< text-color
                        'anchor' => 'top',
                        'xOffset' => 100,
                        'yOffset' => 230,
                        'shadow' => ['x' => '0', 'y' => '15', 'color' => '#ececec' ]
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/certipeid/phrase.png', 'left',1,385,25,false) ///< phrase certipeid
                ->overlay(resource_path() . '/assets/images/dni/'.$certipeid[0]->dni_number_pet .'.jpg', 'left',1,167,6) ///< principal image
                ->overlay(resource_path() . '/assets/images/generate/certipeid/brand.png', 'top center',1,0,94.35) ///< brand image
                ->overlay(resource_path() . '/assets/images/generate/certipeid/mark2.png', 'top left',1,175,436.35) ///< logo secundary
                ->overlay(resource_path() . '/assets/images/generate/certipeid/peidsign.png', 'left',1,333,189.35) ///< sign certipeid
                ->overlay(resource_path() . '/assets/images/generate/certipeid/qr/'.$certipeid[0]->dni_number_pet.'.jpg', 'top left',1,605,450.35) ///< watermark image
                ->toScreen();
        } catch(Exception $err) {
            echo $err->getMessage();
        }

        //return response()->json($certipeid,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    // @to_do = check this function and solve this problem
    public function createQrCode($dni_number) {
        $pet_qr_code = resource_path() . '/assets/images/generate/certipeid/qr/'.$dni_number.'.jpg';
        $params = [
         'scanned' => [
            'kind' => 'certipeid',
            'type' => 'inscription',
             'subtype' => 'free'
         ],
        ];

        $base_path_local = 'http://127.0.0.1:8000/api/certipeid/'.$dni_number;
        $base_path_server = 'https://pet-id.tk/api/certipeid/'.$dni_number;
        copy("https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=$base_path_server", $pet_qr_code);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
