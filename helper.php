<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_users_latest
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_users_latest
 *
 * @since  1.6
 */
class ModUsersDuesHelper
{
	/**
	 * Get dues for user sorted by year
	 *
	 * @param   \Joomla\Registry\Registry  $params  module parameters
	 *
	 * @return  array  The array of users
	 *
	 * @since   1.6
	 */
	public static function getUsersDues($params)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName(array('a.user_id', 'a.year', 'a.status', 'a.date_paid')))
			->order($db->quoteName('a.year') . ' DESC')
			->from('#__user_dues AS a');
		$user = JFactory::getUser();
		$user_id = $user->id;

		if (!$user->authorise('core.admin') && $params->get('filter_groups', 0) == 1)
		{
			$groups = $user->getAuthorisedGroups();

			if (empty($groups))
			{
				return array();
			}

			$query->join('LEFT', '#__users AS b ON b.id = a.user_id')
				->where('a.user_id =' . $user_id);
		}

		$db->setQuery($query, 0, $params->get('shownumber'));

		try
		{
			return (array) $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');

			return array();
		}
	}
}
