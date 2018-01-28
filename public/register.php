<?php
  require_once('../private/initialize.php');

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  
	if(is_post_request())
	{
	
	// Confirm that POST values are present before accessing them.
	
	$first_name = $_POST['first_name'] ?? '';
	$last_name = $_POST['last_name'] ?? '';
	$email = $_POST['email'] ?? '';
	$username = $_POST['username'] ?? '';
	
	//sanitize all the inputs
	
	$first_name = h($first_name);
	$first_name = strip_tags(html_entity_decode($first_name));
	$last_name = h($last_name);
	$last_name = strip_tags(html_entity_decode($last_name));
	$email = h($email);
	$email = strip_tags(html_entity_decode($email));
	$username = h($username);
	$username = strip_tags(html_entity_decode($username));

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
	
	$errors = array();
	
	if(!is_blank($first_name)){
		if(has_length($first_name, array("min" => 2, "max" => 255))){
		}
		else{
			array_push($errors, "First name must be between 2 and 255 characters!");
		}
	}
	else{
		array_push($errors, "First name field was left blank!");
	}
	
	if(!is_blank($last_name)){
		if(has_length($last_name, array("min" => 2, "max" => 255))){
		}
		else{
			array_push($errors, "Last name must be between 2 and 255 characters!");
		}
	}
	else{
		array_push($errors, "Last name field was left blank!");
	}

	if(!is_blank($username)){
		if(has_length($username, array("min" => 8, "max" => 255))){
		}
		else{
		array_push($errors, "Username must be between 8 and 255 characters!");
		}
	}
	else{
		array_push($errors, "Username field was left blank!");
	}
	
	if(!is_blank($email)){
		if(has_length($email, array("min" => 3, "max" => 255))){
			if(has_valid_email_format($email)){
			}
			else{
			array_push($errors, "Email address must be formatted correctly!");
			}
		}
		else{
			array_push($errors, "Email address must be between 3 and 255 characters!");
		}
	}
	else{
		array_push($errors, "Email field was left blank!");
	}
	
    // if there were no errors, submit data to database
	
	if(empty($errors))
	{
		$date = date("Y-m-d H:i:s");
		$sql = "
		INSERT INTO users (first_name, last_name, email, username, created_at)
		VALUES ('$first_name', '$last_name', '$email', '$username', '$date');";
		
		$result = db_query($db, $sql);
		if($result) {
			db_close($db);
			header("Location: registration_success.php");
			exit;
		}
		else {
			echo db_error($db);
			db_close($db);
			exit;
		}
	}
	}

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>
  

  <?php
	if(is_post_request()){
		$out = display_errors($errors);
		echo $out;
	}
  ?>

  <form action = "./register.php" method = "post">
	<input type = "text" name = "first_name" value = "<?php if(is_post_request()){echo $first_name;}?>">	First Name</input><br><br>
	<input type = "text" name = "last_name" value = "<?php if(is_post_request()){echo $last_name;}?>">	Last Name</input><br><br>
	<input type = "text" name = "email" value = "<?php if(is_post_request()){echo $email;}?>">	Email</input><br><br>
	<input type = "text" name = "username" value = "<?php if(is_post_request()){echo $username;}?>">	Username</input><br><br>
	<input type = "submit" name = "submit" value = "Submit"></input><br><br>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
