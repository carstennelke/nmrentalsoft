<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_company')->default(false);
            $table->string('title', 15)->nullable();
            $table->string('name', 40)->nullable();
            $table->string('lastname', 40)->nullable();
            $table->string('company_name', 40)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30);
            $table->string('street', 100);
            $table->string('zip', 10);
            $table->string('city', 100);
            $table->string('vat', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
