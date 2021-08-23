<?php


namespace Database\Seeds;


use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class EstateInformation extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $dataType = $this->dataType('slug', 'estates');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'estates',
                'display_name_singular' => __('Estates Baibai'),
                'display_name_plural'   => __('Estates Baibai'),
                'icon'                  => 'voyager-key',
                'model_name'            => 'App\Models\Estates',
                'controller'            => 'App\\Http\\Controllers\\EstateController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('estates');

        $estateDataType = DataType::where('slug', 'estates')->firstOrFail();

        $dataRow = $this->dataRow($estateDataType, 'estate_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Estate Name'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 1,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, '_id');
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

        $dataRow = $this->dataRow($estateDataType, 'price');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('Price'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 1,
                'order'        => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, 'status');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('ステータス'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => '非公開',
                    'options' => [
                        '非公開' => '非公開',
                        '公開中' => '公開中',
                        '成約済' => '成約済'
                    ]
                ],
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, 'date_imported');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('Date Imported'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, 'custom_field');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Custom Field'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, 'category_tab_search_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Category Tab Search'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($estateDataType, 'tab_search_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('Tab Search'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 8,
            ])->save();
        }

      $dataRow = $this->dataRow($estateDataType, 'decor');
      if (!$dataRow->exists) {
        $dataRow->fill([
          'type'         => 'text',
          'display_name' => __('Decor'),
          'required'     => 0,
          'browse'       => 0,
          'read'         => 0,
          'edit'         => 0,
          'add'          => 0,
          'delete'       => 0,
          'order'        => 9,
        ])->save();
      }

      $dataRow = $this->dataRow($estateDataType, 'renovation_type');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('リノベーション状態'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 'カスタム可能物件',
                    'options' => [
                        'カスタム可能物件' => 'カスタム可能物件',
                        'リノベ済物件' => 'リノベ済物件',
                    ]
                ],
                'order'        => 11,
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Estates Information'),
            'url'     => 'admin/estates',
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
                'icon_class' => 'voyager-shop',
                'color'      => null,
                'parent_id'  => $menuEstateId,
                'order'      => 1,
            ])->save();
        }

        $pageSeoDataType = DataType::where('model_name', 'App\Models\Estates')->where('name', 'estates')->first();
        $pageSeoDataType->icon = 'voyager-shop';
        $pageSeoDataType->save();

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