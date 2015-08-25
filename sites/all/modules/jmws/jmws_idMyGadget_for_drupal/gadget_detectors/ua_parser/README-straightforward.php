<?php
require_once 'vendor/autoload.php';
use UAParser\Parser;

$ua = "Mozilla/5.0 (Macintosh; Intel Ma...";

$parser = Parser::create();
$result = $parser->parse($ua);

print '<DOCTYPE html>';
print '<html>';
print '<head>';
print '<title>Straightforward - from the README</title>';
print '</head>';
print '<body>';
print '<h2>Straightforward - from the README</h2>';

print '<p>';

print "result->ua->family: \"" . $result->ua->family . "\"<br />";
print "result->ua->major: \"" . $result->ua->major . "\"<br />";
print "result->ua->minor: \"" . $result->ua->minor . "\"<br />";
print "result->ua->patch: \"" . $result->ua->patch . "\"<br />";
print "result->ua->toString(): \"" . $result->ua->toString() . "\"<br />";
print "result->ua->toVersion(): \"" . $result->ua->toVersion() . "\"<br />";

print "result->os->family: \"" . $result->os->family . "\"<br />";
print "result->os->major: \"" . $result->os->major . "\"<br />";
print "result->os->minor: \"" . $result->os->minor . "\"<br />";
print "result->os->patch: \"" . $result->os->patch . "\"<br />";
print "result->os->patchMinor: \"" . $result->os->patchMinor . "\"<br />";
print "result->os->toString(): \"" . $result->os->toString() . "\"<br />";
print "result->os->toVersion(): \"" . $result->os->toVersion() . "\"<br />";

print "result->device->family: \"" . $result->device->family . "\"<br />";

print "result->toString(): \"" . $result->toString() . "\"<br />";
print "result->originalUserAgent: \"" . $result->originalUserAgent . "\"<br />";

print '</p>';
print '</body>';
print '</html>';
