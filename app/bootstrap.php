<?php
  // Start Session
  session_start();

  // Load Config using an absolute path
  require_once dirname(__DIR__) . '/config/config.php';

  // Autoload Core Libraries using an absolute path
  spl_autoload_register(function($className){
    require_once dirname(__DIR__) . '/core/' . $className . '.php';
  });
