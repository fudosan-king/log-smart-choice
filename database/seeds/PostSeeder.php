<?php

namespace Database\Seeds;

use App\Http\Traits\CustomAdminVoyager;
use App\Models\Post;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class PostSeeder extends Seeder
{
    use CustomAdminVoyager;

    public function run()
    {
        $dataType = $this->dataType('slug', 'post');
        if (!$dataType->exists) {
            $dataType->fill([
                'name' => 'post',
                'display_name_singular' => __('Post'),
                'display_name_plural' => __('Posts'),
                'icon' => 'voyager-bolt',
                'model_name' => 'App\Models\Post',
                'controller' => 'App\\Http\\Controllers\\PostController',
                'description' => '',
                'server_side' => 1
            ])->save();
        }
        Permission::generateFor('post');

        $groupsDataType = DataType::where('slug', 'post')->firstOrFail();

        $dataRow = $this->dataRow($groupsDataType, 'title');

        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => __('Title'),
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 1,
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
                'details'      => ["default" => "Activate", "options" => [Post::STATUS_ACTIVE => "Activate", Post::STATUS_INACTIVE => "Inactivate"]],
            ])->save();
        }

        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        $menu = Menu::where('name', 'admin')->first();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('Post Manages'),
            'url'     => 'admin/post',
            'route'   => null,
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-company',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

        $menuPagePost = MenuItem::where('title', 'Post Manages')->where('url', 'admin/post')->first();
        $menuPagePostId = null;
        if ($menuPagePost) {
            $menuPagePostId = $menuPagePost->id;
        }

        $menuItemChild = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('Post'),
            'url' => 'admin/post',
            'route' => null,
        ]);

        if (!$menuItemChild->exists) {
            $menuItemChild->fill([
                'target' => '_self',
                'icon_class' => 'voyager-barbell',
                'color' => null,
                'parent_id' => $menuPagePostId,
                'order' => 2,
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
