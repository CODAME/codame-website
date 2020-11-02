<?
  include('admin/functions.php');

  // the GET variables are set in the .htaccess file
  // URLs are rewritten like this:
  // codame.com/artists/example-artist -> codame.com/single.php?table=artists&slug=example-artist

  $table = $_GET['table'];
  $slug  = $_GET['slug'];

  // this should be an option in edit-single.php, rather than forced like this
  if( $slug == 'sponsors' || $slug  == 'partners' ){
    $class = 'white-bg';
  }else{
    $class = '';
  }

  $content = get_row($table,'slug',$slug);

?>
<html>
<? include('partials/head.php'); ?>
<body>

  <? include('partials/header.php') ?>
  <? include('partials/sidebar.php') ?>

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

        <? 
          // Display featured events
          $featured_events = explode(',',$content['events_array']);
          $where_clause_part = '';
          $slugs = [];

          foreach ($featured_events as $featured_event){            
            $slugs[] = "'" . trim($featured_event) . "'";
          }

          $where_clause_part = implode(',', $slugs);

          if($table == 'events' && !empty($featured_events[0])) {
            echo "<div>";
            echo "<h2>Events:</h2>";
            
            $order_by = "date";
            $where_clause = " WHERE slug IN ($where_clause_part) ";

            echo "<div class='tiles'>";
            output_results($table,0,0,'tiles',$order_by, $where_clause);
            echo "</div>";
            echo "</div>";
          }
        ?>

    </div>
    <div id="info-bar">

      <?

      // COMMISSION THIS ARTIST
      if( $table == 'artists' ){

        // echo '<img src="../assets/commission-this-artist.png" />';

      }

      // For event or project or artist page, show shop url if there is one
      if( !empty($content['shop_url']) ){

        echo '<div class="cta-wrapper">';
        echo '<a href="'.$content["shop_url"].'" id="cta-link">';
        include('assets/shop.svg');
        echo 'Buy now';
        echo '</a><hr>';
        echo '</div>';

      }

      // For event page OR project page: show artists
      if( $table == 'events' || $table == 'projects' ){

        $artists = explode(',',$content['artists_array']);

        if ( !empty($artists[0]) ){

          // keep first artist listed in place, shuffle the rest of the artists

          $first_artist = array_shift($artists);
          shuffle($artists); // mix it up
          array_unshift($artists,$first_artist); // add the first back on
          
          echo "<div class='related'>";
          echo "<h3>Artists:</h3>";
          foreach( $artists as $artist){
            $artist_slug = $artist;
            $artist = get_row('artists','slug',$artist);
            
            $pic  = $artist['pic'];
            $name = $artist['name'];
            $url  = $site_url.'/artists/'.$artist_slug;

            output_related_post($url,$pic,$name);
          }
          echo "</div>";
        }
      }

      if( !empty($content['website']) ){

        echo '<a href="'.$content["website"].'" class="info-link">';
        include('assets/network.svg');
        echo $content['name'];
        echo '</a><hr>';

      }

      if( !empty($content['twitter']) ){

        echo '<a href="'.$content["twitter"].'" class="info-link">';
        include('assets/twitter.svg');
        echo $content['name'] . ' on Twitter';
        echo '</a><hr>';

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

          echo "<div class='related'>";
          echo "<h3>Events:</h3>";

          while($event = mysqli_fetch_assoc($events)){

            $pic    = $event['pic'];
            $name   = $event['name'];
            $url    = $site_url.'/events/'.$event['slug'];

            output_related_post($url,$pic,$name);
            
          }

          echo "</div>";
        }
      }

      // For event page: show sponsors and projects
      if( $table == 'events' ){

        // sponsors
        $sponsors = explode(',',$content['sponsors_array']);
        if ( !empty($sponsors[0]) ){
          
          echo "<div class='related'>";
          echo "<h3>Sponsors:</h3>";
          foreach( $sponsors as $sponsor){
            $sponsor_slug = $sponsor;
            $sponsor = get_row('sponsors','slug',$sponsor);

            $pic  = $sponsor['pic'];
            $name = $sponsor['name'];
            $url  = $sponsor['website'];

            output_sponsor($url,$pic,$name);
          }
          echo "</div>";
        }

        // projects
        $projects = explode(',',$content['projects_array']);
        if ( !empty($projects[0]) ){

          echo "<div class='related'>";
          echo "<h3>Projects:</h3>";
          foreach( $projects as $project){
            $project_slug = $project;
            $project = get_row('projects','slug',$project);

            $pic  = $project['pic'];
            $name = $project['name'];
            $url  = $site_url.'/projects/'.$project_slug;

            output_related_post($url,$pic,$name);
          }
          echo "</div>";
        }

      }

     
      // For artists page: show projects
      if( $table == 'artists' ){
        $projects = search_table('projects','artists_array',$slug);
        if( mysqli_num_rows( $projects ) ){

          echo "<div class='related'>";
          echo "<h3>Projects:</h3>";

          while($project = mysqli_fetch_assoc($projects)){

            $pic    = $project['pic'];
            $name   = $project['name'];
            $url    = $site_url.'/projects/'.$project['slug'];

            output_related_post($url,$pic,$name);
            
          }
          echo "</div>";
        }
      }
      
      // For event page: show partners (after artists and projects)
      if( $table == 'events' ){

        // partners
        $partners = explode(',',$content['partners_array']);
        if ( !empty($partners[0]) ){
          echo "<div class='related'>";
          echo "<h3>Partners:</h3>";
          foreach( $partners as $partner){
            $partner_slug = $partner;
            $partner = get_row('partners','slug',$partner);

            $pic  = $partner['pic'];
            $name = $partner['name'];
            $url  = $partner['website'];

            output_partner($url,$pic,$name);
          }
          echo "</div>";
        }
      }

      ?>

    </div>
  </div>
  <? include('partials/footer.php') ?>

</body>
</html>