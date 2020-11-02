<?

session_start();

// config vars
$secrets_path = $_SERVER['DOCUMENT_ROOT'] . '/../config/secrets.php';
include($secrets_path);

function db_connect(){
  // config vars
  $secrets_path = $_SERVER['DOCUMENT_ROOT'] . '/../config/secrets.php';
  include($secrets_path);

  $con = mysqli_connect($mysql_host, $mysql_user, $mysql_pw, $mysql_db)
  or die( 'Could not connect: ' . mysqli_error($con) . ' // if local check allowed IPs for DB' );
  return $con;
}

function delete_row($table,$where_key,$where_value){
  $con = db_connect();

  $table       = mysqli_real_escape_string($con,$table);
  $where_key   = mysqli_real_escape_string($con,$where_key);
  $where_value = mysqli_real_escape_string($con,$where_value);

  $delete_query = "DELETE FROM $table WHERE $where_key='$where_value'" or die("Error in the consult.." . mysqli_error($con));
  $delete_result = mysqli_query($con, $delete_query);  
}

function update_field($table,$where_key,$where_value,$set_key,$set_value){

	// note: never use dashes in the mysql field key, it wont work

  $con = db_connect();

  $table       = mysqli_real_escape_string($con,$table);
  $where_key   = mysqli_real_escape_string($con,$where_key);
  $where_value = mysqli_real_escape_string($con,$where_value);
  $set_key     = mysqli_real_escape_string($con,$set_key);
  $set_value   = mysqli_real_escape_string($con,$set_value);

  $update_query = "UPDATE $table SET $set_key='$set_value' WHERE $where_key='$where_value'" or die("Error in the consult.." . mysqli_error($con));
  $update_result = mysqli_query($con, $update_query);

}

function insert_row($table,$row_array){

  $con = db_connect();

  $table = mysqli_real_escape_string($con,$table);

  foreach ($row_array as $key => $value){
    
    $key   = mysqli_real_escape_string($con,$key);
    $value = mysqli_real_escape_string($con,$value);

    $keys_string   .= $key . ", ";
    $values_string .= "'" . $value . "', ";

  }

  $keys_string   = rtrim($keys_string, ", ");
  $values_string = rtrim($values_string, ", ");  

  $insert_row_query = "INSERT INTO $table ($keys_string) VALUES($values_string)" or die("Error in the consult.." . mysqli_error($con));
  $insert_row_result = mysqli_query($con, $insert_row_query);

}

function get_table($table, $offset, $limit, $order_by = '', $where_clause = ''){

  $con      = db_connect();
  $table    = mysqli_real_escape_string($con,$table);
  $limit    = mysqli_real_escape_string($con,$limit);
  $offset   = mysqli_real_escape_string($con,$offset);
  $order_by = mysqli_real_escape_string($con,$order_by);

  if( $limit > 0 ){
    $limit_clause = "LIMIT $offset, $limit ";
  }else{
    $limit_clause = '';
  }

  if( $order_by !== '' && $table !== 'sponsors' && $table !== 'partners' ){
    $order_by_clause = "ORDER BY $order_by DESC";
  }else if( $order_by !== '' && ( $table == 'sponsors' || $table == 'partners' ) ){
    $order_by_clause = "ORDER BY $order_by ASC";
  }else{
    $order_by_clause = "ORDER BY id DESC";
  }

  $query = "SELECT * FROM $table $where_clause $order_by_clause $limit_clause";

  $result = mysqli_query($con, $query);
  
  return $result;
}

function get_row($table,$where_key,$where_value){
  
  $con = db_connect();

  $table       = mysqli_real_escape_string($con,$table);
  $where_key   = mysqli_real_escape_string($con,$where_key);
  $where_value = mysqli_real_escape_string($con,$where_value);

  $query = "SELECT * FROM $table WHERE $where_key='$where_value'" or die("Error in the consult.." . mysqli_error($con));
  $result = mysqli_query($con, $query);

  $row = mysqli_fetch_assoc($result);
  return $row;

}

function get_amount_of_results($table,$where_key,$where_value){

  $con = db_connect();

  $table       = mysqli_real_escape_string($con,$table);
  $where_key   = mysqli_real_escape_string($con,$where_key);
  $where_value = mysqli_real_escape_string($con,$where_value);

  $query = "SELECT * FROM $table WHERE $where_key='$where_value'" or die("Error in the consult.." . mysqli_error($con));
  $result = mysqli_query($con, $query);

  return mysqli_num_rows ( $result );

}

function to_slug($string){
  return strtolower(trim(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)),'-'));
}

