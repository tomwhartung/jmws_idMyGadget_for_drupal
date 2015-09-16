<?php
/**
 * Bundles and sets the data that we use to create the phone burger menu icons
 * Note: Everything that uses the phone burger icon file name is part of a hack we need
 *   because using the JS API to draw the phone burger menu is currently not working on phones
 *   except when we reload the page. It would be nice to be able to remove that someday....
 */

class PhoneBurgerMenuIcon
{
	const LEFT = 'left';
	const RIGHT = 'right';

	/**
	 * The html markup we want to use for this.
	 * Note that if this particular icon is not being displayed, this remains empty.
	 * @var type String
	 */
	public $html = '';
	/**
	 * The javascript we want to use for this.
	 * Note that if this particular icon is not being displayed, this remains empty.
	 * @var type String
	 */
	public $js = '';
	/**
	 * Using a canvas element and drawing the phoneburger icon
	 * does not work on all devices (e.g. phones) and
	 * with all templates (e.g., beez3), without reloading the page.
	 * Hence this hack, to allow using an image in a file.
	 * To display a file instead of drawing the icon,
	 * (1) put it in images/idMyGadget/ and
	 * (2) name it phoneBurgerMenuIcon[Left|Right][Device].png .
	 *     where [Device] is "Desktop" "Phone" or "Tablet"
	 * Examples:
	 *    images/idMyGadget/phoneBurgerMenuIconLeftDesktop.png
	 *    images/idMyGadget/phoneBurgerMenuIconRightPhone.png
	 *    images/idMyGadget/phoneBurgerMenuIconRightTablet.png
	 * @var type
	 */
	public $fileName = '';      // used for hack needed for phones and beez3
	/**
	 * If the file is there, we use it, else we generate the html and js needed to draw the icon.
	 * @var type Boolean
	 */
	public $useImage = FALSE;

	/**
	 * Either self::LEFT or self::RIGHT
	 * @var type String
	 */
	protected $leftOrRight = '';
	/**
	 * Parameters set in the joomla adminstrator area
	 * @var type Object
	 */
	protected $params = null;
	/**
	 * The object we are using for device detection
	 * @var type Object
	 */
	protected $jmwsIdMyGadget = null;
	/**
	 * Just the template name (not an object, just a string)
	 * Needed to find the image files used for the hack (see above)
	 * @var type String
	 */
	protected $template = '';

	/**
	 * Constructor: use the parameters set in the joomla back end to set the data members
	 */
	public function __construct( $leftOrRight, $params, $jmwsIdMyGadget, $template )
	{
		$this->leftOrRight = $leftOrRight ;
		$this->params = $params;
		$this->jmwsIdMyGadget = $jmwsIdMyGadget ;
		$this->template = $template;
		$this->setPublicDataMembers();
	}

	protected function setPublicDataMembers()
	{
		$this->fileName = $this->template . '/images/idMyGadget/phoneBurgerMenuIcon' .
			ucfirst($this->leftOrRight) .
			ucfirst($this->jmwsIdMyGadget->getGadgetString()) .
			'.png';
		if ( file_exists(JPATH_THEMES . DS . $this->fileName) )
		{
			$this->useImage = TRUE;
		}
		if ( $this->leftOrRight === self::LEFT &&
		     $this->jmwsIdMyGadget->phoneBurgerIconThisDeviceLeft )
		{
			$this->html = '<a href="#phone-burger-menu-left" data-rel="dialog">';
			if ( $this->useImage )
			{
				$this->html .=
					'<img id="phone-burger-icon-image-left" ' .
						'width="' . $this->params->get('phoneBurgerMenuLeftSize') . '" ' .
						'height="' . $this->params->get('phoneBurgerMenuLeftSize') . '" ' .
						'src="templates/' . $this->fileName . '" />';
			}
			else
			{
				$this->html .=
					'<canvas id="phone-burger-icon-left" ' .
						'width="' . $this->params->get('phoneBurgerMenuLeftSize') . '" ' .
						'height="' . $this->params->get('phoneBurgerMenuLeftSize') . '">' .
						'&nbsp;Menu&nbsp;' . '</canvas>';
			}
			$this->html .= '</a>';
			$this->js =
				'<script>' .
					'var phoneBurgerIconLeftOptions = {};' .
					'phoneBurgerIconLeftOptions.color = "' . $this->params->get('phoneBurgerMenuLeftColor') . '";' .
					'phoneBurgerIconLeftOptions.lineCap = "' . $this->params->get('phoneBurgerMenuLeftLineCap') . '";' .
					'phoneBurgerIconLeftOptions.lineSize = "' . $this->params->get('phoneBurgerMenuLeftLineSize') . '";' .
				'</script>';
		}
		if ( $this->leftOrRight === self::RIGHT &&
		     $this->jmwsIdMyGadget->phoneBurgerIconThisDeviceRight )
		{
			$this->html =
				'<a href="#phone-burger-menu-right" class="pull-right" data-rel="dialog">';
			if ( $this->useImage )
			{
				$this->html .=
					'<img id="phone-burger-icon-image-right"' .
						'width="' . $this->params->get('phoneBurgerMenuRightSize') . '" ' .
						'height="' . $this->params->get('phoneBurgerMenuRightSize') . '" ' .
						' src="templates/' . $this->fileName . '" />';
			}
			else
			{
				$this->html .=
					'<canvas id="phone-burger-icon-right" ' .
						'width="' . $this->params->get('phoneBurgerMenuRightSize') . '" ' .
						'height="' . $this->params->get('phoneBurgerMenuRightSize') . '">' .
						'&nbsp;Menu&nbsp;' . '</canvas>';
			}
			$this->html .= '</a>';
			$this->js =
				'<script>' .
					'var phoneBurgerIconRightOptions = {};' .
					'phoneBurgerIconRightOptions.color = "' . $this->params->get('phoneBurgerMenuRightColor') . '";' .
					'phoneBurgerIconRightOptions.lineCap = "' . $this->params->get('phoneBurgerMenuRightLineCap') . '";' .
					'phoneBurgerIconRightOptions.lineSize = "' . $this->params->get('phoneBurgerMenuRightLineSize') . '";' .
				'</script>';
		}
	}
}
