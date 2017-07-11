<?

// set site_url variable based on detected server name
$parts = explode('.', $_SERVER["SERVER_NAME"]);

if( $parts[0] == 'codame' && $parts[1] == 'com' ){
  $site_url = "http://codame.com";
}else if( $parts[0] == 'dev' ){
  $site_url = 'http://dev.codame.com';
}else{
  $site_url = 'http://codame.dev'; // change this to match your local site name
}

$codame_api_key = "fill in";

$mysql_host = "fill in";
$mysql_user = "fill in";
$mysql_pw   = "fill in";
$mysql_db   = "fill in";

$admin_user = "fill in";
$admin_pw   = "fill in";

?>