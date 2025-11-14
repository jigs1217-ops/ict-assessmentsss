<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('department')->nullable();
            $table->string('division')->nullable();          
            $table->string('name')->nullable();              
            $table->string('care_of')->nullable();           
            $table->string('equipment_type')->nullable();
            $table->string('model')->nullable();
            $table->date('date_acquired')->nullable();
            $table->date('date_assessed')->nullable();
            $table->string('motherboard')->nullable();
            $table->string('processor')->nullable();
            $table->string('memory')->nullable();
            $table->string('harddisk_capacity')->nullable();
            $table->string('lan_connected')->nullable();
            $table->string('internet_connected')->nullable();
            $table->string('os')->nullable();
            $table->string('ms_office')->nullable();
            $table->string('condition')->nullable();
            $table->string('analysis')->nullable();
            $table->string('recommendation')->nullable();
            $table->text('remarks')->nullable();
            $table->text('assessed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};