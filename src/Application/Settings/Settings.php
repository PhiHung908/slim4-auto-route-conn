<?php

declare(strict_types=1);

namespace App\Application\Settings;

use Monolog\Logger;

class Settings implements SettingsInterface
{
    private array $settings;

    public function __construct(array $settings)
    {	
        $this->settings = array_merge($settings, [
			'temp' => APP_ROOT . '/var/temp',
		]);
    }

    /**
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
