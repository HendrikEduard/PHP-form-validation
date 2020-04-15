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
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format"; 
      }
    }
    
  if (empty($_POST["website"])) {
    $website = "";
    } else {
      $website = filter_var($_POST["website"], FILTER_SANITIZE_URL);
      // check if URL address syntax is valid 
      if (!filter_var($website, FILTER_VALIDATE_URL)) {
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
// Sanitize functions
function clean($data) {
  $data = trim(htmlspecialchars(strip_tags(stripslashes($data))));
  return $data;
  }

// Create the token
$_SESSION['token'] = bin2hex(random_bytes(22));

include_once 'form.php';
