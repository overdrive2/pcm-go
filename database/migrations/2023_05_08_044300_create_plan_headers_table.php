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
        Schema::create('plan_headers', function (Blueprint $table) {
            $table->id();
            $table->date('plan_date');
            $table->smallInteger('y');
            $table->mediumInteger('from_dept_id');
            $table->mediumInteger('qty');
            $table->decimal('amount', 11, 2);
            $table->mediumInteger('created_by');
            $table->mediumInteger('updated_by');
            $table->string('note');
            $table->string('title');
            $table->mediumInteger('to_dept_id');
            $table->char('plan_status', 1);
            $table->mediumInteger('doctype_id');
            $table->boolean('delflg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_headers');
    }
};
