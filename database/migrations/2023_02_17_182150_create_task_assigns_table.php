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
        Schema::create('task_assigns', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('task_id');
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
			$table->date('start_date');
			$table->date('end_date');
			$table->date('submit_date')->nullable();
			$table->unsignedBigInteger('assign_user_id');
			$table->foreign('assign_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('task_assigns');
    }
};
