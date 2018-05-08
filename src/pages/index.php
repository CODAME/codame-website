<?
  include('admin/functions.php');
?>
<html>
<? include('partials/head.php') ?>
<body>

  <? include('partials/header.php') ?>
  <? include('partials/sidebar.php') ?>
  
  <div id="content">

    <div id="hero">
      
      <? $header = get_row('headers','slug','homepage'); ?>

      <? if( $header['pic'] !== '' ){ ?>
        <a href="<? echo $header['banner-link-url'] ?>">
          <img src="<? echo $header['pic'] ?>">
        </a>
      <? } ?>

      <? if( $header['description'] !== '' ){ ?>

        <div class="hero-text">
          <? echo $header['description'] ?>
        </div>

      <? } ?>
      
    </div>

    <!-- EVENTS -->

    <section class="column" id="events">
      <a href="<? echo $site_url; ?>/events" class="bar-link">
        <h2>
          Events
        </h2>
      </a>

      <div class='inner-column'>
        <? output_results('events',0,0,'blocks','date'); ?>
      </div>

    </section>

    <!-- PROJECTS -->

    <section class="column" id='projects'>
      <a href="<? echo $site_url; ?>/projects" class="bar-link">
        <h2>
          Projects
        </h2>
      </a>
      <div class='inner-column'>
        <? output_results('projects',0,0,'blocks','edited'); ?>
      </div>
    </section>

  </div>
  <? include('partials/footer.php') ?>

</body>
</html>