<?php require('includes/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'admin Page';
//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['phone'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['address1'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['address2'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['city'])) $error[] = "Please fill out all fields";

	$username = $_POST['username'];
	$password = $_POST['password'];
	$phone = $_POST['phone'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$zip = $_POST['zip'];
	$state = $_POST['state'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	

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


			
			
				if(!empty($_POST['email'])) {
					$_SESSION['email'] = $_POST['email'];
				}
				if(!empty($_POST['zip'])) {
					$_SESSION['zip'] = $_POST['zip'];
				}
				if(!empty($_POST['phone'])) {
					$_SESSION['phone'] = $_POST['phone'];
				}
				if(!empty($_POST['address1'])) {
					$_SESSION['address1'] = $_POST['address1'];
				}
				if(!empty($_POST['address2'])) {
					$_SESSION['address2'] = $_POST['address2'];
				}
				if(!empty($_POST['state'])) {
					$_SESSION['state'] = $_POST['state'];
				}
				if(!empty($_POST['city'])) {
					$_SESSION['city'] = $_POST['city'];
				}
				
				//Push session variables into db by replacing items with $_SESSION
				
				header("location:memberpage.php");
				die();
			


}

//include header template
require('layout/header.php');
?>
<html>
<body style="color:rgb(0,128,255);background-color:rgb(230,230,230);">
    <nav class="navbar navbar-light navbar-expand-md navbar-fixed-top navigation-clean-button" style="background-color:rgba(119,11,11,0.83);font-family:Lora, serif;">
        <div class="container">
            <a class="navbar-brand" href="#"><span>Ultimate Laundry Solutions</span> </a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
            class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav nav-right">
                <li class="nav-item" role="presentation"><a class="nav-link" href="memberpage.php" style="color:rgb(255,255,255);">Dashboard</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="profilemanagment.php" style="color:rgb(255,255,255);">Profile Managment</a></li>
            </ul>
            <p class="ml-auto navbar-text actions"> <a class="btn btn-light action-button" role="button" href="logout.php" style="background-color:rgba(86,198,198,0);">Sign Out</a></p>
        </div>
    </div>
</nav>
<div class="container">
<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="">
				<h2>Edit Your Account</h2>
				<hr>

				<div class="form-group">
				Email
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="<?php  echo htmlspecialchars($_SESSION['email'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="2">
				</div>
				<div class="form-group">
				Phone number
				<input type="phone" name="phone" id="phone" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['phone'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['phone'], ENT_QUOTES); } ?>" tabindex="5">
				</div>
				
				<div class="form-group">
				Address 1
				<input type="text" name="address1" id="address1" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['address1'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['address1'], ENT_QUOTES); } ?>" tabindex="6">
				</div>
				
				<div class="form-group">
				Address 2
					<input type="text" name="address2" id="address2" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['address2'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['address2'], ENT_QUOTES); } ?>" tabindex="7">
				</div>
				
				<div class="form-group">
				City
					<input type="text" name="city" id="city" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['city'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['city'], ENT_QUOTES); } ?>" tabindex="8">
				</div>
				
				<div class="form-group">
				State
					<input type="text" name="state" id="state" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['state'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['state'], ENT_QUOTES); } ?>" tabindex="8">
				</div>
				
				<div class="form-group">
				Zip
					<input type="text" name="zip" id="zip" class="form-control input-lg" placeholder="<?php echo htmlspecialchars($_SESSION['zip'], ENT_QUOTES);  ?>" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['zip'], ENT_QUOTES); } ?>" tabindex="8">
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
        <div class="footer-dark" style="font-family:Lora, serif;background-color:rgba(119,11,11,0.83);">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 item text">
                            <h3>Ultimate Laundry Solutions</h3>
                            <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                        </div>
                        <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                    </div>
                    <p class="copyright">ULS©2018</p>
                </div>
            </footer>
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    </body>
    </html>