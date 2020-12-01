<head>
  <meta name="viewport" content="width=device-width">
  <link href='//fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<? echo $site_url ?>/style.css" />
  <link rel="shortcut icon" href="//codame.com/favicon.ico" />
  <?

    $title = '';

    if( is_single() ){
      $title .= $content['name'];
    }

    if( is_category() ){
      $title .= ucwords($table);
    }

    $title .= ' CODAME ART+TECH';

  ?>
  <title>
    <? echo $title ?>
  </title>
  <script src="https://apps.elfsight.com/p/platform.js" defer></script>
</head>