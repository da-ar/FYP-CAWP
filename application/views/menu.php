<?php if ($this->ion_auth->logged_in()) : ?>
<ul>
    <?php if($this->ion_auth->is_admin() || $this->ion_auth->is_group('service_user')) : ?>         
        <li><a href="/dashboard">Dashboard</a></li>
    <?php endif; ?>
    <li><a href="/profile">Your Profile</a></li>
    <li><a href="/auth/logout">Sign Out</a></li>                
</ul>
<?php else : ?>
<ul>
    <li><a href="/auth/login" >Sign In</a></li>                
</ul>
<?php endif; ?>
<div style="clear:both"></div>