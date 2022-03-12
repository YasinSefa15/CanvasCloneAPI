<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_to_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
//            $table->tinyText('first_name');
//            $table->tinyText('last_name');
            $table->string('phone',10);
            $table->tinyText('country');
            $table->enum('organization_type',[
                'Further Education',
                'Corporate Education',
                'Government'
            ]);
            $table->tinyText('job_title');
            $table->tinyText('school_organization');
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
        Schema::dropIfExists('teacher_to_details');
    }
};
