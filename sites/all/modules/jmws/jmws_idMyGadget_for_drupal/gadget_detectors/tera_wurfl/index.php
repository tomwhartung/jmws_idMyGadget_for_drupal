<!DOCTYPE html>
<html lang='en'>
<?php
$detectorName = 'tera_wurfl';
//
// Determine whether this dector is installed
//
if ( file_exists('Tera-Wurfl/wurfl-dbapi/TeraWurflConfig.php') )
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
	<h3>Installation and Administration:</h3>
	<dl>
		<dt><a href="https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/tera_wurfl/README.md"
		  target="_blank">README.md</a></dt>
		<dd>The idMyGadget Tera-Wurfl README file contains instructions on how to set up Tera-Wurfl.</dd>
		<dt><a href="Tera-Wurfl/wurfl-dbapi/README.txt">Tera-Wurfl/wurfl-dbapi/README.txt</a></dt>
		<dd>The Tera-Wurfl README file contains detailed installation instructions.</dd>
		<dt><a href="Tera-Wurfl/wurfl-dbapi/admin/install.php">
			Tera-Wurfl/wurfl-dbapi/admin/install.php</a></dt>
		<dd>The Tera-Wurfl install script that initializes the database.
			For more information, see the README files.</dd>
	</dl>
	<?php
		if ( ! $detectorInstalled )
		{
			print '<dl class="warning">';
			print '<dt>Warning:</dt>';
			print '<dd>The ' . $detectorName . ' device detector software is not installed, ';
			print 'so demos will not work.  ';
			print 'To install ' . $detectorName . ', follow the instructions in the ';
			print '<a href="https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/tera_wurfl/README.md" ';
			print   'target="_blank">README.md file</a> ';
			print 'and try again.</dd>';
			print '</div><!-- .warning -->';
			print '</dl>';
		}
	 ?>
	<h3>Standard Demos:</h3>
	<dl>
		<dt><a href="verySimpleExample.php" <?php print $demoDisabledClass; ?> target="_blank">
			verySimpleExample.php</a></dt>
		<dd>A Tera-Wurfl "EXAMPLE" demo program copied from the
			<a href="Tera-Wurfl/wurfl-dbapi/README.txt" target="_blank">
			Tera-Wurfl/wurfl-dbapi/README.txt</a> file.
			<br />
			Expected results:
			<ul>
			<li>If accessed in a desktop browser, expect to see "You should not be here."</li>
			<li>If accessed in a mobile browser, expect to see the markup version and resolution.
			You may have to pinch to zoom into the display so you can read the values.</li>
			</ul>
		</dd>
		<dt><a href="rawDemo.php" <?php print $demoDisabledClass; ?> >rawDemo.php</a></dt>
		<dd>Demonstrates <?php print  $detectorName; ?>
			device detection, <strong>without</strong> using the IdMyGadget Adapter API.</dd>
		<dt><a href="idMyGadgetDemo.php" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php</a></dt>
		<dd>Demonstrates <?php print $detectorName; ?>
			device detection, using the IdMyGadget Adapter API.</dd>
	</dl>
	<h3>More Demos:</h3>
	<dl>
		<dt><a href="idMyGadgetDemo.php?displayDeviceData=true" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php?displayDeviceData=true</a></dt>
		<dd>Displays the gadget types that idMyGadget has deduced from the key capabilities obtained from Tera-Wurfl</dd>
		<dt><a href="idMyGadgetDemo.php?displayKeyCapabilities=true" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php?displayKeyCapabilities=true</a></dt>
		<dd>Displays all the key capabilities that idMyGadget uses to determine what type of device the user is using</dd>
		<dt><a href="idMyGadgetDemo.php?displayCapabilityArrays=true" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php?displayCapabilityArrays=true</a></dt>
		<dd>Displays the capability arrays that Tera-Wurfl can identify</dd>
		<dt><a href="idMyGadgetDemo.php?displayAllCapabilities=true" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php?displayAllCapabilities=true</a></dt>
		<dd>Displays all of the capabilities that Tera-Wurfl can identify</dd>
		<dt><a href="idMyGadgetDemo.php?displaySortedCapabilities=true" <?php print $demoDisabledClass; ?> >
			idMyGadgetDemo.php?displaySortedCapabilities=true</a></dt>
		<dd>Displays a sorted list of the capabilities that Tera-Wurfl can identify</dd>
		<dt><a href=""></a></dt>
		<dd></dd>
	</dl>
	<h3>Wurfl Reference</h3>
	<dl>
		<dt><a href="http://sourceforge.net/projects/wurfl/" target="_blank">
		sourceforge.net/projects/wurfl/</a></dt>
		<dd>WURFL Home Page at sourceforge.net .</dd>
		<dt><a href="http://sourceforge.net/projects/wurfl/files/WURFL%20Database/" target="_blank">
		sourceforge.net/projects/wurfl/files/WURFL Database/</a></dt>
		<dd>WURFL Database Download Page at sourceforge.net .</dd>
		<dt><a href="http://www.tera-wurfl.com/wiki/index.php/Main_Page" target="_blank">
		www.tera-wurfl.com/wiki/index.php/Main_Page</a></dt>
		<dd>Tera Wurfl Wiki main page.</dd>
		<dt><a href=""></a></dt><dd></dd>
	</dl>
	<hr />
	<p class="centered">|&nbsp;<a href="../gadget_detectors.php">Back</a>&nbsp;|</dt>
	<hr />
</div> <!-- content -->
</div> <!-- container -->
</body>
</html>
