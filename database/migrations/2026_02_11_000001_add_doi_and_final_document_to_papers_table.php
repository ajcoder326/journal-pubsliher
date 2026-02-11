<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->string('doi')->nullable()->after('keywords');
            $table->string('final_document_path')->nullable()->after('document_path');
        });
    }

    public function down(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropColumn(['doi', 'final_document_path']);
        });
    }
};
