<?
  include('admin/functions.php');

  // this GET variable is set in the .htaccess file
  // URLs are rewritten like this:
  // codame.com/artists -> codame.com/category.php?table=artists

  $table = $_GET['table'];

  $where_clause = '';
  $page_title = $table;

  if ($table == 'events') {
    if ($_GET['event_type'] == "workshop") {
      $page_title = "Workshops";
      $where_clause = " WHERE event_type = 'workshop' ";
    } else {
      $page_title = "Events";
      $where_clause = " WHERE event_type = 'event' ";
    }
  }

  if( $table == 'artists' || $table == 'projects'){
    $order_by = 'edited';
  }else if( $table == 'events' ){
    $order_by = 'date';
  }else if( $table == 'sponsors' || $table == 'partners' ){
    $order_by = 'name';
  }else{
    // an invalid table was given. Redirect to home.
    header('Location:http://codame.com');
  }

?>
<html>
<? include('partials/head.php'); ?>
<body>

  <? include('partials/header.php') ?>
  <? include('partials/sidebar.php') ?>
  <div id="content">

      <? $header = get_row('headers','slug',$table); ?>
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

      <div class="tiles">
        <? output_results($table,0,0,'tiles',$order_by, $where_clause); ?>
      </div>

  </div>
  <? include('partials/footer.php') ?>

</body>
</html>