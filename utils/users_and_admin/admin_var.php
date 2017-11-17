<?php

/*
* OLD
* use only for many admin levels
* possible conflict with login_functions
* use login_functions for secure functionality
*/

$_admin;

$_ADMIN_LEVEL_ZERO = 0;
$_ADMIN_LEVEL_NORMAL = 1;
$_ADMIN_LEVEL_SUPER = 2;

$_admin = $_ADMIN_LEVEL_ZERO;

function isAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	if ($_admin >= $_ADMIN_LEVEL_NORMAL)
		return true;
	else
		return false;
}

function setAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	$_admin = $_ADMIN_LEVEL_NORMAL;
}

function removeAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	$_admin = $_ADMIN_LEVEL_ZERO;
}

function isSuperAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	if ($_admin >= $_ADMIN_LEVEL_SUPER)
		return true;
	else
		return false;
}

function setSuperAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	$_admin = $_ADMIN_LEVEL_SUPER;
}

function removeSuperAdmin()
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	if ($_admin >= $_ADMIN_LEVEL_SUPER)
	{
		$_admin = $_ADMIN_LEVEL_NORMAL;
	}
	else
	{
		//do nothing
	}
}

function setAdminLevel($level)
{
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	$_admin = $level;
}
function getAdminLevel()
{	
	global $_admin;
	global $_ADMIN_LEVEL_ZERO;
	global $_ADMIN_LEVEL_NORMAL;
	global $_ADMIN_LEVEL_SUPER;
	
	return $_admin;
}
?>