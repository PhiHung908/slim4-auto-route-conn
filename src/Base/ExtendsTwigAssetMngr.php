<?php

declare(strict_types=1);

namespace App\Base;

use Glazilla\TwigAsset\TwigAssetManagement;

/**
 * PhiHung Note: phai sua file TwigAssetManagement cho nó extend TwigAssetExtension
 * mod func nhu duoi
	public function getAssetExtension() : AbstractExtension
    {
        $this->loadDefaultPackage();
        $this->loadNamedPackages();
    -    //return new TwigAssetExtension(new Packages($this->defaultPackage, $this->namedPackages));
	+	parent::__construct(new Packages($this->defaultPackage, $this->namedPackages));
	+	return $this;

    }
 */
class ExtendsTwigAssetMngr extends TwigAssetManagement
{
	
	public $assetSender = [];
	
	public function __construct(array $userSettings = [])
    {
		parent::__construct($userSettings);
	}
	
	public function asset(string $path = '', string $packageName = ''): string
	{
		if ($path == '' || $path == 'render' ) {
			echo $this->renderAsset();
			return '';
		} else return parent::asset($path, $packageName);
	}
		
	public function addArrayAsset($dir, array $k_v) {
		//$this->assetSender = array_merge($this->assetSender, $k_v);
		if (!isset($this->assetSender[$dir])) $this->assetSender[$dir] = [];
		$this->assetSender[$dir] = array_merge($this->assetSender[$dir], $k_v);
	}
	
	
	public function renderAsset($xKey = null) {
		$s = '';
		foreach ($this->assetSender as $dir) {
		foreach ($dir as $jscss => $aFile) { 
			foreach ($aFile as $n => $file) { //TODO: còn phần muốn đặt các file ở head hoặc body hoặc footer..
				$xK = $xKey ?? $jscss;
				if ($xK === 'js') {
					$s .= '<script type="text/javascript" src="' . $file . '"></script>';
				} else if ($xK === 'css') {
					$s .= '<link rel="stylesheet" href="' . $file . '">';
				} if ($xK === 'img') {
					$s .= '<link rel="image" href="' . $file . '">';
				}
			}
		}
		}
		return $s;
	}
	
}
