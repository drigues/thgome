<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Settings table already exists — just seed the key
        Setting::set('intro_video_label', 'Nice to meet you');
    }

    public function down(): void {}
};
