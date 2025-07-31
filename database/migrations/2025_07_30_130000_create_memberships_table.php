<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->unique()->nullable(); // Generated after approval
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('citizenship_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('address');
            $table->string('education');
            $table->integer('experience_years');
            $table->string('current_workplace');
            $table->string('position');
            $table->enum('membership_type', ['associate', 'regular', 'life']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'inactive', 'expired'])->default('pending');
            $table->string('photo_path')->nullable();
            $table->string('citizenship_copy_path')->nullable();
            $table->string('experience_certificate_path')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); // For membership categories
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('membership_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('memberships');
    }
};