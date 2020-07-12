<div id="sidebar">

  <a id="logo-link" href="<? echo $site_url ?>">
    <img id="logo" src="<? echo $site_url; ?>/assets/codame-logo-alpha.png" alt="CODAME Art+Tech" />
  </a>

  <h1>We build ART+TECH projects and nonprofit events, to inspire through experience. Join us!</h1>

  <div id="menu-button" onclick="toggle_menu();">
    MENU
  </div>

  <div id="menu-content">
    <nav id="links" class='active-<?
     echo (
      $table == "events" && $_GET['event_type'] == "event"
      ? 
      'events' 
      :
      (
        $table == "events" && $_GET['event_type'] == "workshop" 
        ?
        'workshops' 
        :
        $table
      )
     )
      ?>'>
      <a href="<? echo $site_url; ?>/workshops" id='link-workshops'>Workshops</a>
      <a href="<? echo $site_url; ?>/events" id='link-events'>Events</a>
      <a href="<? echo $site_url; ?>/projects" id='link-projects'>Projects</a>
      <a href="<? echo $site_url; ?>/artists" id='link-artists'>Artists</a>
      <a href="<? echo $site_url; ?>/sponsors" id='link-sponsors'>Sponsors</a>
      
      <?
      // do not remove or edit the flags below. They are used by PHP search/replace to auto generate the list of pages.
      // this is done in functions.php, in generate_sidebar_pages()
      // this function is called when a new page is saved, or any page is edited.
      ?>

      <!-- flag start --><a href='//codame.com/pages/join-us'>Join Us</a><a href='//codame.com/pages/about'>About</a><a href='//codame.com/pages/media-kit'>Media Kit</a><a href='//codame.com/pages/support-art-tech'>Support ART+TECH</a><!-- flag end -->

    </nav>

    <div id='social-sidebar'>

      <a href="https://codame.substack.com/" target="_blank">
        <? include('assets/rss.svg') ?>
      </a>

      <a href="https://twitter.com/codame" target="_blank">
        <? include('assets/twitter.svg') ?>
      </a>

      <a href="https://www.facebook.com/CODAME.ART.TECH" target="_blank">
        <? include('assets/facebook.svg') ?>
      </a>

      <a href="https://medium.com/codame-art-tech" target="_blank">
        <? include('assets/medium.svg') ?>
      </a>

      <a href="https://instagram.com/codame/" target="_blank">
        <? include('assets/instagram.svg') ?>
      </a>

      <a href="https://github.com/codame" target="_blank">
        <? include('assets/github.svg') ?>
      </a>

      <a href="https://www.linkedin.com/company/codame" target="_blank">
        <? include('assets/linkedin.svg') ?>
      </a>

    </div>
  </div>

</div>
