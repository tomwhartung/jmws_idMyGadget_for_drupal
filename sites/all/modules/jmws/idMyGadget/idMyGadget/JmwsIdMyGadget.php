<?php
/**
 * Creates an object of the desired idMyGadget subclass and uses it for device detection.
 * Ideally this should exactly match the class with the same name in jmws_idMyGadget_for_joomla.
 */
if( !defined('DS') )
{
	define('DS', DIRECTORY_SEPARATOR);
}
require_once 'php/IdMyGadget.php';

/**
 * Error message for when the underlying 3rd party detection software is not installed
 */
define( 'IDMYGADGET_DETECTOR_NOT_INSTALLED_OPENING',
	'<div class="idmygadget-error"><p>Third party device detector software is not installed.  To fix, see ' );
define( 'IDMYGADGET_DETECTOR_NOT_INSTALLED_CLOSING', '</p></div>' );

class JmwsIdMyGadget
{
	/**
	 * Valid values for the gadget string.  Use invalid values at your own risk!
	 */
	const GADGET_STRING_DETECTOR_NOT_INSTALLED = IdMyGadget::GADGET_STRING_DETECTOR_NOT_INSTALLED;
	const GADGET_STRING_UNKNOWN_DEVICE = IdMyGadget::GADGET_STRING_UNKNOWN_DEVICE;
	const GADGET_STRING_DESKTOP = IdMyGadget::GADGET_STRING_DESKTOP;
	const GADGET_STRING_TABLET = IdMyGadget::GADGET_STRING_TABLET;
	const GADGET_STRING_PHONE = IdMyGadget::GADGET_STRING_PHONE;

	/**
	 * URLs of the device-specific jquery files we are using
	 */
//	const JQUERY_DESKTOP_JS_URL = 'http://code.jquery.com/jquery-1.11.3.min.js';
	const JQUERY_MOBILE_CSS_URL = 'http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css';
	const JQUERY_MOBILE_JS_URL = 'http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js';
//	const JQUERY_MOBILE_CSS_URL = 'http://code.jquery.com/mobile/latest/jquery.mobile.min.css';
//	const JQUERY_MOBILE_JS_URL = 'http://code.jquery.com/mobile/latest/jquery.mobile.min.js';

