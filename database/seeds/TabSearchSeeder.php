<?php


namespace Database\Seeds;


use App\Models\TabSearch;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class TabSearchSeeder extends Seeder
{

    public function run()
    {
        $dataType = $this->dataType('slug', 'tab_search');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'tab_search',
                'display_name_singular' => __('Tab Search'),
                'display_name_plural'   => __('Tab Search'),
                'icon'                  => 'voyager-window-list',
                'model_name'            => 'App\Models\TabSearch',
                'controller'            => 'App\\Http\\Controllers\\TabSearchController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('tab_search');
        Permission::firstOrCreate(['key' => 'edit_tab_search', 'table_name' => 'tab_search']);

        $groupsDataType = DataType::where('slug', 'tab_search')->firstOrFail();

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
                'details'      => ["default" => "Activate", "options" => [TabSearch::ACTIVE => "Activate", TabSearch::INACTIVE => "Deactivate"]],
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Tab Search'),
            'url'     => 'admin/tab_search',
            'route'   => null,
        ]);

        $menuEstate = MenuItem::where('title', 'Estates')->where('url', 'admin/estates')->first();
        $menuEstateId = null;
        if ($menuEstate) {
            $menuEstateId = $menuEstate->id;
        }

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-window-list',
                'color'      => null,
                'parent_id'  => $menuEstateId,
                'order'      => 4,
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