<?php namespace Skripteria\Sitesearch\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateWinterSitesearchQueryLogs extends Migration
{
    public function up()
    {
        Schema::create('skripteria_sitesearch_query_logs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('query');
            $table->string('location')->nullable();
            $table->string('domain')->nullable();
            $table->string('useragent')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skripteria_sitesearch_query_logs');
    }
}
