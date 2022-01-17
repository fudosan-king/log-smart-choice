<?php


namespace Database\Seeds;


use App\Http\Traits\CustomAdminVoyager;
use App\Models\District;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class DistrictSeeder extends Seeder
{
    use CustomAdminVoyager;

    public function run()
    {
        $dataType = $this->dataType('slug', 'district');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'district',
                'display_name_singular' => __('District'),
                'display_name_plural'   => __('Districts'),
                'icon'                  => 'voyager-sound',
                'model_name'            => 'App\Models\District',
                'controller'            => 'App\\Http\\Controllers\\DistrictController',
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }
        Permission::generateFor('district');

        $groupsDataType = DataType::where('slug', 'district')->firstOrFail();


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
                'display_name' => __('District name'),
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
                'details'      => ["default" => "Activate", "options" => [District::STATUS_ACTIVATE => "Activate", District::STATUS_DEACTIVATE => "Deactivate"]],
            ])->save();
        }

        // $dataRow = $this->dataRow($groupsDataType, 'city_id');

        $dataRow = $this->dataRow($groupsDataType, 'romaji_name');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Romaji name'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($groupsDataType, 'count_estates');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Contain Estates'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 6,
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Districts'),
            'url'     => 'admin/district',
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
                'icon_class' => 'voyager-sound',
                'color'      => null,
                'parent_id'  => $menuEstateId,
                'order'      => 5,
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