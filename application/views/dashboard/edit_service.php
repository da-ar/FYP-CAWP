<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Services</h1>
    
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
        <?= anchor('dashboard/services', 'back', 'class="button green"') ?>
    </div>
    
    <div id="form">
    <?php 
        if($service->id != null){
            echo form_open_multipart("services/update");
        } else {
            echo form_open_multipart("services/create");
        }
      ?>
    
    <div class="cellRow">
        <label for="service_name">Name <abbr title="Required">*</abbr> :</label>
        <input type="text" name="service_name" id="service_name" size="40" maxlength="100" class="required" value="<?php echo set_value('service_name', $service->name); ?>" />
    </div>
        
    <div class="cellRow">
        <label for="url">URL :</label>
        <input type="text" name="url" id="url" size="40" maxlength="255" value="<?php echo set_value('url', $service->url); ?>" />
    </div>
        
    <div class="cellRow">
        <label for="body">Body :</label>
        <div style="float:left">
            <textarea name="body" id="body" cols="60" rows="10"><?php echo set_value('body', $service->body); ?></textarea>    
        </div>        
        <div style="clear:both"></div>
    </div>
        
    <div class="cellRow">
        <label for="location">Location :</label>
        <select name="location" id="location">
            <?php
                foreach($locations as $location){
                    if($service->Location && $location->id == $service->Location->id){
                        $setIt = TRUE;
                    } else {
                        $setIt = FALSE;
                    }
                    echo '<option value="' . $location->id .  '" ' . set_select('location', $location->id, $setIt) . '>' . $location->getLocationString() .'</option>';
                }
            ?>
        </select>
    </div>   
        
    <div class="cellRow">
        <label for="image_upload">Background Image <abbr title="Required">*</abbr>:</label>
        <input type="file" name="image_upload" id="image_upload" />
        <input type="hidden" name="image_bg" id="image_bg" size="40" maxlength="255" value="<?php echo set_value('image_bg', $service->image_bg); ?>" />
        <?php if ($service->image_bg != null) : ?>
            <a href="/images/services/<?= $service->image_bg; ?>" target="_blank">View Image</a>
        <?php endif; ?>
    </div>    
    
    <p><?php echo form_submit('submit', 'Save');?></p>
    <?php 
        echo form_hidden('id', set_value('id', $service->id));
        echo form_close();
    ?>
    </div>
</div>

<?php $this->load->view('footer')?>