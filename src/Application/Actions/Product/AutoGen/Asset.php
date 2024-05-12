<?php

declare(strict_types=1);

namespace App\Application\Actions\Product\AutoGen;

use App\Base\AbstractAsset;

class Asset extends AbstractAsset
{
	public $sourcePath = __DIR__ . '\\Assets';
	
    public $depends = [
		'App\Application\Actions\User\AutoGen\Asset',
	];
	
    
    public $js = [
		'test1.js',
		'test2.js',
	];
    
    public $css = [
		'test1.css',
	];
}
