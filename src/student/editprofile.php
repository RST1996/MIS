
<?php
	include("../template/head.php");
?>
   <?php
		include("../template/loader.php");
   ?>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <?php
		include("../template/navbar.php");
   ?>
    <section>
         
    <?php
		include("../template/leftside.php");
		include("../template/rightside.php");
   ?>
        
    </section>

    <section class="content">
        <?php
		include("profile_details.php");
   ?>
    </section>

 <?php
		include("../template/jquery.php");
   ?>
</body>

</html>