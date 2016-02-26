<? 

include('head.php');
include('form-submit.php');
 
$slug    = $_GET['slug'];  
$content = get_row('category-headers','slug',$slug);
$pic     = get_image_size('large',$content['pic']);

?>
<body>

    <? include('sidebar.php'); ?>

    <div id="content">     

      <h1>
        Edit Header: <? echo ucfirst($slug) ?>
      </h1>
      
      <form method='post' enctype="multipart/form-data">

        <!-- Hidden form fields -->

        <!-- initial pic value when editing. saved here because it would get overwritten by an empty value -->
        <input type="hidden" name="pic" value="<? echo $content['pic'] ?>" />
        
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
            <input type="text" name="banner-link-url" value="<? echo $content['banner-link-url'] ?>" />
          </label>

        </fieldset>

        <fieldset class=right>
          <div class='button-wrapper'>
            <span>Submit</span>
            <input type="submit" />
          </div>
        </fieldset>

      </form>

    </div>
</body>