<?php 
	require_once "Core/init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<title>Trash Hima</title>
</head>
<body>
	<form method = "POST" action="submit.php">
	  <div class="form-group">
	    <label for="accountname">Account Name<span>*</span>:</label>
	    <input type="text" class="form-control" id="accountname" name = "accountname" minlength = "4" maxlength = "23" required>
	  </div>
	  <div class="form-group">
	    <label for="accountpwd">Password<span>*</span>:</label>
	    <input type="text" class="form-control" id="pwd" name = "accountpwd" minlength = "4" maxlength = "23" required>
	  </div>
	  <div class="form-group">
	    <label for="email">Email Adress(optional):</label>
	    <input type="email" class="form-control" id="email" name = "email">
	  </div>
	  <div class="form-group">
	    <label for="accountpwd">Char Name<span>*</span>:</label>
	    <input type="text" class="form-control" id="charname" name = "charname" minlength = "4" maxlength = "23" required>
	  </div>
	  <label for="gender">Gender<span>*</span>:</label>
	  <select name = "gender" class="browser-default custom-select">
            <option selected value = "1">Male</option>
            <option value="0">Female</option>
      </select>
	  <input type="submit" class="btn btn-primary form-control" name = "submit" value = "Submit">
	</form>
</body>
</html>
