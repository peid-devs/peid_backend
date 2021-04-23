<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertipeidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certipeids', function (Blueprint $table) {
            $table->increments('id_certipeid');
            $table->string('type_certipeid',50);///< free, premium
            $table->string('subtype_certipeid',100); ///< valentine,etc.
            $table->string('lastname_pet',100);
            $table->string('name_pet',100);
            $table->string('url_image_pet',255);
            $table->date('birthday_pet',255);
            $table->string('gender_pet',150);
            $table->string('specie_type_pet',150);
            $table->string('breed_pet',100);
            $table->string('lastname_owner',255);
            $table->string('name_owner',255);
            $table->string('country_code',10);
            $table->string('cellphone_owner',14);
            $table->string('email_owner',100);
            $table->integer('dni_number_pet')->nullable();
            $table->string('dni_type_pet',100)->nullable();
            $table->date('date_enrollment_pet',255)->nullable();
            $table->date('date_issue_pet',255)->nullable();
            $table->date('date_expiry_pet',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certipeids');
    }
}
