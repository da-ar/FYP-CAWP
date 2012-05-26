<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Your Profile</h1>    
    
    <?php
    
    if(validation_errors() != ''){
        echo "<div id='error'><h2>Validation errors</h2><ul>" .  validation_errors('<li>','</li>') . "</ul></div>";
    } else if ($this->session->flashdata('message')){
        echo "<div id=\"message\">" . $this->session->flashdata('message')  . "</div>";
    }

    echo form_open('profile/update'); 
    ?>
    
    <div class="cellRow">
        <label for="name">Your Name <abbr title="Required">*</abbr> :</label>
        <input type="text" name="name" id="firstName" size="40" maxlength="100" value="<?php echo set_value('name', $name); ?>" />
    </div>
    
    <div class="cellRow">
        <label for="email">Email <abbr title="Required">*</abbr> :</label>
        <input type="text" name="email" id="email" size="40" maxlength="100" value="<?php echo set_value('email', $email); ?>" />
    </div>
    
    <br />
    <div>
        <h2>Your Interests</h2>
        
        
        <?php             
        
        foreach($interests as $interest) {
            
            $status = false;
            if(array_search($interest->id, $user_interests) !== false){ 
                $status = true;
            }
            
          echo '<div class="interest"><input type="checkbox" name="interests[]" id="interest_' . $interest->id .  '" value="' . $interest->id . '"' . 
                  set_checkbox("interests[]", $interest->id, $status) . ' /> <label for="interest_' .$interest->id . '">' . 
                  $interest->name . '</label></div>';            
            
        } ?>
        <div style="clear:both"></div>
    </div>    
        
    

  <?php
  
    echo form_submit('submit', 'Update Profile');
    echo form_close(); 
  
  ?>
    
    
    
</div>
<?php $this->load->view('footer')?>z