<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Schedule</h1>
    
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
        <?= anchor('/schedules/index/' . $service->id, 'back', 'class="button green"') ?>
    </div>
    
    <div id="form">
    <?php 
        if($schedule->id != null){
            echo form_open_multipart("schedules/update");
        } else {
            echo form_open_multipart("schedules/create/" . $service->id);
        }
      ?>

    <div class="cellRow">
        <label for="start_date">Start Date :</label>
        <select name="start_date[]">
            <?php 
            for($i=1; $i<=31; $i++){
                
                if(is_object($schedule->start_date) && $i == $schedule->start_date->format('d')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('start_date[]', $i, $status) . ">";
                echo $i . "</option>";
            }
            ?>
        </select>
        <select name="start_date[]">
            <?php 
            
            for($i=1; $i<=12; $i++){
                
                if(is_object($schedule->start_date) && $i == $schedule->start_date->format('n')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo '<option value="' . $i .'"' . set_select('start_date[]', $i, $status) . ">";
                echo date("M", mktime(0, 0, 0, $i, 1, 2000)) . "</option>";                
                
            }
            ?>
        </select>
        <select name="start_date[]">
            <?php 
            $date = new DateTime();
            $thisYear = $date->format('Y');
            $endYear = $thisYear + 5; // creates drop down for up to 5 additional years
            
            for($i=$thisYear; $i<=$endYear; $i++){
                if(is_object($schedule->start_date) &&$i == $schedule->start_date->format('Y')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('start_date[]', $i, $status) . ">";
                echo $i . "</option>";
            }
            ?>
        </select>
    </div>
        
    <div class="cellRow">
        <label for="end_date">End Date :</label>
        <select name="end_date[]">
           <?php 
            for($i=1; $i<=31; $i++){
                
                if(is_object($schedule->end_date) &&$i == $schedule->end_date->format('d')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('end_date[]', $i, $status) . ">";
                echo $i . "</option>";
            }
            ?>
        </select>
        <select name="end_date[]">
            <?php 
            
            for($i=1; $i<=12; $i++){
                
                if(is_object($schedule->end_date) &&$i == $schedule->end_date->format('n')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo '<option value="' . $i .'"' . set_select('end_date[]', $i, $status) . ">";
                echo date("M", mktime(0, 0, 0, $i, 1, 2000)) . "</option>";                
                
            }
            ?>
        </select>
        <select name="end_date[]">
            <?php 
            $date = new DateTime();
            $thisYear = $date->format('Y');
            $endYear = $thisYear + 5; // creates drop down for up to 5 additional years
            
            for($i=$thisYear; $i<=$endYear; $i++){
                if(is_object($schedule->end_date) &&$i == $schedule->end_date->format('Y')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('end_date[]', $i, $status) . ">";
                echo $i . "</option>";
            }
            ?>
        </select>
        <?php
        
            if($schedule->end_date == null){
                $status = true;
            } else {
                $status = false;
            } ?>
        
    </div>    
    
    <div class="cellRow">
        <label for="null_end"> Ignore End Date </label> 
        <input type="checkbox" name="null_end" id="null_end" value="1" <?php   echo set_checkbox('null_end', '1', $status); ?> />            
    </div>
    
    <div class="cellRow">
        <label for="start_time">Start Time :</label>
        <select name="start_time[]">
            <?php 
            for($i=0; $i<=23; $i++){
                if(is_object($schedule->start_time) && $i == $schedule->start_time->format('G')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('start_time[]', $i, $status) . ">";
                echo str_pad($i, 2, "0", STR_PAD_LEFT)  . "</option>";
                
            }
            ?>            
        </select>
        <select name="start_time[]">
            <?php 
            for($i=0; $i<=45; $i += 15){
                if(is_object($schedule->start_time) && $i == $schedule->start_time->format('i')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('start_time[]', $i, $status) . ">";
                echo str_pad($i, 2, "0", STR_PAD_LEFT)  . "</option>";
            }
            ?>            
        </select>        
    </div>
        
    <div class="cellRow">
        <label for="end_time">End Time :</label>
         <select name="end_time[]">
           <?php 
            for($i=0; $i<=23; $i++){
                if(is_object($schedule->end_time) && $i == $schedule->end_time->format('G')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('end_time[]', $i, $status) . ">";
                echo str_pad($i, 2, "0", STR_PAD_LEFT)  . "</option>";
                
            }
            ?>          
        </select>
        <select name="end_time[]">
            <?php 
            for($i=0; $i<=45; $i += 15){
                if(is_object($schedule->end_time) && $i == $schedule->end_time->format('i')){
                    $status  = true;
                } else {
                    $status  = false;
                }
                
                echo "<option" . set_select('end_time[]', $i, $status) . ">";
                echo str_pad($i, 2, "0", STR_PAD_LEFT)  . "</option>";
            }
            ?>            
        </select>
    </div>
        
    <div class="cellRow">
        <label for="isRecurring">Recurring Daily?</label>
        <input type="checkbox" name="isRecurring" id="isRecurring" value="1" <?php   echo set_checkbox('isRecurring', '1', (bool)$schedule->isRecurring); ?> />
    </div>
        <br style="clear:left"/>
    <div>
        <h2 style="margin:0;">Recurring Days</h2>
        
        
        <?php             
        
        foreach($days as $day) {
            
            $status = false;
            if(array_search($day->id, $scheduled_days) !== false){ 
                $status = true;
            }
            
          echo '<div class="interest"><input type="checkbox" name="days[]" id="day_' . $day->id .  '" value="' . $day->id . '"' . 
                  set_checkbox("days[]", $day->id, $status) . ' /> <label for="day_' .$day->id . '">' . 
                  $day->name . '</label></div>';            
            
        } ?>
        <div style="clear:both"></div>
    </div>     
      
    
    <p><?php echo form_submit('submit', 'Save');?></p>
    <?php 
        echo form_hidden('id', set_value('id', $schedule->id));
        echo form_close();
    ?>
    </div>
</div>

<?php $this->load->view('footer')?>