<?

include('../functions.php');

$table       = $_GET['table'];
$where_key   = $_GET['where_key'];
$where_value = $_GET['where_value'];
$api_key     = $_GET['api_key'];

if( $api_key !== $codame_api_key ){
  echo "Permission not granted.";
  die;
}

db_connect();

delete_row($table, $where_key, $where_value);

?>