<!DOCTYPE html>
<html lang='en'>
<?php
/**
 * Instantiate an IdMyGadget object and use it to display a page with links that allow
 * the user to see information about the device making the request in various forms.
 * These "various forms" include raw WURFL information, key capabilities, and
 * summary device data based on key WURFL device capabilities.
 */
$pageTitle = basename( $_SERVER['PHP_SELF'], '.php' );

require_once 'Tera-Wurfl/wurfl-dbapi/TeraWurfl.php';
require_once '../../php/IdMyGadgetTeraWurfl.php';
require_once '../all_detectors/getIdMyGadgetStringAllDevices.php';
require_once '../all_detectors/printStyleSheetLinkTags.php';
require_once 'DemoTeraWurfl.php';

//
// debugging: displays verbose information; we don't need to use this very often
// allowOverridesInUrl: Allow testing with overrides as GET variables, TRUE is OK 
//    for example:
//       <a href="http://localhost/resume/?gadgetType=phone&gadgetModel=iPhone&gadgetBrand=Apple">
//
$debugging = FALSE;
$allowOverridesInUrl = TRUE;   // Needed for footer forms to work
$idMyGadget = new IdMyGadgetTeraWurfl( $debugging, $allowOverridesInUrl );
$idMyGadget->idMyGadgetDir = '../..';
$deviceData = $idMyGadget->getDeviceData();
$gadgetString = getIdMyGadgetStringAllDevices( $deviceData );
?>

<head>
	<title><?php print $pageTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php
		$styleSheetFile = printStyleSheetLinkTags( $deviceData );
	?>
</head>

<body>
<div id="container">
<h2><?php print $pageTitle; ?></h2>
<div id='content'>
	<h3><?php print get_class($idMyGadget); ?></h3>
	<h3><?php print $gadgetString ?></h3>

<?php
//
// Produce and display any demo output that may be desired
// -------------------------------------------------------
//
$demoTeraWurfl = new DemoTeraWurfl( $idMyGadget );
$displayCapabilityArrays = filter_input( INPUT_GET, 'displayCapabilityArrays', FILTER_VALIDATE_BOOLEAN );
$displayAllCapabilities  = filter_input( INPUT_GET, 'displayAllCapabilities', FILTER_VALIDATE_BOOLEAN );
$displaySortedCapabilities = filter_input( INPUT_GET, 'displaySortedCapabilities', FILTER_VALIDATE_BOOLEAN );
$displayKeyCapabilities = filter_input( INPUT_GET, 'displayKeyCapabilities', FILTER_VALIDATE_BOOLEAN );
$displayDeviceData = filter_input( INPUT_GET, 'displayDeviceData', FILTER_VALIDATE_BOOLEAN );
$output = "";
//
// Print a "Back" link at the top of pages with a lot of content,
// so the user doesn't need to scroll all the way down to go Back.
//
$longOutput = FALSE;
if ( isset($displayAllCapabilities) ||
	   isset($displayCapabilityArrays) ||
	   isset($displaySortedCapabilities) )
{
	$longOutput = TRUE;
}
if ( $longOutput === TRUE )
{
		$output .= '<hr />';
		$output .= '<p class="centered"><a href="index.php">Back</a></p>';
		$output .= '<hr />';
}

if ( isset($displayAllCapabilities) )
{
	$output .= "<h3>Flat List of Capabilities</h3>";
	$output .= "<ul class='no-bullets'>" . $demoTeraWurfl->displayAllCapabilities() . "</ul>";
}
else if ( isset($displayCapabilityArrays) )
{
	$output .= "<h3>Capability Arrays for This Device</h3>";
	$output .= $demoTeraWurfl->displayCapabilityArrays();
}
else if ( isset($displayKeyCapabilities) )
{
	$idMyGadget->getKeyCapabilities();
	$output .= "<h3>Key Capabilities</h3>";
	$output .= "<ul class='no-bullets'>" . $idMyGadget->displayKeyCapabilities() . "</ul>";
}
else if ( isset($displaySortedCapabilities) )
{
	$output .= "<h3>Sorted List of Capabilities</h3>";
	$output .= "<ul class='no-bullets'>" . $demoTeraWurfl->displaySortedCapabilities() . "</ul>";
}
else // if ( isset($displayDeviceData) ) // display device data by default
{
	$output .= "<h4>detectorUsed:" . "</h4>";
	$output .= "<p class='detector-used'>" . $idMyGadget->detectorUsed . "</p>";
	$idMyGadget->getDeviceData();
	$output .= "<h4>deviceData</h4>";
	$output .= "<ul class='no-bullets'>" . $idMyGadget->displayDeviceData() . "</ul>";
}

if ( strlen($output) > 0 )
{
	print "<div class='output'>";
	print $output;
	print "</div> <!-- output -->";
}
?>

	<p class="centered">
		<?php
			if ( $longOutput === TRUE )
			{
				print '<hr />';
				print '|&nbsp;<a href="#container">Top</a>&nbsp;';
			}
		?>

</div> <!-- #content -->
<footer>
	<hr />
	<div class="footerLink">
		<p class="centered">|&nbsp;<a href="index.php">Back</a>&nbsp;|</p>
	</div> <!-- .footerLink -->
	<hr />
</footer>
</div> <!-- #container -->
</body>
</html>
