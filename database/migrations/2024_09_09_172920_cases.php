<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('origin');
            $table->text('context');
            $table->text('analysis');
            $table->text('resolution');
            $table->text('note');
//            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('trial_id');

            //constraints
//            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade');
            $table->foreign('trial_id')->references('id')->on('trials')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
