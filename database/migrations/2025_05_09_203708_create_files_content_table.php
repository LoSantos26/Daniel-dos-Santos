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
        Schema::create('files_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->date('rpt_dt')->nullable();
            $table->string('tckr_symb')->nullable();
            $table->string('mkt_nm')->nullable();
            $table->string('scty_ctgy_nm')->nullable();
            $table->string('isin')->nullable();
            $table->string('crpn_nm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_content');
    }
};
