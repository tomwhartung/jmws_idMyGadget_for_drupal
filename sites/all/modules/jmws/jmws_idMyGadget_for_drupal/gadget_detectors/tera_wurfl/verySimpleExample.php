<?php
/**
 * Copied from the wurfl-dbapi/README.txt file.
 * If run from a desktop browser, expect to see "You should not be here"
 * If run from a non-desktop "gadget," expect to see "Markup" and "Resolution"
 * If neither of these display, you do not have TeraWurfl installed properly.
 */
// Include the Tera-WURFL file
// require_once('./TeraWurfl.php');
require_once('Tera-Wurfl/wurfl-dbapi/TeraWurfl.php');

// instantiate the Tera-WURFL object
$wurflObj = new TeraWurfl();

// Get the capabilities of the current client.
$wurflObj->getDeviceCapabilitiesFromAgent();

// see if this client is on a wireless device (or if they can't be identified)
if(!$wurflObj->getDeviceCapability("is_wireless_device")){
	echo "<h2>You should not be here</h2>";
}

// see what this device's preferred markup language is
echo "Markup: ".$wurflObj->getDeviceCapability("preferred_markup");

// see the display resolution
$width = $wurflObj->getDeviceCapability("resolution_width");
$height = $wurflObj->getDeviceCapability("resolution_height");
echo "<br/>Resolution: $width x $height<br/>";
?>
