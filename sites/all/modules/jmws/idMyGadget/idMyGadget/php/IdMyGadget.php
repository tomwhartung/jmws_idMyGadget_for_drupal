<?php
/**
 * Base class for classes that detect device characteristics
 */
abstract class IdMyGadget
{
	/**
	 * Valid values for the gadget string.  Use invalid values at your own risk!
	 */
	const GADGET_STRING_DETECTOR_NOT_INSTALLED = 'Detector Not Installed';
	const GADGET_STRING_UNKNOWN_DEVICE = 'Unknown Device';
	const GADGET_STRING_DESKTOP = 'Desktop';
	const GADGET_STRING_TABLET = 'Tablet';
	const GADGET_STRING_PHONE = 'Phone';

	const GADGET_DETECTOR_UNKNOWN = 'unknown';
	const GADGET_DETECTOR_DETECT_MOBILE_BROWSERS = 'detect_mobile_browsers';
	const GADGET_DETECTOR_MOBILE_DETECT = 'mobile_detect';
	const GADGET_DETECTOR_TERA_WURFL = 'tera_wurfl';
	const GADGET_DETECTOR_NO_DETECTION = 'no_detection';

	const GADGET_TYPE_UNKNOWN = 'unknown';
	const GADGET_TYPE_UNRECOGNIZED = 'unrecognized';
	const GADGET_TYPE_DESKTOP = 'desktop';
	const GADGET_TYPE_TABLET = 'tablet';
	const GADGET_TYPE_PHONE = 'phone';

	const GADGET_BRAND_UNKNOWN = 'brand_unknown';
	const GADGET_BRAND_UNRECOGNIZED = 'unrecognized';
	const GADGET_BRAND_ANDROID = 'Android';
	const GADGET_BRAND_APPLE = 'Apple';
	const GADGET_BRAND_ASUS = 'Asus';
	const GADGET_BRAND_BLACKBERRY = 'BlackBerry';
	const GADGET_BRAND_DELL = 'Dell';
	const GADGET_BRAND_GENERIC = 'Generic';
	const GADGET_BRAND_HTC = 'HTC';
	const GADGET_BRAND_LG = 'LG';
	const GADGET_BRAND_NEXUS = 'Nexus';
	const GADGET_BRAND_MOTOROLA = 'Motorola';
	const GADGET_BRAND_SAMSUNG = 'Samsung';
	const GADGET_BRAND_SONY = 'Sony';
	const GADGET_BRAND_WINDOWS = 'Windows';

	const GADGET_MODEL_UNKNOWN = 'model_unknown';
	const GADGET_MODEL_UNRECOGNIZED = 'unrecognized';
	const GADGET_MODEL_ANDROID_PHONE = 'androidPhone';
	const GADGET_MODEL_ANDROID_TABLET = 'androidTablet';
	const GADGET_MODEL_ANDROID_OTHER = 'androidOther';
	const GADGET_MODEL_APPLE_PHONE = 'iPhone';
	const GADGET_MODEL_APPLE_TABLET = 'iPad';
	const GADGET_MODEL_KINDLE = 'Kindle';
	const GADGET_MODEL_NOOK = 'Nook';

	/**
	 * Subclasses set this to indicate which detector did the detecting
	 */
	public $detectorUsed = IdMyGadget::GADGET_DETECTOR_UNKNOWN;
	/**
	 * Displays debugging output
	 * @var boolean
	 */
	public $debugging = FALSE;
	/**
	 * Allows overriding of all gadget* values in the URL
	 * Allows testing in browser instead of device
	 * @var boolean
	 */
	public $allowOverridesInUrl = TRUE;
	/**
	 * Directory in which this project is installed (rooted directory to "..")
	 * Used by isInstalled methods to determine whether the underlying 3rd-party gadget detectors are installed
	 * @var type String
	 */
	public $idMyGadgetDir = null;
	/**
	 * TRUE if desired device detector is installed else FALSE
	 * @var boolean
	 */
	protected $detectorIsInstalled = null;

