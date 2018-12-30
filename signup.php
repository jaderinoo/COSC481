<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); exit(); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	if (!isset($_POST['firstname'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['lastname'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['username'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['phone'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['address1'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['address2'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['city'])) $error[] = "Please fill out all fields";

	$username = $_POST['username'];
	$phone = $_POST['phone'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$zip = $_POST['zip'];
	$state = $_POST['state'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	

	//very basic validation
	if(!$user->isValidUsername($username)){
		$error[] = 'Usernames must be at least 3 Alphanumeric characters';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (firstname,lastname,username,password,email,active,phone,address1,address2,city,state,zip) VALUES (:firstname, :lastname, :username, :password, :email, :active, :phone, :address1, :address2, :city, :state, :zip)');
			$stmt->execute(array(
				':firstname' => $firstname,
				':lastname' => $lastname,
				':username' => $username,
				':password' => $hashedpassword,
				':email' => $email,
				':active' => 'Yes',
				':phone' => $phone,
				':address1' => $address1,
				':address2' => $address2,
				':city' => $city,
				':state' => $state,
				':zip' => $zip
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at demo site.</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to signup page
			header('Location: signup.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Demo';

//include header template
require('layout/header.php');
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULS</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:300,400,700">
    <link rel="stylesheet" href="assets/css/Article-Clean.css">
    <link rel="stylesheet" href="assets/css/Article-List.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="assets/css/Data-Table2.css">
    <link rel="stylesheet" href="assets/css/dh-navbar-centered-brand.css">
    <link rel="stylesheet" href="assets/css/Dropdown-Login-with-Social-Logins.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Good-login-dropdown-menu.css">
    <link rel="stylesheet" href="assets/css/Good-login-dropdown-menu1.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Google-Style-Login.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/MUSA_navbar.css">
    <link rel="stylesheet" href="assets/css/MUSA_navbar1.css">
    <link rel="stylesheet" href="assets/css/Navbar-Fixed-Side.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/SIdebar-Responsive-2.css">
    <link rel="stylesheet" href="assets/css/SIdebar-Responsive-21.css">
    <link rel="stylesheet" href="assets/css/sticky-dark-top-nav.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

	<body style="background-color:rgb(230,230,230);font-family:Lora, serif;">
<div class="container">
<div style="height:150px;">
        <nav class="navbar navbar-light navbar-expand-md fixed-top navigation-clean-button" style="background-color:rgba(119,11,11,0.83);">
            <div class="container"><a class="navbar-brand" href="index.php">Ultimate Laundry Solutions</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle invisible" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </li>
                    </ul><span class="navbar-text actions"> <a href="login.php" class="login">Log In &nbsp;&nbsp;</a><a class="btn btn-light action-button" role="button" href="signup.php" style="padding:3px;margin:-4px;background-color:rgba(86,198,198,0);">Sign Up</a></span></div>
    </div>
    </nav>
    </div>
	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful.</h2>";
				}
				?>
				<div class="form-group">
					<input type="text" name="firstname" id="firstname" class="form-control input-lg" placeholder="First Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['firstname'], ENT_QUOTES); } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="text" name="lastname" id="lastname" class="form-control input-lg" placeholder="Last Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['lastname'], ENT_QUOTES); } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="2">
				</div>
				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
				</div>
				<div class="form-group">
					<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
				</div>
					<!-- new stuff -->
				<div class="form-group">
				<input type="phone" name="phone" id="phone" class="form-control input-lg" placeholder="phone" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['phone'], ENT_QUOTES); } ?>" tabindex="5">
				</div>
				
				<div class="form-group">
				<input type="text" name="address1" id="address1" class="form-control input-lg" placeholder="address1" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['address1'], ENT_QUOTES); } ?>" tabindex="6">
				</div>
				
				<div class="form-group">
					<input type="text" name="address2" id="address2" class="form-control input-lg" placeholder="address2" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['address2'], ENT_QUOTES); } ?>" tabindex="7">
				</div>
				
				<div class="form-group">
					<input type="text" name="city" id="city" class="form-control input-lg" placeholder="city" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['city'], ENT_QUOTES); } ?>" tabindex="8">
				</div>
				
				<div class="form-group">
					<input type="text" name="state" id="state" class="form-control input-lg" placeholder="state" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['state'], ENT_QUOTES); } ?>" tabindex="8">
				</div>
				
				<div class="form-group">
					<input type="text" name="zip" id="zip" class="form-control input-lg" placeholder="zip" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['zip'], ENT_QUOTES); } ?>" tabindex="8">
				</div>
	
	
	
	<h3>Service Type:</h3>
    <label><input type="radio" name="service" value="1">Student</label>
    <label><input type="radio" name="service" value="2">Resident</label>
	
	<h3>Bag Size:</h3>
    <label><input type="radio" name="bag" value="1">Regular</label>
    <label><input type="radio" name="bag"value="2">Large</label>
	
	<h2> Subscription Frequency</h2>
	
	<h3> Monthly:</h3>
    <label><input type="radio" name="monthly" value="1">Weekly</label>
    <label><input type="radio" name="monthly" value="2">Biweekly</label>
	
	<h3>Other:</h3>
    <label><input type="radio" name="other" value="1">One-time</label>
    <label><input type="radio" name="other" value="2">Semester</label>
	
	<h2>Choose Day</h2>
	<h3>Pickup:</h3>
    <input type="datetime-local" name="pickupdayandtime">
	
	<h3>Dropoff:</h3>
    <input type="datetime-local" name="dropoffdayandtime">
	<p></p>
			<div class="row" style="height: 50px;">
			<div style="height: 50px;"></div>
				<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
			</div>
			</form>
	</div>

</div>
</div>
<div style="height:325px;background-color:rgb(230,230,230);"></div>
<div class="footer-dark" style="font-family:Lora, serif;background-color:rgba(119,11,11,0.83);">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 item text">
                    <h3>Ultimate Laundry Solutions</h3>
                    <p>Live	&hearts; Love &hearts; Laundry</p>
                </div>
                <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
            </div>
            <p class="copyright">ULS©2018</p>
        </div>
    </footer>
</div>

</body>
<?php
//include header template
require('layout/footer.php');
?>
