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
        Schema::create('Tayanon', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('age')->nullable();
            $table->integer('weight')->nullable();
            $table->float('note')->nullable();
            $table->date('date')->nullable();
            $table->text('remark')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Tayanon');
    }
};
