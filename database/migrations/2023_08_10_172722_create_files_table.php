<?php

use App\Models\Line;
use App\Models\Sector;
use App\Models\User;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Line::class);
            $table->foreignIdFor(Sector::class);
            $table->boolean('status')->default(1);
            $table->string('stored_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
