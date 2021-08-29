<?php
	include("../template/index.php");
?>

<section class="content">
<?php
		$conn = mysqli_connect('localhost','root','');
		$cn = mysqli_select_db($conn,'gcoej_mis');
		$check = mysqli_query($conn,"SELECT * FROM student WHERE prn = $user_name") or die(mysqli_error($conn));
		$res=mysqli_fetch_assoc($check);
?>

		<div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
		
		 <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="index.php">
                    <div class="msg">Edit your Profile here..</div>
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>&nbsp;&nbsp;FULL NAME -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="fullname" placeholder="FULL NAME" value="<?php echo $res["name"];?>" disabled>
                        </div>
                        
                    </div> 
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>&nbsp;&nbsp;E-MAIL -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="E-Mail" value="<?php echo $res["email"];?>" required autofocus>
                        </div>
                        
                    </div> 
				<div class="input-group">
                        
                        <span class="input-group-addon">
                            <i class="material-icons">phone</i>&nbsp;&nbsp;MOBILE NO -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $res["mobile_no"];?>" required autofocus>
                        </div>
						<span class="input-group-addon">
                            <i class="material-icons">phone</i>&nbsp;&nbsp;LANDLINE NO -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="phone" placeholder="Landline" value="<?php echo $res["landline_no"];?>" required autofocus>
                        </div>
                    </div> 					
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">home</i>&nbsp;&nbsp;LOCAL ADDRESS -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="addr" placeholder="Address Line 1" value="<?php echo $res["local_address"];?>" disabled>
                        </div>
                        <span class="input-group-addon">
                            <i class="material-icons">home</i>
                        </span>
						
						<div class="form-line">
                            <input type="text" class="form-control" name="addr" placeholder="Address Line 2" disabled>
                        </div>
                        <span class="input-group-addon">
                            <i class="material-icons">domain</i>&nbsp;&nbsp;CITY -
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $res["city"];?>" disabled>
                        </div>
                    </div>  
					
					<div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">location_city</i>
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="city" placeholder="District" disabled>
                        </div>
                    </div>  
					
                    <button type="button" class="btn btn-primary waves-effect">Submit</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
		
        </div>
</section>