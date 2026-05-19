<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('bank_accounts')->insert([
            ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_holder' => 'PT PublikDigital Indonesia', 'sort_order' => 1, 'is_active' => true],
            ['bank_name' => 'Mandiri', 'account_number' => '1234567890123', 'account_holder' => 'PT PublikDigital Indonesia', 'sort_order' => 2, 'is_active' => true],
            ['bank_name' => 'BSI', 'account_number' => '1234567890', 'account_holder' => 'PT PublikDigital Indonesia', 'sort_order' => 3, 'is_active' => true],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
