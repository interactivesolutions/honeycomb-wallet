<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHcWalletHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_wallet_history', function(Blueprint $table) {
            $table->integer('count', true);
            $table->string('id', 36)->unique('id_UNIQUE');
            $table->timestamps();
            $table->softDeletes();

            $table->string('wallet_id', 36);

            $table->double('balance', 10, 6);
            $table->double('amount', 10, 6)->unsigned();
            $table->enum('action', ['increased', 'decreased', 'reserved']);
            $table->string('triggerable_id', 36)->nullable();
            $table->string('triggerable_type')->nullable();

            $table->foreign('wallet_id')->references('id')->on('hc_wallet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hc_wallet_history');
    }
}
