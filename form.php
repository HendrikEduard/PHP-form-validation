<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP Secure Form With Validation</title>
  <style>
    body {background:#f0f8ff; font-size: 16px;}
    .error {color: #cc0000;}
    .main {margin:10px auto; width:350px;}
    input, textarea {display: inline-block; margin: 0 0 20 0;}
  </style>
</head>
<body>  
  <div class="main">
  <h2>PHP Secure Form with Validation</h2>
  <p><span class="error">* required field.</span></p>
  <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Name: <input type="text" name="name" value="<?=$name;?>">
    <span class="error">* <?=$name_error;?></span><br>
    E-mail: <input type="text" name="email" value="<?=$email?>">
    <span class="error">* <?=$email_error?></span><br>
    Website: <input type="text" name="website" value="<?=$website?>"><br>
    <span class="error"><?=$website_error?></span><br>
    Comment: <textarea name="comment" rows="5" cols="45"><?=$comment?></textarea><br>
    Gender:
    <input type="radio" name="gender" <?= ($gender=="female") ? "checked" : "";?> value="female">Female 
    <input type="radio" name="gender" <?= ($gender=="male") ? "checked" : "";?> value="male">Male 
    <span class="error">* <?=$gender_error?></span><br>
    <input type="hidden" name="csrf_token" value="<?=$_SESSION['token']?>">
    <input type="submit" name="submit" value="Submit">  
  </form>
<?= "<h2>Your Input:</h2>".$name."<br>".$email."<br>".$website."<br>".$comment."<br>".$gender?>
  </div>
</body>
</html>
