<!DOCTYPE html>
<html lang='en'>
<?php
$pageTitle = 'mobile_detect raw demo';

require_once 'Mobile-Detect/Mobile_Detect.php';
$detect = new Mobile_Detect;

$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

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
		print "deviceType = '$deviceType'";
	?>
	</p>
	<h3>Using the Results</h3>
	<?php if ( $deviceType == 'phone' ): ?>
		<p>This is content for phones only.</p>
		<p>You might want this content to link to
			<a href="https://en.wikipedia.org/wiki/Mobile_security">a page about mobile security</a>,
			for example.</p>
	<?php else: ?>
		<p>This is content for browsers that are not on a phone.</p>
		<p>You might want this content to link to
			<a href="https://en.wikipedia.org/wiki/Computer_virus">a page about computer viruses</a>,
			for example.</p>
	<?php endif; ?>
	<hr />
	<p>This is content delivered to all browsers, regardless of the device.</p>
	<hr />
	<p class="centered">|&nbsp;<a href="index.php">Back</a>&nbsp;|</dt>
	<hr />
</div> <!-- content -->
</div> <!-- container -->
</body>
</html>
