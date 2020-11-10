<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class SaleSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'sale']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Sale',
            ])->save();
        }

        $meunuItemSale = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Sale',
            'url'     => '',
            'route'   => 'admin.sale.index',
        ]);

        if (!$meunuItemSale->exists) {
            $meunuItemSale->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-activity',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 17,
            ])->save();
        }

        $meunuItemSale = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Estate',
            'url'     => '',
            'route'   => 'admin.estate.index',
        ]);

        if (!$meunuItemSale->exists) {
            $meunuItemSale->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-data',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 18
            ])->save();
        }

        $meunuItemSale = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'About',
            'url'     => '',
            'route'   => 'admin.about.index',
        ]);

        Permission::generateFor('about');

        if (!$meunuItemSale->exists) {
            $meunuItemSale->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-data',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 19
            ])->save();
        }

        $dataType = $this->dataType('slug', 'sale');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'sale',
                'display_name_singular' => __('Sale'),
                'display_name_plural'   => __('Sale'),
                'icon'                  => 'voyager-data',
                'model_name'            => 'App\Models\Estate',
                'controller'            => 'App\\Http\\Controllers\\SaleController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('sale');
        
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
}
