<?php

require 'vendor/autoload.php';

error_reporting(E_ALL & ~E_NOTICE);

try {
  /**
   * Number order of an specific pet.
   *
   * @var string
   */
  $name_order='PERRIJO 01';

  /**
   * Lastname of an specific pet.
   *
   * @var string
   */
  $lastname_dog='Espinoza';

  /**
   * Name of an specific pet.
   *
   * @var string
   */
  $name_dog='Rufian';

  $image = new \claviska\SimpleImage();

  $image
      ->fromFile('peid/dni/background3.png')        ///< load background
      ->autoOrient()                           ///< adjust orientation
      ->resize(630, 379)          ///< resize to 630x379 pixels
      ///< Dni title
      ->text('REPUBLICA DEL PERÚ', [
           'fontFile' => 'font/montserratbold.ttf',      ///< text-font
           'size' => 22.8 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 54,
           'yOffset' => 38,
          ])
      ->overlay('peid/dni/field_back.png', 'top left',
                1,53,95) ///< dni field
      ->overlay('peid/dni/field_back.png', 'top left',
                1,53,145) ///< dni field
      ->overlay('peid/dni/field_back.png', 'top left',
                1,53,195) ///< dni field
      ->overlay('peid/dni/field_back.png', 'top left',
                1,53,245) ///< dni field
      ->overlay('peid/dni/qrcode.png', 'top left',
                1,358,75) ///< dni field
      ->overlay('peid/dni/dogbottomb.png', 'top left',
                1,53,300) ///< dni field
      ->text($name_order.' < < < < < < < < < < < < < < < < < < < < < <', [
           'fontFile' => 'font/quickmedium.ttf',
           'size' => 18 ,
           'color' => '#000000',
           'anchor' => 'top left',
           'xOffset' => 170,
           'yOffset' => 315,
          ])
      ->text(strtoupper($lastname_dog).' < < '.
           strtoupper($name_dog).' < < < < < < < < ', [  ///< first field
           'fontFile' => 'font/quickmedium.ttf',      ///< text-font
           'size' => 18 ,               ///< text-size
           'color' => '#000000',        ///< text-color
           'anchor' => 'top left',
           'xOffset' => 170,
           'yOffset' => 338,
          ])
      ->toScreen();
} catch(Exception $err) {
    echo $err->getMessage();                   ///< Return error message
}

