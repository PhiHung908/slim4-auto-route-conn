<?php
namespace App\Base;

abstract class AbstractAsset
{
    public $sourcePath;
	public $dependsAllSrcFiles = false; //true để chép tất cả src depends vào cache cho các js trong depends có thể cần dùng lẫn nhau.
    
    public $basePath;
    
    public $baseUrl;
    
    public $depends = [];
    
    public $js = [];
    
    public $css = [];
    
    public $jsOptions = [];
    
    public $cssOptions = [];
    
    public $publishOptions = [];
		
	public $storageLast = ['priv_params' => ['classModTime' => 0]];
	protected $assetCachePath = '/public/asset';
	
	private $classDir;
	private $markDepends;
	
	private $classModTime = 0;
	
	public function __construct()
    {
		$this->markDepends = $this->storageLast;
		
		$this->basePath = __DIR__ . '\\..\\..\\public';
		$this->assetCachePath = $this->basePath . '\\..\\var\\cache\\twig';
		
		$s = get_called_class();
		$ReflectionClass = new \ReflectionClass($s); 
		
		$clsFName = $ReflectionClass->getFilename();
		$this->classModTime = filemtime($clsFName);
		$this->classDir = dirname($clsFName);
		if (file_exists($this->classDir . '\\MarkDepends.php')) {
			$this->markDepends = require ($this->classDir . '\\MarkDepends.php');
			if ($this->markDepends['priv_params']['classModTime'] == $this->classModTime) {
				$this->storageLast = $this->markDepends;
				return $this;
			}
		}
	
		$storage = [];
		
		$A = $ReflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);
		foreach ($A as $prop) {
			if ($prop->class === $s) {
				$storage[str_replace('\\','-',$s)][$prop->name] = $prop->getValue($this);
			}
		}
		$this->storageLast = array_merge($this->storageLast, $storage);
		$this->cacheAsset($this->basePath, $this->sourcePath, $storage);
	}

	private function cacheAsset($basePath, $sourcePath, &$storage, $internal = false)
	{
		$pth = $basePath . '\\Assets'; 
		if (!is_dir($pth)) {
			mkdir($pth);
			$h = fopen($pth . '\\.gitignore','w');
			fwrite($h, '.*' . chr(13).chr(10) . '!.gitignore');
			fclose($h);
		}
		foreach ($storage as $sDir => $aProp) {
			$pth .= '\\' . $sDir;
			if (!is_dir($pth)) mkdir($pth);
			
			foreach($aProp as $k => $v) {
				if ( strpos(',js,css,img,' ,','.$k.',') !== false) {
					$d = $pth . '\\' . $k;
					if (!is_dir($d)) mkdir($d);
					foreach($v as $file) {
						if (empty($file)) continue;
						$src = $sourcePath . '\\' . $k . '\\' . $file;
						$des = $d . '\\' . $file;
						if (!file_exists($des) || filemtime($src) > filemtime($des)) {
							copy($src, $des);
						}
					}
				} else if ($k == 'depends' && !$internal) {
					$hasChg = false;
					foreach($v as $dep) {
						if (!in_array($dep, array_keys($this->markDepends))) {
						
							$this->markDepends['depends'][] = $dep;
							$hasChg = true;
						
							$tmp = new $dep();
							$asset = $tmp->storageLast;
							$this->storageLast = array_merge($this->storageLast, $asset);
							$this->cacheAsset($tmp->basePath, $tmp->sourcePath, $asset, true);
						}
					}
					if ($hasChg) {
						$h = fopen($this->classDir . '\\MarkDepends.php', 'w');
						$this->storageLast['priv_params']['classModTime'] = $this->classModTime;
						fwrite($h, '<?php
declare(strict_types=1);
//autoGen để đánh dấu đã gọi depends - FOR-FAST
return ' . var_export($this->storageLast, true) . '
;'
);
						fclose($h);
					}
				}
			}
		}
		$this->registerTwig();
	}
	
	
	public function registerTwig()
	{
		return $this->storageLast;
	}
	
    public static function register($view)
    {
       return 1;
    }

    public function init()
    {
        if ($this->sourcePath !== null) {
            $this->sourcePath = rtrim(Yii::getAlias($this->sourcePath), '/\\');
        }
        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }
    }
}
;
