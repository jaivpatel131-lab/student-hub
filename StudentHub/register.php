<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<h2>Use the registration form to submit data.</h2>';
    exit;
}

function clean($value) {
    return htmlspecialchars(
        trim((string)$value),
        ENT_QUOTES,
        'UTF-8'
    );
}

/* Get form values */

$name     = clean($_POST['regName'] ?? '');
$id       = clean($_POST['regId'] ?? '');
$email    = clean($_POST['regEmail'] ?? '');
$phone    = clean($_POST['regPhone'] ?? '');
$dob      = clean($_POST['regDob'] ?? '');
$gender   = clean($_POST['regGender'] ?? '');
$semester = clean($_POST['regSemester'] ?? '');
$course   = clean($_POST['regCourse'] ?? '');

$password = (string)($_POST['regPassword'] ?? '');
$confirm  = (string)($_POST['regConfirm'] ?? '');

$address = clean($_POST['regAddress'] ?? '');


/* Validation */

$errors = [];

if (!preg_match('/^[A-Za-z .\'-]{2,60}$/', $name)) {
    $errors[] = 'Please enter a valid name.';
}

if (!preg_match('/^STU-[0-9]{4}-[0-9]{3}$/', $id)) {
    $errors[] = 'Invalid student ID.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if (!preg_match('/^[+0-9 ()-]{10,16}$/', $phone)) {
    $errors[] = 'Please enter a valid mobile number.';
}

if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[^A-Za-z0-9]/', $password)
) {
    $errors[] =
        'Password must contain uppercase, lowercase, number and special character.';
}

if ($password !== $confirm) {
    $errors[] = 'Passwords do not match.';
}


/* Required fields */

$requiredFields = [
    'dob'      => $dob,
    'gender'   => $gender,
    'semester' => $semester,
    'course'   => $course,
    'address'  => $address
];

foreach ($requiredFields as $field => $value) {

    if ($value === '') {
        $errors[] = ucfirst($field) . ' is required.';
    }
}


/* Show errors */

if ($errors) {

    echo '
    <!doctype html>
    <html>
    <body style="font-family:Arial;padding:40px">

        <h2>Registration Error</h2>

        <ul>
    ';

    foreach ($errors as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }

    echo '
        </ul>

        <a href="register.html">Go back</a>

    </body>
    </html>
    ';

    exit;
}


/* Create storage folder */

$dir = __DIR__ . '/php-data';

if (!is_dir($dir)) {
    mkdir($dir, 0775, true);
}


/* Prepare student data */

$row = [
    'name'         => $name,
    'student_id'   => $id,
    'email'        => $email,
    'phone'        => $phone,
    'dob'          => $dob,
    'gender'       => $gender,
    'semester'     => $semester,
    'course'       => $course,
    'address'      => $address,
    'submitted_at' => date('c')
];


/* Save to CSV */

$csv = $dir . '/registrations.csv';

$newFile = !file_exists($csv);

$fp = fopen($csv, 'a');

if ($fp) {

    if ($newFile) {
        fputcsv($fp, array_keys($row));
    }

    fputcsv($fp, array_values($row));

    fclose($fp);
}


/* Save to JSON */

$json = $dir . '/registrations.json';

if (file_exists($json)) {
    $items = json_decode(
        file_get_contents($json),
        true
    );
} else {
    $items = [];
}

if (!is_array($items)) {
    $items = [];
}

$items[] = $row;

file_put_contents(
    $json,
    json_encode(
        $items,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    ),
    LOCK_EX
);


/* Success message */

echo '
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
</head>

<body style="font-family:Arial;padding:40px">

    <h2>Registration successful!</h2>

    <p>
        Your data was validated and stored
        in CSV and JSON format.
    </p>

    <a href="login.html">Go to Login</a>

</body>

</html>
';

?>