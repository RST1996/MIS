<?php
    include("../template/index.php");   
    require "../config/dbconnect.php";
    if(isLogin() == null)
    {
        header("Location:../");
        die("You are not allowed ");
    }
?>
<link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<?php	
	if(isset($_POST['submit']))
	{
        $old_pass = $_POST['oldpass'];
        $new_pass = $_POST['newpass'];
        $conf_pass = $_POST['confnewpass'];
        $user_id = $_SESSION['user_uid'];
        if($new_pass == $conf_pass)
        {
            $old_pass = base64_encode(md5($old_pass));
            $new_pass = base64_encode(md5($new_pass));
            $check_query = "SELECT `id` FROM `users`WHERE `id` = '$user_id' AND `password` = '$old_pass'";
            if($check_res = mysqli_query($dbcon,$check_query))
            {
                if(mysqli_num_rows($check_res) == 1)
                {
                    $update_query = "UPDATE `users` SET `password` = '$new_pass' WHERE `id` = '$user_id'";
                    if($res  = mysqli_query($dbcon,$update_query))
                    {
?>
    <script type="text/javascript">
        swal("Done!!", "Pasword changed sucessfully!", "success")
    </script>
<?php
                    }
                    else
                    {
?>
    <script type="text/javascript">
        swal("Oops!! Failed", "Failed to update password!", "error")
    </script>
<?php
                    }
                }
                else
                {
?>
    <script type="text/javascript">
        swal("Failed!!", "Current Password mismatched", "info")
    </script>
<?php
                }
            }
        }
        else
        {
?>
    <script type="text/javascript">
        swal("Oops! Password Mismatched","Fields new password and confirm new password should be same!!","error");
    </script>
<?php
        }
	}
?>
    <section class="content">
		<div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
    		<div class="card">
                <div class="body">
                    <form id="sign_in" method="POST" onsubmit="return check_form(this.id)" action="edit_password.php">
                        <div class="msg">Edit your Password here..</div>    					
                        <div class="input-group">
                            
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            
                            <div class="form-line">
                                <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Enter your Old password" required autofocus>
                            </div>
                        </div>  
    					<div class="input-group">
                            
                            <span class="input-group-addon">
                                <i class="material-icons">create</i>
                            </span>
                            
                            <div class="form-line">
                                <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Enter your New password" required autofocus>
                            </div>
                        </div>  
    					<div class="input-group">
                            
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            
                            <div class="form-line">
                                <input type="password" class="form-control" id="confnewpass" name="confnewpass" placeholder="Conform your Password" required autofocus>
                            </div>
                        </div>  
    					<div align = "center">
    						<input type="submit" name="submit" value="Submit" class="btn btn-primary waves-effect" />
                        </div>
                    </form>
    			</div>
            </div> 
        </div>
	</section>
    <script type="text/javascript">
        function check_form(form)
        {
            var p1 = document.getElementById('newpass').value;
            var p2 = document.getElementById('confnewpass').value;
            if(p1 == p2)
            {
                return true;
            }
            else
            {
                swal("Oops! Password Mismatched","Fields new password and confirm new password should be same!!","error");
                return false;
            }
        }
    </script>

    <?php
        ob_end_flush();
    ?>