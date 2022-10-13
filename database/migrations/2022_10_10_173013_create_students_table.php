<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("firstname");
            $table->string("lastname");
            $table->string("address_line_1");
            $table->string("address_line_2")->nullable();
            $table->string("address_line_3")->nullable();
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("school_id");
            $table->unsignedBigInteger("parent_id");
            $table->string("tag_id");
            $table->string("local_index");
            $table->boolean("is_active")->default(true);
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
        Schema::dropIfExists('students');
    }
}
