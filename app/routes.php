<?php

  $container["HomeController"] = function($container) {
    return new \App\Controllers\HomeController($container);
  };

  $app->get('/', 'HomeController:index')->setName('home');
  $app->get('/memes', 'HomeController:getMemes')->setName('memes');
