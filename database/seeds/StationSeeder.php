<?php

namespace Database\Seeds;

use App\Http\Traits\CustomAdminVoyager;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class StationSeeder extends Seeder
{
    use CustomAdminVoyager;

    public function run()
    {
        $dataType = $this->dataType('slug', 'stations');
        if (!$dataType->exists) {
            $dataType->fill([
                'name' => 'stations',
                'display_name_singular' => __('Stations'),
                'display_name_plural' => __('Stations'),
                'icon' => 'voyager-bolt',
                'model_name' => 'App\Models\Station',
                'controller' => 'App\\Http\\Controllers\\ImportManagementSystemController',
                'description' => '',
                'server_side' => 1
            ])->save();
        }
        Permission::generateFor('stations');

        $groupsDataType = DataType::where('slug', 'stations')->firstOrFail();

        $dataRow = $this->dataRow($groupsDataType, 'name');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => __('Station name'),
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('Station'),
            'url' => 'admin/stations',
            'route' => null,
        ]);

        $menuEstate = MenuItem::where('title', 'Estates')->where('url', 'admin/estates')->first();
        $menuEstateId = null;
        if ($menuEstate) {
            $menuEstateId = $menuEstate->id;
        }

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-bolt',
                'color' => null,
                'parent_id' => $menuEstateId,
                'order' => 3,
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
