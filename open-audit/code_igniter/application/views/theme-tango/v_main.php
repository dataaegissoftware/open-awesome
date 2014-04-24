<?php 
#  Copyright 2003-2014 Opmantek Limited (www.opmantek.com)
#
#  ALL CODE MODIFICATIONS MUST BE SENT TO CODE@OPMANTEK.COM
#
#  This file is part of Open-AudIT.
#
#  Open-AudIT is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as published 
#  by the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  Open-AudIT is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
#
#  You should have received a copy of the GNU Affero General Public License
#  along with Open-AudIT (most likely in a file named LICENSE).
#  If not, see <http://www.gnu.org/licenses/>
#
#  For further information on Open-AudIT or for a license other than AGPL please see
#  www.opmantek.com or email contact@opmantek.com
#
# *****************************************************************************

/**
 * @package Open-AudIT
 * @author Mark Unwin <marku@opmantek.com>
 * @version 1.2
 * @copyright Copyright (c) 2014, Opmantek
 * @license http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
 */

if ($query) { 
if ($config->distinct_groups == 'y') {
	$old_category = '';
	foreach($query as $key) {
		if ($key->group_category != $old_category) {
			if ($old_category != '') { echo "</tbody>\n</table>\n"; }
			if ($key->group_category == 'os') {
				echo "<h3>OS</h3>\n"; 
			} else {
				echo "<h3>" . ucfirst($key->group_category) . "</h3>\n"; 
			}
			echo "<table cellspacing=\"1\" class=\"tablesorter\">\n";
			echo "	<thead>\n";
			echo "		<tr>\n";
			echo "			<th align=\"center\" style=\"width:120px;\">" .  __('Icon') . "</th>\n";
			echo "			<th align=\"center\" style=\"width:120px;\">" .  __('Systems') . "</th>\n";
			echo "			<th style=\"width:300px;\">" .  __('Name') . "</th>\n";
			echo "			<th>" .  __('Description') . "</th>\n";
			if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { echo "			<th align=\"center\" style=\"width:120px;\">" . __('Search') . "</th>\n"; }
			echo "			<th align=\"center\" style=\"width:120px;\">" . __('Reports') . "</th>\n";
			echo "		</tr>\n";
			echo "	</thead>\n";
			echo "	<tbody>\n";
		} 
		$old_category = $key->group_category;
		echo "		<tr>\n";
		echo "			<td align=\"center\"><img src=\"" . $image_path . "16_" . $key->group_icon . ".png\" alt=\"" . $key->group_category . "\" title=\"" . $key->group_category . "\" style=\"border-width:0px;\" /></td>\n";
		echo "			<td align=\"center\">" . $key->total . "</td>\n";
		if ($key->group_padded_name > "") {
			echo "			<td><span style=\"display: none;\">" . $key->group_padded_name . "</span><a href=\"" . base_url() . "index.php/main/list_devices/" . $key->group_id . "\">" . $key->group_name . "</a></td>\n";
		} else {
			echo "			<td><a href=\"" . base_url() . "index.php/main/list_devices/" . $key->group_id . "\">" . $key->group_name . "</a></td>\n";
		}
		echo "			<td>" . $key->group_description . "</td>\n";
		if (($config->non_admin_search == 'y') or ($user_admin == 'y')) {
			echo "			<td align=\"center\"><a class=\"SearchPopupTrigger\" rel=\"" . $key->group_id . "\" href=\"#\" ><img src=\"" . $image_path . "16_find.png\" style=\"border-width:0px;\" title=\"\" alt=\"\" /></a></td>\n";
		}
		echo "			<td align=\"center\"><a class=\"ReportPopupTrigger\" rel=\"" . $key->group_id . "\" href=\"#\" ><img src=\"" . $image_path . "16_csv.png\"  style=\"border-width:0px;\" title=\"\" alt=\"\" /></a></td>\n";
		echo "		</tr>\n";
	}
} else { ?>
<table cellspacing="1" class="tablesorter">
	<thead>
		<tr>
			<th align="center" style="width:120px;" class="{sorter: false}"><?php echo __('Icon')?></th>
			<th align="center" style="width:120px;"><?php echo __('Systems')?></th>
			<th><?php echo __('Name')?></th>
			<th><?php echo __('Description')?></th>
			<?php if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { ?>
			<th align="center"><?php echo __('Search')?></th>
			<?php } ?>
			<th align="center"><?php echo __('Reports')?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($query as $key): ?>
		<?php if ($key->group_category <> 'network') { ?>
		<tr>
			<td align="center"><img src="<?php echo $image_path;?>16_<?php echo $key->group_icon?>.png" alt="<?php echo $key->group_category?>" title="<?php echo $key->group_category?>" style='border-width:0px;' /></td>
			<td align="center"><?php echo $key->total?></td>
			<?php if ($key->group_padded_name > "") { ?>
				<td><span style="display: none;"><?php echo $key->group_padded_name?></span><a href="<?php echo base_url()?>index.php/main/list_devices/<?php echo $key->group_id?>"><?php echo $key->group_name?></a></td>
			<?php } else { ?>
				<td><a href="<?php echo base_url()?>index.php/main/list_devices/<?php echo $key->group_id?>"><?php echo $key->group_name?></a></td>
			<?php } ?>
			<td><?php echo $key->group_description?></td>
			<?php if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { ?>
			<td align="center"><a class="SearchPopupTrigger" rel="<?php echo $key->group_id?>" href="#" ><img src="<?php echo $image_path;?>16_find.png"  style="border-width:0px;" title="" alt="" /></a></td>
			<?php } ?>
			<td align="center"><a class="ReportPopupTrigger" rel="<?php echo $key->group_id?>" href="#" ><img src="<?php echo $image_path;?>16_csv.png"  style="border-width:0px;" title="" alt="" /></a></td>
		</tr>
		<?php } ?>
		<?php endforeach; ?>
	</tbody>
</table>
<h2>Network Groups</h2>
<table cellspacing="1" class="tablesorter">
	<thead>
		<tr>
			<th align="center" style="width:120px;"><?php echo __('Icon')?></th>
			<th align="center" style="width:120px;"><?php echo __('Systems')?></th>
			<th><?php echo __('Name')?></th>
			<th><?php echo __('Description')?></th>
			<?php if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { ?>
			<th align="center"><?php echo __('Search')?></th>
			<?php } ?>
			<th align="center"><?php echo __('Reports')?></th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		<?php foreach($query as $key): ?>
		<?php if ($key->group_category == 'network') { $i++;?>
		<tr>
			<td align="center"><img src="<?php echo $image_path;?>16_<?php echo $key->group_icon?>.png" alt="<?php echo $key->group_category?>" title="<?php echo $key->group_category?>" style='border-width:0px;' /></td>
			<td align="center"><?php echo $key->total?></td>
			<?php if ($key->group_padded_name > "") { ?>
				<td><span style="display: none;"><?php echo $key->group_padded_name?></span><a href="<?php echo base_url()?>index.php/main/list_devices/<?php echo $key->group_id?>"><?php echo $key->group_name?></a></td>
			<?php } else { ?>
				<td><a href="<?php echo base_url()?>index.php/main/list_devices/<?php echo $key->group_id?>"><?php echo $key->group_name?></a></td>
			<?php } ?>
			<td><?php echo $key->group_description?></td>
			<?php if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { ?>
			<td align="center"><a class="SearchPopupTrigger" rel="<?php echo $key->group_id?>" href="#" ><img src="<?php echo $image_path;?>16_find.png"  style="border-width:0px;" title="" alt="" /></a></td>
			<?php } ?>
			<td align="center"><a class="ReportPopupTrigger" rel="<?php echo $key->group_id?>" href="#" ><img src="<?php echo $image_path;?>16_csv.png"  style="border-width:0px;" title="" alt="" /></a></td>
		</tr>
		<?php } ?>
		<?php endforeach; ?>
		<?php if ($i == 0) { ?>
		<?php if (($config->non_admin_search == 'y') or ($user_admin == 'y')) { ?>
		<tr>
			<td></td><td></td><td></td><td></td><td></td><td></td>
		</tr>
		<?php } else { ?>
		<tr>
			<td></td><td></td><td></td><td></td><td></td>
		</tr>
		<?php } ?>
		<?php } ?>
		
	</tbody>
</table>
<?php } // end of distinct groups ?>
<?php
} else {
	echo "<br />" . __('<h2>Welcome to Open-AudIT.</h2><br />Please ensure you set the appropriate configuration items at Menu -> Admin -> Config. You should set all the "default_*" items, to take advantage of Discovery. Once that has been done, why not try running Discovery (Menu -> Admin -> Discovery) on your environment?<br /><br />Don\'t forget you can activate extra Groups via the Menu -> Admin -> Groups -> Activate Group item. This will automatically Group items and allow you to set User Access on a per Group Basis.<br /><br />Extra Reports are available at Menu -> Admin -> Reports -> Activate Report. Take a look - you might find exactly the Report you need.');
}
?>
<script type="text/javascript">
function dynamic_search( group )
{
	search_text = document.getElementById("search_term").value;
	location.href = '<?php echo site_url(); ?>/main/search/' + group + '/' + search_text;
	return false;
}
</script>