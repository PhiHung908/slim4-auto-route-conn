<?php
declare(strict_types=1);
// /vendor/slim4-mod/helper/autoController.php

/**
 * use: khai bao truoc 'class': #[FastRoute('METHOD', 'parten', callabled)] - giong kieu tham so cua FastRoute\RouteCollector
 */
return  function ($app, $onlyThisModel = null, $andThisAction = null) {
		$oldDir = __DIR__;
		chdir (__DIR__ . '/../Application/Actions');
		$dir = getcwd() . '\\';
		chdir($oldDir);
		
		$s1 = '';
		$s2 = '';
		$x = 0;
		$not = '';
		function addRoute($dir, $name, &$x, &$s1, &$s2, &$not, $andThisAction) {
			$namespace = '';
			$m = null;
			$parten = '';
			$dirName = null;
			$afunc = null;
			$filename = str_replace('/','\\',$dir . $name);
			if (!file_exists($filename)) return;
			$handle = fopen($filename, "rb");
			while (($ln = fgets($handle, 4096)) !== false) {
				if (empty($namespace) && strpos($ln,'namespace') !== false) {
					$namespace = trim(explode(';',explode('namespace',$ln)[1])[0]);
				}
				
				$ln = $m ?? str_replace(';'.chr(10), chr(10) ,str_replace(chr(13).chr(10), chr(10), str_replace(' ','',$ln)));

				if (empty($m) && strpos($ln,'#[FastRoute(') !== false) {
					$opts = rtrim(trim(explode(']'.chr(10),explode('#[FastRoute(', $ln)[1])[0]), ')');
					if (strpos($opts, ',[') !== false) {
						$dirName = '[' . explode(',[', $opts)[1];
					}
					$opts = explode(',', $opts . ',,');
					$m = str_replace('"','', str_replace('\'','', $opts[0]));
					$parten = str_replace('"','', str_replace('\'','', $opts[1]));
				}
				if (!empty($m) && !empty($namespace)) break;
				if (!empty($namespace) && (
							strpos($ln, chr(10).'class') !== false 
						||  strpos($ln, chr(10).'abstract') !== false 
						||  strpos($ln, chr(10).'interface') !== false
						||  strpos($ln, chr(10).'final') !== false
					)) break; //for fast
			}
			fclose($handle);
			if (empty($m)) {
				$m = 'GET'; //$_SERVER['REQUEST_METHOD'];
				$parten = '{Route:.*}';
			}
			
			$dirName = $dirName ?? $namespace . '\\' . explode('.',$name)[0];
			
			if ($x == 1) $not = strtolower(explode('Action',$name)[0]);
			
			$s2 = str_replace(']"', ']' , str_replace('"[', '[' , str_replace('#PARTEN#', $parten, str_replace('#ACTION#', strtolower(explode('Action',$name)[0]), str_replace('#MODEL#', strtolower(explode('Action.php',$name)[0]), str_replace('#METHOD#', strtolower($m), str_replace('#DIR##NAME#', $dirName, 
				(!empty($andThisAction) && $x==1 ? 
					'$group->#METHOD#("/#ACTION#", "#DIR##NAME#");
					 $group->#METHOD#("/#ACTION#/#PARTEN#", "#DIR##NAME#");
					' : '$group->#METHOD#("/#PARTEN#", "#DIR##NAME#");'
				)
			)))))));
			
			if ($x==0) $s1 = str_replace(']"', ']' , str_replace('"[', '[' , str_replace('#MODEL#', strtolower(explode('Controller.php',$name)[0]), str_replace('#METHOD#', strtolower($m), str_replace('#DIR##NAME#', $dirName, 'use Slim\Interfaces\RouteCollectorProxyInterface as Group;
				$app->group("/#MODEL#", function (Group $group) {
						$group->#METHOD#("", "#DIR##NAME#");
						$group->#METHOD#("/{Route:[^(#NOT#/)].*}", "#DIR##NAME#");
						#SUBACTION#
					});
				')))));
			$x++;
		}
		
		function scasFile(&$x, &$s1, &$s2, &$not, $dir, $prefix = 'Controller.php', $onlyThisModel = null, $andThisAction = null) {
			$gBreak = false;
			if ($handle = opendir($dir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && (empty($onlyThisModel) || $entry === $onlyThisModel)) {
						if (is_dir($dir . $entry)) {
							$d = $dir . $entry . '\\' . ($x==0 ? 'AutoGen\\' : '');
							if ($h = opendir($d)) {
								while (false !== ($e = readdir($h))){
									if ($e !== '.' && $e !== '..' && strpos($e, $prefix)>0 && (empty($onlyThisModel) || ($x==0 && $e === $onlyThisModel.$prefix) || ($x==1 && $e = $andThisAction.$prefix ) ) ) {								
										addRoute($d, $e, $x, $s1, $s2, $not, $andThisAction);
										if (!empty($onlyThisModel)) {
											$gBreak = true;
											break;
										}
									}
								}
								closedir($h);
							}
							if ($gBreak) break;
						}
					}
				}
				closedir($handle);
			}
		}
		
		if (!empty($onlyThisModel)) {
			scasFile($x, $s1, $s2, $not, $dir, 'Controller.php', $onlyThisModel);
			scasFile($x, $s1, $s2, $not, $dir, 'Action.php'	   , $onlyThisModel, $andThisAction);
		} else {
			scasFile($x, $s1, $s2, $not, $dir, 'Controller.php');
		}
		eval(str_replace('#NOT#', $not, str_replace('#SUBACTION#', $s2, $s1)));
	}
;