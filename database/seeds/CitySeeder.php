<?php


namespace Database\Seeds;


use App\Http\Traits\CustomAdminVoyager;
use App\Models\City;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class CitySeeder extends Seeder
{

    use CustomAdminVoyager;

    public function run()
    {
        $dataType = $this->dataType('slug', 'city');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'city',
                'display_name_singular' => __('City'),
                'display_name_plural'   => __('City'),
                'icon'                  => 'voyager-megaphone',
                'model_name'            => 'App\Models\City',
                'controller'            => 'App\\Http\\Controllers\\CityController',
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }
        Permission::generateFor('city');

        $groupsDataType = DataType::where('slug', 'city')->firstOrFail();


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
                'type'         => 'text',
                'display_name' => __('City name'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 1,
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
                'details'      => ["default" => "Activate", "options" => [City::STATUS_ACTIVE => "Activate", City::STATUS_DEACTIVE => "Deactivate"]],
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Cities'),
            'url'     => 'admin/city',
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
                'icon_class' => 'voyager-megaphone',
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