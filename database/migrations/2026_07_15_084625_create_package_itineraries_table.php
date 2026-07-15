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
        Schema::create('package_itineraries', function (Blueprint $table) {
            $table->id();
            $table->string('marker', 50);
            $table->string('title', 100);
            $table->mediumText('itinerary');
            $table->string('accommodation_place', 100)->nullable();
            $table->integer('accommodation_days')->unsigned()->nullable();
            $table->string('meals', 100)->nullable();
            $table->text('optional_activities')->nullable();
            $table->text('included_activities')->nullable();
            $table->text('special_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_itineraries');
    }
};
