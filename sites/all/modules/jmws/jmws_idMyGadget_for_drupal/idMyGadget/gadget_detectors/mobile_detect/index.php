<!DOCTYPE html>
<html lang='en'>
<?php
$detectorName = 'mobile_detect';
//
// Determine whether this dector is installed
//
if ( file_exists('Mobile-Detect/Mobile_Detect.php') )
{
	$detectorInstalled = TRUE;
	$demoDisabledClass = '';
}
else
{
	$detectorInstalled = FALSE;
	$demoDisabledClass = 'class="disabled"';
}

?>

<head>
	<title><?php print $detectorName; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../../css/allDevices.css" />
	<link rel="stylesheet" type="text/css" href="../../css/mediaQueries.css" />
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="../../css/device/explorer.css" media="all" />
	<![endif]-->
</head>

<body>
<div id="container">
 <?php
	print "<h1>$detectorName</h1>";
 ?>
 <div id='content'>
 <h3>Standard Demos:</h3>
 <dl>
	<dt><a href="https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/mobile_detect/README.md"
	  target="_blank">README.md</a></dt>
	<dd>The idMyGadget Mobile-Detect README file contains instructions on how to set up Mobile-Detect.</dd>
	<?php
		if ( ! $detectorInstalled )
		{
			print '</dl>';
			print '<dl class="warning">';
			print '<dt>Warning:</dt>';
			print '<dd>The ' . $detectorName . ' software is not installed, so demos will not work.  ';
			print 'To install ' . $detectorName . ', follow the instructions in the ';
			print '<a href="https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/mobile_detect/README.md" ';
			print   'target="_blank">README.md file</a> ';
			print 'and try again.</dd>';
			print '</div><!-- .warning -->';
			print '</dl>';
			print '<dl>';
		}
	 ?>
	<dt><a href="rawDemo.php" <?php print $demoDisabledClass; ?> >rawDemo.php</a></dt>
	<dd>Demonstrates <?php print $detectorName; ?>
		device detection, <strong>without</strong> using the IdMyGadget Adapter API.</dd>
	<dt><a href="Mobile-Detect/examples/demo.php" <?php print $demoDisabledClass; ?> target="_blank">
		Mobile-Detect/examples/demo.php</a></dt>
	<dd>The Mobile-Detect example demo program</dd>
	<dt><a href="idMyGadgetDemo.php" <?php print $demoDisabledClass; ?> >idMyGadgetDemo.php</a></dt>
	<dd>Demonstrates <?php print $detectorName; ?>
		device detection, using the IdMyGadget Adapter API.</dd>
 </dl>
 <hr />
 <p class="centered">|&nbsp;<a href="../gadget_detectors.php">Back</a>&nbsp;|</p>
 <hr />
</div> <!-- content -->
</div> <!-- container -->
</body>
</html>
