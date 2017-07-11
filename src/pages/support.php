<?

  // send the message
  if( !empty($_GET['message']) ){
    $mailer = $_SERVER['DOCUMENT_ROOT'] . '/../config/mailer.php';
    include($mailer);
  }

  include('admin/functions.php');

  $table = $_GET['table'];
  $slug  = $_GET['slug'];

  $content = get_row($table,'slug',$slug);

?>
<html>
<? include('head.php'); ?>
<body>
  <? include('header.php') ?>
  <div id="container" class='support-content'>
    <a id="logo-link" href="<?= $site_url ?>">
      <img id="logo" src="<?= $site_url; ?>/assets/codame-logo-alpha.png" alt="CODAME Art+Tech" />
    </a>

    <? if( !empty($_GET['message']) ){ ?>
      <div class="notification"><?= $form_result ?></div>
    <? } ?>
    

    <h2 class="commission-headline">Commission An Artist</h2>
    
    <div class="artist-section">
      <h1 class="name"><?= $content['name'] ?></h1>
      <img class='artist-main' src="<?= $content['pic'] ?>" alt="<?= $content['name'] ?>" />
    </div>

    

    <div class="options">
      <? if( $table == 'artists' ): ?>

        <div>
          <div class="magenta-blur"><? include('./assets/chat.svg') ?></div>
          <div class="cyan-blur"><? include('./assets/chat.svg') ?></div>
          <? include('./assets/chat.svg') ?>
          <span>Have this artist give a lecture or teach a workshop at your&nbsp;event.</span>
        </div>

        <div>
          <div class="magenta-blur"><? include('./assets/tools.svg') ?></div>
          <div class="cyan-blur"><? include('./assets/tools.svg') ?></div>
          <? include('./assets/tools.svg') ?>
          <span>Collaborate directly with this artist to develop new works.</span>
        </div>

        <div>
          <div class="magenta-blur"><? include('./assets/rocket.svg') ?></div>
          <div class="cyan-blur"><? include('./assets/rocket.svg') ?></div>
          <? include('./assets/rocket.svg') ?>
          <span>Support further development of an existing project from this&nbsp;artist.</span>
        </div>

      <? elseif( $table == 'projects' ): ?>

        project stuff

      <? endif; ?>
    </div>
  

    <div class="explanation">
      CODAME is a not-for-profit organization dedicated to promoting artists who use technology. All proceeds from commissions go to advancing the artist's work and sustaining CODAME as an organization.
    </div>

    <div class="cta">
      Call, text or email for more information.<br>
      <a href="tel:4155815345">(415) 581-5345</a> &bull; <a href="mailto:jordan@codame.com">jordan@codame.com</a>
    </div>

    <div class="contact">
      <span>Or use this form to contact us now:</span>
      <form method="POST" action="./contact-submit.php">
                  
          <label for="name">
            <span><i>★</i>Name:</span>
            <input type="text" name="name" value="">
          </label>

          <label for="email">
            <span><i>★</i>Email:</span>
            <input type="text" name="email" value="">  
          </label>

          <label for="message">
            <span><i>★</i>Message:</span>
            <textarea name="message" cols="30" rows="10"></textarea>  
          </label>

          <label for="submit">
            <input type="submit" value="Submit">
          </label>
     
      </form>
    </div>

  </div>
  <? include('footer.php') ?>
</body>
</html>