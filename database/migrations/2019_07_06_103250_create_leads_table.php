<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('channel_id');
            $table->string('type');
            $table->string('form_name')->nullable();
            $table->string('form_email')->nullable();
            $table->string('form_phone')->nullable();
            $table->string('form_content')->nullable();
            $table->string('form_ip_address')->nullable();
            $table->string('form_page_url')->nullable();
            $table->string('call_phone')->nullable();
            $table->string('call_status')->nullable();
            $table->string('call_recording_url')->nullable();
            $table->string('call_forward_phone')->nullable();
            $table->boolean('is_duplicated');
            $table->integer('parent_id')->nullable();
            $table->timestamps();

            /*
            $table->foreign('channel_id')
                ->references('id')->on('channels')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
