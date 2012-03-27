<?php if ($this->ion_auth->logged_in()) : ?>
<ul>
    <li><a onclick="reloadApp();">Refresh Location</a></li>
    <li><a href="/profile/timetable">Your Timetable</a></li>
    <li><a href="/profile">Your Profile</a></li>
    <li><a href="/auth/logout">Sign Out</a></li>                
</ul>
<?php else : ?>
<ul>
    <li><a href="/auth/login" >Sign In</a></li>                
</ul>
<?php endif; ?>
<div style="clear:both"></div>