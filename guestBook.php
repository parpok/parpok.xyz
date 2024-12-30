<?php


$db = mysqli_connect("localhost", "web", "","parpokxyz");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "we good";
}

$messagesQuery = mysqli_query($db,"SELECT * FROM guestBook");

while ($queryResult = mysqli_fetch_assoc($messagesQuery)) {

    // TODO: FANCY HTML BLOCK TO MAKE IT ALL LOOK NICE AND NEAT

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="My personal pages guest book" />
    <meta name="author" content="Parpok" />
    <meta name="keywords" content="personal page, links" />
    <meta property="og:title" content="Parpok" />
    <meta property="og:description" content="My personal page" />
    <meta property="og:image" content="https://parpok.xyz/content/avatar.png" />
    <meta property="og:url" content="https://parpok.xyz" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="Parpok" />

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>pat</title>

    <link rel="icon" type="image/png" href="/content/avatar.png" />

    <link rel="preload" href="style.css" as="style" />
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <div class="container" id="CenterContainer">
      <div class="bs">
        <a href="./index.html" style="color: #cdb58f"><h1>pat</h1></a>
        <div class="hstack" id="things">
          <h2>:3</h2>

          <div class="svgs">
            <a href="https://twitter.com/parpok206" target="_blank">
              <img src="./content/svgs-feather/twitter.svg" alt="Twitter" />
            </a>
            <a href="https://github.com" target="_blank">
              <img src="./content/svgs-feather/github.svg" alt="GitHub" />
            </a>
          </div>
        </div>
        <nav>
          <a href="./index.html">home</a>
          <a href="./thinks.html">thinks</a>
          <a href="./gibmoney.html">gib money</a>
          <a href="./guestBook.php">guest Book</a>
          <a href="./about.html">about</a>
        </nav>

        <h3>Things</h3>
        <div class="hstack" id="things">
          <a href="/content/edc.JPG">edc.png</a>
          <a href="/content/myComputer.JPEG">myComputer.png</a>
          <a href="/content/werktop.JPEG">werkTop.png</a>
          <a href="/content/drink.jpg">drink</a>
          <a href="/content/model3.png">model :3</a>
          <a href="/content/holygrail.jpg">holygrail.jpg</a>
          <a href="/content/yaoi.png">yaoi</a>
          <a href="/content/tomaszkoncik.png">tomaszkoncik.png</a>
        </div>
      </div>

      <div class="guestBook">
        <h3>guest book</h3>
        </div>
    </div>
  </body>
</html>
<style></style>

