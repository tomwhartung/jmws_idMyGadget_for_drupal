<?php
require_once 'IdMyGadget.php';

/**
 * Gets summary device data based on key WURFL device capabilities
 */
class IdMyGadgetMobileDetect extends IdMyGadget
{
	/**
	 * The Mobile Detect object
	 * @var 
	 */
	public $mobileDetectObject = null;
	/**
	 * Link to README.md file on github for this detector
	 * @var type URL
	 */
	protected $linkToReadme =
		'https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/mobile_detect/README.md';

	/**
	 * Constructor: initialize essential data members
	 */
	public function __construct( $debugging=FALSE, $allowOverridesInUrl=FALSE )
	{
		parent::__construct( $debugging, $allowOverridesInUrl );
		$this->detectorUsed = parent::GADGET_DETECTOR_MOBILE_DETECT;
	}

	/**
	 * Test whether this detector's code is installed
	 * @return boolean TRUE if the code is installed else FALSE
	 */
	public function isInstalled()
	{
		if ( $this->detectorIsInstalled === null )
		{
			$this->detectorIsInstalled = FALSE;
			$fileWeNeedPartialPath = 'gadget_detectors' . DIRECTORY_SEPARATOR .
				$this->detectorUsed . DIRECTORY_SEPARATOR .
				'Mobile-Detect' . DIRECTORY_SEPARATOR . 'Mobile_Detect.php';
			$fileWeNeedFullPath = $this->idMyGadgetDir . DIRECTORY_SEPARATOR . $fileWeNeedPartialPath;
		//	print '<p>isInstalled() in IdMyMobileDetect,: $fileWeNeedPartialPath = ' . $fileWeNeedPartialPath . '</p>';
		//	print '<p>isInstalled() in IdMyMobileDetect: $fileWeNeedFullPath = ' . $fileWeNeedFullPath . '</p>';
			if ( file_exists($fileWeNeedFullPath) )
			{
				$this->detectorIsInstalled = TRUE;
			}
		}

		return $this->detectorIsInstalled ;
	}

	/**
	 * Get all of the data we can about the device
	 * @return associative array of device data
	 */
	public function getDeviceData()
	{
		if ( $this->mobileDetectObject === null )
		{
			if ( $this->isInstalled() )
			{
				$this->mobileDetectObject = new Mobile_Detect();
			}
		}
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
		parent::setGadgetType();

		if ( $this->gadgetType == parent::GADGET_TYPE_UNKNOWN )
		{
			if ( $this->mobileDetectObject->isTablet() )
			{
				$this->gadgetType = parent::GADGET_TYPE_TABLET;
			}
			else if ( $this->mobileDetectObject->isMobile() )
			{
				$this->gadgetType = parent::GADGET_TYPE_PHONE;
			}
			else
			{
				$this->gadgetType = parent::GADGET_TYPE_DESKTOP;
			}
		}
	
		return $this->gadgetType;
	}
	/**
	 * Set the gadget brand
	 * @return gadgetBrand
	 */
	protected function setGadgetBrand()
	{
		parent::setGadgetBrand();

		if ( $this->gadgetBrand == parent::GADGET_BRAND_UNKNOWN )
		{
			if ( $this->mobileDetectObject->isiPhone() ||
			     $this->mobileDetectObject->isiPad() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_APPLE;
			}
			else if ( $this->mobileDetectObject->isAsus() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_ASUS;
			}
			else if ( $this->mobileDetectObject->isBlackBerry() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_BLACKBERRY;
			}
			else if ( $this->mobileDetectObject->isDell() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_DELL;
			}
			else if ( $this->mobileDetectObject->isGenericPhone() ||
			          $this->mobileDetectObject->isGenericTablet() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_GENERIC;
			}
			else if ( $this->mobileDetectObject->isHTC() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_HTC;
			}
			else if ( $this->mobileDetectObject->isLG() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_LG;
			}
			else if ( $this->mobileDetectObject->isNexus() ||
			          $this->mobileDetectObject->isNexusTablet() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_NEXUS;
			}
			else if ( $this->mobileDetectObject->isMotorola() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_MOTOROLA;
			}
			else if ( $this->mobileDetectObject->isSamsung() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_SAMSUNG;
			}
			else if ( $this->mobileDetectObject->isSony() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_SONY;
			}
			else if ( $this->mobileDetectObject->isWindowsMobileOS() ||
			          $this->mobileDetectObject->isWindowsPhoneOS() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_WINDOWS;
			}
			else if ( $this->mobileDetectObject->isAndroidOS() )
			{
				$this->gadgetBrand = parent::GADGET_BRAND_ANDROID;
			}
			else
			{
				$this->gadgetBrand = parent::GADGET_BRAND_UNRECOGNIZED;
			}
		}

		return $this->gadgetBrand;
	}
	/**
	 * Set the gadget model (in this case it is unknown)
	 * @return gadgetModel
	 */
	protected function setGadgetModel()
	{
		parent::setGadgetModel();
	
		if ( $this->gadgetModel == parent::GADGET_MODEL_UNKNOWN )
		{
			if ( $this->mobileDetectObject->isiPhone() )
			{
				$this->gadgetModel = parent::GADGET_MODEL_APPLE_PHONE;
			}
			else if ( $this->mobileDetectObject->isiPad() )
			{
				$this->gadgetModel = parent::GADGET_MODEL_APPLE_TABLET;
			}
			else if ( $this->mobileDetectObject->isKindle() )
			{
				$this->gadgetModel = parent::GADGET_MODEL_KINDLE;
			}
			else if ( $this->mobileDetectObject->isNookTablet() )
			{
				$this->gadgetModel = parent::GADGET_MODEL_NOOK;
			}
			else if ( $this->mobileDetectObject->isAndroidOS() )
			{
				if( $this->mobileDetectObject->isTablet() )
				{
					$this->gadgetModel = parent::GADGET_MODEL_ANDROID_TABLET;
				}
				else if ( $this->mobileDetectObject->isMobile() )
				{
					$this->gadgetModel = parent::GADGET_MODEL_ANDROID_PHONE;
				}
				else
				{
					$this->gadgetModel = parent::GADGET_MODEL_ANDROID_OTHER;
				}
			}
			else
			{
				$this->gadgetModel = parent::GADGET_MODEL_UNRECOGNIZED;
			}
		}

		return $this->gadgetModel;
	}
}
