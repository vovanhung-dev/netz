<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name', 191);
            $t->string('phone', 50);
            $t->string('email', 191)->nullable();
            $t->text('content')->nullable();
            $t->string('ip', 45)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->string('status', 20)->default('new');
            $t->timestamps();

            $t->index('created_at');
            $t->index('status');
            $t->index('phone');
        });
    }
    public function down(): void {
        Schema::dropIfExists('contact_messages');
    }
};