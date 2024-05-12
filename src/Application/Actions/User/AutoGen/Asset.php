<?php

declare(strict_types=1);

namespace App\Application\Actions\User\AutoGen;

use App\Base\AbstractAsset;

class Asset extends AbstractAsset
{
	public $sourcePath = __DIR__ . '\\Assets';
	
    public $depends = [
	];
    
    public $js = [
		'utest1.js',
	];
    
    public $css = [
		'utest1.css',
	];
}
