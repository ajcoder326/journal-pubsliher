<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('volume_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('abstract');
            $table->string('authors');
            $table->string('keywords')->nullable();
            $table->string('document_path');
            $table->enum('status', ['pending', 'in_review', 'correction_needed', 'approved', 'rejected', 'published'])->default('pending');
            $table->date('submitted_at');
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
