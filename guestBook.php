<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="My personal pages guest book"/>
    <meta name="author" content="Parpok"/>
    <meta name="keywords" content="personal page, links"/>
    <meta property="og:title" content="Parpok"/>
    <meta property="og:description" content="My personal page"/>
    <meta property="og:image" content="https://parpok.xyz/content/avatar.png"/>
    <meta property="og:url" content="https://parpok.xyz"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:site_name" content="Parpok"/>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>pat</title>

    <link rel="icon" type="image/png" href="/content/avatar.png"/>

    <link rel="preload" href="style.css" as="style"/>
    <link rel="stylesheet" href="./style.css"/>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    
</head>
<body>
<div class="container" id="CenterContainer">
    <div class="bs">
        <a href="./index.html" style="color: #cdb58f"><h1>pat</h1></a>
        <div class="hstack" id="things">
            <h2>:3</h2>

            <div class="svgs">
                <a href="https://twitter.com/parpok206" target="_blank">
                    <img src="./content/svgs-feather/twitter.svg" alt="Twitter"/>
                </a>
                <a href="https://github.com/parpok" target="_blank">
                    <img src="./content/svgs-feather/github.svg" alt="GitHub"/>
                </a>
            </div>
        </div>
        <nav>
            <a href="./index.html">home</a>
            <a href="./thinks.html">thinks</a>
            <a href="./gibmoney.html">gibMoney</a>
            <a href="./guestBook.php">guestBook</a>
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

        <form method="post" action="./newNote.php">
            <label for="userNameGuestBook"></label><input type="text" name="userNameGuestBook" id="userNameGuestBook"
                                                          placeholder="Your name" required/>
            <br>
            <label for="guestBookMessage"></label><textarea name="guestBookMessage" id="guestBookMessage" required
                                                            placeholder="Say something" maxlength="180"></textarea>
            <br>

            <div class="cf-turnstile" data-sitekey="0x4AAAAAAA8O6SJ5lgwmXBvd"></div>

            <input type="submit" value="submit">
        </form>


        <?php
        $db = new mysqli("localhost", "web", "", "parpokxyz");

        $turnstile_secret     = $_ENV["TurnStyle_Secret"];
        $turnstile_response   = $_POST['cf-turnstile-response'];
        $url                  = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $post_fields          = "secret=$turnstile_secret&response=$turnstile_response";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response_data = json_decode($response);
        if ($response_data->success != 1) {
            header("Location: /");
            exit;
        }


        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $query = "SELECT userName, postDate, message FROM guestBook ORDER BY postDate DESC";
        $stmt = $db->prepare($query);

        if (!$stmt) {
            die("Query preparation failed: " . $db->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userName = htmlspecialchars($row['userName'], ENT_QUOTES, 'UTF-8');
                $postDate = htmlspecialchars($row['postDate'], ENT_QUOTES, 'UTF-8');
                $message = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');

                echo "<div class='guestBookEntry'>
                    <div class='hstack'>
                        <h4>$userName</h4>
                        <p>$postDate</p>
                    </div>
                    <p>$message</p>
                </div>";
            }
        } else {
            echo "Empty here lol";
        }
        //
        //        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //            $data = ['userName' => $_POST['userNameGuestBook'], 'message' => $_POST['guestBookMessage'], 'postDate' => date('Y-m-d H:i:s')];
        //
        //            $coreData->insert('guestBook', $data);
        //        }
        //        // bye bye mario sound

        $stmt->close();
        $db->close();
        ?>
    </div>
</div>
</body>
</html>
<style></style>

