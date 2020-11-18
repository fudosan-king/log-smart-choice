<?php
namespace Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class FDKSettingsSeeder extends Seeder
{
    public function run()
    {
        $setting = $this->findSetting('admin.fdk_host');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.fdk_host'),
                'value'        => '',
                'details'      => 'FDK host',
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.log_smart_choice_api_path');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.log_smart_choice_api_path'),
                'value'        => '',
                'details'      => 'Log Smart Choice API path',
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Admin',
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
