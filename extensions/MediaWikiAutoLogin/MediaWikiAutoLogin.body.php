<?php
if ( ! defined( 'MEDIAWIKI' ) ) {
  exit( 1 );
}

class MediaWikiAutoLogin {
  
  static function onUserLoginForm(&$template) {
    if ( ! isset($_REQUEST['mwal_user'], $_REQUEST['mwal_pass'])) { // If login parameters not in request
      return;
    }
    global $wgOut;
    
    $mwal_user  = $_REQUEST['mwal_user'];
    $mwal_pass  = $_REQUEST['mwal_pass'];
    

    global $wgServer,$wgScriptPath;
    global $wgUser;
    
    if ( ! $wgUser->isAnon() ) { // If logged in
      if ( $wgUser->getName() ==  $mwal_user ) {
        return true; // User is already logged in.
      } else {
        $wgUser->doLogout(); // Logout mismatched user.
      }
    }
    
    $data   = array (
      'wpName'        => $mwal_user,
      'wpPassword'    => $mwal_pass,
      'wpDomain'      => '',
      'wpLoginToken'  => '',
      'wpRemember'    => ''
    );
    $params = new FauxRequest($data);
    $loginForm  = new LoginForm( $params );
    $result     = $loginForm->authenticateUserData();
    if ($result == LoginForm::NEED_TOKEN) {
      $token = $loginForm->getLoginToken();
      $data['wpLoginToken']  = $token;
      $params = new FauxRequest($data);
      $loginForm = new LoginForm( $params );
      $result = $loginForm->authenticateUserData();
    }
    switch ( $result ) {
      case LoginForm :: SUCCESS :
        $wgUser->setOption( 'rememberpassword', 1 );
        $wgUser->setCookies(); // Set login cookies
        $wgOut->redirect($wgServer.$wgScriptPath); // Redirect
        return;
        break;
    }
    // API login using javascript if the above method fails
    $wgOut->addModules('ext.MediaWikiAutoLogin');
    $wgOut->addHTML("
    <script>
      window.mwal_user = '{$mwal_user}';
      window.mwal_pass = '{$mwal_pass}';
    </script>"
    );
  }
  
}
