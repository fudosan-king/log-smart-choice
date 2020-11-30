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
            'title'   => 'About',
            'url'     => '',
            'route'   => 'admin.about.index',
        ]);

        Permission::generateFor('about');

        if (!$meunuItemSale->exists) {
            $meunuItemSale->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-book',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 19
            ])->save();
        }

        $dataType = $this->dataType('slug', 'about');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'about',
                'display_name_singular' => __('About'),
                'display_name_plural'   => __('About'),
                'icon'                  => 'voyager-data',
                'model_name'            => 'App\Models\About',
                'controller'            => 'App\\Http\\Controllers\\AboutController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
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
}
