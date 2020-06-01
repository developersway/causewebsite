<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
    <link href="styles/maxcdn_bootstrap_4.1.1.css" rel="stylesheet" id="bootstrap-css">  <!-- //maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">    
	<link rel="stylesheet" href="styles/maxcdn_bootstrap_4.1.3.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> <!--https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css-->
    <link rel='stylesheet' href='styles/site.css'>
</head>

<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
                        <img src="images/brand_logo1.jpeg" class="brand_logo" alt="Logo">
                        <div class='logo_subtitle'>ForCause</div>
                    </div>
                    
				</div>
				<div class="d-flex justify-content-center form_container">
                    
					<form action='./store.php'>
                        <label class='label_text'>Email</label>
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-envelope " aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control input_user" >
                        </div>
                        <label class='label_text'>Password</label>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-lock login_icon" aria-hidden="true"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" >
                        </div>

						<input type='hidden' name='form' value='login'>
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="button" class="btn login_btn"><i class="fa fa-sign-in" aria-hidden="true"></i><span class='login_text'>Log In</span></button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						New Member? <a href="sign_up.php" class="ml-2">Register here</a>
					</div>
					<div class="d-flex justify-content-center links">
						<a href="#" class='forgot_password'>Forgot your password?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>



    <script src="scripts/maxcdn_bootstrap_4.1.1.min.js"></script>  <!--//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js-->
    <script src="scripts/cdjns_jquery_3.2.1.min.js"></script>   <!--//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js-->
    <script src="scripts/ajax_jquery_3.3.1.min.js"></script>  <!--https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js-->


	</html>

