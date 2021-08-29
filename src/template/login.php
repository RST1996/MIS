<?php
	session_start();
	ob_start();
	require "../config/dbconnect.php";
	include "../config/funlib/login_functions.php";
?>

<?php
	if(isLogin() == null)
	{
		if (isset($_POST['login'])) {
			if(/*$_SESSION['captcha'] == $_POST['captcha_ip']*/true)
			{
				unset($_SESSION['captcha']);
				$username = $_POST['username'];
				$password = $_POST['password'];
				$err_msg = login($username,$password);
				$_SESSION['username']=$username;
			}
			else
			{
				$err_msg = "Captcha mismatched....!!";
			}
		}
		
	}
	else
	{
		
		header('Location:../');
		die(":(  ");
	}
	ob_end_flush();
?>
<!DOCTYPE html>
<html>

<?php
    include("head.php");
?>
<body class="login-page">
    <link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="../plugins/sweetalert/sweetalert.min.js"></script>
<?php
    if(isset($err_msg))
    {
?>
<script type="text/javascript">
        swal("Oops!","<?php echo $err_msg ?>","error");
</script>
<?php
    }
?>
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">GCoE, Jalgaon - <b>MIS</b></a>
            
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="login.php">
                    <div class="msg">Please Sign In to Continue...</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
                        </div>
                        
                    </div>          
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line form-float">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
					
					<div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="captcha_img" src="../assets/images/generate.php" /> 
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">     
										 <button type="button" onclick="reload()" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
											<i class="material-icons">loop</i>
										</button>
                                    </div>
                                </div>
                    </div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line form-float">
                            <input type="text" class="form-control" id="captcha_ip" name="captcha_ip"  placeholder="Captcha Text" required>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit" name="login" >SIGN IN</button>
                        </div>
                    </div>
                        <div class="col-xs-6 align-left">
							
                            
                        </div>
						
						<div class="row clearfix" align="right">
                                <div class="col-md-6">
                                    <a href="forgot-password.php">Forgot Password?</a>    
                                </div>
						</div>
						
                    </div>
                </form>
            </div>
        </div>
    </div>
	<script type="text/javascript">
	function reload()
	{
		var image = document.getElementById('captcha_img');
		var image_src = document.createAttribute("src");
		image_src.value = "../assets/images/generate.php";
		image.setAttributeNode(image_src);
	}
</script>
<?php
    include("jquery.php");
?>
</body>

</html>