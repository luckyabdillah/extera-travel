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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('package_category_id')->nullable()->constrained('package_categories')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('flyer_path')->nullable();
            $table->string('flight_by')->nullable();
            $table->date('date');
            $table->tinyInteger('total_days')->unsigned();
            $table->smallInteger('quota')->unsigned();
            $table->mediumText('inclusions')->nullable();
            $table->mediumText('exclusions')->nullable();
            $table->mediumText('requirements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
