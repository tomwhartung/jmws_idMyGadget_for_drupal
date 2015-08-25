<?php
require_once 'IdMyGadget.php';

/**
 * Gets summary device data based on key WURFL device capabilities
 */
class IdMyGadgetTeraWurfl extends IdMyGadget
{
	/**
	 * The TeraWURFL object
	 * @var TeraWurfl
	 */
	public $teraWurflObject = null;

	/**
	 * Link to README.md file on github for this detector
	 * @var type URL
	 */
	protected $linkToReadme =
		'https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/tera_wurfl/README.md';
	/**
	 * Whether the key capabilities have been set
	 * @var boolean
	 */
	protected $keyCapabilitiesAreSet = FALSE;
	/**
	 * These are the key capabilities we use to set the gadget types
	 * At this time, the Key Capabilities are specific to Tera Wurfl
	 * @var array
	 */
	protected $keyCapabilities = array (
		"pointing_method" => '',
		"is_tablet" => '',
		"model_name" => '',
		"brand_name" => '',
		"device_os" => '',             // currently unused but keep for easy future reference
		"is_wireless_device" => '',    // currently unused but keep for easy future reference
		"dual_orientation" => '',      // currently unused but keep for easy future reference
	);

	/**
	 * Constructor: initialize essential data members
	 */
	public function __construct( $debugging=FALSE, $allowOverridesInUrl=FALSE )
	{
		parent::__construct( $debugging, $allowOverridesInUrl );
		$this->detectorUsed = parent::GADGET_DETECTOR_TERA_WURFL;
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
				'Tera-Wurfl' . DIRECTORY_SEPARATOR . 'wurfl-dbapi' . DIRECTORY_SEPARATOR .  'TeraWurflConfig.php';
			$fileWeNeedFullPath = $this->idMyGadgetDir . DIRECTORY_SEPARATOR . $fileWeNeedPartialPath;
		//	print '<p>isInstalled() in IdMyGadgetTeraWurfl,: $fileWeNeedPartialPath = ' . $fileWeNeedPartialPath . '</p>';
		//	print '<p>isInstalled() in IdMyGadgetTeraWurfl: $fileWeNeedFullPath = ' . $fileWeNeedFullPath . '</p>';
			if ( file_exists($fileWeNeedFullPath) )
			{
				$this->detectorIsInstalled = TRUE;
			}
		}

