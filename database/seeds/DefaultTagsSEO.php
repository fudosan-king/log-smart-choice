<?php

namespace Database\Seeds;

use App\Models\PagesSeo;
use App\Models\Tags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultTagsSEO extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default page SEO
        $pageDefault = PagesSeo::where('name', 'default')->first();
        $tagDefault = Tags::where('page_id', $pageDefault->id)->get();
        if ($pageDefault && $tagDefault->isEmpty()) {
            Tags::insert([
                [
                    'type'         => 'title',
                    'name'         => '',
                    'name_content' => '',
                    'tag_content'  => 'Đây là title nhóe',
                    'page_id'      => $pageDefault->id,
                    'created_at'   => DB::raw('CURRENT_TIMESTAMP'),
                    'updated_at'   => DB::raw('CURRENT_TIMESTAMP'),
                ],
                [
                    'type'         => 'meta',
                    'name'         => 'name',
                    'name_content' => 'keywords',
                    'tag_content'      => 'Meta keywords nè',
                    'page_id'      => $pageDefault->id,
                    'created_at'   => DB::raw('CURRENT_TIMESTAMP'),
                    'updated_at'   => DB::raw('CURRENT_TIMESTAMP'),
                ],
                [
                    'type'         => 'meta',
                    'name'         => 'name',
                    'name_content' => 'description',
                    'tag_content'      => 'Meta description for default page',
                    'page_id'      => $pageDefault->id,
                    'created_at'   => DB::raw('CURRENT_TIMESTAMP'),
                    'updated_at'   => DB::raw('CURRENT_TIMESTAMP'),
                ],
            ]);
        }
    }
}
