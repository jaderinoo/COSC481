<?php 

require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

$sql_query = "SELECT * from auth.members";
if(mysqli_query($sql_query))
     {
     $_SESSION['username']=$username;
          $_SESSION['email']=$email;

     }
//define page title
$title = 'Members Page';

//include header template
require('layout/header.php'); 
					
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpme</title>
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
<body style="color:rgb(0,128,255);background-color:rgb(230,230,230);">
<!--This is the header of the page-->
<div>
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
</div>

<!--This is the main body of the page-->
<div style="height: 100%">
<div style="height: 100px">
</div>
<style>
table, th, td {
  border: 1px solid black;
}
table{
    width:80%;
}
</style>
<h2>&nbsp &nbsp &nbsp User History</h2><br>
<table style="text-align:center"; align="center";>
<thead>
    <tr>
		<th>Date</th>
		<th>Time</th>
		<th>Status</th>
		<th>Pickup</th>
		<th>Dropoff</th>
		<th>Address</th>
	</tr>
	</thead>
	<tr> <!--loop this bitch -->
	
		<th> - </th>
		<th> - </th>
		<th> - </th>
		<th> - </th>
		<th> - </th>
		<th><?php echo htmlspecialchars($_SESSION['address1'], ENT_QUOTES); ?></th>

	</tr>

   </table>
	</div>
	<!--This is the footer of the page-->
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
<?php 
//include header template
require('layout/footer.php'); 
?>
