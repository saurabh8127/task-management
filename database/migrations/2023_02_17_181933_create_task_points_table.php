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
        Schema::create('task_points', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('task_id');
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
			$table->string('sub_task');
			$table->unsignedBigInteger('created_by');
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('task_points');
    }
};
