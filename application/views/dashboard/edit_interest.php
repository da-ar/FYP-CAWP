<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Interests</h1>
    
    <?php
    
    if(validation_errors() != ''){

        echo "<div id=\"error\"><h2>Validation errors</h2><ul>" .  validation_errors('<li>','</li>') . "</ul></div>";
    } else if ($this->session->flashdata('message')){
        echo "<div id=\"message\">" . $this->session->flashdata('message')  . "</div>";
    } else if ($this->session->flashdata('error')){
        echo "<div id=\"error\"><h2>An error occured</h2>" . $this->session->flashdata('error') . "</div>";
    }
    ?>
    
    <div id="button_holder">
        <?= anchor('dashboard/interests', 'back', 'class="button green"') ?>
    </div>
    
    <div id="form">
    <?php 
        if($interest->id != null){
            echo form_open("interests/update");
        } else {
            echo form_open("interests/create");
        }
      ?>
    
    <div class="cellRow">
        <label for="interest_name">Name <abbr title="Required">*</abbr> :</label>
        <input type="text" name="interest_name" id="interest_name" size="40" maxlength="100" class="required" value="<?php echo set_value('interest_name', $interest->name); ?>" />
    </div>     
    
    <p><?php echo form_submit('submit', 'Save');?></p>
    <?php 
        echo form_hidden('id', set_value('id', $interest->id));
        echo form_close();
    ?>
    </div>
</div>
<?php $this->load->view('footer')?>