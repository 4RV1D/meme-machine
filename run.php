<?php

  include "collector.php";

  $limit = "100";

  $memePages = array(
    'DankestMemesNoice',
    'keepitvague',
    'painwave',
    'ocfreshstolenmemes2',
    'shitpostbot'
  );

  while (true) {

    /*-------------------------------------
      Looping trough all added memePages
    -------------------------------------*/
    foreach ($memePages as $memePage) {

      /*---------------------------------
        Creates a new Collector class
      ---------------------------------*/
      $Collector = new Collector($limit, $memePage);

      /*------------------------------------------------------
        Get's the information needed from one memePage
        created and generated to grab and store all memes.
      ------------------------------------------------------*/
      if ($Collector->getUrl() == false) {                                      // Creates the graph Api url to use with Curl
        echo "Error: " . $Collector->getUrl() . "\n";
        continue;
      } else {
        $url = $Collector->getUrl();
      }

      $memes    = $Collector->getMemes($url);                                   // Uses Curl to get the API information
      $latestId = $Collector->getLastId();                                      // Uses the Data from the database to get the lastId (if no Id is found create one)
      $amount   = $Collector->getMemesAmount($memes, $latestId, $limit);        // Gets the amount off memes we actually need to insert to the database

      $Collector->checkConnection();                                            // Checks MySQL connection

      /*-----------------------------------------------------------
        Stores all the memes from that memePage in the database
      -----------------------------------------------------------*/
      if ($amount > 2) {
        $a = 0;
        while ($a < $amount) {                                                  // While loop to build the SQL insert string, and use that to insert into database
          $sql = $Collector->buildInsert('memes', $memes[$a]);
          $Collector->postMemes($sql);
          $a++;
        }

        echo " - " . $amount . " Memes from "
        . $memePage . " where stored in the database. \n";

        $lastId = $memes["0"]["id"];
        $Collector->updateLastId($lastId);                                      // Updates the lastId to be used next time in getLastId();
      } else {
        echo " - Less then 2 memes where posted on "
        . $memePage . " in the last 30 minutes. \n";
      }
    }

    sleep(30*60);                                                               // 30min timer before next "scan"
  }
