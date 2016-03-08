<div id="sidebar">

  <a id="logo-link" href="<? echo $site_url ?>">
    <img id="logo" src="<? echo $site_url; ?>/assets/codame-logo-alpha.png" alt="CODAME Art+Tech" />
  </a>

  <h1>ART+TECH nonprofit events to inspire through experience.</h1>

  <div id="menu-button" onclick="toggle_menu();">
    MENU
  </div>

  <div id="menu-content">
    <nav id="links" class='active-<? echo $table ?>'>
      <a href="<? echo $site_url; ?>/artists" id='link-artists'>Artists</a>
      <a href="<? echo $site_url; ?>/events" id='link-events'>Events</a>
      <a href="<? echo $site_url; ?>/projects" id='link-projects'>Projects</a>
      <a href="http://labs.codame.com" >Labs</a>
      <a href="<? echo $site_url; ?>/sponsors" id='link-sponsors'>Sponsors</a>
      
      <?
      // do not remove or edit the flags below. They are used by PHP search/replace to auto generate the list of pages.
      // this is done in functions.php, in generate_sidebar_pages()
      // this function is called when a new page is saved, or any page is edited.
      ?>

      <!-- flag start --><a href='http://codame.com/pages/join-us'>Join Us</a><a href='http://codame.com/pages/about'>About</a><a href='http://codame.com/pages/media-kit'>Media Kit</a><a href='http://codame.com/pages/support-art-tech'>Support ART+TECH</a><!-- flag end -->

    </nav>

    <div id='social-sidebar'>

      <a href="https://twitter.com/codame">
        <? include('assets/twitter.svg') ?>
      </a>

      <a href="https://www.facebook.com/CODAME.ART.TECH">
        <? include('assets/facebook.svg') ?>
      </a>

      <a href="https://medium.com/codame-art-tech">
        <? include('assets/medium.svg') ?>
      </a>

      <a href="https://instagram.com/codame/">
        <? include('assets/instagram.svg') ?>
      </a>

      <a href="http://codame.tumblr.com/">
        <? include('assets/tumblr.svg') ?>
      </a>

      <a href="https://github.com/codame">
        <? include('assets/github.svg') ?>
      </a>

      <a href="https://www.flickr.com/photos/codame">
        <? include('assets/flickr.svg') ?>
      </a>

      <a href="https://vine.co/tags/codame">
        <? include('assets/vine.svg') ?>
      </a>

      <a href="https://www.linkedin.com/company/codame">
        <? include('assets/linkedin.svg') ?>
      </a>

      <a href="https://vimeo.com/codame">
        <? include('assets/vimeo.svg') ?>
      </a>

    </div>
  </div>

</div>
