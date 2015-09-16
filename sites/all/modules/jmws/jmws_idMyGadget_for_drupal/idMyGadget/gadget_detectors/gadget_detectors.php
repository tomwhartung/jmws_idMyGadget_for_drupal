<!DOCTYPE html>
<html lang='en'>
<?php
$pageTitle = 'jmws_idMyGadget_for_wordpress';
?>

<head>
	<title><?php print $pageTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../css/allDevices.css" />
	<link rel="stylesheet" type="text/css" href="../css/mediaQueries.css" />
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="../css/device/explorer.css" media="all" />
	<![endif]-->
</head>

<body>
<div id="container">
<?php
	print "<h1>$pageTitle</h1>";
?>
<div id="content">
	<p>The IdMyGadget Adapter API offers a common API to the device detectors listed on this page.</p>
	<p>Learn more about idMyGadget by installing and playing around with it; the git repo is here:
		<a href="https://github.com/tomwhartung/idMyGadget" target="_blank">https://github.com/tomwhartung/idMyGadget</a> .</p>
	<h4>Gadget Detectors:</h4>
	<p>Each of the following gadget detector links takes you to a page containing links that demonstrate how to use the
	 selected detector, with and without the IdMyGadget Adapter API.</p>
	<dl>
		<dt><a href="detect_mobile_browsers">detect_mobile_browsers</a></dt>
		<dd>A script available from the site <a href="http://detectmobilebrowsers.com" target="_blank">detectmobilebrowsers.com</a>
			is simple to install but can tell only whether the visitor is using a browser on a phone.</dd>
		<dt><a href="mobile_detect">mobile_detect</a></dt>
		<dd>The Mobile Detect device detection package is lightweight, fully open source, and returns several parameters for each device.
		<dt><a href="tera_wurfl">tera_wurfl</a></dt>
		<dd>The Tera-Wurfl device detection package requires a MySql database and is released under a modified GNU licence so it is not fully open source.
			It returns hundreds of parameters for each device.</dd>
	</dl>
	<hr />
	<dl>
		<dt><a href="ua_parser" class="disabled">ua_parser</a></dt>
		<dd>TBD.  The repositories at
			<a href="https://github.com/ua-parser/uap-core">github.com/ua-parser/uap-core</a> and
			<a href="https://github.com/ua-parser/uap-php">github.com/ua-parser/uap-php</a>
			look promising, but I was unable to quickly get them to work, and so far the others are good enough.</dd>
	</dl>
	<hr />
	<hr />
</div> <!-- content -->
</div> <!-- container -->
</body>
</html>
