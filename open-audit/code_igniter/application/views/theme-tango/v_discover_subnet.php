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

echo form_open('discovery/discover_subnet');
$image_path = base_url() . 'theme-' . $user_theme . '/' . $user_theme . '-images/';
switch ($type) {
	case '':
		$title = 'Discover the devices on your network';
		$icon = $image_path . "48_network_wireless.png";
		$scan_title = "Subnet";
		$submit_text = "Discover";
		break;

	case 'windows':
		$title = 'Audit a Windows computer';
		$icon = $image_path . "48_windows.png";
		$scan_title = "Computer";
		$submit_text = "Audit";
		break;

	case 'linux':
		$title = 'Audit a Linux computer';
		$icon = $image_path . "48_linux.png";
		$scan_title = "Computer";
		$submit_text = "Audit";
		break;

	case 'snmp':
		$title = 'Scan a device using SNMP';
		$icon = $image_path . "48_network.png";
		$scan_title = "Device";
		$submit_text = "Scan";
		break;

	case 'device':
		$title = 'Discover a device';
		$icon = $image_path . "48_network.png";
		$scan_title = "Device";
		$submit_text = "Discover";
		break;

	default:
		$title = 'Discover the devices on your network';
		$icon = $image_path . "48_network_wireless.png";
		$scan_title = "Subnet";
		$submit_text = "Discover";
		break;
}
if (!isset($ip_address)) { $ip_address = ''; }
if (!isset($system_id)) { $system_id = ''; }
if (!isset($type)) { $type = ''; }
if (isset($config->show_snmp_community) and $config->show_snmp_community == 'n') {
	$snmp_community_field = 'password';
} else {
	$snmp_community_field = 'text';
}
if (isset($config->show_passwords) and $config->show_passwords == 'n') {
	$password_field = 'password';
} else {
	$password_field = 'text';
}
?>

