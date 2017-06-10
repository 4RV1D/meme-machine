<?php

/**
 * Collecting them memes
 */
class Collector
{

  private $appId;
  private $appSecret;
  private $apiUrl;
  private $servername;
  private $username;
  private $password;
  private $dbName;

  function __construct($limit, $memePage) {

    $this->appId      = "1875750035976215";
    $this->appSecret  = "76680e27408308261ec627917d085465";
    $this->apiUrl     = "https://graph.facebook.com/";

    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbName = "memes";

    $this->limit      = $limit;
    $this->memePage   = $memePage;

  }

  function checkConnection() {
    // Check connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  }

  function getUrl() {
    return "" . $this->apiUrl . "" . $this->memePage
    . "/feed?fields=full_picture,message&limit=" . $this->limit
    . "&access_token=" . $this->appId . "|" . $this->appSecret;
  }

  function getLastId() {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    $sql = "SELECT latest FROM cache WHERE pageId='$this->memePage'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row["latest"];
    } else {

      $sql = "INSERT INTO cache (latest, pageId)
              VALUES ('0', '$this->memePage')";

      if ($conn->query($sql) === TRUE) {
          echo "New memePage Added! \n";
          return "new";
      }
    }

    $conn->close();
  }

  function updateLastId($lastId) {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    $sql = "UPDATE cache SET latest='$lastId' WHERE pageId = '$this->memePage'";

    if ($conn->query($sql) === TRUE) {
      return true;
    } else {
      echo "Error updating record: " . $conn->error;
    }

    $conn->close();
  }

  function getMemesAmount($memes, $latestId, $limit) {

    if ($latestId == "new") {
      return $limit;
    } else {
      $a = 0;

      while ($a < $limit) {
        if ($memes[$a]["id"] == $latestId) {
          return $a;
          break;
        }

        $a++;
      }

      return $limit;
    }

  }

  function getMemes($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    curl_close($ch);

    $memes = (json_decode($result, true));

    if (isset($memes["error"])) {
      return $memes["error"];
    } else {
      return $memes["data"];
    }
  }

  function buildInsert($table, $array) {
    $mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    $str = "insert into $table ";
    $strn = "(";
    $strv = " VALUES (";

    while(list($name,$value) = each($array)) {
      if(is_string($value)) {
        $_value = $mysqli->real_escape_string($value);
        $strn .= "$name,";
        $strv .= "'$_value',";
        continue;
      }

      if (!is_null($value) and ($value != "")) {
        $strn .= "$name,";
        $strv .= "$value,";
        continue;
      }
    }

    $strn[strlen($strn)-1] = ')';
    $strv[strlen($strv)-1] = ')';
    $str .= $strn . $strv;
    return $str;
  }

  function postMemes($sql) {
    // Post memes to database
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Database Error: " . $sql . "\n" . $conn->error;
    }

    $conn->close();
  }

}
