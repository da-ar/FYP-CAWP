<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Locations</h1>    
    
    <div id="button_holder">
        <?= anchor('locations/add', 'Add a location', 'class="button green"') ?>
    </div>
       
    <table class="list">
        <tr>
            <th>Block</th>
            <th>Floor</th>
            <th>On the Mall?</th>
            <th>Edit</th>
            <th>Access Points</th>
        </tr>
        <?php  foreach($locations as $location) : ?>
        <tr>
            <td><?= $location->block ?></td>
            <td><?= $location->floor ?></td>
            <td><?php 
                if($location->isMall){  
                    echo " Yes";
                } else {
                    echo " ---";
                }
            ?></td>
            <td><?= anchor('locations/edit/' . $location->id, 'Edit') ?></td>
            <td><?= anchor('AccessPoints/index/' . $location->id, 'Edit Access Points') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>   
    
</div>
<?php $this->load->view('footer')?>