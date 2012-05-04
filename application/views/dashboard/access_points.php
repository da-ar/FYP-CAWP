<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Access Points</h1>    
    
    <div id="button_holder">
        <?= anchor('AccessPoints/add/' . $id, 'Add an access point', 'class="button green"') ?>
        <?= anchor('dashboard/locations', 'Back to locations', 'class="button green"') ?>
    </div>
    
    <table class="list">
        <tr>
            <th>Location</th>
            <th>BSSID</th>
            <th>Edit</th>
        </tr>
        <?php  foreach($aps as $ap) : ?>
        <tr>
            <td><?= $location ?></td>
            <td><?= $ap->bssid ?></td>
            <td><?= anchor('AccessPoints/edit/' . $ap->id, 'Edit') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>    
    
    
</div>
<?php $this->load->view('footer')?>