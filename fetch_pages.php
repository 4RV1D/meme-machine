<?php
include "mysql.php";

$item_per_page = 20;
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

if(!is_numeric($page_number)){
    header('HTTP/1.1 500 Invalid page number!');
    exit();
}

$position = (($page_number-1) * $item_per_page);

$results = $conn->prepare("SELECT memeId, full_picture, message FROM memes ORDER BY memeId DESC LIMIT ?, ?");

$results->bind_param("dd", $position, $item_per_page);
$results->execute();
$results->bind_result($id, $meme, $message);

while($results->fetch()) {
    if ($meme != "") {
      echo '<div class="meme">';
      if ($message != "") {echo '<p>' . $message . '</p>';}
      echo '<img src="' . $meme . '"/></div>';
    }
}
