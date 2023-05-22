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
        Schema::create('plan_details', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('y');
            $table->smallInteger('no');
            $table->string('stmas_id');
            $table->string('stkcode');
            $table->string('stkdesc');
            $table->string('stkdesc2');
            $table->decimal('pqty', 8, 2);
            $table->decimal('bqty', 8, 2);
            $table->mediumInteger('to_dept_id'); //หน่วยงานที่ดำเนินการจัดซื้อ/จ้าง
            $table->decimal('pamt', 11, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('q1', 8, 2);
            $table->decimal('q2', 8, 2);
            $table->decimal('q3', 8, 2);
            $table->decimal('q4', 8, 2);
            $table->decimal('bamt', 11, 2);
            $table->decimal('prc', 8, 2);
            $table->string('unit', 50);
            $table->char('plntype', 1);
            $table->mediumInteger('doctype_id');
            $table->string('note');
            $table->string('resplan');
            $table->decimal('last_prc', 8, 2);
            $table->boolean('dept_req');
            $table->boolean('conf');
            $table->mediumInteger('from_dept_id'); // ขอจากหน่วยงาน
            $table->string('plan_header_id');
            $table->boolean('approved');
            $table->boolean('delflg');
            $table->boolean('cmp');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_details');
    }
};
