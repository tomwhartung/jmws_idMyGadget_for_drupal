
Getting an error trying to use jQuery Mobile.

Tried fixing it by using the latest version.

That led to errors, which led to trying to override the default version of jQuery used in drupal (1.4.4) with this one.

References for overriding the default version of jQuery in Drupal:
  https://www.drupal.org/node/1058168
  https://api.drupal.org/api/drupal/modules%21system%21system.api.php/function/hook_js_alter/7
  http://drupal.stackexchange.com/questions/28820/how-do-i-update-jquery-to-the-latest-version-i-can-download
  https://api.drupal.org/api/drupal/includes%21common.inc/function/drupal_get_path/7

This is not working, but having downloaded it I want to go ahead and keep it for possible future reference, until we solve this issue.

There is a module we can install, but I don't want to do that.

Maybe wait for Drupal 8?  It is installable now....

See commented out code in:
  sites/all/modules/jmws/idMyGadget/idMyGadget.module
    (function idMyGadget_js_alter)
  sites/all/modules/jmws/idMyGadget/idMyGadget/JmwsIdMyGadget.php
    (JQUERY_MOBILE_CSS_URL and const JQUERY_MOBILE_JS_URL)

