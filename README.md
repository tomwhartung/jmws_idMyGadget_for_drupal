# jmws_idMyGadget_for_drupal-d7

Module containing idMyGadget code for integration with version 7 of the Drupal CMS.

# This Project Is on Hold Indefinitely

Work on this project is on hold indefinitely for the following reasons:

1. The version of jQuery that Drupal 7 uses is incompatible with the version of jQuery Mobile that we want to use

1. Drupal 8 has been released

Therefore all work on this project is currently being done in the [jmws_drupal_stark_idMyGadget-d8 repo](https://github.com/tomwhartung/jmws_drupal_stark_idMyGadget-d8).

Thank you for your understanding.

# For possible future reference:

### Structural change to heading in page.tpl.php

In the final product, I want:
* the logo image to appear side-by side with the site name and/or site title
* the site slogan (aka. "description" (Joomla) and "tag line" (WP)) to appear under the logo image, site name and/or site title (each of which is optional via the admin panel)

Therefore, in the markup produced by getLogoNameTitleDescriptionHtml, I moved the logo image inside the div id="name-and-slogan.
You can compare it to the original markup, which is still in page.tpl.php, and displays when device detection is off ("no_detection" option is set in the admin panel).

Hopefully that makes sense!