	//
	// Device Data Fields are: gadgetType, gadgetModel, and gadgetBrand
	//
	/**
	 * Whether the device data have been set
	 * @var boolean
	 */
	protected $deviceDataAreSet = FALSE;
	/**
	 * The gadget types array is set based on the key capabilities
	 * @var array
	 */
	protected $deviceData = array (
			"gadgetType" => '',
			"gadgetBrand" => '',
			"gadgetModel" => '',
	);
	/**
	 * One of the GADGET_TYPE_* constants: desktop, phone, etc.
	 * @var string
	 */
	protected $gadgetType = self::GADGET_TYPE_UNKNOWN;
	/**
	 * One of the GADGET_BRAND_* constants: apple, etc.
	 * @var string
	 */
	protected $gadgetBrand = self::GADGET_BRAND_UNKNOWN;
	/**
	 * One of the GADGET_MODEL_* constants: iPad, androidTablet, iPhone, etc.
	 * @var string
	 */
	protected $gadgetModel = self::GADGET_MODEL_UNKNOWN;
	/**
	 * Link to README.md file on github for this detector
	 * @var type URL
	 */
	protected $linkToReadme =
		'https://github.com/tomwhartung/idMyGadget/blob/master/gadget_detectors/README.md';

	/**
	 * Constructor: initialize essential data members
	 */
	public function __construct( $debugging=FALSE, $allowOverridesInUrl=FALSE )
	{
		$this->debugging = $debugging;
		$this->allowOverridesInUrl = $allowOverridesInUrl;
	}

	/**
	 * Returns TRUE if the desired detector (subclass) is installed, else FALSE
	 */
	abstract public function isInstalled();
	/**
	 * For each device detection mechanisim, we must implement this function
	 * to get the data that is available about the device.
	 * This may be a single value, as is the case with the Detect Mobile Browser option, or
	 * hundreds of values, as is the case with the Tera Wurfl option.
	 */
	abstract public function getDeviceData();

	/**
	 * Returns a link to the README.md file on github,
	 * that contains instructions on how toinstall the detector
	 */
	public function getLinkToReadme()
	{
		return $this->linkToReadme;
	}
	/**
	 * Display the device data
	 * @return string of <li> tags listing the device data
	 */
	public function displayDeviceData()
	{
		$output = "";

		foreach( $this->deviceData as $key => $value )
		{
			$output .= "<li>" . $key . ":&nbsp;'" . $value . "'</li>";
		}

		return $output;
	}

	/**
	 * Supports setting the gadget type as a get variable in the request
	 * This can help with testing
	 * Note that in this case it may not equal one of the constants defined above
	 * @return gadgetType
	 */
	protected function setGadgetType()
	{
		if ( $this->allowOverridesInUrl )
		{
			$gadgetType = filter_input( INPUT_GET, 'gadgetType', FILTER_SANITIZE_STRING );
			if ( isset($gadgetType) )
			{
				$this->gadgetType  = $gadgetType;
			}
		}

		if ( $this->gadgetType == null || $this->gadgetType == '' )
		{
			$this->gadgetType = parent::GADGET_TYPE_UNKNOWN;   // make sure it has a value
		}
	
		return $this->gadgetType;
	}
	/**
	 * Supports setting the gadget brand as a get variable in the request for all detectors
	 * This can help with testing
	 * Note that in this case it may not equal one of the constants defined above
	 * @return gadgetBrand
	 */
	protected function setGadgetBrand()
	{
		if ( $this->allowOverridesInUrl )
		{
			$gadgetBrand = filter_input( INPUT_GET, 'gadgetBrand', FILTER_SANITIZE_STRING );
			if ( isset($gadgetBrand) )
			{
				$this->gadgetBrand = $gadgetBrand;
			}
		}

		if ( $this->gadgetBrand == null || $this->gadgetBrand == '' )
		{
			$this->gadgetBrand = parent::GADGET_BRAND_UNKNOWN;   // make sure it has a value
		}

		return $this->gadgetBrand;
	}
	/**
	 * Supports setting the gadget model as a get variable in the request for all detectors
	 * This can help with testing
	 * Note that in this case it may not equal one of the constants defined above
	 * @return gadgetModel
	 */
	protected function setGadgetModel()
	{
		if ( $this->allowOverridesInUrl )
		{
			$gadgetModel = filter_input( INPUT_GET, 'gadgetModel', FILTER_SANITIZE_STRING );
			if ( isset($gadgetModel) )
			{
				$this->gadgetModel = $gadgetModel;
			}
		}

		if ( $this->gadgetModel == null || $this->gadgetModel == '' )
		{
			$this->gadgetModel = parent::GADGET_MODEL_UNKNOWN;   // make sure it has a value
		}

		return $this->gadgetModel;
	}
}
