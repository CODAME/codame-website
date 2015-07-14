<? include('head.php');

$table = $_GET['table'];
$noun = ucfirst(substr($table, 0, -1)); // noun for what is being edited. artist, etc

?>

<body>

  <? include('sidebar.php'); ?>

  <div id="content">
    
    <a href="edit-single.php?action=add&table=<? echo $table ?>">
      Add New <? echo $noun ?>
    </a>

    <h1>All <? echo $noun ?>s</h1>
    <? 
    
    $rows = get_table($table,0,0);

    if( $table == 'artists' || $table == 'projects' || $table == 'pages' ){

    }

    $posts = array();
    $delete_svg = file_get_contents('assets/cross.svg');

    //iterate over all the rows
    while($row = mysqli_fetch_assoc($rows)){
      $name   = $row['name'];
      $slug   = $row['slug'];
      $date   = $row['date'];
      $hidden = $row['hidden'];
      if( $hidden == 1 ){ 
        $checked = 'checked';
      }else{
        $checked = '';
      }

      $row  = "<tr slug='$slug'>";
      $row .= "<td>$date</td>";
      $row .= "<td><input class='visibility' type='checkbox' $checked /></td>";
      $row .= "<td class='post-link'><a href='edit-single.php?action=edit&table=$table&slug=$slug'>$name</a></td>";
      $row .= "<td class='delete'>$delete_svg</td>";
      $row .= "</tr>";

      // if events, sort by date.
      // otherwise sort alphabetically

      if( $table == 'events' ){

        while( isset( $posts[$date] ) ){
          $date = $date . "0";
        }

        $posts[$date] = $row;
        ksort($posts);
        $posts = array_reverse($posts);
      }else{
        $posts[$name] = $row;
        ksort($posts);
      }

    }


    // output them all
    echo "<table>";

    foreach( $posts as $post_row ){
      echo $post_row;
    }

    echo "</table>";

  ?>

  </div>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script>

    var table          = '<? echo $table ?>';
    var codame_api_key = '<? echo $codame_api_key ?>';

    $('.visibility').click(function(){
      
      val = $(this).prop('checked');

      if( val == true){
        val = 1;
      }else{
        val = 0;
      }

      slug = $(this).closest('tr').attr('slug');

      $.ajax({
        url: './api/update_field.php',
        data: {
          table:       table,
          where_key:   'slug',
          where_value: slug,
          set_key:     'hidden',
          set_value:   val,
          api_key:     codame_api_key
        },
        success:function(data){
          console.log(data);
        }
      });

      if( table == 'pages' ){
        $.ajax({
          url: './api/generate_sidebar_pages.php'
        });
      }

    });

    $('.delete').click(function(){
      $parent = $(this).parent();
      title = $(this).prev('.post-link').text();
      slug = $parent.attr('slug');

      r = confirm("Delete this post? \n"+title);
      if( r ){
        $.ajax({
          url: './api/delete_row.php',
          data: {
            table:       table,
            where_key:   'slug',
            where_value: slug,
            api_key:     codame_api_key
          },
          success:function(data){
            console.log(data);
            $parent.remove();
          }
        }); 
      }
    });

  </script>
</body>