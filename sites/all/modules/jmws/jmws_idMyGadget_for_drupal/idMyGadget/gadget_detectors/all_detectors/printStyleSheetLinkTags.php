<?php
require_once 'getStyleSheetFile.php';
/**
 * Prints the style sheet link tags, if desired (based on inputs in footer forms)
 *
 * @param type $deviceData
 * @return type style sheet file name (for footer forms)
 */
function printStyleSheetLinkTags( $deviceData )
{
	$styleSheetFile = getStyleSheetFile( $deviceData );

	$rmAllDevicesCss = filter_input( INPUT_GET, 'rmAllDevicesCss', FILTER_SANITIZE_NUMBER_INT );
	if ( ! $rmAllDevicesCss )
	{
		print '<link rel="stylesheet" type="text/css" href="../../css/allDevices.css" />';
	}

	$rmStyleSheetCss = filter_input( INPUT_GET, 'rmStyleSheetCss', FILTER_SANITIZE_NUMBER_INT );
	if ( ! $rmStyleSheetCss )
	{
		$rmStyleSheetCssChecked = '';
		print '<link rel="stylesheet" type="text/css" href="' . $styleSheetFile . '" />';
	}

	print '<!--[if IE]>';
	print '<link rel="stylesheet" type="text/css" href="../../css/device/explorer.css" media="all" />';
	print '<![endif]-->';

	return $styleSheetFile;
}
