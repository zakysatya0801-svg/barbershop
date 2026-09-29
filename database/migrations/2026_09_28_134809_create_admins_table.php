<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void  //dijalankan ketika kita menjalankan
    {
        Schema::create('admins', function (Blueprint $table) {//membuat table admins
            $table->id('admin_id');
            $table->foreignId('user_id')//menghubungkan dengan tabel user id
            ->constrained('user', 'id')//Menentukan bahwa user_id merupakan foreign key yang mengacu kepada
            ->onDelete('cascade');
            $table->string('role');//menentukan role admins
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');//Menghapus tabel admins jika tabel tersebut memang ada.
    }
};
