<!DOCTYPE html>
<html>

<?php
    include("head.php");
?>
<body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);">GCoE, Jalgaon -<b>MIS</b></a>
            <small>Management Information System </small>
        </div>
        <div class="card">
            <div class="body">
                <form id="forgot_password" method="POST">
                    <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET MY PASSWORD</button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="../template/index.php">Log In!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <?php
    include("jquery.php");
?>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
    <script src="../js/pages/examples/forgot-password.js"></script>
</body>

</html>