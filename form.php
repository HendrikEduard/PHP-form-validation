<?php  
// Start the session to use the CSRF token
session_start();
// define variables and set to empty values
$name_error = $email_error = $gender_error = $website_error = "";
$csrf_token = $name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["csrf_token"] !== $_SESSION['token']) {
    die('Your form has been submitted.');
  }
    
    if (empty($_POST["name"])) {
      $name_error = "Name is required";
    } else {
      $name = clean($_POST["name"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $name_error = "Only letters and white space allowed"; 
      }
    }
    
    if (empty($_POST["email"])) {
      $email_error = "Email is required";
    } else {
      $email = clean($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format"; 
      }
    }
      
    if (empty($_POST["website"])) {
      $website = "";
    } else {
      $website = clean($_POST["website"]);
      // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
        $website_error = "Invalid URL"; 
      }
    }

    if (empty($_POST["comment"])) {
      $comment = "";
    } else {
      $comment = clean($_POST["comment"]);
    }

    if (empty($_POST["gender"])) {
      $gender_error = "Gender is required";
    } else {
      $gender = clean($_POST["gender"]);
    }
}

function clean($data) {
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = trim($data);
  return $data;
}
// Create the token
$_SESSION['token'] = bin2hex(random_bytes(22));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP Form Validation</title>
  <style>
    body {background:#f8faff;}
    .error {color: #cc0000;}
    .main {margin:10px auto; width:320px;}
  </style>
</head>
<body>  
  <div class="main">
  <h2>PHP Form Validation Example</h2>
  <p><span class="error">* required field.</span></p>
  <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Name: <input type="text" name="name" value="<?=$name;?>">
    <span class="error">* <?=$name_error;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?=$email;?>">
    <span class="error">* <?=$email_error?></span>
    <br><br>
    Website: <input type="text" name="website" value="<?=$website;?>">
    <span class="error"><?=$website_error;?></span>
    <br><br>
    Comment: <textarea name="comment" rows="5" cols="50"><?=$comment;?></textarea>
    <br><br>
    Gender:
    <input type="radio" name="gender" <?= ($gender=="female") ? "checked" : "";?> value="female">Female
    <input type="radio" name="gender" <?= ($gender=="male") ? "checked" : "";?> value="male">Male
    <span class="error">* <?=$gender_error;?></span>
    <br><br>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['token']; ?>">
    <input type="submit" name="submit" value="Submit">  
  </form>
<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;
?>
  </div>
</body>
</html>
