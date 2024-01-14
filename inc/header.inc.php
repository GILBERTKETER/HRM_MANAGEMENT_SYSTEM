

<nav role="navigation" class="navbar navbar-default real-nav" >
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
			
            <ul class="nav navbar-nav navbar-right">
			
                <?php if(!User::loggedIn()) {?> 
               <li><a href='login.php'>Login</a></li>
               <?php } else {
                ?> 

               <!-- <li><a href='profile.php?token=<?php //echo $token; ?> '>Hello <?php// echo $userFirstName." ".$userSecondName; ?>,</a></li>--> 
			    <li><a href='logout.php'>Logout</a></li>
                <?php 
               } ?>
            </ul>
            
        </div>
    </div>
</nav>
