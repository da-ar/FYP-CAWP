<?php $this->load->view('header')?>
<div id="sub_page_container">
    
    <h1>Schedule for: <?= $service->name; ?></h1>    
    
    <div id="button_holder">
        <?= anchor('schedules/add/' . $service->id, 'Create a new Schedule', 'class="button green"') ?>
        <?= anchor('services/edit/' . $service->id, 'Return to service', 'class="button green"') ?>
    </div>
    
     <table class="list">
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Recurring?</th>
            <th>Recurring Days</th>
            <th>Edit</th>
        </tr>
        <?php foreach($service->Schedule as $schedule): ?>
        <tr>
            <td><?php if($schedule->start_date){echo $schedule->start_date->format('D d F Y');} ?></td>
            <td><?php if($schedule->end_date){echo $schedule->end_date->format('D d F Y');} ?></td>
            <td><?php if($schedule->start_time){echo $schedule->start_time->format('H:i');} ?></td>
            <td><?php if($schedule->end_time){echo $schedule->end_time->format('H:i');} ?></td>
            <td><?= $schedule->isRecurring ? 'true' : 'false'; ?></td>
            <td>
                <?php foreach($schedule->Days as $day) {
                    echo $day->name . ",";                    
                }
                ?>
            </td>
            <td>
                <?= anchor('schedules/edit/' . $schedule->id, 'Edit') ?>
            </td>
        </tr>     
        <?php endforeach;  ?>        
    </table>   
    
</div>
<?php $this->load->view('footer')?>