<fieldset id="subnet_details" class="niceforms">
	<legend><span style="font-size: 12pt;">&nbsp;<?php echo __($title)?></span></legend>
	<img style='float: right; margin; 10px; ' src='<?php echo $icon;?>' alt='' title='' width='48'/>
	<table cellpadding = "0" cellspacing="0">
		<tr>
			<td width='30%' style="vertical-align: top;">
				<p><label for='subnet'><?php echo __($scan_title); ?>: </label> <input type='text' id='subnet' name='subnet' tabindex='1' title='Subnet' value='<?php echo $ip_address; ?>' /></p>

				<?php if ($type == "" or $type == "device" or $type == "linux" or (php_uname('s') == "Linux" and $type == "windows")) { ?>
					<p><label for='network_address'><?php echo __("Local Network Address"); ?>: </label> <input type='text' id='network_address' name='network_address' tabindex='2' title='Local Network Address' value='<?php echo $config->default_network_address; ?>' />*</p>
				<?php } ?>

				<?php if ($type == "" or $type == "snmp" or $type == "device") { ?>
					<?php if (isset($credentials->snmp_community)) { 
						$snmp_community = $credentials->snmp_community;
					} else {
						$snmp_community = $config->default_snmp_community;
					} ?>
					<p><label for='snmp_community'><?php echo __("SNMP Community"); ?>: </label> <input type='<?php echo $snmp_community_field; ?>' id='snmp_community' name='snmp_community' tabindex='3' title='SNMP Community' value='<?php echo $snmp_community; ?>' /></p>
				<?php } ?>

				<?php if ($type == "" or $type == "linux" or $type == "device") { ?>
					<?php if (isset($credentials->ssh_username)) { 
						$ssh_username = $credentials->ssh_username;
					} else {
						$ssh_username = $config->default_ssh_username;
					} ?>
					<?php if (isset($credentials->ssh_password)) { 
						$ssh_password = $credentials->ssh_password;
					} else {
						$ssh_password = $config->default_ssh_password;
					} ?>
				<p><label for='ssh_username'><?php echo __("SSH User"); ?>: </label> <input type='text' id='ssh_username' name='ssh_username' tabindex='4' title='SSH User' value='<?php echo $ssh_username; ?>' /></p>
				<p><label for='ssh_password'><?php echo __("SSH Password"); ?>: </label> <input type='<?php echo $password_field; ?>' id='ssh_password' name='ssh_password' tabindex='5' title='SSH Password' value='<?php echo $ssh_password; ?>' /></p>
				<?php } ?>

				<?php if ($type == "" or $type == "windows" or $type == "device") { ?>
				<?php if (isset($credentials->windows_username)) { 
					$windows_username = $credentials->windows_username;
				} else {
					$windows_username = $config->default_windows_username;
				} ?>
				<?php if (isset($credentials->windows_password)) { 
					$windows_password = $credentials->windows_password;
				} else {
					$windows_password = $config->default_windows_password;
				} ?>
				<?php if (isset($credentials->windows_domain)) { 
					$windows_domain = $credentials->windows_domain;
				} else {
					$windows_domain = $config->default_windows_domain;
				} ?>
				<p><label for='windows_username'><?php echo __("Windows User"); ?>: </label> <input type='text' id='windows_username' name='windows_username' tabindex='6' title='Windows User' value='<?php echo $windows_username; ?>' /></p>
				<p><label for='windows_password'><?php echo __("Windows Password"); ?>: </label> <input type='<?php echo $password_field; ?>' id='windows_password' name='windows_password' tabindex='7' title='Windows Password' value='<?php echo $windows_password; ?>' /></p>
				<p><label for='windows_domain'><?php echo __("Windows Domain"); ?>: </label> <input type='text' id='windows_domain' name='windows_domain' tabindex='8' title='Windows Domain' value='<?php echo $windows_domain; ?>' /></p>
				<?php } ?>

				<?php #if ($type > "") { ?>
				<p><label for='debug'><?php echo __("Debug"); ?>: </label> <input type='checkbox' id='debug' name='debug' tabindex='9' title='Debug' />**</p>
				<?php #} ?>

				<p><input type="hidden" id="type" name="type" value="<?php echo $type; ?>" />
					<input type="hidden" id="system_id" name="system_id" value="<?php echo $system_id; ?>" />
					<label for='submit'>&nbsp;</label>
					<input type='submit' name='submit' id='submit' tabindex='10' value='<?php echo __($submit_text); ?>' /></p>
				
				<?php if ($type == "" or $type == "device" or $type == "linux" or (php_uname('s') == "Linux" and $type == "windows")) { ?>* The ip address or resolvable hostname used by external devices to talk to Open-AudIT (This should be the real IP Address of this Open-AudIT server).<br /><?php } ?>

				<?php if ($type > "") { ?><p>** Do not set "debug" in normal use. Doing so may take a while for the page to return - please be patient.</p><?php } ?>

				<?php if ($warning > '') { echo "<p><br /><br />$warning</p>\n"; } ?>
			</td>
			<td width='70%' style="vertical-align: top;">
				<?php if ($type != '') { ?>
				<h3>Note - Discovery</h3>This will run an nmap scan against the target device, followed by attempting to retrieve details via SNMP (if SNMP is detected), then finally either running the Windows or Linux audit script (if WMI/SMB or SSH is detected). This will effectively "audit" your target device, assuming you provide the correct credentials.
				<?php } else { ?>
				<h3>Note - Discovery</h3>This will run an nmap scan against each ip address in the the target subnet, followed by attempting to retrieve details via SNMP (if SNMP is detected), then finally either running the Windows or Linux audit script (if WMI/SMB or SSH is detected). This will effectively "audit" your target subnet, assuming you provide the correct credentials.
				<?php } ?>

				<?php if ($type != 'windows') { ?>
				<h3>Note - sudo without TTY</h3>Some Linux systems cannot use "sudo" without a TTY. The discovery function relies on an SSH command without a TTY. To completely audit one of these linux distributions it is best to supply the root user credentials. If no root is supplied and sudo without a TTY is not possible, the audit script will be run but will NOT contain the amount of data as would otherwise.<br />
				<?php } ?>

				<h3>Note - SNMP Credentials</h3>The order of credential use for SNMP is as follows: Device specific credentials will be used as a first preference. If these fail (or do not exist) the form credentials (the credentials on this form) will be attempted. If these fail the Open-AudIT default credentials (as per Menu -> Admin -> Config) will be attempted.<br />

				<h3>Note - Audit Credentials</h3>The credentials used for auditing are device specific (if they exist) then form supplied (the credentials on this form). Device specific credentials can be modified on the Device Summary pages by clicking the menu item for Credentials.<br />

				<h3>Note - Credentials Storage</h3>Any credentials that are used and are valid will be stored against the specific device. These can be modified per device on the Device Summary pages by clicking the menu item for Credentials.</br />
			</td>
		</tr>
	</table>
</fieldset>
<br />

<?php
if ($type == '') {
	if ($config->default_snmp_community == '' or
		$config->default_ssh_username == '' or 
		$config->default_ssh_password == '' or 
		$config->default_windows_username == '' or 
		$config->default_windows_password == '' or 
		$config->default_windows_domain == ''){
	?>
	<p><h3 style="color: blue">Warning</h3>Please ensure you have default for ALL attributes. Defaults can be set on the Config page - click <a href="<?php echo base_url(); ?>index.php/admin/edit_config" style="color: red";>here</a>.<br />
	<?php } ?>
	<h3>Subnet Examples</h3>The format of the subnet is specified in standard Nmap syntax. The following are valid examples:<br />
		192.168.0.1 (a single address)<br />
		192.168.1.2/32 (a single address with mask)<br />
		192.168.3.0/24 (a 24 bit mask - 192.168.3.0 to 192.168.3.255)<br />
		198.168.0-255.1-127 (a range of ip addresses)<br />
	<br />
	<h3>Network Group Creation</h3>At present Network Groups will be created is a subnet is supplied using a slash (ie - 192.168.1.0/24) and you have the config option to auto create network groups set to 'y'. Network Groups will NOT be created if a range of ip addresses, a /32 subnet or a single ip address is supplied.</p>
	<br />
<?php } else { ?>

<?php } ?>

</form>
