<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Unglaub 2012
 * @author     Leo Unglaub <leo@leo-unglaub.net>
 * @package    login_count
 * @license    LGPL
 * @filesource
 */


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['postLogin'][] = array('LoginCount', 'incrementCounter');


// Contao 2.9 contains the Hook getContentElement (http://dev.contao.org/issues/2065)
if (version_compare('2.9.0', VERSION . '.' . BUILD, '<='))
{
	$GLOBALS['TL_HOOKS']['getContentElement'][] = array('LoginCount', 'checkCounterPermissions');
}

?>