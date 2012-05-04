<?php $this->load->view('header')?>
<div id="sub_page_container">
    <h1>Dashboard</h1>    
    
    <div id="button_holder">
    <p>Welcome to the Ferret control center.</p>
    
    <br/>
    
    <?= anchor('/auth', 'Users', 'class="button green"'); ?> &nbsp;
    <?= anchor('/dashboard/services', 'Services', 'class="button green"'); ?>  &nbsp;
    <?= anchor('/dashboard/locations', 'Locations', 'class="button green"'); ?>  &nbsp;
    <?= anchor('/dashboard/interests', 'Interests', 'class="button green"'); ?>  &nbsp;
    </div>
    
</div>
<?php $this->load->view('footer')?>