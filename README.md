# jmws_idMyGadget_for_drupal
Module containing idMyGadget code for integration with the Drupal CMS.

### Structural change to heading in page.tpl.php

In the final product, I want:
* the logo image to appear side-by side with the site name and/or site title
* the site slogan (aka. "description" (Joomla) and "tag line" (WP)) to appear under the logo image, site name and/or site title (each of which is optional via the admin panel)

Therefore, in the markup produced by getLogoNameTitleDescriptionHtml, I moved the logo image inside the div id="name-and-slogan.
You can compare it to the original markup, which is still in page.tpl.php, and displays when device detection is off ("no_detection" option is set in the admin panel).

Hopefully that makes sense!

