<?php

  require 'vendor/autoload.php';

  error_reporting(E_ALL & ~E_NOTICE);
   /**
   * Name of an specific pet.
   *
   * @var string
   */
   $name_pet = 'Rufian';
  /**
   * Name of an specific pet.
   *
   * @var string
   */
   $lastname_pet = 'Vargas';
  try {

  // Create a new SimpleImage object
  $image = new \claviska\SimpleImage();

  $image
    ->fromFile('peid/certipeid/background.png')  ///< load background image
    ->autoOrient()                           ///< adjust orientation
    ->border('black', 5)      ///< add a 5 pixel black border
    ->text($name_pet.' '.$lastname_pet, [
          'fontFile' => 'font/robotoregular.ttf',      ///< text-font
          'size' => 53.56 ,               ///< text-size
          'color' => '#F15B5B',        ///< text-color
          'anchor' => 'top',
          'xOffset' => 96,
          'yOffset' => 230,
          'shadow' => ['x' => '0', 'y' => '15', 'color' => '#ececec' ]
          ]
      )
      ->overlay('peid/certipeid/phrase.png', 'left',1,390,25,false) ///< phrase certipeid
      ->overlay('peid/certipeid/boby.png', 'left',1,167,6) ///< principal image
      ->overlay('peid/certipeid/brand.png', 'top center',1,0,94.35) ///< brand image
      ->overlay('peid/certipeid/mark2.png', 'top left',1,175,436.35) ///< logo secundary
      ->overlay('peid/certipeid/incl.png', 'left',1,382,189.35) ///< sign certipeid
      ->overlay('peid/certipeid/qr.png', 'top left',1,565,436.35) ///< watermark image
      ->toScreen();
  } catch(Exception $err) {
      echo $err->getMessage();
  }
