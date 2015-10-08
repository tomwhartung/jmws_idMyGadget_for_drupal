<?php
require_once 'IdMyGadget.php';

/**
 * Determines whether device is a mobile phone
 */
class IdMyGadgetNoDetection extends IdMyGadget
{
	/**
	 * Link to README.md file on github for this detector
	 * @var type URL
	 */
	protected $linkToReadme =
		'https://github.com/tomwhartung/jmws_idMyGadget_for_wordpress/blob/master/README.md';
	/**
	 * Constructor: initialize essential data members
	 */
	public function __construct( $debugging=FALSE, $allowOverridesInUrl=FALSE )
	{
		// Ignore overrides: without detection, we should not expect to see phone/tablet views
		//
		$allowOverridesInUrl = FALSE;
		parent::__construct( $debugging, $allowOverridesInUrl );
		$this->detectorUsed = parent::GADGET_DETECTOR_NO_DETECTION;
	}

	/**
	 * Test whether this detector's code is installed
	 * @return boolean TRUE if the code is installed else FALSE
	 */
	public function isInstalled()
	{
		if ( $this->detectorIsInstalled === null )
		{
			$this->detectorIsInstalled = TRUE;
		}
		return $this->detectorIsInstalled ;
	}
	/**
	 * Get all of the data we can about the device
	 * @return associative array of device data
	 */
	public function getDeviceData()
	{
		if ( $this->deviceDataAreSet !== TRUE )
		{
			$this->setGadgetType();
			$this->setGadgetBrand();
			$this->setGadgetModel();
			$this->deviceData['gadgetType']  = $this->gadgetType;
			$this->deviceData['gadgetBrand'] = $this->gadgetBrand;
			$this->deviceData['gadgetModel'] = $this->gadgetModel;
			$this->deviceDataAreSet = TRUE;
		}

		if ( $this->debugging )
		{
			print "<ul class='debugging'>debugging with deviceData:" .
					$this->displayDeviceData() . "</ul>";
		}

		return $this->deviceData;
	}

	/**
	 * Set the gadget type to one of the GADGET_TYPE_* constants: desktop, phone, etc.
	 * @return gadgetType
	 */
	protected function setGadgetType()
	{
		parent::setGadgetType();   // Allows for setting this in the URL (as a GET variable)

		if ( $this->gadgetType == parent::GADGET_TYPE_UNKNOWN )
		{
			$this->gadgetType = parent::GADGET_TYPE_DESKTOP;
		}
	
		if ( $this->debugging )
		{
			print '<ul class="debugging">';
			print '<li>this->gadgetType: ' . $this->gadgetType . '</li>';
			print '</ul>';
		}

		return $this->gadgetType;
	}
	/**
	 * Set the gadget brand (in this case it is unknown)
	 * @return gadgetBrand
	 */
	protected function setGadgetBrand()
	{
		parent::setGadgetBrand();
	
		return $this->gadgetBrand;
	}
	/**
	 * Set the gadget model (in this case it is unknown)
	 * @return gadgetModel
	 */
	protected function setGadgetModel()
	{
		parent::setGadgetModel();
	
		return $this->gadgetModel;
	}
}
