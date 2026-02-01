<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->nullable()->constrained('careers')->nullOnDelete();
            $table->string('name', 255);
            $table->string('phone', 50);
            $table->string('email', 255);
            $table->string('position', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('cv_path', 255);
            $table->timestamps();

            $table->index(['career_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};

