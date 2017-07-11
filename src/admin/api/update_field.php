<?

include('../functions.php');

$table       = $_GET['table'];
$where_key   = $_GET['where_key'];
$where_value = $_GET['where_value'];
$set_key     = $_GET['set_key'];
$set_value   = $_GET['set_value'];
$api_key     = $_GET['api_key'];

if( $api_key !== $codame_api_key ){
  echo "Permission not granted.";
  die;
}

db_connect();

update_field($table, $where_key, $where_value, $set_key, $set_value);

?>