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
        Schema::create('subscriber_certificate_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('certificate_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('event_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriber_certificate_notifications');
    }
};
