<?php

use App\Models\Line;
use App\Models\Sector;
use App\Models\File;
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
        Schema::create('file_notifications', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignIdFor(Sector::class);
            $table->foreignIdFor(Line::class);
            $table->foreignIdFor(File::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_notifications');
    }
};
