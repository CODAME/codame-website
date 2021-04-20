<?
  include('admin/functions.php');

  // this GET variable is set in the .htaccess file
  // URLs are rewritten like this:
  // codame.com/artists -> codame.com/category.php?table=artists

  $table = $_GET['table'];

  $where_clause = '';
  $page_title = $table;
  $header = null;

  if ($table == 'events') {
    if ($_GET['event_type'] == "workshop") {
      $page_title = "Workshops";
      $where_clause = " WHERE event_type = 'workshop' ";
      $header = get_row('headers','slug','workshops');
    } else {
      $page_title = "Events";
      $where_clause = " WHERE event_type = 'event' ";
      $header = get_row('headers','slug','events');
    }
  } 
  
  if ($table == 'projects') {
      if ($_GET['is_nft'] == 'nft') {
        $page_title = "NFT art";
        $where_clause = " WHERE is_nft = 'nft' ";
        $header = get_row('headers', 'slug', 'nft');
    } else {
      $page_title = "Projects";
      $where_clause = " WHERE is_nft IS NULL ";
      $header = get_row('headers','slug','projects');
    }
 } 
  
  if (  
    $table == "homepage" ||
    $table == "sponsors" ||
    $table == "artists"
  ) {
    $header = get_row('headers','slug',$table);
  }

  if( $table == 'artists' || $table == 'projects'){
    $order_by = 'edited';
  }else if( $table == 'events' ){
    $order_by = 'date';
  }else if( $table == 'sponsors' || $table == 'partners' ){
    $order_by = 'name';
  }else{
    // an invalid table was given. Redirect to home.
    header('Location://codame.com');
  }

?>
<html>
<? include('partials/head.php'); ?>
<body>

  <? include('partials/header.php') ?>
  <? include('partials/sidebar.php') ?>
  <div id="content">
    <? if ($header) { ?>
      <? if( $header['pic'] !== '' ){ ?>
        <a href="<? echo $header['banner_link_url'] ?>">
          <img src="<? echo $header['pic'] ?>">
        </a>
      <? } ?>

      <div class="bar-link">
        <h2><? echo $page_title; ?></h2>
        <?
        if( $header['description'] !== '' ){
          echo $header['description'];
        }
        ?>
      </div>
    <? } ?>

      <div class="tiles">
        <? output_results($table,0,0,'tiles',$order_by, $where_clause); ?>
      </div>

  </div>
  <? include('partials/footer.php') ?>

</body>
</html>