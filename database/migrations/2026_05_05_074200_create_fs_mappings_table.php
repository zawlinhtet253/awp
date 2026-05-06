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
        Schema::create('fs_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('acc_code');
            $table->string('fs_group');
            $table->string('fs_line');
            $table->string('ls');
            $table->string('ls_name');
            $table->string('mapping_no')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fs_mappings');
    }
};