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

class login_count extends Frontend {
	
	/**
	 * count the logins from a frontend user
	 */
	public function count_fe($objUser)
	{
		$this->import('Database');
		$intActCount = $objUser->lu_login_count;
		
		//TODO: Ich wei� nicht obs n�tig ist oder ob PHP mittlerweile auch null ++$value rechnen kann ohne notice.
		if (empty($intActCount))
			$intActCount = 0;

		$objUpdateCount = $this->Database->prepare('UPDATE tl_member SET lu_login_count=lu_login_count+1 WHERE id=?')
										 ->execute($objUser->id);								
	}
	
	/**
	 * check the permissions of each content element and show them or not
	 */
	public function check_counter_permissions($objElement, $strBuffer)
	{
		// if no FE user is logged in, we dont need to check and can solve ressources
		if (!FE_USER_LOGGED_IN && $objElement->lc_from > 0)
			return '';

		// the article view parse the content elements, so we skip the check
		if (TL_MODE == 'BE')
		{
			if($objElement->lc_from > 0 || $objElement->lc_to > 0)
				return '<div class="cte_type">' . sprintf($GLOBALS['TL_LANG']['MSC']['login_count_be_info'], $objElement->lc_from, $objElement->lc_to) . '</div>' . $strBuffer;
			else
				return $strBuffer;
		}
		
		$this->Import('FrontendUser', 'User');
		
		// see KV Diagram :) Big thanks to xtra
		// typecast to get a zero for non logged in users
		if (((int)$this->User->lu_login_count >= $objElement->lc_from && $this->User->lu_login_count <= $objElement->lc_to)
		|| ($objElement->lc_from == 0 && $objElement->lc_to == 0)
		|| ($intLogins >= $objElement->lc_from && $objElement->lc_to == 0))
		{
			return $strBuffer;
		}

		return '';
	}
}

?>