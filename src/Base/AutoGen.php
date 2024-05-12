<?php
declare(strict_types=1);
// /vendor/slim4-mod/helper/AutoGen.php


/**
 * use: khai bao truoc 'class': #[FastRoute('METHOD', 'parten', callabled)] - giong kieu tham so cua FastRoute\RouteCollector
 */
return  function($newModuleName) {
		$sTmp = __DIR__;
		chdir (__DIR__ . '/../Application/Actions');
		$dir = getcwd() . '\\';
		chdir($sTmp);
		$newModuleName = ucfirst($newModuleName);
		
		
		//==========Action
		if (!file_exists($dir . $newModuleName . '/AutoGen/' . $newModuleName . 'Controller.php')
			&& !file_exists($dir . $newModuleName . '/AutoGen/' . $newModuleName . 'Action.php')) {
			
			echo "AutoGen Controller ...";
			$f = str_replace('/','\\', $dir . $newModuleName); //. '/AutoGen/' . $newModuleName . 'Controller.php');
			if (!is_dir($f)) mkdir($f);
			$f .= '\\AutoGen';
			if (!is_dir($f)) mkdir($f);
			$d = $f . '\\' . $newModuleName;
			$f = $d . 'Controller.php';
			$filename = str_replace('/','\\', $dir . 'TemplateController.php');
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			
			//----------
			$filename = str_replace('/','\\', $dir . 'TemplateAction.php');
			$f = $d . 'Action.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------
			$filename = str_replace('/','\\', $dir . 'TemplateAsset.php');
			$f = dirname($d) . '\\Asset.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			mkdir(dirname($d) . '\\Assets');
			mkdir(dirname($d) . '\\Assets\\js');
			mkdir(dirname($d) . '\\Assets\\css');
			mkdir(dirname($d) . '\\Assets\\img');
			//-------
			$filename = str_replace('/','\\', $dir . 'TemplateListAction.php');
			$f = str_replace('/','\\', $dir . $newModuleName) . '\\ListAction.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//-------
			$filename = str_replace('/','\\', $dir . 'TemplateRowAction.php');
			$f = str_replace('/','\\', $dir . $newModuleName) . '\\RowAction.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------
			$filename = str_replace('/','\\', $dir . 'TemplateIndexAction.php');
			$f = str_replace('/','\\', $dir . $newModuleName) . '\\IndexAction.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			
			echo " Hoàn tất.\nAutoGen Module ...";
			//=========Domain
			$dir = $dir . '../../Domain';
			chdir ($dir);
			$dir = getcwd() . '\\';
			chdir($sTmp);
			
			$filename = str_replace('/','\\', $dir . 'TemplateRepositoryInterface.php');
			$f = $dir . $newModuleName;
			if (!is_dir($f)) mkdir($f);
			$d = $f . '\\';
			$f = $d . 'RepositoryInterface.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------------
			$filename = str_replace('/','\\', $dir . 'TemplateRepository.php');
			$f = $dir . $newModuleName;
			$f = $d . 'Repository.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------------
			$filename = str_replace('/','\\', $dir . 'TemplateProduct.php');
			$f = $dir . $newModuleName;
			$f = $d . $newModuleName . '.php';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			
			echo " Hoàn tất.\nAutoGen Views ...";
			//=============Views
			$dir = $dir . '../Views';
			chdir ($dir);
			$dir = getcwd() . '\\';
			chdir($sTmp);
			
			$filename = str_replace('/','\\', $dir . 'TemplateHome.twig');
			$f = $dir . $newModuleName;
			if (!is_dir($f)) mkdir($f);
			$d = $f . '\\';
			$f = $d . 'Home.twig';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------------
			$filename = str_replace('/','\\', $dir . 'TemplateLayout.twig');
			$f = $dir . $newModuleName;
			$f = $d . 'Layout.twig';
			$handle = fopen($filename, "rb");
			$h = fopen($f, "w");
			while (($ln = fgets($handle, 4096)) !== false) {
				fwrite($h, str_replace('#TPL_PRODUCT#', $newModuleName, $ln));
			}
			fclose($h);
			fclose($handle);
			//----------------
			echo " Hoàn tất.\n";
			echo "\nModule $newModuleName đã được thiết lập, hãy gõ vào trình duyệt 'localhost/$newModuleName' để thử ngay.\n";
			return 0;
//var_dump('da AutoGen...', $f, $filename); die;
		} else {
			echo "Module $newModuleName đã tồn tại. Ứng dụng AutoGen đã ngưng sớm.\n";
			return 1;
		}
	}
;