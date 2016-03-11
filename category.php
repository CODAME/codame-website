<?
  include('admin/functions.php');

  // this GET variable is set in the .htaccess file
  // URLs are rewritten like this:
  // codame.com/artists -> codame.com/category.php?table=artists

  $table = $_GET['table'];

  if( $table == 'artists' || $table == 'projects'){
    $order_by = 'edited';
  }else if( $table == 'events' ){
    $order_by = 'date';
  }else if( $table == 'sponsors' ){
    $order_by = 'name';
  }else{
    // an invalid table was given. Redirect to home.
    header('Location:http://codame.com');
  }

?>
<html>
<? include('head.php'); ?>
<body>

  <? include('header.php') ?>
  <? include('sidebar.php') ?>
  <div id="content">

      <? $header = get_row('headers','slug',$table); ?>
      <? if( $header['pic'] !== '' ){ ?>
        <a href="<? echo $header['banner-link-url'] ?>">
          <img src="<? echo $header['pic'] ?>">
        </a>
      <? } ?>

      <div class="bar-link">
        <h2><? echo $table; ?></h2>
        <?
        if( $header['description'] !== '' ){
          echo $header['description']
        }
        ?>
      </div>

      <div class="tiles">
        <? output_results($table,0,0,'tiles',$order_by); ?>
      </div>

  </div>
  <? include('footer.php') ?>

</body>
</html>