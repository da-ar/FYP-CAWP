<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Locations</h1>
    
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
        <?= anchor('dashboard/locations', 'back', 'class="button green"') ?>
    </div>
    
    <div id="form">
    <?php 
        if($location->id != null){
            echo form_open("locations/update");
        } else {
            echo form_open("locations/create");
        }
      ?>
    
    <div class="cellRow">
        <label for="block">Block <abbr title="Required">*</abbr> :</label>
        <input type="text" name="block" id="interest_name" size="40" maxlength="100" class="required" value="<?php echo set_value('block', $location->block); ?>" />
    </div>
        
    <div class="cellRow">
        <label for="floor">Floor <abbr title="Required">*</abbr> :</label>
        <input type="text" name="floor" id="floor" size="40" maxlength="100" class="required" value="<?php echo set_value('floor', $location->floor); ?>" />
    </div>
        
    <div class="cellRow">
        <label for="isMall">Is on the Mall? :</label>
        <input type="checkbox" name="isMall" id="isMall" class="required" value="1" <?php echo set_checkbox('isMall', 1, (bool)$location->isMall); ?> />
    </div>    
        
    
    <p><?php echo form_submit('submit', 'Save');?></p>
    <?php 
        echo form_hidden('id', set_value('id', $location->id));
        echo form_close();
    ?>
    </div>
</div>
<?php $this->load->view('footer')?>