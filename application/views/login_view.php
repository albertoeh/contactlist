<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Contact list</title>
    <script src="<?php echo base_url("static/js/main.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("static/js/jquery-1.9.1.js")?>" type="text/javascript"></script>  
    <script src="<?php echo base_url("static/js/jquery-ui-1.10.3.custom.min.js")?>" type="text/javascript"></script>
    <script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
    <link rel="stylesheet" href="<?php echo base_url("static/css/login.css"); ?>" />

</head>
<body>
<div class="content_box"> 
        
    <div class="tabs">
       <div class="tab">
           <input type="radio" id="tab-1" name="tab-group-1" checked>
           <label for="tab-1">Login</label>
           <div class="content"> <br>
                <input type="text" id="login_email" value="" title="Email" placeholder="Email">
                <input type="password" id="login_password" value="" title="Password" placeholder="Password">
                <input type="button" value="Login" onclick="login()">
           </div>
       </div>
       <div class="tab">
           <input type="radio" id="tab-2" name="tab-group-1">
           <label for="tab-2">Signin</label>
           <div class="content">
                <input type="text" id="signin_name" value="" title="Name" placeholder="Name"> 
                <input type="text" id="signin_email" value="" title="Email" placeholder="Email">
                <input type="password" id="signin_password" value="" title="Password" placeholder="Password">
                <input type="button" value="Signin" onclick="signin()">
           </div>
       </div>
    </div>
</div>

</body>
</html>