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

  public function getMemes($request, $response) {
    $memes = Memes::all();

    foreach ($memes as $meme) {
      echo '<div class="meme">';
      if ($meme->message != "") {echo '<p>' . $meme->message . '</p>';}
      echo '<img src="' . $meme->full_picture . '"/></div>';
    }
  }

}
