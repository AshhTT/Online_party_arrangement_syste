<?php 

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'aaa');

// variable declaration
$username = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
//if(!function_exists('register')){

function register(){
    // call these variables with the global keyword to make them available in function
    global $db, $errors, $username;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['uname']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = ($password_1);//saving password in db

		if (isset($_POST['type'])) {
			$user_type = e($_POST['type']);
			$query = "INSERT INTO login ( uname, type, password) 
					  VALUES('$username', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: ../html/home.html');
		}else{
			$query = "INSERT INTO login ( uname,type, password) 
					  VALUES('$username', '$user_type', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['login'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: ../html/home.html');				
		}
	}
}


// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM login WHERE user-id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}



// escape string

function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}



function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	
?>