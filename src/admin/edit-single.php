<? 

include('partials/head.php');
include('partials/form-submit.php');
 
$action = $_GET['action'];
$table   = $_GET['table'];
$slug    = $_GET['slug'];
$noun = ucfirst(substr($table, 0, -1)); // noun for what is being edited. artist, etc

if( $action == "edit" ){
  
  $content = get_row($table,'slug',$slug);
  $pic = get_image_size('small',$content['pic']);

  $view_link = " / <a href='$site_url/$table/$slug'>View Page</a>";

}

?>
<body class='admin'>

    <? include('partials/sidebar.php'); ?>

    <div id="content">
      
      <?

      // print_r($content);

      ?>

      <h1>
        <?
        echo $_GET['action'] . " " . $noun;
        echo $view_link;
        ?>
      </h1>
      
      <form method='post' enctype="multipart/form-data">
        

        <!-- Hidden form fields -->

        <!-- Tells form-submit.php what table to update -->
        <input type="hidden" name="table" value="<? echo $table ?>" />
        
        <!-- edit or add -->
        <input type="hidden" name="action" value="<? echo $action ?>" />
        
        <!-- this slug is used when editing an existing entry. New slug gets generated from the new name of the entry. -->
        <input type="hidden" name="slug" value="<? echo $slug ?>" />
        
        <!-- initial pic value when editing. saved here because it would get overwritten by an empty value -->
        <input type="hidden" name="pic" value="<? echo $content['pic'] ?>" />
        
        <!-- API Key. Verifies that the form submission is from our server. -->
        <input type="hidden" name="api-key" value="<? echo $codame_api_key ?>" />

        <!-- Shared fields. Name, pic -->

        <fieldset class='left'>
        
          <label>
            <span><? echo $noun ?> Name <b>*</b></span>
            <input type="text" name="name" placeholder="Name" value="<? echo $content['name'] ?>" />
          </label>

          <? 
            if($content['pic']){
              echo "<img class='thumbnail' width='150' src='$pic' />";
            }
          ?>

          <label>
            <span>Main Picture <b>*</b></span>
            <input type="file" name="pic" value="<? echo $content['pic'] ?>" accept="image/*" />
            <button type='button' id='remove-picture'>Remove Picture</button>
          </label>

        </fieldset>

        <fieldset class='right'>

        <!-- Fields for artists only -->

        <? if( $table == 'artists' ){ ?>       
        
          <label>
            <span>Artist Email Address (for internal use)</span>
            <input type="text" name="email" placeholder="Email Address" value="<? echo $content['email'] ?>"/>
          </label>

        <? } ?>

        <!-- Fields for artists, projects, sponsors (website) -->

        <? if( $table == 'artists' || $table == 'projects' || $table == 'sponsors' || $table == 'partners' ){ ?>

          <label>
            <span><? echo $noun ?> Website URL</span>
            <input type="text" name="website" placeholder="Website" value="<? echo $content['website'] ?>"/>
          </label>

        <? } ?>

        <!-- Fields for artists and projects only (Twitter) -->

        <? if( $table == 'artists' || $table == 'projects'){ ?>

          <label>
            <span><? echo $noun ?> Twitter URL (appears on sidebar)</span>
            <input type="text" name="twitter" placeholder="//twitter.com/<? echo $noun ?>" value="<? echo $content['twitter'] ?>"/>
          </label>

        <? } ?>

        <? if( $table == 'artists' ){ ?>

          <label>
            <span><? echo $noun ?> Shop URL (appears on sidebar)</span>
            <input type="text" name="shop_url" placeholder="//example.com/<? echo $noun ?>" value="<? echo $content['shop_url'] ?>"/>
          </label>

        <? } ?>

        <!-- Fields for events and projects only. (Artists list) -->
        <? if( $table == 'events' ){ ?>
          <label>
            <span>Event Type</span>
            <select name="event-type">
              <option value="event" <?= $content['event_type'] == "event" ? "selected='selected'" : "" ?>>Event</option>
              <option value="workshop"<?= $content['event_type'] == "workshop" ? "selected='selected'" : "" ?>>Workshop</option>
            </select>
          </label>
        <? } ?>

        <? if( $table == 'events' || $table == 'projects' ){ ?>

          <label>
            <span>Artists Involved</span>
            <input name="artists-array" id="artists-array" value="<? echo $content['artists_array']; ?>" />
          </label>

        <? } ?>

        <!-- Fields for events only -->

        <? if( $table == 'events' ){ ?>

          <label>
            <span>Projects Represented</span>
            <input name="projects-array" id="projects-array" value="<? echo $content['projects_array']; ?>" />
          </label>

          <label>
            <span>Sponsored By</span>
            <input name="sponsors-array" id="sponsors-array" value="<? echo $content['sponsors_array']; ?>" />
          </label>
          
          <label>
            <span>Partnered With</span>
            <input name="partners-array" id="partners-array" value="<? echo $content['partners_array']; ?>" />
          </label>

          <label>
            <span>Event Date <b>*</b></span>
            <input type="date" name="date" value="<? echo $content['date'] ?>" />
          </label>

        <? } ?>

        </fieldset>

        <fieldset class=right>
          <div class='button-wrapper'>
            <span>Submit</span>
            <input type="submit" />
          </div>
        </fieldset>

        <!-- Fields for artists, projects, events, pages (Description) -->

        <? if( $table == 'artists' || $table == 'projects' || $table == 'events' || $table == 'pages' ){ ?>

          <fieldset>
            <label>
              <span> Description <b>*</b></span>
              <textarea name="description" />
                <? echo $content['description'] ?>
              </textarea>
            </label>
          </fieldset>

        <? } ?>

      </form>

    </div>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">

    tinymce.init({
        selector: "textarea",
        height: 500,
        // theme:'advanced',
        relative_urls : false,
        plugins : 'advlist autolink link image media jbimages code textcolor pagebreak table',
        toolbar: "jbimages | styleselect | table | forecolor backcolor | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | pagebreak | bullist numlist outdent indent | link unlink | removeformat | code",
     });

    $('#remove-picture').click(function(){
      deletePic = confirm('Delete the picture?')
      if( deletePic ){
        $('input[name=pic]').val('')
        $('.thumbnail').hide()
      }
    })

  </script>

  <!-- JS for events and projects. Allows tagging artists onto events and projects -->
  
  <? if( $table == 'events' || $table == 'projects' ){ ?>
  
  <!-- jquery UI for autocomplete -->
  <script src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="js/jquery-ui-1.11.4/jquery-ui.min.css" />
  
  <!-- tag cloud widget -->
  <script src="js/jquery.tag-editor.min.js"></script>
  <script src="js/jquery.caret.min.js"></script>
  <script>
    <?
    // print the list of artists in an array for autocompletion
    $artists = get_table('artists',0,0);
    echo "artists = [";
    while($artist = mysqli_fetch_assoc($artists)){
      echo "'".$artist['slug']."', ";
    }
    echo "];";
    
    // if this is an event page, also print a list of all available projects and sponsors
    if( $table == 'events' ){
     
      // get all projects
      $projects = get_table('projects',0,0);
      echo "projects = [";
      while($project = mysqli_fetch_assoc($projects)){
        echo "'".$project['slug']."', ";
      }
      echo "];\n"; ?>

      // activate the projects picker
      $('#projects-array').tagEditor({
        autocomplete: {
          delay: 0,
          source: projects
        }
      });

      <? // get all sponsors
      $sponsors = get_table('sponsors',0,0);
      echo "sponsors = [";
      while($sponsor = mysqli_fetch_assoc($sponsors)){
        echo "'".$sponsor['slug']."', ";
      }
      echo "];\n"; ?>

      // activate the sponsors picker
      $('#sponsors-array').tagEditor({
        autocomplete: {
          delay: 0,
          source: sponsors
        }
      });

    <? } ?>
    
      <? // get all partners
      $partners = get_table('partners',0,0);
      echo "partners = [";
      while($partner = mysqli_fetch_assoc($partners)){
        echo "'".$partner['slug']."', ";
      }
      echo "];\n"; ?>

      // activate the partners picker
      $('#partners-array').tagEditor({
        autocomplete: {
          delay: 0,
          source: partners
        }
      });

    // activate the artists picker
    $('#artists-array').tagEditor({
      autocomplete: {
        delay: 0,
        source: artists
      }
    });

  </script>
  <? } ?>
</body>