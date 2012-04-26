<?php $this->load->view('header')?>
<div id="sub_page_container">
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

    <p>Please login with your email address and password below.</p>
	
    <?php echo form_open("auth/login", array('id'=>'login_main'));?>
    
    
    <div class="cellRow">
        <label for="main_login_email">Email <abbr title="Required">*</abbr> :</label>
        <input type="text" name="email" id="main_login_email" size="40" maxlength="100" class="required email login" value="<?php echo set_value('email'); ?>" />
    </div>
    <div class="cellRow">
        <label for="main_login_password">Password :</label>
        <input type="password" name="password" id="main_login_password" size="40" maxlength="50" value="<?php echo set_value('password'); ?>" class="required login" />
    </div>
      
    <p>
    <label for="remember">Remember Me:</label>
    <?php 
        $check_arr = array(
            'name' => 'remember',
            'id' => 'remember',
            'value' => 1,
            'checked' => FALSE
        );
            echo form_checkbox($check_arr);?>
    </p>


    <p><?php echo form_submit('submit', 'Login');?></p>
    <br />
    <p><?= anchor('auth/forgot_password', 'Forgotten your password?'); ?></p>
      
    <?php echo form_close();?>
     
    
    
    
</div>    
<?php 
    
    $data["scripts"] = '$(document).ready(function(){
        $("#login_main").validate({
                errorPlacement: function(error, element) {
                        error.appendTo( element.parent() );
                }
        }); 
    });';




    $this->load->view('footer', $data);
        
        ?>
