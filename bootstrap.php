<?php
// Add in the tests directory for phpunit
$base = dirname(__FILE__).DIRECTORY_SEPARATOR;
set_include_path("{$base}classes:"."{$base}tests:".get_include_path());

spl_autoload_register("auto_load");

/**
 * Autoloader
 *
 * @param	string	The class to load
 * @return	boolean	Did the class load?
 */
function auto_load($name)
{
	$found = false;
	$path = str_replace("_", "/", $name);

	foreach (explode(":", get_include_path()) as $dir)
	{
		$fp = $dir.DIRECTORY_SEPARATOR.$path.".php";
		if (is_file($fp))
		{
			$found = true;
			require_once $fp;
			break;
		}
	}

	return $found;
}

// Timezone
date_default_timezone_set('America/Detroit');
