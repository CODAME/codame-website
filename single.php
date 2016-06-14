<?
  include('admin/functions.php');

  // the GET variables are set in the .htaccess file
  // URLs are rewritten like this:
  // codame.com/artists/example-artist -> codame.com/single.php?table=artists&slug=example-artist

  $table = $_GET['table'];
  $slug  = $_GET['slug'];

  // this should be an option in edit-single.php, rather than forced like this
  if( $slug == 'sponsors' ){
    $class = 'white-bg';
  }else{
    $class = '';
  }

  $content = get_row($table,'slug',$slug);

?>
<html>
<? include('head.php'); ?>
<body>

  <? include('header.php') ?>
  <? include('sidebar.php') ?>

  <div id="container">
    <div id="content" class="article <? echo $class ?>">

        <div class="bar-link">
          <h2>
            <? echo $content['name']; ?>
          </h2>
        </div>

        <? if( !empty( $content['pic'] ) ){ ?>
          <img src="<? echo $content['pic']; ?>" alt="<? echo $content['name']; ?>" />
        <? } ?>
        
        <div class="text-content">
          <? echo $content['description']; ?>
        </div>

    </div>
    <div id="info-bar">

      <?

      // COMMISSION THIS ARTIST
      if( $table == 'artists' ){

        // echo '<img src="../assets/commission-this-artist.png" />';

      }      

      // RELATED POSTS

      // For artist page OR project page: show events

      if( $table == 'artists' || $table == 'projects'){

        if( $table == 'artists' ){
          // search column is artists in the event row
          $search_col = 'artists_array';
        }

        if( $table == 'projects' ){
          // search column is projects in the event row
          $search_col = 'projects_array';
        }

        // run the search
        $events = search_table( 'events', $search_col, $slug, 'date');

        // if there are results, output them
        if( mysqli_num_rows($events) ){

          echo "<h3>Seen At:</h3>";  

          while($event = mysqli_fetch_assoc($events)){

            $pic    = $event['pic'];
            $name   = $event['name'];
            $url    = $site_url.'/events/'.$event['slug'];

            output_related_post($url,$pic,$name);
            
          }
        }
        
      }

      // For event page OR project page: show artists

      if( $table == 'events' || $table == 'projects' ){

        $artists = explode(',',$content['artists_array']);

        if ( !empty($artists[0]) ){

          // keep first artist listed in place, shuffle the rest of the artists

          $first_artist = array_shift($artists);
          shuffle($artists); // mix it up
          array_unshift($artists,$first_artist); // add the first back on
          
          echo "<h3>Artists:</h3>";
          foreach( $artists as $artist){
            $artist_slug = $artist;
            $artist = get_row('artists','slug',$artist);
            
            $pic  = $artist['pic'];
            $name = $artist['name'];
            $url  = $site_url.'/artists/'.$artist_slug;

            output_related_post($url,$pic,$name);
          }
        }
      }

      // event page: show projects and sponsors
      if( $table == 'events' ){
        
        // projects
        $projects = explode(',',$content['projects_array']);
        if ( !empty($projects[0]) ){
          echo "<h3>Projects:</h3>";
          foreach( $projects as $project){
            $project_slug = $project;
            $project = get_row('projects','slug',$project);
            
            $pic  = $project['pic'];
            $name = $project['name'];
            $url  = $site_url.'/projects/'.$project_slug;

            output_related_post($url,$pic,$name);
          }
        }

        // sponsors
        $sponsors = explode(',',$content['sponsors_array']);
        if ( !empty($sponsors[0]) ){
          echo "<h3>Sponsored By:</h3>";
          foreach( $sponsors as $sponsor){
            $sponsor_slug = $sponsor;
            $sponsor = get_row('sponsors','slug',$sponsor);
            
            $pic  = $sponsor['pic'];
            $name = $sponsor['name'];
            $url  = $sponsor['website'];

            output_sponsor($url,$pic,$name);
          }
        }

      }

      // artists page: show projects
      if( $table == 'artists' ){
        $projects = search_table('projects','artists_array',$slug);
        if( mysqli_num_rows( $projects ) ){

          echo "<h3>Works On:</h3>";

          while($project = mysqli_fetch_assoc($projects)){

            $pic    = $project['pic'];
            $name   = $project['name'];
            $url    = $site_url.'/projects/'.$project['slug'];

            output_related_post($url,$pic,$name);
            
          }
        }
      }

      if( $content['website'] ){

        echo '<a href="'.$content["website"].'" class="info-link">';
        include('assets/network.svg');
        echo $content['name'];
        echo '</a><hr>';

      }

      if( $content['twitter'] ){

        echo '<a href="'.$content["twitter"].'" class="info-link">';
        include('assets/twitter.svg');
        echo $content['name'] . ' on Twitter';
        echo '</a><hr>';

      }      

      ?>

    </div>
  </div>
  <? include('footer.php') ?>

</body>
</html>