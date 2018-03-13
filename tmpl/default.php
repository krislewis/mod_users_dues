<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_users_latest
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (!empty($names)) : ?>
	<ul class="usersdues<?php echo $moduleclass_sfx; ?>" >
	<?php foreach ($names as $name) : ?>
		<li>
			<?php 
			if($name->status)
			{
				$paydate = new DateTime($name->date_paid);
				$paydateformat = $paydate->format('m/d/Y');
				echo $name->year . ' Dues: paid on ' . $paydateformat; 
			}else{
				
				echo '<a href="' . $magento_url . '/' . $name->user_id . '/' . $name->user_id . '-' . $name->year . '.html"> ' . $name->year . ': Pay dues here.</a>';
			}
			?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
