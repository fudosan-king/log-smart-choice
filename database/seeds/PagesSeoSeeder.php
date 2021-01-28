<?php


namespace Database\Seeds;

use App\Models\PagesSeo;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class PagesSeoSeeder extends Seeder
{
    public function run()
    {
        $dataType = $this->dataType('slug', 'pages_seo');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'pages_seo',
                'display_name_singular' => __('Pages SEO'),
                'display_name_plural'   => __('Pages SEO'),
                'icon'                  => 'voyager-shop',
                'model_name'            => 'App\Models\PagesSeo',
                'controller'            => 'App\\Http\\Controllers\\PagesSeoController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('pages_seo');
        Permission::firstOrCreate(['key' => 'edit_pages_seo', 'table_name' => 'pages_seo']);

        $groupsDataType = DataType::where('slug', 'pages_seo')->firstOrFail();

        $dataRow = $this->dataRow($groupsDataType, 'name');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Page Name'),
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
                'details'      => ["default" => "Activate", "options" => ["Activate" => "Activate", "Deactivate" => "Deactivate"]],
            ])->save();
        }


        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Pages SEO'),
            'url'     => 'admin/pages_seo',
            'route'   => null,
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-lab',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        $pageDefault = PagesSeo::where('name', 'default')->where('status', PagesSeo::STATUS_ACTIVATE)->get();
        if ($pageDefault->isEmpty()) {
            $pageDefault = new PagesSeo();
            $pageDefault->name = 'default';
            $pageDefault->status = 'Activate';
            $pageDefault->save();
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