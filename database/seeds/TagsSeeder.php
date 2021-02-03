<?php


namespace Database\Seeds;


use App\Http\Traits\PagesSeoList;
use App\Models\PagesSeo;
use App\Models\Tags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class TagsSeeder extends Seeder
{

    use PagesSeoList;

    public function run()
    {
        $dataType = $this->dataType('slug', 'tags');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'tags',
                'display_name_singular' => __('Tags Seo'),
                'display_name_plural'   => __('Tags Seo'),
                'icon'                  => 'voyager-bolt',
                'model_name'            => 'App\Models\Tags',
                'controller'            => 'App\\Http\\Controllers\\TagsController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('tags');

        $groupsDataType = DataType::where('slug', 'tags')->firstOrFail();

        $dataRow = $this->dataRow($groupsDataType, 'type');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Tag Type'),
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


        $dataRow = $this->dataRow($groupsDataType, 'name');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('Tag Name'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 3,
                'details'      => ["default" => 'name', "options" => ['name' => 'name', 'property' => 'property']],
            ])->save();
        }

        $dataRow = $this->dataRow($groupsDataType, 'tag_content');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Tag Content'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($groupsDataType, 'page_id');

        $allPage = $this->getPagesSeo();

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('Page Seo'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 5,
                'details'      => ["default" => array_shift($allPage), "options" => $allPage],
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Tags Seo'),
            'url'     => 'admin/tags',
            'route'   => null,
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-bolt',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 3,
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