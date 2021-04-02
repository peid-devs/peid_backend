<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnis', function (Blueprint $table) {
            $table->integer('dni_number_pet')->unique();
            $table->string('dni_type_pet',100);
            $table->string('lastname_pet',100);
            $table->string('name_pet',100);
            $table->string('url_image_pet',255);
            $table->date('birthday_pet',255);
            $table->date('date_enrollment_pet',255);
            $table->date('date_issue_pet',255);
            $table->date('date_expiry_pet',255);
            $table->string('gender_pet',150);
            $table->string('specie_type_pet',150);
            $table->string('breed_pet',100);
            $table->string('lastname_owner',255);
            $table->string('name_owner',255);
            $table->string('country_code',10);
            $table->string('cellphone_owner',14);
            $table->string('email_owner',100);
            $table->primary('dni_number_pet');
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
        Schema::dropIfExists('dnis');
    }
}
