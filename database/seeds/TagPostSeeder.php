<?php


namespace Database\Seeds;


use App\Models\TabSearch;
use App\Models\TagPost;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class TagPostSeeder extends Seeder
{

    public function run()
    {
        $dataType = $this->dataType('slug', 'tag_post');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'tag_post',
                'display_name_singular' => __('Tag Post'),
                'display_name_plural'   => __('Tags Post'),
                'icon'                  => 'voyager-window-list',
                'model_name'            => 'App\Models\TagPost',
                'controller'            => 'App\\Http\\Controllers\\TagPostController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('tag_post');
        Permission::firstOrCreate(['key' => 'edit_tag_post', 'table_name' => 'tag_post']);

        $groupsDataType = DataType::where('slug', 'tag_post')->firstOrFail();

        $dataRow = $this->dataRow($groupsDataType, 'name');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Name'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($groupsDataType, 'id');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 2,
            ])->save();
        }


        $dataRow = $this->dataRow($groupsDataType, 'status');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('Status'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 3,
                'details'      => ["default" => "Activate", "options" => [TagPost::STATUS_ACTIVE => "Activate", TagPost::STATUS_INACTIVE => "Inactivate"]],
            ])->save();
        }

        

        $menuEstate = MenuItem::where('title', 'Post Manages')->where('url', 'admin/post')->first();
        $menuEstateId = null;
        if ($menuEstate) {
            $menuEstateId = $menuEstate->id;
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Tag Post'),
            'url'     => 'admin/tag_post',
            'route'   => null,
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-flashlight',
                'color'      => null,
                'parent_id'  => $menuEstateId,
                'order'      => 1,
            ])->save();
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }
}