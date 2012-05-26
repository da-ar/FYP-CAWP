<?php $this->load->view('header')?>
<div id="sub_page_container">
	<h1>Create User</h1>
	<p>Please enter the users information below.</p>
	
	<?php if($message != '') : ?>
	<div id="infoMessage"><?php echo $message;?></div>
        <?php endif; ?>
	
    <?php echo form_open("auth/create_user");?>
      <p>Name:<br />
      <?php echo form_input($name);?>
      </p>
      
      <p>Email:<br />
      <?php echo form_input($email);?>
      </p>
      
      <p>Password:<br />
      <?php echo form_input($password);?>
      </p>
      
      <p>Confirm Password:<br />
      <?php echo form_input($password_confirm);?>
      </p>
      
      
      <p><?php echo form_submit('submit', 'Create User');?></p>

      
    <?php echo form_close();?>
</div>
<?php $this->load->view('footer')?></div>
