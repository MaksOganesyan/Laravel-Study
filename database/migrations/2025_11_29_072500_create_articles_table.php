<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');                   
            $table->text('short_description');          
            $table->longText('content');                
            $table->string('preview_image');            
            $table->string('full_image');               
            $table->date('published_at');               
            $table->timestamps();                       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
