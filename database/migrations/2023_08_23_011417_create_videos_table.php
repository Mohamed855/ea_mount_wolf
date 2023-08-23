<?php

use App\Models\User;
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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('src');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Line::class);
            $table->foreignIdFor(Sector::class);
            $table->boolean('status')->default(1);
            $table->mediumInteger('viewed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
