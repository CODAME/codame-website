<? 

include('partials/head.php');
include('partials/form-submit.php');
 
$slug    = $_GET['slug'];  
$content = get_row('headers','slug',$slug);
$pic     = get_image_size('large',$content['pic']);

?>
<body class='admin'>

    <? include('partials/sidebar.php'); ?>

    <div id="content">     

      <h1>
        Edit Header: <? echo ucfirst($slug) ?>
      </h1>
      
      <form method='post' enctype="multipart/form-data">

        <!-- Hidden form fields -->

        <!-- Tells form-submit.php what table to update -->
        <input type="hidden" name="table" value="headers" />

        <!-- edit an entry -->
        <input type="hidden" name="action" value="edit" />

        <!-- initial pic value when editing. saved here because it would get overwritten by an empty value -->
        <input type="hidden" name="pic" value="<? echo $content['pic'] ?>" />
        
        <!-- this slug is used when editing an existing entry. -->
        <input type="hidden" name="slug" value="<? echo $slug ?>" />

        <!-- API Key. Verifies that the form submission is from our server. -->
        <input type="hidden" name="api-key" value="<? echo $codame_api_key ?>" />        

        <fieldset class='left'>
        
          <?
            if($content['pic']){
              echo "<img class='thumbnail' width='150' src='$pic' />";
            }
          ?>

          <label>
            <span>Hero Banner <b>*</b></span>
            <input type="file" name="pic" value="<? echo $content['pic'] ?>" />
          </label>

          <label>
            <span>Banner Link URL <b>*</b></span>
            <input type="text" name="banner_link_url" value="<? echo $content['banner_link_url'] ?>" />
          </label>

        </fieldset>

        <fieldset class=right>
          <div class='button-wrapper'>
            <span>Submit</span>
            <input type="submit" />
          </div>
        </fieldset>

        <fieldset>
          <label>
            <span> Description <b>*</b></span>
            <textarea name="description" />
              <? echo $content['description'] ?>
            </textarea>
          </label>
        </fieldset>

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
    </script>
</body>