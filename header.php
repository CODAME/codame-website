<?
if( $_SESSION['logged_in'] == true ){

  $edit_url = $site_url ."/admin";

  if( is_single() ){

    $edit_url .= "/edit-single.php?action=edit&table=$table&slug=$slug";

  }else if( is_category() ){

    $edit_url .= "/category.php?table=$table";

  } ?>

  <div id="admin-bar">
    <a href="<? echo $edit_url ?>" id="edit">Edit This</a>
    <a href="<? echo $site_url ?>/admin/logout.php" id="log-out">Log Out</a>
  </div>

<? } ?>