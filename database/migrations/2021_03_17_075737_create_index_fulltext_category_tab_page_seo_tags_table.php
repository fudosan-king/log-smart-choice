<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndexFulltextCategoryTabPageSeoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `category_tab_search` ADD FULLTEXT INDEX category_tab_search_name_index (name)');
        DB::statement('ALTER TABLE `tab_search` ADD FULLTEXT INDEX tab_search_name_index (name)');
        DB::statement('ALTER TABLE `tags` ADD FULLTEXT INDEX tags_title_index (type, name, tag_content)');
        DB::statement('ALTER TABLE `pages_seo` ADD FULLTEXT INDEX pages_seo_name_index (name)');
        DB::statement('ALTER TABLE category_tab_search ENGINE=InnoDB');
        DB::statement('ALTER TABLE tab_search ENGINE=InnoDB');
        DB::statement('ALTER TABLE tags ENGINE=InnoDB');
        DB::statement('ALTER TABLE pages_seo ENGINE=InnoDB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE category_tab_search DROP INDEX category_tab_search_name_index');
        DB::statement('ALTER TABLE tab_search DROP INDEX tab_search_name_index');
        DB::statement('ALTER TABLE tags DROP INDEX tags_title_index');
        DB::statement('ALTER TABLE pages_seo DROP INDEX pages_seo_name_index');
    }
}
