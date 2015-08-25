<!DOCTYPE html>
<html lang='en'>
<?php
$pageTitle = basename( $_SERVER['PHP_SELF'], '.php' );

require_once( 'Mobile-Detect/Mobile_Detect.php' );
require_once( '../../php/IdMyGadgetMobileDetect.php' );
require_once '../all_detectors/getIdMyGadgetStringAllDevices.php';
require_once '../all_detectors/printStyleSheetLinkTags.php';

$debugging = FALSE;
$allowOverridesInUrl = TRUE;   // Needed for footer forms to work
$idMyGadget = new IdMyGadgetMobileDetect( $debugging, $allowOverridesInUrl );
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
<div id="content">
	<h3><?php print get_class($idMyGadget); ?></h3>
	<h3><?php print $gadgetString; ?></h3>
	<?php
		print "<div class='output'>";
		print "<h4>detectorUsed:" . "</h4>";
		print "<p class='detector-used'>" . $idMyGadget->detectorUsed . "</p>";
		print "<h4>deviceData:</h4>";
		print "<ul class='no-bullets'>" . $idMyGadget->displayDeviceData() . "</ul>";
		print "</div> <!-- .output -->";
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
