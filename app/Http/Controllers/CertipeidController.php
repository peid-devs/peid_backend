<?php

namespace App\Http\Controllers;

use App\Models\Certipeid;
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
        $path = storage_path() . '/app/public/images/certipeid/' . $img_pet;
        Image::make($request->file('url_image_pet'))
            ->resize(3368, 2380)
            ->save($path);
        $certipeid = Certipeid::create([
            'type_certipeid' => $request->type_certipeid,
            'subtype_certipeid' => $request->subtype_certipeid,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => 'storage/images/certipeid/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner
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
