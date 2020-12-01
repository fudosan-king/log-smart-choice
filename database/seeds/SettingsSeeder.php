<?php
namespace Database\Seeds;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $setting = $this->findSetting('about.company_name');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Company Name'),
                'value'        => __('voyager::seeders.settings.site.company_name'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 10,
                'group'        => 'AboutCompany',
            ])->save();
        }

        $setting = $this->findSetting('about.company_address');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Company Address'),
                'value'        => __('voyager::seeders.settings.site.company_address'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 20,
                'group'        => 'AboutCompany',
            ])->save();
        }

        $setting = $this->findSetting('about.established_at');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Established At'),
                'value'        => __('voyager::seeders.settings.site.established_at'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 30,
                'group'        => 'AboutCompany',
            ])->save();
        }

        $setting = $this->findSetting('about.investment');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Investment'),
                'value'        => __('voyager::seeders.settings.site.investment'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 40,
                'group'        => 'AboutCompany',
            ])->save();
        }

        $setting = $this->findSetting('about.staff');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Staff'),
                'value'        => __('voyager::seeders.settings.site.staff'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 50,
                'group'        => 'AboutCompany',
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
