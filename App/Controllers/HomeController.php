<?php

namespace App\Controllers;

use App\Models\Memes;
use Slim\Views\Twig as View;

/**
 *
 */
class HomeController extends Controller
{

  public function index($request, $response) {
    $memes = Memes::all();

    return $this->view->render($response, 'home.twig', [
      'memes' => $memes,
    ]);
  }

}
