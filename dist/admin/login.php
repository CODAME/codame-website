<?

if( $_SESSION['logged_in'] !== true ){
  
  if( strtolower($_POST['username']) == $admin_user && $_POST['password'] == $admin_pw ){
  
    $_SESSION['logged_in'] = true;
  
  }else{
    
    // show login

    ?>
    
    <body class='admin'>
      <div id="login">
        <form method="post">
          <label>
            <span>User:</span>
            <input type="text" name="username" />
          </label>
          <label>
            <span>Password:</span>
            <input type="password" name="password" />
          </label>
          <input type="submit" />
        </form>
      </div>
    </body>

    <?
    die;
  }
}

?>