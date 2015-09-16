<!DOCTYPE html>
<html lang='en'>
<?php
$pageTitle = 'detect_mobile_browsers raw demo';

$usingMobilePhone = FALSE;
require_once( 'php/detectmobilebrowser.php' );
?>

<head>
	<title><?php print $pageTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../../css/allDevices.css" />
	<link rel="stylesheet" type="text/css" href="../../css/mediaQueries.css" />
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="../../css/device/explorer.css" media="all" />
	<![endif]-->
</head>

<body>

<div id="container">
<h2><?php print $pageTitle; ?></h2>
<div id="content">
	<h3>Raw Demo Results:</h3>
	<p class="centered">
	<?php
		print "usingMobilePhone = '$usingMobilePhone'";
	?>
	</p>

	<?php
		print "<h3>Using the Results</h3>";
		if ( $usingMobilePhone )
		{
			print '<p>';
			print 'This is content for phones only.  ';
			print '</p>';
			print '<p>';
			print 'You might want this content to link to ';
			print '<a href="https://en.wikipedia.org/wiki/Mobile_security">a page about mobile security</a>, ';
			print 'for example.';
			print '</p>';
		}
		else
		{
			print '<p>';
			print 'This is content for browsers that are not on a phone.  ';
			print '</p>';
			print '<p>';
			print 'You might want this content to link to ';
			print '<a href="https://en.wikipedia.org/wiki/Computer_virus">a page about computer viruses</a>, ';
			print 'for example.';   
			print '</p>';
		}
		print '<hr />';
		print '<p>';
		print 'This is content delivered to all browsers, regardless of the device.';
		print '</p>';
	?>

	<hr />
	<p class="centered">|&nbsp;<a href="index.php">Back</a>&nbsp;|</p>
	<hr />
</div> <!-- content -->
</div> <!-- container -->
</body>
</html>
