<h1><?= $service[0]->name; ?></h1>
<br />

<?php if($service[0]->url != '') : ?>
    <p><a href="<?= $service[0]->url; ?>" class="button green"><b>Visit:</b> <?= $service[0]->name; ?></a></p>
<?php endif; ?>
    
<br />
<div id="info_details">
    <?= nl2br($service[0]->body); ?>
    
    <br /><br />
    
    <h2>Schedule</h2>
    
    <?php 
    $currentItem = 0;
    foreach($service[0]->Schedule as $schedule): ?>
        
        <?php 
        
        $currentItem++;
        
        if($schedule->isRecurring) : ?>
            Runs on the following days: 
                
                <?php foreach($schedule->Days as $day) {
                    echo $day->name . ", ";                    
                }
                ?>            
            
                <br />
        <?php endif; ?>
        <?php
            
            if($schedule->start_date){
                echo "<b>Starting:</b> ";
                echo $schedule->start_date->format('D d F Y');
            }
            
            if($schedule->end_date){
                echo " <b>Ending:</b> ";
                echo $schedule->end_date->format('D d F Y');
            }
            
            if($schedule->start_time){
                echo " <b>Kicking off at:</b> ";
                echo $schedule->start_time->format('H:i');
                
            }
            
            if($schedule->end_time){
                echo " <b>Finishing by:</b> ";
                echo $schedule->end_time->format('H:i');
            }
            
            if(count($service[0]->Schedule) > $currentItem){
                echo "<hr />";
            }
            
        ?>    
            
    <?php endforeach;  ?>
    
    <br /><br />
    
    <h2>Related Interests</h2>
    
    <ul>
    <?php
        foreach($service[0]->Interests as $interest){
            echo "<li>" . $interest->name . "</li>";
        }
    ?>
    </ul>
    
</div>