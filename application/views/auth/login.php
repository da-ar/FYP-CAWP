<?php $this->load->view('header')?>
    
<h1>Login</h1>
    <?php
    
    if(validation_errors() != ''){

        echo "<div id=\"error\"><h2>Validation errors</h2><ul>" .  validation_errors('<li>','</li>') . "</ul></div>";
    } else if ($this->session->flashdata('message')){
        echo "<div id=\"message\">" . $this->session->flashdata('message')  . "</div>";
    } else if ($this->session->flashdata('error')){
        echo "<div id=\"error\"><h2>An error occured</h2>" . $this->session->flashdata('error') . "</div>";
    }
    ?>

    <div class="pageTitleBorder"></div>
    <p>Please login with your email address and password below.</p>
	
    <?php echo form_open("auth/login", array('id'=>'login_main'));?>
    
    
    <div class="cellRow">
        <label for="login_email">Email <abbr title="Required">*</abbr> :</label>
        <input type="text" name="email" id="main_login_email" size="40" maxlength="100" class="required email login" value="<?php echo set_value('email'); ?>" />
    </div>
    <div class="cellRow">
        <label for="login_password">Password :</label>
        <input type="password" name="password" id="main_login_password" size="40" maxlength="50" value="<?php echo set_value('password'); ?>" class="required login" />
    </div>
      
      <p>
	      <label for="remember">Remember Me:</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	  </p>
      
      
      <p><?php echo form_submit('submit', 'Login');?></p>
      <p><?= anchor('auth/forgot_password', 'Forgotten your password?'); ?></p>
      
    <?php echo form_close();?>

<?php $this->load->view('footer')?>