<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Services</h1>    
    
    
    <div id="button_holder">
        <?= anchor('services/add', 'Add a service', 'class="button green"') ?>
    </div>
    
     <table class="list">
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Url</th>
            <th>Edit</th>
        </tr>
        <?php  foreach($services as $service) : ?>
        <tr>
            <td><?= $service->name; ?></td>
            <td><?php 
                if($service->Location){
                    echo $service->Location->getLocationString(); 
                } else {
                    echo "---";
                }
            ?></td>
            <td><?php 
                if($service->url != null){  
                    echo '<a href="' . $service->url .  '" target="_blank">' . $service->url . '</a>';
                } else {
                    echo " ---";
                }
            ?></td>
            <td><?= anchor('services/edit/' . $service->id, 'Edit') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>   
    
</div>
<?php $this->load->view('footer')?>