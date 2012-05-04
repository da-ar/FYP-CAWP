<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Interests</h1>    
    
    <div id="button_holder">
        <?= anchor('interests/add', 'Add an interest', 'class="button green"') ?>
    </div>
    
    <table class="list">
        <tr>
            <th>Name</th>
            <th>Edit</th>
        </tr>
        <?php  foreach($interests as $interest) : ?>
        <tr>
            <td><?= $interest->name ?></td>
            <td><?= anchor('interests/edit/' . $interest->id, 'Edit') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>    
    
    
</div>
<?php $this->load->view('footer')?>