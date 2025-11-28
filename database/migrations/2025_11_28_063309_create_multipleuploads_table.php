<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multipleuploads', function (Blueprint $table) {
            $table->id('multipleuploads_id');
            $table->string('ref_table');
            $table->unsignedBigInteger('ref_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multipleuploads');
    }
};