<?php
if ( ! defined( 'MEDIAWIKI' ) ) {
  exit( 1 );
}
/**
 * @author sukum <developer@sukum.net>
 * @copyright Copyright © 2014, sukum
 * @license http://en.wikipedia.org/wiki/MIT_License MIT license
 */

$wgExtensionCredits['other'][] = array(
  'path'            => __FILE__,
  'name'            => 'MediaWiki Auto Login',
  'author'          => array( 'sukum', ),
  'version'         => '1.0',
  'url'             => 'http://sukum.net/MediaWikiAutoLogin',
  'description'     => 'Media Wiki Extension to automatically login a user with username and password provided through request parameters.',
  'license-name'    => "MIT",
);

$dir = __DIR__;

$wgExtensionMessagesFiles['MediaWikiAutoLogin'] = $dir . '/MediaWikiAutoLogin.i18n.php';
$wgAutoloadClasses['MediaWikiAutoLogin'] = $dir . '/MediaWikiAutoLogin.body.php';

$wgHooks['UserLoginForm'][] = 'MediaWikiAutoLogin::onUserLoginForm';

$wgResourceModules['ext.MediaWikiAutoLogin'] = array(
  'scripts' => array('ext.MediaWikiAutoLogin.js'),
  'localBasePath' => $dir,
  'remoteExtPath' => 'MediaWikiAutoLogin',
  'dependencies' => array(),
  'messages' => array( 'MediaWikiAutoLogin Loaded',)
);

