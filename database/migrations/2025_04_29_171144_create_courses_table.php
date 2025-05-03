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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('course_name');
            $table->text('course_title')->nullable();
            $table->string('course_name_slug');
            $table->longText('description')->nullable();
            $table->text('video')->nullable();
            $table->string('label')->nullable();
            $table->string('duration')->nullable();
            $table->string('resources')->nullable();
            $table->string('certificate')->nullable();
            $table->integer('selling_price');
            $table->integer('discount_price')->nullable();
            $table->text('prerequisites')->nullable();
            $table->string('bestseller')->nullable();
            $table->string('featured')->nullable();
            $table->string('highestreated')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=inactive, 1=active');

            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('subcategory_id')->constrained('sub_categories');
            $table->foreignId('instructor_id')->constrained('users');
            $table->string('course_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