function search_table( $table, $column, $search_term, $order_by = ''){
  
  $con = db_connect();

  $table       = mysqli_real_escape_string($con,$table);
  $column      = mysqli_real_escape_string($con,$column);
  $search_term = mysqli_real_escape_string($con,$search_term);
  $order_by    = mysqli_real_escape_string($con,$order_by);

  if( $order_by !== '' ){
    $order_by_clause = "ORDER BY $order_by DESC";
  }else{
    $order_by_clause = "ORDER BY id DESC";
  }

  $query = "SELECT * FROM $table WHERE $column LIKE '%$search_term%' $order_by_clause" or die("Error in the consult.." . mysqli_error($con));
  $result = mysqli_query($con, $query);

  return $result;
}

function generate_sidebar_pages($site_url){
  
  $pages = get_table('pages',0,0);
  $links = '';

  while($page = mysqli_fetch_assoc($pages)){
    
    if( $page['hidden'] == 1 || $page['hidden'] == '1' ){
      continue;
    }

    $slug = $page['slug'];
    $name = $page['name'];
    $links .= "<a href='$site_url/pages/$slug'>$name</a>";

  }

  // get the sidebar
  $sidebar = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/sidebar.php');

  // the flags and everything between them with the new links
  $sidebar = preg_replace('/<!-- flag start -->.*<!-- flag end -->/', "<!-- flag start -->".$links."<!-- flag end -->", $sidebar);

  // save the sidebar
  file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/sidebar.php', $sidebar);

}

function get_image_size( $size, $image_url ){

  if( $size == "small" ){
    $ext = '.'.pathinfo($image_url, PATHINFO_EXTENSION);
    $image_url = str_replace($ext, '-small'.$ext, $image_url);    
    return $image_url;
  }

  if( $size == "large" ){
    $image_url = str_replace('-small', '', $image_url);    
    return $image_url;
  }

}

// use this function like so: upload_image( $_FILE['pic'], 'modbod3d', 350 );
// 'pic' would be replaced with whatever the file input was named in the form.
// $slug is used to name the final file
// $small_width is the width of the thumbnail that is generated.
// images are saved to codame.com/uploaded_images/
// thumbnails are in the same directory and are named like image-small.jpg

function upload_image($file_array, $slug, $small_width = 350){

  // upload troubleshooting
  // echo "Upload: " . $file_array["name"] . "<br>";
  // echo "Type: " . $file_array["type"] . "<br>";
  // echo "Size: " . ($file_array["size"] / 1024) . " kB<br>";
  // echo "Stored in: " . $file_array["tmp_name"] . "<br>";
  // echo "Error is: " . $file_array["error"];

  // die;

  // check if image was uploaded
  if( empty( $file_array ) ){
    return false;
  }

  // check for error
  if ( $file_array["error"] > 0){
    echo "Error: " . $file_array["error"];
    return false;
  }

  // check if the file has a size.
  if( !getimagesize($file_array['tmp_name']) ){
    echo "Error: image has no data.";
    return false;
  }

  $image_name = $file_array["name"];

  // check if name contains php
  $pos = strpos($image_name,'.php');
  if( !($pos === false) ){
    echo "Error: File name cannot contain '.php'.";
    return false;
  }

  $filename_parts = explode(".", $image_name);

  if( !$slug ){
  	$slug = to_slug($filename_parts[0]).'-'.time();
  }

  $ext = strtolower('.' . end($filename_parts));

  //check if extension is allowed or not
  $whitelist = array(".jpg",".jpeg",".gif",".png"); 
  if (!(in_array($ext, $whitelist))) {
    echo "Error: Not jpg, jpeg, gif or png.";
    return false;
  }

  $filetype = $file_array['type'];
  $filetype = strtolower($filetype);

  // double check that it is an image
  $pos = strpos($filetype,'image');
  if($pos === false) {
    echo "Error: Filetype says not an image.";
    return false;
  }

  // again make sure the mime type is an image
  $imageinfo = getimagesize($file_array['tmp_name']);
  if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg'&& $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png') {
    echo "Error: MIME type says not an image.";
    return false;
  }

  // check for double file type (image with comment)
  if(substr_count($filetype, '/')>1){
    echo "Error: Double file type.";
    return false;
  }    
  
  $image_name = $slug . $ext;

  if( move_uploaded_file( $file_array['tmp_name'], "../uploaded_images/".$image_name )){
    
    $pic = "http://codame.com/uploaded_images/$image_name";
    
    $small_pic = str_replace($ext, '-small'.$ext, $image_name);
    $small_pic_path = '../uploaded_images/' . $small_pic;

    // generate small version
    $img = new Imagick($pic);
    $format = $img->getImageFormat();
        
    if ($format == 'GIF') {
      
      // gifs are not resized. Instead for consistency a copy of the gif is appended with -small.
      
      try{
        copy( '../uploaded_images/'.$image_name, $small_pic_path );
      }catch(Exception $e){
        echo 'Error: Couldnt copy gif. Exception: ',  $e->getMessage(), "n";
        return false;
      }

    }else{

      try{    
        $img->thumbnailImage($small_width, 0);
        $img->writeImage($small_pic_path);
      }catch(Exception $e){
        echo 'Error: Couldnt resize image. Exception: ',  $e->getMessage(), "n";
        return false;
      }

    }

    return $pic;

  }else {
    echo "Error: A problem occurred when moving the file to the uploads folder.";
  }

}

