<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting()
    {
        return new class {
            public function get(string $key, $default = null)
            {
                return Setting::get($key, $default);
            }

            public function set(string $key, $value): void
            {
                Setting::set($key, $value);
            }
        };
    }
}
