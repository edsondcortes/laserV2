<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('adderi_budget_item');
            $table->string('item_code');
            $table->string('description');
            $table->string('position')->nullable();
            $table->string('type')->nullable();
            $table->string('note')->nullable();

            $table->dateTime('cut')->nullable();
            $table->unsignedBigInteger('user_cut')->nullable();
            $table->foreign('user_cut')->references('id')->on('users');

            $table->dateTime('edition')->nullable();
            $table->unsignedBigInteger('user_edition')->nullable();
            $table->foreign('user_edition')->references('id')->on('users');

            $table->dateTime('layout')->nullable();
            $table->unsignedBigInteger('user_layout')->nullable();
            $table->foreign('user_layout')->references('id')->on('users');

            $table->dateTime('engraving')->nullable();
            $table->unsignedBigInteger('user_engraving')->nullable();
            $table->foreign('user_engraving')->references('id')->on('users');

            $table->string('background')->nullable();
            $table->string('delivery_type')->nullable();

            $table->unsignedBigInteger('delivery_id')->nullable();

            $table->unsignedBigInteger('budget_id');
            $table->foreign('budget_id')->references('id')->on('budgets');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_items');
    }
};
