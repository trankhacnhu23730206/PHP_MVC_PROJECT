<?php
  // Start Session
  session_start();

  // Load Config using an absolute path
  require_once dirname(__DIR__) . '/config/config.php';

  // Load Helpers
  require_once dirname(__DIR__) . '/app/helpers/url_helper.php';
  require_once dirname(__DIR__) . '/app/helpers/session_helper.php';

  // Autoload Core Libraries using an absolute path
  spl_autoload_register(function($className){
    require_once dirname(__DIR__) . '/core/' . $className . '.php';
  });
