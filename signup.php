<?php
include 'connection.php';

if(isset($_SESSION['id'])){
	if($_SESSION['user_type'] == 2){
		header('location:user_home.php');
	}else{
		header('location:lawyer_home.php');
	}
}


$fname_err = $fname = $lname = $lname_err = $email = $email_err = $pwd = $cpwd = $pwd_err = $cpwd_err = "";
$contact = $contact_err = $gender =$user_type = "";
$err_count=0;
if(isset($_POST['submit'])){
	$fname = strtolower(trim($_POST['fname']));
	$lname = strtolower(trim($_POST['lname']));
	$email = trim($_POST['email']);
	$pwd = trim($_POST['pwd']);
	$cpwd = trim($_POST['cpwd']);
	$gender = trim($_POST['gender']);
	$user_type = trim($_POST['user_type']);
	$contact = trim($_POST['contact']);
	if(empty($fname)){
		$err_count++;
		$fname_err =  "**First name is required.";
	}
	if(empty($lname)){
		$err_count++;
		$lname_err =  "**Last name is required.";
	}
	if(empty($email)){
		$err_count++;
		$email_err =  "**Email is required.";
	}else{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $email_err = "**Invalid email format"; 
		  $err_count++;
		}else{
			$query = "select * from users where `email`='$email'";
			$query_res = mysqli_query($conn,$query);
			if(mysqli_num_rows($query_res) > 0){
				$err_count++;

 				$email_err = "**This emal has already been taken."; 
			}
		}
	}
	if(empty($pwd)){
		$err_count++;
		$pwd_err =  "**Password is required.";
	}else{
		if(strlen($pwd)<4){
			$pwd_err =  "**Password must be of greater than 3 digits.";
			$err_count++;
		}
	}
	if($pwd!=$cpwd){
		$cpwd_err =  "**Password and confirm password does not matched.";
		$err_count++;
		
	}
	if(strlen($contact)!=10){
		$contact_err =  "**Invalid contact number.";
		$err_count++;
	}
	if($err_count==0){
		$query = "INSERT into users(`fname`,`lname`,`type`,`email`,`pwd`,`contact`,`gender`,`created_at`,`updated_at`) values('$fname','$lname','$user_type','$email','$pwd','$contact','$gender','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
		$sql = mysqli_query($conn,$query);
		if($sql){
			$query  = "select * from users where email='$email'";
			$result = mysqli_query($conn,$query);
			if(mysqli_num_rows($result)>0){
				$row = mysqli_fetch_assoc($result);
				$_SESSION['id'] = $row['id'];
				$_SESSION['user_type'] = $row['type'];
			}	
			if($_SESSION['user_type'] == 2){
				header('location:user_home.php');
			}else{
				header('location:lawyer_home.php');
			}
			
		}else{
			echo "Something went wrong.";
		}

	}
}
?>
<!DOCTYPE html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body class="container">
	<div class="row mt-3">
		<div class="col-sm-8 offset-sm-2 col-xs-12">
			<div class="bg-info text-white col-12 text-center p-2 mb-2">Register Now</div>
			<div class="text-right"><a href="index.php">Login if already registered</a></div>
			<form class="" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
				<div class="form-group">
				  <label>First Name:</label>
				  <input type="text" class="form-control" value="<?php echo $fname; ?>" placeholder="Enter First Name" name="fname">
				  <span class="text-danger"><?php echo $fname_err;?></span>
				</div>
				<div class="form-group">
				  <label>Last Name:</label>
				  <input type="text" class="form-control" value="<?php echo $lname; ?>" placeholder="Enter Last Name" name="lname">
				  <span class="text-danger"><?php echo $lname_err;?></span>
				</div>
				<div class="form-group">
				  <label>Email:</label>
				  <input type="text" class="form-control" value="<?php echo $email; ?>" placeholder="Enter email" name="email">
				  <span class="text-danger"><?php echo $email_err;?></span>
				</div>
				<div class="form-group">
				  <label>Password:</label>
				  <input type="password" class="form-control" value="<?php echo $pwd; ?>" placeholder="Enter Password" name="pwd">
				  <span class="text-danger"><?php echo $pwd_err;?></span>
				</div>
				<div class="form-group">
				  <label>Confirm Password:</label>
				  <input type="password" class="form-control" value="<?php echo $cpwd; ?>" placeholder="Enter Password" name="cpwd">
				  <span class="text-danger"><?php echo $cpwd_err;?></span>
				</div>
				<div class="form-group">
				  <label>Contact Number:</label>
				  <input type="number" class="form-control" value="<?php echo $contact; ?>" placeholder="Enter contact number" name="contact">
				  <span class="text-danger"><?php echo $contact_err;?></span>
				</div>
				<div class="form-group">
				  <label>Gender:</label>
				  <input class="ml-3" type="radio" name="gender" value="Male" <?php if($gender=='' || $gender=="Male"){echo 'checked';}?>>
				  <span class="ml-1">Male</span> 
				  <input class="ml-3" type="radio" name="gender" value="Female" <?php if($gender=="Female"){echo 'checked';}?> ><span class="ml-1">Female</span>
				</div>
				<div class="form-group">
				  <label>Register As:</label>
				  <input class="ml-3" type="radio" name="user_type" value="2" <?php if($user_type=='' || $user_type=="2"){echo 'checked';}?>>
				  <span class="ml-1">User</span> 
				  <input class="ml-3" type="radio" name="user_type" value="1" <?php if($user_type=="1"){echo 'checked';}?> ><span class="ml-1">Lawyer</span>
				</div>
				<div class="">
					<button class="btn btn-info col-3" name="submit" type="submit">Submit</button>			
				</div>

			</form>
		</div> 
	</div>
</body>
</html>