<?php

use App\Models\Line;
use App\Models\Sector;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('user_name');
            $table->string('crm_code');
            $table->string('email')->unique();
            $table->string('phone_number',11)->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->string('title');
            $table->foreignIdFor(Line::class);
            $table->foreignIdFor(Sector::class);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
