<?php

namespace App\Http\Controllers;

use App\Models\Dni;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
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
        $phone_number = $request->country_code.$request->cellphone_owner;
       $path = storage_path() . '/app/public/images/dni/' . $img_pet;
       Image::make($request->file('url_image_pet'))
           ->resize(816, 816)
           ->save($path);
        $dni =  Dni::create([
            'dni_number_pet' => $dni_number,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => 'storage/images/dni/'.$img_pet,
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
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
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
