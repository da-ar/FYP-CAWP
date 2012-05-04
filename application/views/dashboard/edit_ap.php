<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Access Points</h1>
    
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
        <?= anchor('AccessPoints/index/' . $location, 'back', 'class="button green"') ?>
    </div>
    
    <div id="form">
    <?php 
        if($ap->id != null){
            echo form_open("AccessPoints/update");
        } else {
            echo form_open("AccessPoints/create");
        }
      ?>
    
    <div class="cellRow">
        <label for="bssid">BSSID <abbr title="Required">*</abbr> :</label>
        <input type="text" name="bssid" id="bssid" size="40" maxlength="17" class="required" value="<?php echo set_value('bssid', $ap->bssid); ?>" />
    </div>     
    
    <p><?php echo form_submit('submit', 'Save');?></p>
    <?php 
        echo form_hidden('id', set_value('id', $ap->id));
        echo form_hidden('location', set_value('location', $location));
        echo form_close();
    ?>
    </div>
</div>
<?php $this->load->view('footer')?>