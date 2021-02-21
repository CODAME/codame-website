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
        <? if($content['slug'] != "art-tech-festival-2020-joynt") { ?>
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
        <? } ?>
        <? if($content['slug'] == "art-tech-festival-2020-joynt") { ?>
          <div class="elfsight-app-3eb52dbc-c36b-40bd-9b9b-da4d14fb4706"></div>
          <div class="festival-info">
            <h3>『 Partners & Sponsors  』</h3>
            <p><a href="https://codame.com/pages/support-art-tech">Contact Us</a> to inspire and educate your team with a discounted Ticket Group Buy! Be recognized as an innovative and visionary organization. Join our list of amazing <a href="https://codame.com/sponsors">Sponsors</a> with a tax deductable non profit donation. </p>
            <h3>『 Volunteers 』</h3>
            <p><a href="https://codame.com/pages/call-for-volunteers">Joyn</a> us to be part of the magic! All background and interests welcome for a fun and rewarding experience. </p>
            <h3>『 Call for Proposals 』</h3>
            <p>The deadline for the CODAME ART+TECH Festival 2020 has passed, but we're still excited to hear from you for future opportunities! Fill in our <a href="https://codame.com/pages/call-for-proposals">Call for Proposals Form</a>. </p>
            <ul><li>💟</li><li>👾</li><li>💜</li><li>👾</li><li>💟</li></ul>
            <p>CODAME is a member of Intersection for the Arts a non profit 501(c)(3) organization. All proceeds will be split with the participating artists. </p>
            <p>Thank you for your support for ART <span>💜</span> TECH !!! <a href="http://codame.com/pages/code-of-conduct">Code of Conduct</a> for all attendees. </p>
          </div>
        <? } ?>
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


      if( !empty($content['instagram']) ){

        echo '<a href="'.$content["instagram"].'" class="info-link">';
        include('assets/instagram.svg');
        echo $content['name'] . ' on Instagram';
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

      // For event and project page: show sponsors
      if( $table == 'events' || $table == 'projects' ){

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
      }
      
      // For event page: show projects
      if( $table == 'events' ){
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
      
      // For event and project page: show partners (after artists and projects)
      if( $table == 'events' || $table == 'projects' ){

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