		return $this->detectorIsInstalled ;
	}
	/**
	 * Get data about the device
	 * @return associative array of device data
	 */
	public function getDeviceData()
	{
		if ( $this->teraWurflObject === null )
		{
			if ( $this->isInstalled() )
			{
				$this->teraWurflObject = new TeraWurfl();    // Instantiate the TeraWURFL object
			}
		}
		if ( ! $this->deviceDataAreSet )
		{
			$this->keyCapabilities = $this->getKeyCapabilities();
			//
			// We don't *need* to pass in the key capabilities values but doing so makes it clear
			// which device data items depend on which key capabilities.
			//
			$this->setGadgetType( $this->keyCapabilities['pointing_method'],
					$this->keyCapabilities['is_tablet'] );
			$this->setGadgetModel( $this->keyCapabilities['model_name'] );
			$this->setGadgetBrand( $this->keyCapabilities['brand_name'] );
			$this->deviceData['gadgetType']  = $this->gadgetType;
			$this->deviceData['gadgetModel'] = $this->gadgetModel;
			$this->deviceData['gadgetBrand'] = $this->gadgetBrand;
			$this->deviceDataAreSet =TRUE;
		}

		if ( $this->debugging )
		{
			print '<div class="debugging">';
			print '<p>detectorUsed: ' . $this->detectorUsed . '</p>';
			print '<ul class="debugging">debugging with keyCapabilities:' .
					$this->displayKeyCapabilities() . '</ul>';
			print '<ul class="debugging">debugging with deviceData:' .
					$this->displayDeviceData() . '</ul>';
			print '</div>';
		}

		return $this->deviceData;
	}
	/**
	 * Get the key capabilities of the device
	 * @return associative array of the capabilities
	 */
	public function getKeyCapabilities()
	{
		if ( ! $this->keyCapabilitiesAreSet )
		{
			if ( $this->teraWurflObject->getDeviceCapabilitiesFromAgent() )
			{
				foreach ( $this->keyCapabilities as $key => $value )
				{
					$this->keyCapabilities[$key] = $this->teraWurflObject->getDeviceCapability($key);
				}
			}
			$this->keyCapabilitiesAreSet = TRUE;
		}

		return $this->keyCapabilities;
	}
	/**
	 * Display the key capabilities
	 * @return string of <li> tags listing the key capabilities
	 */
	public function displayKeyCapabilities()
	{
		$output = "";

		foreach( $this->keyCapabilities as $key => $value )
		{
			$output .= "<li>" . $key . ":&nbsp;'" . $value . "'</li>";
		}

		return $output;
	}

	/**
	 * Set the gadget type to one of the GADGET_TYPE_* constants: desktop, phone, etc.
	 * @return gadgetType
	 */
	protected function setGadgetType()
	{
		parent::setGadgetType();
		$pointing_method = $this->keyCapabilities['pointing_method'];
		$is_tablet = $this->keyCapabilities['is_tablet'];

		if ( $this->gadgetType === parent::GADGET_TYPE_UNKNOWN )
		{
			if ( isset($pointing_method) )
			{
				if ( $pointing_method == "mouse" )
				{
					$this->gadgetType = parent::GADGET_TYPE_DESKTOP;
				}
				else if ( $pointing_method == "touchscreen" )
				{
					if ( isset($is_tablet) && $is_tablet == "true" )
					{
						$this->gadgetType = parent::GADGET_TYPE_TABLET;
					}
					else
					{
						$this->gadgetType = parent::GADGET_TYPE_PHONE;
					}
				}
			}
		}

		return $this->gadgetType;
	}
	/**
	 * Set the gadget brand based on the gadget type and brand name
	 * Note that it does not necessarily equal one of the constants defined in deviceData.php
	 * @return gadgetBrand
	 */
	protected function setGadgetBrand()
	{
		parent::setGadgetBrand();
		$brand_name = $this->keyCapabilities['brand_name'];

		if ( $this->gadgetBrand === parent::GADGET_BRAND_UNKNOWN )
		{
			$this->gadgetBrand = parent::GADGET_BRAND_UNRECOGNIZED;
			if ( isset($brand_name) )
			{
				if ( $this->gadgetType == parent::GADGET_TYPE_DESKTOP )
				{
					$this->gadgetBrand = $brand_name;
				}
				else if ( $this->gadgetType == parent::GADGET_TYPE_TABLET )
				{
					if ( $brand_name == parent::GADGET_BRAND_APPLE )
					{
						$this->gadgetBrand = parent::GADGET_BRAND_APPLE;
					}
					else
					{
						$this->gadgetBrand = $brand_name;
					}
				}
				else if ( $this->gadgetType == parent::GADGET_TYPE_PHONE )
				{
					if ( $brand_name == parent::GADGET_BRAND_APPLE )
					{
						$this->gadgetBrand = parent::GADGET_BRAND_APPLE;
					}
					else
					{
						$this->gadgetBrand = $brand_name;
					}
				}
				else
				{
					$this->gadgetBrand = "Unknown Gadget Type " .
							"(" .$this->gadgetType . "); brand_name: " . $brand_name;
				}
			}
			else
			{
				$this->gadgetBrand = parent::GADGET_BRAND_UNKNOWN;
			}
		}
	
		return $this->gadgetBrand;
	}
	/**
	 * Set the gadget model based on the gadget type and model name
	 * Note that it does not necessarily equal one of the constants defined in deviceData.php
	 * @return gadgetModel
	 */
	protected function setGadgetModel()
	{
		parent::setGadgetModel();
		$model_name = $this->keyCapabilities['model_name'];

		// $this->gadgetModel = $model_name;
		// return;

		if ( $this->gadgetModel === parent::GADGET_MODEL_UNKNOWN )
		{
			if ( isset($model_name) )
			{
				if ( $this->gadgetType == parent::GADGET_TYPE_DESKTOP )
				{
					$this->gadgetModel = $model_name;
				}
				else if ( $this->gadgetType == parent::GADGET_TYPE_TABLET )
				{
					if ( stristr($model_name,parent::GADGET_BRAND_ANDROID) === FALSE )
					{
						$this->gadgetModel = $model_name;
					}
					else
					{
						$this->gadgetModel = parent::GADGET_MODEL_ANDROID_TABLET;
					}
				}
				else if ( $this->gadgetType == parent::GADGET_TYPE_PHONE )
				{
					if ( $model_name == parent::GADGET_MODEL_APPLE_PHONE )
					{
						$this->gadgetModel = parent::GADGET_MODEL_APPLE_PHONE;
					}
					else if ( stristr($model_name,parent::GADGET_BRAND_ANDROID) === FALSE )
					{
						$this->gadgetModel = $model_name;
					}
					else
					{
						$this->gadgetModel = parent::GADGET_MODEL_ANDROID_PHONE;
					}
				}
				else
				{
					$this->gadgetModel = "Unknown Gadget Type (" . $this->gadgetType . "); model_name: " . $model_name;
				}
			}
			else
			{
				$this->gadgetModel = parent::GADGET_MODEL_UNKNOWN;
			}
		}
	
		return $this->gadgetModel;
	}
}
