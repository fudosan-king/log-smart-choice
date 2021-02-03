<?php

use App\Http\Traits\PagesSeoList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTagContentAndEditFieldNameTableTag extends Migration
{

    use PagesSeoList;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {

            $table->string('name_content', 50)->nullable()->after('name');
            $table->renameColumn('content', 'tag_content');
        });

        if (Schema::hasTable('data_rows')) {
            if (Schema::hasTable('data_rows')) {
                $tags = DB::table('data_types')->where('slug', 'tags')->get();
                if ($tags->isNotEmpty()) {
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'type')
                        ->update([
                            'type'    => 'select_dropdown',
                            'details' => ["default" => 'Title', "options" => ['title' => 'Title', 'meta' => 'Meta']],
                        ]);
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'content')
                        ->update([
                            'field' => 'tag_content',
                        ]);
                    DB::table('data_rows')
                        ->insert([
                            'data_type_id' => $tags[0]->id,
                            'field'        => 'name_content',
                            'type'         => 'text',
                            'display_name' => 'Name Content',
                            'required'     => 0,
                            'browse'       => 1,
                            'read'         => 1,
                            'edit'         => 1,
                            'add'          => 1,
                            'delete'       => 1,
                            'order'        => 3,
                        ]);

                    $allPage = $this->getPagesSeo();
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'page_id')
                        ->update([
                            'details' => ["default" => $allPage[1], "options" => $allPage],
                        ]);
                }

                // Default page SEO
                $pageDefault = DB::table('pages_seo')->where('name', 'default')->get();

                if ($pageDefault->isEmpty()) {
                    $pageDefaultId = DB::table('pages_seo')->insertGetId([
                        'name'       => 'default', 'status' => 1,
                        'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                        'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                    ]);
                } else {
                    $pageDefaultId = $pageDefault[0]->id;
                }
                $tagDefault = DB::table('tags')->where('page_id', $pageDefaultId)->get();

                if ($tagDefault->isNotEmpty()) {
                    DB::table('tags')->where('page_id', $pageDefaultId)
                        ->where('type', 'meta')
                        ->where('name', 'keyword')->update([
                            'name'         => 'name',
                            'name_content' => 'keywords',
                        ]);
                    DB::table('tags')->where('page_id', $pageDefaultId)
                        ->where('type', 'meta')
                        ->where('name', 'description')->update([
                            'name'         => 'name',
                            'name_content' => 'description',
                        ]);
                }

            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('data_rows')) {
            if (Schema::hasTable('data_rows')) {
                $tags = DB::table('data_types')->where('slug', 'tags')->get();
                if ($tags->isNotEmpty()) {
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'type')
                        ->update([
                            'type'    => 'text',
                            'details' => '',
                        ]);
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'tag_content')
                        ->update([
                            'field' => 'content',
                        ]);
                    DB::table('data_rows')
                        ->where('data_type_id', $tags[0]->id)
                        ->where('field', 'name_content')
                        ->delete();

                }

                // Default page SEO
                $pageDefault = DB::table('pages_seo')->where('name', 'default')->get();

                if ($pageDefault->isEmpty()) {
                    $pageDefaultId = DB::table('pages_seo')->insertGetId([
                        'name'       => 'default', 'status' => 1,
                        'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                        'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                    ]);
                } else {
                    $pageDefaultId = $pageDefault[0]->id;
                }
                $tagDefault = DB::table('tags')->where('page_id', $pageDefaultId)->get();

                if ($tagDefault->isNotEmpty()) {
                    DB::table('tags')->where('page_id', $pageDefaultId)
                        ->where('type', 'meta')
                        ->where('name', 'name')
                        ->where('name_content', 'keywords')
                        ->update([
                            'name'         => 'name',
                            'name_content' => '',
                        ]);
                    DB::table('tags')->where('page_id', $pageDefaultId)
                        ->where('type', 'meta')
                        ->where('name', 'name')
                        ->where('name_content', 'description')
                        ->update([
                            'name'         => 'description',
                            'name_content' => '',
                        ]);
                }
            }
        }

        Schema::table('tags', function (Blueprint $table) {

            $table->dropColumn('name_content');
            $table->renameColumn('tag_content', 'content');
        });
    }
}
