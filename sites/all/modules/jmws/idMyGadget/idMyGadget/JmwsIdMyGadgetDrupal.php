<?php
/**
 * Creates an object of the desired idMyGadget subclass and uses it for device detection.
 * NOTE:
 * *IF* we can keep all the Drupal-specific code here,
 * *THEN* we can reuse the rest of the code in this project for joomla and wordpress (and...?)
 */
require_once 'JmwsIdMyGadget.php';

class JmwsIdMyGadgetDrupal extends JmwsIdMyGadget
{
	/**
	 * Array of themes that know how to use idMyGadget
	 */
	public static $supportedThemes = array(
		'jmws_wp_vqsg_ot_idMyGadget',
		'jmws_twentyfifteen_idMyGadget'
	);
	/**
	 * Translated version of the radio button choices defined (as static) in the parent class
	 */
	public $translatedRadioChoices = array();
	/**
	 * Used by when this plugin is not installed or active, etc.
	 * Set only when there's an error.
	 */
	public $errorMessage = '';
	/**
	 * Boolean: Using jQuery Mobile changes everything, so we need to know when we are using it.
	 * Although we always use it on phones, we do not always use it on tablets.
	 */
	public $usingJQueryMobile = FALSE;
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
	 * Constructor: for best results, install and use a gadgetDetector other than the default
	 */
	public function __construct( $gadgetDetectorString=null, $debugging=FALSE, $allowOverridesInUrl=TRUE )
	{
		$this->idMyGadgetDir = IDMYGADGET_MODULE_DIR;
		parent::__construct( $gadgetDetectorString, $debugging, $allowOverridesInUrl );
		$this->translateStaticArrays();
	}
	/**
	 * Based on the current device, access the device-dependent options set in the admin console
	 * and use them to generate most of the markup for the heading
	 * @return string Markup for site heading (name, logo, title, and description, each of which is optional)
	 */
	public function getLogoTitleDescriptionHtml()
	{
		global $base_url;
		$logoTitleDescription = '';
		$logoFile = '';
		$siteName = variable_get( 'site_name', '' );
		$siteTitle = '';
		$siteDescription = '';
		$anchorTagOpen = '<a href="' . $base_url . '" rel="home">';
		$anchorTagClose = '</a>';

		if ( $this->isPhone() )
		{
			$logoFile = variable_get( 'idmg_logo_file_phone' );
			$siteTitle = variable_get( 'idmg_site_title_phone' );
			$siteDescription = variable_get('idmg_site_description_phone');
			if ( strlen($logoFile) > 0 )
			{
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= '<img src="' . $logoFile . '" class="logo-file-phone" alt="' . $siteName . '" />';
				$logoTitleDescription .= $anchorTagClose;
			}
			if ( variable_get('idmg_show_site_name_phone') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_phone')];
				$logoTitleDescription .= '<' . $siteNameElement . ' class="site-name-phone">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteName;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_phone')];
				$logoTitleDescription .= '<' . $siteTitleElement . ' class="site-title-phone">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteTitle;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteTitleElement . '>';
			}
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_phone')];
				$logoTitleDescription .= '<' . $siteDescriptionElement . ' class="site-description-phone">';
				$logoTitleDescription .= $siteDescription;
				$logoTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
		}
		else if ( $this->isTablet() )
		{
			$logoFile = variable_get( 'idmg_logo_file_tablet' );
			$siteTitle = variable_get('idmg_site_title_tablet');
			$siteDescription = variable_get('idmg_site_description_tablet');
			if ( strlen($logoFile) > 0 )
			{
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= '<img src="' . $logoFile . '" class="logo-file-tablet" alt="' . $siteName . '" />';
				$logoTitleDescription .= $anchorTagClose;
			}
			if ( variable_get('idmg_show_site_name_tablet') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_tablet')];
				$logoTitleDescription .= '<' . $siteNameElement . ' class="site-name-tablet">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteName;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_tablet')];
				$logoTitleDescription .= '<' . $siteTitleElement . ' class="site-title-tablet">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteTitle;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteTitleElement . '>';
			}
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_tablet')];
				$logoTitleDescription .= '<' . $siteDescriptionElement . ' class="site-description-tablet">';
				$logoTitleDescription .= $siteDescription;
				$logoTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
		}
		else
		{
			$logoFile = variable_get( 'idmg_logo_file_desktop' );
			$siteTitle = variable_get('idmg_site_title_desktop');
			$siteDescription = variable_get('idmg_site_description_desktop');
			if ( strlen($logoFile) > 0 )
			{
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= '<img src="' . $logoFile . '" class="logo-file-desktop" alt="' . $siteName . '" />';
				$logoTitleDescription .= $anchorTagClose;
			}
			if ( variable_get('idmg_show_site_name_desktop') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_desktop')];
				$logoTitleDescription .= '<' . $siteNameElement . ' class="site-name-desktop">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteName;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_desktop')];
				$logoTitleDescription .= '<' . $siteTitleElement . ' class="site-title-desktop">';
				$logoTitleDescription .= $anchorTagOpen;
				$logoTitleDescription .= $siteTitle;
				$logoTitleDescription .= $anchorTagClose;
				$logoTitleDescription .= '</' . $siteTitleElement . '>';
			}
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_desktop')];
				$logoTitleDescription .= '<' . $siteDescriptionElement . ' class="site-description-desktop">';
				$logoTitleDescription .= $siteDescription;
				$logoTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
		}

		return $logoTitleDescription;
	}

  /**
	 * Translate the static radioChoices array to get the non-static array translatedRadioChoices
	 */
	protected function translateStaticArrays()
	{
		foreach( parent::$radioChoices as $aChoice )
		{
			array_push( $this->translatedRadioChoices, t($aChoice) );
		}
	}
}
