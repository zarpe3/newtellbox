<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('ipaddr', 50)->nullable();
            $table->integer('port')->nullable();
            $table->integer('regseconds')->nullable();
            $table->string('defaultuser')->nullable();
            $table->string('fullcontact')->nullable();
            $table->string('regserver')->nullable();
            $table->string('useragent')->nullable();
            $table->integer('lastms')->nullable();
            $table->string('host')->nullable();
            $table->string('type')->nullable();
            $table->string('context')->nullable();
            $table->string('permit')->nullable();
            $table->string('deny')->nullable();
            $table->string('secret')->nullable();
            $table->string('md5secret')->nullable();
            $table->string('remotesecret')->nullable();
            $table->string('transport')->nullable();
            $table->string('dtmfmode')->nullable();
            $table->string('directmedia')->nullable();
            $table->string('nat')->nullable();
            $table->string('callgroup')->nullable();
            $table->string('pickupgroup')->nullable();
            $table->string('language')->nullable();
            $table->string('allow')->nullable();
            $table->string('disallow')->nullable();
            $table->string('insecure')->nullable();
            $table->string('trustrpid')->nullable();
            $table->string('progressinband')->nullable();
            $table->string('promiscredir')->nullable();
            $table->string('useclientcode')->nullable();
            $table->string('accountcode')->nullable();
            $table->string('setvar')->nullable();
            $table->string('callerid')->nullable();
            $table->string('amaflags')->nullable();
            $table->string('callcounter')->nullable();
            $table->integer('busylevel')->nullable();
            $table->string('allowoverlap')->nullable();
            $table->string('auth')->nullable();
            $table->string('parkinglot')->nullable();
            $table->string('call-limit')->nullable();
            $table->string('allowsubscribe')->nullable();
            $table->string('videosupport')->nullable();
            $table->string('regexten')->nullable();
            $table->string('fromdomain')->nullable();
            $table->string('fromuser')->nullable();
            $table->string('qualify')->nullable();
            $table->string('defaultip')->nullable();
            $table->string('sendrpid')->nullable();
            $table->string('outboundproxy')->nullable();
            $table->string('dtlsenable')->nullable();
            $table->string('dtlsverify')->nullable();
            $table->string('dtlsprivatekey')->nullable();
            $table->string('dtlscertfile')->nullable();
            $table->string('dtlssetup')->nullable();
            $table->string('rtcp_mux')->nullable();
            $table->string('icesupport')->nullable();
            $table->string('avpf')->nullable();
            $table->string('context_to')->nullable();
            $table->string('record')->nullable();

            $table->timestamps();

            //$table->foreign('accountcode')->references('accountcode')->on('customer')->onDelete('cascade')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
