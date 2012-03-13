<?php  

    if (!$this->ion_auth->logged_in()){

    // using codeigniter form helper gives nice security stuph
    echo form_open('auth/login', array('id'=>'login_frm')); 
?>

<div class="cellRow">
    <label for="login_email">Email :</label>
    <input type="text" name="email" id="login_email" size="40" maxlength="100" class="required email login" value="<?php echo set_value('email'); ?>" />
</div>
<div class="cellRow">
    <label for="login_password">Password :</label>
    <input type="password" name="password" id="login_password" size="40" maxlength="50" value="<?php echo set_value('password'); ?>" class="required login" />
</div>
<p><?php
       // echo anchor('auth/forgot_password', 'Forgotten your password?'); 
    ?></p>
<input type="submit" value=" Sign in " />

<?php  
        echo form_close();
    } else { // user is logged in
?>

<div id="loginForm">
    <h2>You're logged in</h2>
    <ul>
        <li><?= anchor('dashboard', 'View your dashboard'); ?></li>
        <li><?= anchor('auth/logout', 'Sign out'); ?></li>
    </ul>
     
</div>    

<?php 

    }

?>