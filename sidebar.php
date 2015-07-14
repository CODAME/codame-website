<div id="sidebar">

  <a href="<? echo $site_url ?>">
    <img src="<? echo $site_url; ?>/assets/codame-logo-alpha.png" alt="CODAME Art+Tech" />
  </a>

  <div id="links">
    <a href="<? echo $site_url; ?>/artists">Artists</a>
    <a href="<? echo $site_url; ?>/events">Events</a>
    <a href="<? echo $site_url; ?>/projects">Projects</a>
    <a href="https://medium.com/codame-art-tech">Stories</a>
    <hr>
    
    <?
    // do not remove or edit the flags below. They are used by PHP search/replace to auto generate the list of pages.
    // this is done in functions.php, in generate_sidebar_pages()
    // this function is called when a new page is saved, or any page is edited.
    ?>

    <!-- flag start --><a href='http://codame.com/pages/contact-us'>Contact Us</a><a href='http://codame.com/pages/about'>About</a><a href='http://codame.com/pages/media-kit'>Media Kit</a><a href='http://codame.com/pages/sponsors'>Sponsors</a><a href='http://codame.com/pages/donate'>Donate</a><a href='http://codame.com/pages/adopt-art-tech'>Adopt ART+TECH</a><!-- flag end -->    

  </div>

  <div id='social-sidebar'>

    <a href="https://twitter.com/codame">
      <? include('assets/twitter.svg') ?>
    </a>

    <a href="https://www.facebook.com/CODAME.ART.TECH">
      <? include('assets/facebook.svg') ?>
    </a>

    <a href="https://medium.com/@codame">
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