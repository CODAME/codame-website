<?
  include('admin/functions.php');
?>
<html>
<? include('head.php') ?>
<body>

  <? include('header.php') ?>
  <? include('sidebar.php') ?>
  
  <div id="content">

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

    <!-- PROJECTS -->

    <section class="column" id='projects'>
      <a href="<? echo $site_url; ?>/projects" class="bar-link">
        <h2>
          Projects
        </h2>
      </a>
      <div class='inner-column'>
        <? output_results('projects',0,14,'blocks','edited'); ?>
      </div>
      <a href="<? echo $site_url; ?>/projects" class="more-link">
        All CODAME adoptable PROJECTS
      </a>
    </section>

    

  </div>
  <? include('footer.php') ?>

</body>
</html>