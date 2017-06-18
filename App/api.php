<?php

  session_start();

  require __DIR__."/../vendor/autoload.php";

  $api = new \Slim\App([
    'settings' => [
      'displayErrorDetails' => true,
      'determineRouteBeforeAppMiddleware' => true,
      'displayErrorDetails' => true,
      'addContentLengthHeader' => false,

      'db' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'memes',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'latin1',
        'collation' => 'latin1_swedish_ci',
        'prefix'    => '',
      ]
    ],
  ]);

  $container = $api->getContainer();

  // Eloquent setup
  $capsule = new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container["settings"]["db"]);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  $container["db"] = function($container) use ($capsule) {
    return $capsule;
  };

  require __DIR__."/api-routes.php";
