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
 * @copyright  LU-Hosting 2010
 * @author     Leo Unglaub <leo@leo-unglaub.net>
 * @package    login_count
 * @license    LGPL
 * @filesource
 */

/**
 * Contao 2.9 contains the Hook getContentElement (http://dev.contao.org/issues/2065)
 * so we add some fields to the DCA to select from how much logins a content element sould be shown
 */
if (version_compare('2.9.0', VERSION.'.'.BUILD, '<='))
{
	// add the fields to every palette
	foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key=>$value)
	{
		// don't add to the __selector__
		if ($key != '__selector__')
		{
			$GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = str_replace(',guests', ',lc_from,lc_to,guests', $GLOBALS['TL_DCA']['tl_content']['palettes'][$key]);
		}
	}
	
	$GLOBALS['TL_DCA']['tl_content']['fields']['lc_from'] = array
	(
		'label'				=> &$GLOBALS['TL_LANG']['tl_content']['lc_from'],
		'exclude'			=> true,
		'filter'			=> true,
		'inputType'			=> 'text',
		'eval'				=> array('rgxp'=>'digit', 'tl_class' => 'w50')
	);
	
	$GLOBALS['TL_DCA']['tl_content']['fields']['lc_to'] = array
	(
		'label'				=> &$GLOBALS['TL_LANG']['tl_content']['lc_to'],
		'exclude'			=> true,
		'filter'			=> true,
		'inputType'			=> 'text',
		'eval'				=> array('rgxp'=>'digit', 'tl_class'=>'w50')
	);
	
	// fix a display problem
	$GLOBALS['TL_DCA']['tl_content']['fields']['guests']['eval']['tl_class'] = 'clr';
}

?>