<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // UUID generate လုပ်ဖို့ extension ကို enable လုပ်ပေးရပါမယ် (PostgreSQL အတွက်)
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        DB::statement('DROP TYPE IF EXISTS user_role;');
        DB::statement("CREATE TYPE user_role AS ENUM ('admin', 'staff', 'senior', 'partner', 'manager');");

        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff', 'senior', 'partner', 'manager'])->default('user');       
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        DB::statement("DROP TYPE IF EXISTS user_role;");
        // Extension ကို drop လုပ်ဖို့ မလိုပါဘူး (အခြား table တွေ သုံးနေနိုင်လို့ပါ)
    }
};