	/**
	 * Array of gadget detectors currently supported by idMyGadget
	 */
	public static $supportedGadgetDetectors = array(
		'detect_mobile_browsers',   // note that this is used as the default throughout
		'mobile_detect',
		'tera_wurfl',
		'no_detection'      // defaults to desktop (allows for isolating responsive behavior)
	);
	/**
	 * Array of choices for yes/no radio buttons (e.g., show site name) on plugin page
	 */
	public static $gadgetTypes = array( 'phone', 'tablet', 'desktop' );
	/**
	 * Array of choices for yes/no radio buttons (e.g., show site name) on plugin page
	 */
	public static $radioChoices = array( 'No', 'Yes' );  // NOTE: 'No' must be the zeroeth elt ;-)
	/**
	 * Array of choices for lists of elements (e.g., site name, site title)
	 */
	public static $validElements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );
	/**
	 * Array of choices for jQuery Mobile theme
	 */
	public static $jqueryMobileThemeChoices = array( 'a', 'b', 'c', 'd', 'e', 'f' );

	/**
	 * Used when this plugin/module is not installed or active, etc.
	 * Contains a value only when there's an error.
	 */
	public $errorMessage = '';
	/**
	 * Boolean: Using jQuery Mobile changes everything, so we need to know when we are using it.
	 * Although we always use it on phones, we do not always use it on tablets.
	 */
	public $usingJQueryMobile = TRUE;
	/**
	 * Boolean: determines whether we want the hamburger menu in the upper left corner
	 * of this page for this device.
	 * Set by the template, based on options set in the back end.
	 * Kept here so that modules can access it without us polluting the global namespace.
	 */
	public $phoneBurgerIconThisDeviceLeft = FALSE;
	/**
	 * Boolean: analogous to phoneBurgerIconThisDeviceLeft, but for the right side.
	 */
	public $phoneBurgerIconThisDeviceRight = FALSE;

	/**
	 * We want to use jQuery Mobile data-role attributes only when we are using that library.
	 * In other words, by defining these attributes as variables, that may or may not contain values
	 * (as appropriate for the device and options set), then, when it comes time to use them
	 * we can just use them (empty or not) without having to worry about the device and the options etc.
	 */
	public $jqmDataRole = array(
		'page' => '',
		'header' => '',
		'content' => '',
		'footer' => '',
	);
	/**
	 * Data role and theme attributes determine how the jQuery Mobile widgets appear
	 */
	public $jqmDataThemeAttribute = '';

	/**
	 * Boolean indicating whether device detection is enabled
	 */
	protected $detectionEnabled = FALSE;
	/**
	 * The directory containing the idMyGadget code
	 * Used to determine whether the selected gadget detector code is installed.
	 */
	protected $idMyGadgetDir = ''; // set by subclass in its constructor
	/**
	 * The string identifying the gadget detector we are using
	 */
	protected $gadgetDetectorString = null;
	/**
	 * The idMyGadget object we are using
	 */
	protected $idMyGadget = null;
	/**
	 * The device data we get from the detector
	 */
	protected $deviceData = null;
	/**
	 * A string that represents the gadget being used
	 */
	protected $gadgetString = '';
	/**
	 * First character of the gadgetDetectorString
	 */
	protected $gadgetDetectorStringChar = '?';
	/**
	 * First character of the gadgetString
	 */
	protected $gadgetStringChar = '?';

	/**
	 * Constructor: for best results, specify a different gadgetDetector
	 */
	public function __construct( $gadgetDetectorString=null, $debugging=FALSE, $allowOverridesInUrl=TRUE )
	{
		require_once 'gadget_detectors/all_detectors/getIdMyGadgetStringAllDevices.php';

		if ( $gadgetDetectorString === null )
		{
			$gadgetDetectorString = IdMyGadget::GADGET_DETECTOR_DETECT_MOBILE_BROWSERS;
		}

		$this->gadgetDetectorString = $gadgetDetectorString;

		if ( $gadgetDetectorString === IdMyGadget::GADGET_DETECTOR_DETECT_MOBILE_BROWSERS )
		{
			global $usingMobilePhone;
			$fileToInclude = 'gadget_detectors/detect_mobile_browsers/php/detectmobilebrowser.php';
			$fileToCheck = $this->idMyGadgetDir . DIRECTORY_SEPARATOR . $fileToInclude;
			if ( file_exists($fileToCheck) )
			{
				include_once $fileToInclude;     // sets $usingMobilePhone global variable
			}
			include_once 'php/IdMyGadgetDetectMobileBrowsers.php';
			$this->idMyGadget = new IdMyGadgetDetectMobileBrowsers( $debugging, $allowOverridesInUrl );
		}
		else if ( $gadgetDetectorString === IdMyGadget::GADGET_DETECTOR_MOBILE_DETECT )
		{
			$fileToInclude = 'gadget_detectors/mobile_detect/Mobile-Detect/Mobile_Detect.php';
			$fileToCheck = $this->idMyGadgetDir . DIRECTORY_SEPARATOR . $fileToInclude;
			if ( file_exists($fileToCheck) )
			{
				include_once $fileToInclude ;
			}
			include_once 'php/IdMyGadgetMobileDetect.php';
			$this->idMyGadget = new IdMyGadgetMobileDetect( $debugging, $allowOverridesInUrl );
		}
		else if ( $gadgetDetectorString === IdMyGadget::GADGET_DETECTOR_TERA_WURFL )
		{
			$fileToInclude = 'gadget_detectors/tera_wurfl/Tera-Wurfl/wurfl-dbapi/TeraWurfl.php';
			$fileToCheck = $this->idMyGadgetDir . DIRECTORY_SEPARATOR . $fileToInclude;
			if ( file_exists($fileToCheck) )
			{
				include_once $fileToInclude;
			}
			include_once 'php/IdMyGadgetTeraWurfl.php';
			$this->idMyGadget = new IdMyGadgetTeraWurfl( $debugging, $allowOverridesInUrl );
		}
		else
		{
			error_log( 'Warning: device detection has been disabled in the IdMyGadget administration console options.' );
			include_once 'php/IdMyGadgetNoDetection.php';
			$this->idMyGadget = new IdMyGadgetNoDetection( $debugging, $allowOverridesInUrl );
		}

		if ( $this->idMyGadget !== null )
		{
			$this->idMyGadget->idMyGadgetDir = $this->idMyGadgetDir;
			if ( $this->idMyGadget->isInstalled() )
			{
				$this->deviceData = $this->idMyGadget->getDeviceData();
				$this->gadgetString = getIdMyGadgetStringAllDevices( $this->deviceData );
				if ( $this->idMyGadget->detectorUsed !== IdMyGadget::GADGET_DETECTOR_NO_DETECTION )
				{
					$this->detectionEnabled = TRUE;
				}
			}
			else
			{
				$this->gadgetString = self::GADGET_STRING_DETECTOR_NOT_INSTALLED;
			}
		}

		$this->gadgetDetectorStringChar = substr( $this->gadgetDetectorString, 0, 1 );  // part of the sanity check string
		$this->gadgetStringChar = substr( $this->gadgetString, 0, 1 );                  // part of the sanity check string
	}

	/**
	 * For development only! Please remove when code is stable.
	 * Displaying some values that can help us make sure we haven't inadvertently
	 * broken something while we are actively working on this.
	 * @return string
	 */
	public function getSanityCheckString()
	{
		$returnValue = '';
		$returnValue .= $this->getGadgetDetectorStringChar() . '/';
		$returnValue .= $this->getGadgetStringChar() . '/';
		$returnValue .= $this->usingJQueryMobile ? 'Y' : 'N';
		return $returnValue;
	}

	/**
	 * Returns TRUE if the desired detector (subclass) is installed, else FALSE
	 */
	public function isInstalled()
	{
		return $this->idMyGadget->isInstalled();
	}
	/**
	 * Returns TRUE if device detection is (installed and) enabled, else FALSE
	 */
	public function isEnabled()
	{
		return $this->detectionEnabled;
	}

	/**
	 * Determine whether we are using jQuery Mobile
	 * If we are using it, get it set up, based on the values of our options
	 */
	public function initializeJQueryMobileVars()
	{
		$this->setUsingJQueryMobile();       // sets $this->usingJQueryMobile

		if ( $this->usingJQueryMobile )
		{
			$this->setJqmDataRoles();            // if we're using it, set the data roles and ...
			$this->setJqmDataThemeAttribute();   // the theme attribute (a, b, c, etc.)
		}
	}

	/**
	 * Returns TRUE if the device is a phone, else FALSE
	 */
	public function isPhone()
	{
		$isPhone = FALSE;
		if ( $this->getGadgetString() === $this::GADGET_STRING_PHONE )
		{
			$isPhone = TRUE;
		}
		return $isPhone;
	}
	/**
	 * Returns TRUE if the device is a phone, else FALSE
	 */
	public function isTablet()
	{
		$isTablet = FALSE;
		if ( $this->getGadgetString() === $this::GADGET_STRING_TABLET )
		{
			$isTablet = TRUE;
		}
		return $isTablet;
	}
	/**
	 * Returns TRUE if the device is a phone, else FALSE
	 */
	public function isDesktop()
	{
		$isDesktop = FALSE;
		if ( $this->getGadgetString() === $this::GADGET_STRING_DESKTOP )
		{
			$isDesktop = TRUE;
		}
		return $isDesktop;
	}

	/**
	 * Returns a link to the appropriate README.md file on github
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getLinkToReadme()
	{
		return $this->idMyGadget->getLinkToReadme();
	}

	/**
	 * The gadgetDetectorString is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getGadgetDetectorString()
	{
		return $this->gadgetDetectorString;
	}
	/**
	 * The first character of the gadgetDetectorString is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getGadgetDetectorStringChar()
	{
		return $this->gadgetDetectorStringChar;
	}

	/**
	 * The idMyGadget object is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getIdMyGadget()
	{
		return $this->idMyGadget;
	}
	/**
	 * The device data is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getDeviceData()
	{
		return $this->deviceData;
	}

	/**
	 * The gadget string is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getGadgetString()
	{
		return $this->gadgetString;   // set in constructor
	}
	/**
	 * The first character of the gadget string is read-only!
	 * TODO: Change this class to use the PHP magic get feature
	 */
	public function getGadgetStringChar()
	{
		return $this->gadgetStringChar;   // set in constructor
	}

	/**
	 * Display the device data
	 * @return string of <li> tags listing the device data
	 */
	public function displayDeviceData()
	{
		return $this->idMyGadget->displayDeviceData();
	}

	/**
	 * Set the jQquery Mobile data-role attributes
	 */
	protected function setJqmDataRoles()
	{
		$this->jqmDataRole['page'] = 'data-role="page"';
		$this->jqmDataRole['header'] = 'data-role="header"';
		$this->jqmDataRole['content'] = 'data-role="content"';
		$this->jqmDataRole['footer'] = 'data-role="footer"';
	}
}
