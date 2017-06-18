<?php

  $container["ApiController"] = function($container) {
    return new \App\Controllers\ApiController($container);
  };

  $api->get('/[{token}]', 'ApiController:getMemes')->setName('api-home');
