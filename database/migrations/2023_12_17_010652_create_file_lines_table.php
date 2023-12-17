<?php

use App\Models\File;
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
        Schema::create('file_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(File::class);
            $table->foreignIdFor(Sector::class);
            $table->json('lines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_lines');
    }
};