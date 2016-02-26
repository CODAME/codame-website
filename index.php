<?
  include('admin/functions.php');
?>
<html>
<? include('head.php') ?>
<body>

  <? include('header.php') ?>
  <? include('sidebar.php') ?>
  
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
        <? output_results('events',0,6,'blocks','date'); ?>
      </div>

      <a href="<? echo $site_url; ?>/events" class="more-link">
        All past CODAME EVENTS
      </a>

    </section>

    <!-- ARTISTS -->

    <section class="column">
      <a href="<? echo $site_url; ?>/artists" class="bar-link">
        <h2>
          Artists
        </h2>
      </a>
      <div class='inner-column'>
        <? output_results('artists',0,6,'blocks','edited'); ?>
      </div>

      <a href="<? echo $site_url; ?>/artists" class="more-link">
        All CODAME featured ARTISTS
      </a>
    </section>

    <!-- PROJECTS -->

    <section class="column">
      <a href="<? echo $site_url; ?>/projects" class="bar-link">
        <h2>
          Projects
        </h2>
      </a>
      <div class='inner-column'>
        <? output_results('projects',0,6,'blocks','edited'); ?>
      </div>
      <a href="<? echo $site_url; ?>/projects" class="more-link">
        All CODAME adoptable PROJECTS
      </a>
    </section>

    

  </div>
  <? include('footer.php') ?>

</body>
</html>
