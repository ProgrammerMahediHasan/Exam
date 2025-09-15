<?php
$errors = [];
$name = $email = $gender = $subject = ""; // default empty
$validSubjects = ['English', 'Bangla', 'Islamic']; // move outside so HTML can access

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_Name'])) {
    // Trim & sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $gender  = htmlspecialchars(trim($_POST['gender']));
    $subject = $_POST['subject'] ?? ""; // get subject first

    // Name validation
    if ($name === "") {
        $errors["name"] = "Please fill the name field";
    } elseif (!preg_match("/^[A-Za-z][A-Za-z .]{2,}$/", $name)) {
        $errors["name"] = "Invalid name format (letters, spaces, dots allowed)";
    }

    // Email validation
    if ($email === "") {
        $errors["email"] = "Please fill the email field";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email address";
    }

    // Gender validation
    $validGenders = ['male', 'female', 'other'];
    if ($gender === "") {
        $errors["gender"] = "Please select your gender";
    } elseif (!in_array(strtolower($gender), $validGenders)) {
        $errors["gender"] = "Invalid gender selected";
    }

    // Subject validation
    if ($subject === "") {
        $errors["subject"] = "Please select a subject";
    } elseif (!in_array($subject, $validSubjects)) {
        $errors["subject"] = "Invalid subject selected";
    }

    // Final success message
    if (empty($errors)) {
        echo "<p style='color:green;'>✅ Data is saved successfully!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Validation</title>
</head>
<body>

<h1>PHP Form with Subject Selection</h1>
<form method="post">
    <!-- Name -->
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $name ?>">
    <span style="color:red;"><?= $errors["name"] ?? "" ?></span><br><br>

    <!-- Email -->
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $email ?>">
    <span style="color:red;"><?= $errors["email"] ?? "" ?></span><br><br>

    <!-- Gender -->
    <label>Gender:</label><br>
    <select name="gender">
        <option value="">-- Select --</option>
        <option value="male" <?= ($gender === "male") ? "selected" : "" ?>>Male</option>
        <option value="female" <?= ($gender === "female") ? "selected" : "" ?>>Female</option>
        <option value="other" <?= ($gender === "other") ? "selected" : "" ?>>Other</option>
    </select>
    <span style="color:red;"><?= $errors["gender"] ?? "" ?></span><br><br>

    <!-- Subject Selection -->
    <label>Subject:</label><br>
    <?php foreach ($validSubjects as $subj): ?>
        <input type="radio" name="subject" value="<?= $subj ?>" <?= ($subject === $subj) ? "checked" : "" ?>> <?= $subj ?>
    <?php endforeach; ?>
    <span style="color:red;"><?= $errors["subject"] ?? "" ?></span><br><br>

    <button type="submit" name="btn_Name">Submit</button>
</form>

  
</body>
</html>