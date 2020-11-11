<?php
namespace Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Role;

class MenuSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run() {
        $role = Role::firstOrNew(['name' => 'Sales']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('Sales Team'),
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'sales',
        ]);

        $menu = Menu::where('name', 'sales')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Estate'),
            'url'     => 'admin/estate',
            'route'   => null,
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 0,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Estate Group'),
            'url'     => 'admin/estate_groups',
            'route'   => null,
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => '',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }
        
    }
}
