<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class RenovationSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'renovation']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Renovation',
            ])->save();
        }

        $meunuItemRenovation = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Renovation',
            'url'     => '',
            'route'   => 'admin.renovation.index',
        ]);

        if (!$meunuItemRenovation->exists) {
            $meunuItemRenovation->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-activity',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 15,
            ])->save();
        }

        $meunuItemRenovation = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Estate',
            'url'     => '',
            'route'   => 'admin.estate.index',
        ]);

        if (!$meunuItemRenovation->exists) {
            $meunuItemRenovation->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-data',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 16
            ])->save();
        }

        Permission::firstOrCreate([
            'key'        => 'browse_profile',
            'table_name' => null,
        ]);

        $dataType = $this->dataType('slug', 'renovation');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'renovation',
                'display_name_singular' => __('Renovation'),
                'display_name_plural'   => __('Renovation'),
                'icon'                  => 'voyager-data',
                'model_name'            => 'App\Models\Renovation',
                'controller'            => 'App\\Http\\Controllers\\RenovationController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        Permission::generateFor('renovation');
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
