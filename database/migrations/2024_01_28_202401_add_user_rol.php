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
        Schema::table('users', function(Blueprint $table){
            $table->foreignId('rol_id')
            ->after('email');
            $table->boolean('verify')
            ->after('rol_id')->default(false);
            $table->string('number', 10)
            ->after('verify');
            $table->string('code')
            ->after('number')->nullable();
            $table->string('codeAdmin')
            ->after('number')->nullable();

            $table->foreign('rol_id')->references('id')->on('rols');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
