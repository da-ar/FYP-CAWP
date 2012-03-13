<?php $this->load->view('header')?>
<h1>Forgot Password</h1>
<p>Please enter your <?php echo $identity_human;?> so we can send you an email to reset your password.</p>
<?php

    if(validation_errors() != ''){
        echo "<div id=\"error\"><h2>Validation errors</h2><ul>" .  validation_errors('<li>','</li>') . "</ul></div>";
    } else if ($this->session->flashdata('message')){
        echo "<div id=\"message\">" . $this->session->flashdata('message')  . "</div>";
    } else if ($this->session->flashdata('error')){
        echo "<div id=\"error\"><h2>An error occured</h2>" . $this->session->flashdata('error') . "</div>";
    }
    ?>


<?php echo form_open("auth/forgot_password");?>


    <div class="cellRow">
        <label for="login_email">Email <abbr title="Required">*</abbr> :</label>
        <input type="text" name="email" id="main_login_email" size="40" maxlength="100" class="required email login" value="<?php echo set_value('email'); ?>" />
    </div>  
      
    <p><?php echo form_submit('submit', 'Submit');?></p>
      
<?php echo form_close();?>
<?php $this->load->view('footer')?>