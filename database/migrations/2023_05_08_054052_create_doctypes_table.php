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
        Schema::create('doctypes', function (Blueprint $table) {
            $table->id();
            $table->string('docname');
            $table->string('po_prefix', 5);
            $table->string('pr_prefix', 5);
            $table->string('tr_prefix', 5);
            $table->smallInteger('vndtype_id');
            $table->char('code_format', 1);
            $table->smallInteger('display_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctypes');
    }
};
