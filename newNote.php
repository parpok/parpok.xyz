<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection with error handling
    $db = new mysqli("localhost", "web", "", "parpokxyz");

    $env = './.env';
    if (!file_exists($env)) {
        die("ENV Not found how sad");
    }

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $CFSecret = trim(explode('=', file($env)[0])[1]);
    $remote_addr = $_SERVER['REMOTE_ADDR'];
    $cfURL = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
    $CFSiteToken = $_POST['cf-turnstile-response'];


    // Collect and sanitize input
    $userName = trim($_POST['userNameGuestBook']);
    $message = trim($_POST['guestBookMessage']);

    $badWordsFile = './badWords.txt';
    if (!file_exists($badWordsFile)) {
        die("Bad words file not found.");
    }

    $badWords = file($badWordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($badWords as $badWord) {
        if (stripos($message, $badWord) !== false) {
            die("Your message contains inappropriate language and cannot be posted.");
        }
    }

    // Validate inputs
    if (empty($userName) || empty($message)) {
        die("Both name and message are required.");
    }


    $cfData = array("secret" => $CFSecret, "response" => $CFSiteToken, "remoteip" => $remote_addr,);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $cfURL);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($cfData)); // Use http_build_query for proper encoding
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error_message = curl_error($curl);
        echo 'cURL Error: ' . $error_message . '<br>';
    } else {
        $response = json_decode($response, true);
        echo '<pre>';
        print_r($response);
        echo '</pre>';

        if (isset($response['success'])) {
            // Use prepared statements to insert data safely
            $query = "INSERT INTO guestBook (userName, message, postDate) VALUES (?, ?, NOW())";
            $stmt = $db->prepare($query);

            if (!$stmt) {
                die("Query preparation failed: " . $db->error);
            }

            $stmt->bind_param("ss", $userName, $message);

            if ($stmt->execute()) {
                header("Location: ./guestBook.php");
                $stmt->close();
                exit();
            } else {
                echo "Error: " . $stmt->error;
                $stmt->close();
                exit();
            }

        } else {
            echo 'Cloudflare Turnstile check failed. Error codes:<br>';
            echo '<ul>';
            foreach ($response['error-codes'] as $e) {
                echo '<li>' . $e . '</li>';
            }
            echo '</ul>';
        }
    }

    // Close connections
    curl_close($curl);
    $db->close();
}
?>
