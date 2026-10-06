<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('<h2>Use the contact form to submit data.</h2>');
}

function clean($value) {
    return htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
}

$name = clean($_POST['name'] ?? '');
$email = clean($_POST['email'] ?? '');
$subject = clean($_POST['subject'] ?? '');
$message = clean($_POST['message'] ?? '');

$errors = [];

if ($name === '') $errors[] = 'Name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if ($subject === '') $errors[] = 'Subject is required.';
if ($message === '') $errors[] = 'Message is required.';

if ($errors) {
    echo '<h2>Contact Error</h2><ul>';
    foreach ($errors as $error) echo '<li>' . htmlspecialchars($error) . '</li>';
    echo '</ul><a href="contact.html">Go back</a>';
    exit;
}

$dir = __DIR__ . '/php-data';
if (!is_dir($dir)) mkdir($dir, 0775, true);

$row = [
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'submitted_at' => date('c')
];

$csv = $dir . '/contacts.csv';
$fp = fopen($csv, 'a');
if ($fp) {
    if (!file_exists($csv) || filesize($csv) === 0) fputcsv($fp, array_keys($row));
    fputcsv($fp, array_values($row));
    fclose($fp);
}

$json = $dir . '/contacts.json';
$data = file_exists($json) ? json_decode(file_get_contents($json), true) : [];
if (!is_array($data)) $data = [];
$data[] = $row;
file_put_contents($json, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Submitted | StudentHub</title>
    <style>
        body{font-family:Arial;padding:40px;background:#f5f8fc;color:#17233c}
        .box{max-width:600px;margin:60px auto;background:#fff;padding:35px;border-radius:16px;text-align:center;box-shadow:0 10px 30px #0001}
        a{display:inline-block;margin-top:15px;color:#2563eb;text-decoration:none}
    </style>
</head>
<body>
    <div class="box">
        <h2>Message submitted successfully!</h2>
        <p>Your contact data has been stored in CSV and JSON format.</p>
        <a href="contact.html">Back to Contact</a> |
        <a href="index.html">Back to StudentHub</a>
    </div>
</body>
</html>
