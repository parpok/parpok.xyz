<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection with error handling
    $db = new mysqli("localhost", "web", "", "parpokxyz");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

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

    // Use prepared statements to insert data safely
    $query = "INSERT INTO guestBook (userName, message, postDate) VALUES (?, ?, NOW())";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        die("Query preparation failed: " . $db->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("ss", $userName, $message);

    if ($stmt->execute()) {
        header("Location: ./guestBook.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }

    // Close connections
    $stmt->close();
    $db->close();
}
?>
