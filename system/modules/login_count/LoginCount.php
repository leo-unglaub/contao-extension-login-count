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
 * Class LoginCount
 * Provide methods to count the frontend logins
 */
class LoginCount extends Frontend
{
	/**
	 * Count the logins from a frontend user
	 * 
	 * @param User $objUser
	 * @return void
	 */
	public function incrementCounter($objUser)
	{
		$this->import('Database');

		// only perform if the database field already exists, otherwize we have an error message during the database update
		if ($this->Database->fieldExists('lu_login_count', 'tl_content') && TL_MODE == 'FE')
		{
			// increment the counter using an sql command
			$objUpdateCount = $this->Database->prepare('UPDATE tl_member SET lu_login_count=lu_login_count+1 WHERE id=?')
											 ->execute($objUser->id);
		}
	}


	/**
	 * Check the permissions of each content element and show them or not
	 * 
	 * @param object $objElement
	 * @param string $strBuffer
	 * @return string
	 */
	public function checkCounterPermissions($objElement, $strBuffer)
	{
		// if no FE user is logged in, we can skip the complete test
		if (!FE_USER_LOGGED_IN && $objElement->lc_from > 0)
		{
			return '';
		}

		// the article view parse the content elements, so we skip the check
		if (TL_MODE == 'BE')
		{
			if($objElement->lc_from > 0 || $objElement->lc_to > 0)
			{
				return '<div class="cte_type">' . sprintf($GLOBALS['TL_LANG']['MSC']['login_count_be_info'], $objElement->lc_from, $objElement->lc_to) . '</div>' . $strBuffer;
			}
			else
			{
				return $strBuffer;
			}
		}

		$this->Import('FrontendUser', 'User');

		// see KV Diagram :) Big thanks to xtra
		// typecast to get a zero for non logged in users
		if
		(
			((int) $this->User->lu_login_count >= $objElement->lc_from && $this->User->lu_login_count <= $objElement->lc_to)
			|| ($objElement->lc_from == 0 && $objElement->lc_to == 0)
			|| ($intLogins >= $objElement->lc_from && $objElement->lc_to == 0)
		)
		{
			return $strBuffer;
		}

		return '';
	}
}

?>