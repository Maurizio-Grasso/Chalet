<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyMessagesApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table)

            {
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table){
            $table->dropForeign('messages_apartment_id_foreign');

            // dà errore nel reset perchè questa migration viene dopo la cancellazione della tabella, quindi non la trova
            // $table->dropColumn('apartment_id');
        }); 
    }
}
