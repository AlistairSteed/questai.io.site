<?php

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToCampaignTable extends Migration
{
    public function __construct()
    {
        $database = app(DatabaseManager::class);
        $platform = $database->getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('bit', 'boolean');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign', function (Blueprint $table) {
            $table->integer('caprivate')->change();
            $table->integer('caremote')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign', function (Blueprint $table) {
            $table->boolean('caprivate')->change();
            $table->boolean('caremote')->change();
        });
    }
}
