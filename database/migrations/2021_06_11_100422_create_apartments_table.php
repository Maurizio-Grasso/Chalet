<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 100);
            $table->string('address', 100);
            $table->tinyInteger('rooms_n');
            $table->tinyInteger('beds_n');
            $table->tinyInteger('bathroom_n');
            $table->smallInteger('dimensions');
            $table->decimal('latitude', 9,6);
            $table->decimal('longitude', 9,6);
            $table->text('description')->nullable();
            $table->boolean('visible')->default(0);
            $table->float('price_per_night', 6,2);
            $table->float('rating', 2,1)->nullable();
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
        Schema::dropIfExists('apartments');
    }
}
