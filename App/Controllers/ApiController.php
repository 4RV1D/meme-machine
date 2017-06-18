<?php

namespace App\Controllers;

use App\Models\Memes;

class ApiController extends Controller
{

  public function getMemes($request, $response, $args) {

    if (isset($args['token']) && $args['token'] === "123") {

      $memes = Memes::select('memeId', 'id', 'full_picture', 'message')->get();

      $json = json_encode($memes, JSON_PRETTY_PRINT);
      header('Content-type: text/javascript');

      echo "<pre>";
      print_r($json);
      echo "</pre>";

    } else {
      echo "Wrong authentication token";
    }
  }

}
