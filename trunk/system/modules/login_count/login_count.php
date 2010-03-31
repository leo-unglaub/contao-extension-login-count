<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
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

class login_count extends Frontend {
	
	public function count_fe($objUser)
	{
		$this->import('Database');
		$objUserActCount = $this->Database->prepare('SELECT lu_login_count FROM tl_member WHERE id=?')->execute($objUser->id);
		$intActCount = $objUserActCount->lu_login_count;
		
		//TODO: Ich weiß nicht obs nötig ist oder ob PHP mittlerweile auch null ++$value rechnen kann ohne notice.
		if (empty($intActCount))
			$intActCount = 0;

		$objUpdateCount = $this->Database->prepare('UPDATE tl_member %s WHERE id=?')->set(array('lu_login_count' => ++$intActCount))->execute($objUser->id);								
	}
}
?>