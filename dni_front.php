<?php

require 'vendor/autoload.php';

error_reporting(E_ALL & ~E_NOTICE);

try {
  $dni = '28335622';
  $dni_arr = [];
  $dni_arr = str_split($dni);
  $num_arr = ['0','1','2','3','4','5','6','7','8','9'];

  $same_elements = array_intersect($dni_arr, $num_arr);

  /**
   * Number order of an specific pet.
   *
   * @var string
   */
  $name_order = 'PERRIJO 01';

  /**
   * Lastname of an specific pet.
   *
   * @var string
   */
  $lastname_pet = 'Espinoza';

  /**
   * Name of an specific pet.
   *
   * @var string
   */
  $name_pet = 'Rufian';

  /**
   * Date of birth an specific pet.
   *
   * @var string
   */
  $birth_date = '10/05/2020';

  /**
   * Gender of an specific pet.
   *
   * @var string
   */
  $gender_pet = 'Machito';

  /**
   * Type of an specific pet.
   *
   * @var string
   */
  $type_pet = 'Perro';

  /**
   * Breed of an specific pet.
   *
   * @var string
   */
  $breed_pet = 'Bull terrier';

  /**
   * Dni code.
   *
   * @var string
   */
  $dni_code = 'XXX 535435-1';

  /**
   * Enrollment date.
   *
   * @var string
   */
  $enrollment_date = '11-09-2021';

  /**
   * Issue date.
   *
   * @var string
   */
  $issue_date = '15-09-2021';

  /**
   * Expiry date.
   *
   * @var string
   */
  $expiry_date = '15-09-2025';

  $image = new \claviska\SimpleImage();
  $image
    ->fromFile('peid/dni/background3.png')    ///< load dni background
    ->autoOrient()
    ->resize(630, 379)
    ->text('REPUBLICA DEL PERÚ', [
         'fontFile' => 'font/montserratbold.ttf',
         'size' => 22.8 ,
         'color' => '#000000',
         'anchor' => 'top left',
         'xOffset' => 58,
         'yOffset' => 38,
      ])
      ///< Dni code information
    ->text($name_order.' < < < < < < < < < < < < < < < < < < < < < < < <', [
        'fontFile' => 'font/quickmedium.ttf',
        'size' => 18 ,
        'color' => '#000000',
        'anchor' => 'top left',
        'xOffset' => 40,
        'yOffset' => 315,
     ])
    ->text(strtoupper($lastname_pet).' < < '.
        strtoupper($name_pet).' < < < < < < < < ', [
        'fontFile' => 'font/quickmedium.ttf',
        'size' => 18 ,
        'color' => '#000000',
        'anchor' => 'top left',
        'xOffset' => 40,
        'yOffset' => 338,
      ])
      ///< Dni code
      ->text($dni_code, [
          'fontFile' => 'font/quickmedium.ttf',
          'size' => 18 ,
          'color' => '#000000',
          'anchor' => 'top left',
          'xOffset' => 466,
          'yOffset' => 38,
           ])
      ///< Enrollment date
      ->text($enrollment_date, [
           'fontFile' => 'font/quickbold.ttf',
           'size' => 10 ,
           'color' => '#FFFFFF',
           'anchor' => 'top left',
           'xOffset' => 528,
           'yOffset' => 108,
           ])
      ///< Issue date
      ->text($issue_date, [
           'fontFile' => 'font/quickbold.ttf',
           'size' => 10 ,
           'color' => '#FFFFFF',
           'anchor' => 'top left',
           'xOffset' => 528,
           'yOffset' => 152,
          ])
      ///< Date of expiry
      ->text($expiry_date, [
           'fontFile' => 'font/quickbold.ttf',
           'size' => 10 ,
           'color' => '#FFFFFF',
           'anchor' => 'top left',
           'xOffset' => 528,
           'yOffset' => 198,
          ])
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[0].'.png',
          'top left', 1,35,120) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[1].'.png',
          'top left', 1,35,134) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[2].'.png',
          'top left', 1,35,150) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[3].'.png',
          'top left', 1,35,166) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[4].'.png',
          'top left', 1,35,180) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[5].'.png',
          'top left', 1,35,196) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[5].'.png',
          'top left', 1,35,210) ///< dni number
      ->overlay('peid/dni/numbers_remasterized/'.$same_elements[5].'.png',
          'top left', 1,35,226) ///< dni number
      ->overlay('peid/dni/front_brand.png', 'top left',
                1,92,125) ///< dni brand
      ->overlay('peid/dni/field_front.png', 'top left',
                1,245,95) ///< dni field
      ->text($lastname_pet, [  ///< dni field input - lastname
           'fontFile' => 'font/quickmedium.ttf',
           'size' => 16 ,
           'color' => '#000000',
           'anchor' => 'top left',
           'xOffset' => 258,
           'yOffset' => 105
           ])
      ->overlay('peid/dni/field_front.png', 'top left',
                1, 245,145) ///< dni field
      ->text($name_pet, [  ///< dni field input - name
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 16 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 258,
           'yOffset' => 155,
           ])
      ->overlay('peid/dni/mfield_front.png', 'top left',
                1,245,195) ///< dni field
      ->text($birth_date, [  ///< dni field input - date
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 16 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 258,
           'yOffset' => 205,
           ])
      ->overlay('peid/dni/nfield_front.png', 'top left',
                1,370,195) ///< dni field
      ->text($gender_pet, [  ///< dni field input - date
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 16 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 382,
           'yOffset' => 205,
           ])
      ->overlay('peid/dni/mfield_front.png', 'top left',
                1,245,245) ///< dni field
      ->text($type_pet, [  // type of pet
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 16 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 258,
           'yOffset' => 255,
          ])
      ->overlay('peid/dni/nfield_front.png', 'top left',
                1,370,245) ///< dni field
      ->text($breed_pet, [  // breed of dog
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 16 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 380,
           'yOffset' => 255,
          ])
      ->overlay('peid/dni/panel2.png', 'top left',
                1,495,75) ///< dates panel
      ->overlay('peid/dni/dogbottom.png', 'top left',
                  1,510,235) ///< dni image
      ->toScreen();                            ///< output to the screen

  } catch(Exception $err) {
      echo $err->getMessage();                   ///< Return error message
  }