function is_single(){
  if( basename($_SERVER["SCRIPT_NAME"],'.php') == 'single' ){
    return true;
  }else{
    return false;
  }
}

function is_category(){
  if( basename($_SERVER["SCRIPT_NAME"],'.php') == 'category' ){
    return true;
  }else{
    return false;
  }
}

//////////////////////// Layout functions

function output_related_post($url,$pic,$name){

  $pic = get_image_size('small',$pic);
  echo '<a href="'.$url.'">';
  echo '<div class="related-post">';
  echo '<img src="'.$pic.'" />';
  echo '<span>'.$name.'</span>';
  echo '</div>';
  echo '</a>';
  echo '<hr>';
}

function output_sponsor($url,$pic,$name){

  $pic = get_image_size('small',$pic);
  echo '<a href="'.$url.'" target="_blank">';
  echo '<div class="related-post sponsor">';
  echo '<img src="'.$pic.'"/>';
  echo '<span>'.$name.'</span>';
  echo '</div>';
  echo '</a>';
  echo '<hr>';
 
}

function output_partner($url,$pic,$name){

  $pic = get_image_size('small',$pic);
  echo '<a href="'.$url.'" target="_blank">';
  echo '<div class="related-post partner">';
  echo '<img src="'.$pic.'"/>';
  echo '<span>'.$name.'</span>';
  echo '</div>';
  echo '</a>';
  echo '<hr>';
 
}

function output_results( $table, $offset, $limit, $layout_type, $order_by = '', $where_clause = ''){
  
  $results = get_table($table,$offset,$limit,$order_by,$where_clause);
  $results_array = array();
  
  while($result = mysqli_fetch_assoc($results)){
    if( $result['hidden'] == '1' ){ continue; }
    array_push( $results_array, $result );
  }

  // sort events chronologically

  if( $table == 'events' ){
    $events_chronological = array();
    foreach( $results_array as $result ){

      $date = $result['date'];

      while( isset( $events_chronological[$date] ) ){
        $date = $date . "0";
      }

      $events_chronological[$date] = $result;

    }
    ksort( $events_chronological );
    $results_array = array_reverse($events_chronological);
  }

  // output all the results

  $result_number = 0;
  foreach( $results_array as $result ){

    $name = $result['name'];
    $slug = $result['slug'];
    $pic  = get_image_size('small',$result['pic']);
    if( !empty($result['date']) ){
      date_default_timezone_set('America/Los_Angeles');
      $date = date("d M Y", strtotime($result['date']));  
    }    
    
    // tiles layout

    if( $layout_type == 'tiles' ){

      // get url
      if( $table == 'sponsors' || $table == 'partners' ){
        $url = $result['website'];
      }else{
        $url = '/' . $table . '/' . $slug;
      }

      $tile_class = $table."-tile";

      echo "<a href='$url' style='background-image:url($pic)' class='$tile_class' >";
      
      if( $table == 'events'){
        
        // monkey fix for festival 2018 date
        if( $name == "ART+TECH Festival [2018]" ){
          $date = "June 4-7";
        }

        echo "<div class='date'>$date</div>";
      }

      echo "  <span>$name</span>";
      echo "</a>";  
    }

    // blocks layout

    if( $layout_type == 'blocks' ){

      echo "<a href='$table/$slug' class='content-block'>";
      
      // output the image.
      // if it is within the first few, don't let it be lazy loaded
      if( $result_number < 3 ){
        echo "<img src='$pic' />";  
      }else{
        echo "<img class='lazy' data-src='$pic' src='/assets/blank.gif' height='150' />";
      }
      
      if( $table == 'events'){

        // monkey fix for festival 2018 date
        if( $name == "ART+TECH Festival [2018]" ){
          $date = "June 4-7";
        }

        echo "  <span>$name <div class='date'>$date</div></span>";
      }else{
        echo "  <span>$name</span>";
      }
      echo "</a>";

    }

    $result_number++;
    
  }
}

?>
