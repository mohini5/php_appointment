<?php

include 'connection.php';
if(isset($_SESSION['id'])){
   if($_SESSION['user_type'] == 2){
      header('location:user_home.php');
   }else{
      header('location:lawyer_home.php');
   }
}

   $email = $pwd = $type=$err=$user_type = '';
	if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $pwd = $_POST['password'];
		$user_type = $_POST['user_type'];
      $query = "select * from users where `email`='$email' AND `pwd`='$pwd' AND `type`='$user_type'";
      $result = mysqli_query($conn,$query);
      if(mysqli_num_rows($result)>0){
         $row = mysqli_fetch_assoc($result);
         $_SESSION['id'] = $row['id'];
         $_SESSION['user_type'] = $row['type'];

         if($_SESSION['user_type'] == 2){
            header('location:user_home.php');
         }else{
            header('location:lawyer_home.php');
         }
      }else{
         $err ='**invalid email or password.';
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
<body class="">
<div class="container">
   <div class="row">
   	<div class="col-sm-4 col-xs-8 offset-sm-4 offset-xs-2 border mt-5">
   		<div class="p-2">
   			Login As User Via site
   			<hr>
   		</div>
   		<div>
   			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
   				<div class="form-group">
   					<input class="form-control" type="email" value="<?php echo $email;?>" name="email" placeholder="Enter Your email.." required/>
   				</div>
   				<div class="form-group">
   					<input class="form-control" value="<?php echo $pwd;?>" type="password" name="password" placeholder="Enter Your password.." required/>
   				</div>
               <div class="form-group">
                 <label>Register As:</label>
                 <input class="ml-3" type="radio" name="user_type" value="2" <?php if($user_type=='' || $user_type=="2"){echo 'checked';}?>>
                 <span class="ml-1">User</span> 
                 <input class="ml-3" type="radio" name="user_type" value="1" <?php if($user_type=="1"){echo 'checked';}?> ><span class="ml-1">Lawyer</span>
               </div>
               <div class="text-danger mb-3"><?php echo $err;?></div>
   				<div class="text-center mb-3">
   					<button class="btn btn-info col-12" name="submit" type="submit">Submit</button>
   					<p class="text-center mt-3">OR</p>
   					<a class="col-12 btn btn-primary" href="signup.php">Register if you are a new user</a>
   				</div>

   			</form>
   		</div>
   </div>
</div>
</body>
</html>