<?

include('functions.php');





// generate htaccess redirects

// echo "<pre>";

// $artists = get_table('artists', 0, 0);
// while( $artist = mysqli_fetch_assoc($artists) ){
//   $old_path = str_replace('https://www.codame.com/', '', $artist['old_url']);
//   $new_url = 'https://codame.com/artists/'.$artist['slug'];
//   echo 'rewriterule ^'.$old_path.'(.*)$ '.$new_url.'$1 [r=301,nc]<br>';
// }

// $projects = get_table('projects', 0, 0);
// while( $project = mysqli_fetch_assoc($projects) ){
//   $old_path = str_replace('https://www.codame.com/', '', $project['old_url']);
//   $new_url = 'https://codame.com/projects/'.$project['slug'];
//   echo 'rewriterule ^'.$old_path.'(.*)$ '.$new_url.'$1 [r=301,nc]<br>';
// }

// $events = get_table('events', 0, 0);
// while( $event = mysqli_fetch_assoc($events) ){
//   $old_path = str_replace('https://www.codame.com/', '', $event['old_url']);
//   $new_url = 'https://codame.com/events/'.$event['slug'];
//   echo 'rewriterule ^'.$old_path.'(.*)$ '.$new_url.'$1 [r=301,nc]<br>';
// }

// $pages = get_table('pages', 0, 0);
// while( $page = mysqli_fetch_assoc($pages) ){
//   $old_path = str_replace('https://www.codame.com/', '', $page['old_url']);
//   $new_url = 'https://codame.com/pages/'.$page['slug'];
//   echo 'rewriterule ^'.$old_path.'(.*)$ '.$new_url.'$1 [r=301,nc]<br>';
// }

// // rewriterule ^post/portfolio/laturbo/(.*)$ https://codame.com/new/artists/laturbo-avedon$1 [r=301,nc]

// ?>
// </pre>