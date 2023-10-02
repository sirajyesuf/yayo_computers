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
        Schema::create('lends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("contact_id");
            $table->unsignedBigInteger("product_id");
            $table->foreign("contact_id")->references("id")->on("contacts");
            $table->foreign("product_id")->references("id")->on("products");
            $table->integer("quantity");
            $table->boolean("status")->default(false);
            $table->date("due_date");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lends');
    }
};
