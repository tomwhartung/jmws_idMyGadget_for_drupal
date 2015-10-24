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
	 * Constructor: for best results, install and use a gadgetDetector other than the default
	 */
	public function __construct( $gadgetDetectorString=null, $debugging=FALSE, $allowOverridesInUrl=TRUE )
	{
		$this->idMyGadgetDir = IDMYGADGET_MODULE_DIR;
		parent::__construct( $gadgetDetectorString, $debugging, $allowOverridesInUrl );
		$this->translateStaticArrays();
	}

	/**
	 * For development only! Please remove when code is stable.
	 * Displaying some values that can help us make sure we haven't inadvertently
	 * broken something while we are actively working on this.
	 * @return string
	 */
	public function getSanityCheckString( $extra='' )
	{
		$returnValue = '<p>';
		$returnValue .= parent::getSanityCheckString() . '/';

		$jqmDataThemeIndex = variable_get( 'idmg_jqm_data_theme' );   // WARNING: drupal-specific (but we are just checking sanity)
		$returnValue .= '/' . $jqmDataThemeIndex;
		$returnValue .= '/' . $this->jqmDataThemeAttribute;
		$returnValue .= '/' . $extra;
		$returnValue .= '</p>';
		return $returnValue;
	}

	/**
	 * Based on the current device, access the device-dependent options set in the admin console
	 * and use them to generate most of the markup for the heading
	 * @return string Markup for site heading (logo, name, title, and description, each of which is optional)
	 */
	public function getLogoNameTitleDescriptionHtml( $front_page='' )
	{
		global $base_url;

		if ( $front_page === '' )
		{
			$front_page = $base_url;
		}

		$logoNameTitleDescription = '';  // the return value of this method
		$logoFile = '';
		$logoImgSrc = $base_url . '/sites/default/files/';
		$siteName = variable_get( 'site_name', '' );
		$siteTitle = '';
		$siteDescription = '';
		$nameTitleSloganOpen = '<div id="name-and-slogan" class="name-and-slogan">';
		$nameTitleSloganClose = '</div><!-- #name-and-slogan .name-and-slogan -->';
		$logoAnchorTagOpen = '<a href="' . $front_page . '" title="' . t('Home') . '" rel="home" id="logo">';
		$logoAnchorTagClose = '</a>';
		$textAnchorTagOpen = '<a href="' . $front_page . '" title="' . t('Home') . '" rel="home">';
		$textAnchorTagClose = '</a>';

		if ( $this->isPhone() )
		{
			$logoFile = variable_get( 'idmg_logo_file_phone' );
			$siteTitle = variable_get( 'idmg_site_title_phone' );
			$siteDescription = variable_get('idmg_site_description_phone');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-phone" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-phone">';
			if ( variable_get('idmg_show_site_name_phone') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_phone')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-phone">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_phone')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-phone">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-phone -->';
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_phone')];
				$logoNameTitleDescription .= '<' . $siteDescriptionElement . ' id="site-slogan" class="site-description-phone">';
				$logoNameTitleDescription .= $siteDescription;
				$logoNameTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}
		else if ( $this->isTablet() )
		{
			$logoFile = variable_get( 'idmg_logo_file_tablet' );
			$siteTitle = variable_get('idmg_site_title_tablet');
			$siteDescription = variable_get('idmg_site_description_tablet');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-tablet" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-tablet">';
			if ( variable_get('idmg_show_site_name_tablet') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-tablet">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-tablet">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-tablet -->';
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteDescriptionElement . ' id="site-slogan" class="site-description-tablet">';
				$logoNameTitleDescription .= $siteDescription;
				$logoNameTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}
		else
		{
			$logoFile = variable_get( 'idmg_logo_file_desktop' );
			$siteTitle = variable_get('idmg_site_title_desktop');
			$siteDescription = variable_get('idmg_site_description_desktop');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-desktop" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-desktop">';
			if ( variable_get('idmg_show_site_name_desktop') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[variable_get('idmg_site_name_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-desktop">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[variable_get('idmg_site_title_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-desktop">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-desktop -->';
			if ( strlen($siteDescription) > 0 )
			{
				$siteDescriptionElement = parent::$validElements[variable_get('idmg_site_description_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteDescriptionElement . ' id="site-slogan" class="site-description-desktop">';
				$logoNameTitleDescription .= $siteDescription;
				$logoNameTitleDescription .= '</' . $siteDescriptionElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}

		return $logoNameTitleDescription;
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
	/**
	 * Decide whether we are using the jQuery Mobile js library,
	 * based on the device we are on and the values of device-dependent options set by the admin
	 */
	protected function setUsingJQueryMobile() {
		$this->usingJQueryMobile = FALSE;
		$this->phoneHeaderNavThisDevice = FALSE;
		$this->phoneFooterNavThisDevice = FALSE;
		$this->phoneBurgerIconThisDeviceLeft = FALSE;
		$this->phoneBurgerIconThisDeviceRight = FALSE;
		$phoneNavOnThisDevice = FALSE;
		//
		// Not worrying about the phone burger stuff right now,
		// so this logic will probably change as time progresses
		//
		if ( $this->isPhone() ) {
			$this->usingJQueryMobile = TRUE;
			$phoneNavOnThisDevice = variable_get('idmg_phone_nav_on_phones', 0);
		}
		else if ( $this->isTablet() ) {
			$phoneNavOnThisDevice = variable_get('idmg_phone_nav_on_tablets', 0);
			if ( $phoneNavOnThisDevice ) {
				$this->usingJQueryMobile = TRUE;
			}
		}
		else {
			$phoneNavOnThisDevice = variable_get('idmg_phone_nav_on_desktops', 0);
			if ( $phoneNavOnThisDevice ) {
				$this->usingJQueryMobile = TRUE;
			}
		}
		if( $phoneNavOnThisDevice ) {
			$this->phoneHeaderNavThisDevice = TRUE;
			$this->phoneFooterNavThisDevice = TRUE;
		}
	}
	/**
	 * Use the admin option to set the jQuery Mobile Data Theme attribute (if necessary)
	 */
	protected function setJqmDataThemeAttribute()
	{
		$jqmDataThemeIndex = variable_get( 'idmg_jqm_data_theme' );
		$jqmDataThemeLetter = JmwsIdMyGadget::$jqueryMobileThemeChoices[$jqmDataThemeIndex];
		$this->jqmDataThemeAttribute = 'data-theme="' . $jqmDataThemeLetter . '"';
	}
}
