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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date("export_date");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("source_area_id");
            $table->unsignedBigInteger("category_id");
            $table->string("product_name");
            $table->integer("count")->default(1);
            $table->double("weight");
            $table->double("net_weight");
            $table->double("price");
            $table->double("total");
            $table->string("status");
            $table->string("remark")->nullable();
            $table->unsignedBigInteger("shop_id")->nullable();
            $table->unsignedBigInteger("gate_id");
            $table->unsignedBigInteger("unit_id");
            $table->double("weightfee")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("source_area_id")->references("id")->on("source_areas")->onDelete('restrict');
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('restrict');
            $table->foreign("shop_id")->references("id")->on("shops")->onDelete('restrict');
            $table->foreign("gate_id")->references("id")->on("gates")->onDelete('restrict');
            $table->foreign("unit_id")->references("id")->on("units")->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
