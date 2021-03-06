<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bidding-system/init.php';
include 'heading/header.php';

$username = ((isset($_POST['username']))?($_POST['username']):'');
$username = trim($username);
$errors = array();

?>
<style>
body{
	background-size: 100vw 100vh;
	background-attachment: fixed;
}		
</style>

<div id="login-form">
	<div>
		<?php
		if ($_POST) {
			//form validation
			if (empty($_POST['username'])) {
				$errors[] = 'You must provide username';
			}

			//check if user exists in the database
			$query = $db->query("SELECT * FROM account WHERE username = '$username'");
			$user = mysqli_fetch_assoc($query);
			$userCount = mysqli_num_rows($query);

			if ($userCount < 1) {
			   $errors[] = 'Username doesn\'t exist in database';
			}
			//check for errors
			if (!empty($errors)) {
			  echo display_errors($errors);
			}else{
				//log the user in
				$user_id = $user['account_id'];
				login($user_id);
			}
		}
        
        ?>
	</div>
	<h2 class="text-center">Login</h2><hr>
 <div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="username">Username: </label>
			<input type="text" name="username" id="username" class="form-control" value="<?=$username; ?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right">
		<a href="register.php" alt="home">Register</a>
	</p>
   </div>
   <div class="col-md-3"></div>
</div>

<?php include 'footer.php'; ?>