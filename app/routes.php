<?php

  use App\Models\Memes;

  $app->get('/', function ($request, $response) {

    $memes = Memes::all();

    return $this->view->render($response, 'home.twig', [
      'memes' => $memes
    ]);

  })->setName('home');

  /*$app->get('/hello/{name}', function ($request, $response, $args) {

    return $this->view->render($response, 'profile.html', [
      'name' => $args['name']
    ]);

  })->setName('profile');*/
