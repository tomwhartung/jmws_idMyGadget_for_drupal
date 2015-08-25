 <?php
/**
 * Return a short string describing the device, based on the device data passed in
 *
 * @param type $deviceData
 */

function getIdMyGadgetStringAllDevices( $deviceData )
{
	$gadgetString = IdMyGadget::GADGET_STRING_UNKNOWN_DEVICE;
	$gadgetType = $deviceData["gadgetType"];
	$gadgetModel = $deviceData["gadgetModel"];
	$gadgetBrand = $deviceData["gadgetBrand"];

	if ( $gadgetType === IdMyGadget::GADGET_TYPE_DESKTOP )
	{
		$gadgetString = IdMyGadget::GADGET_STRING_DESKTOP;
	}
	else if ( $gadgetType === IdMyGadget::GADGET_TYPE_TABLET )
	{
		$gadgetString = IdMyGadget::GADGET_STRING_TABLET;
	}
	else if ( $gadgetType === IdMyGadget::GADGET_TYPE_PHONE )
	{
		$gadgetString = IdMyGadget::GADGET_STRING_PHONE;
	}
	return $gadgetString;
}
