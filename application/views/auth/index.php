<?php $this->load->view('header')?>
<div id="sub_page_container">
	<h1>Users</h1>
	
        <?php if($message != '') : ?>
	<div id="infoMessage"><?php echo $message;?></div>
        <?php endif; ?>
        
        <div id="button_holder">
            <?= anchor('auth/create_user', 'Create a new user', 'class="button green"') ?> 
        </div>
	
	<table  class="list">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Group</th>
			<th>Status</th>
		</tr>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo $user['name']?></td>
				<td><?php echo $user['email'];?></td>
				<td><?php echo $user['group_description'];?></td>
				<td><?php echo ($user['active']) ? anchor("auth/deactivate/".$user['id'], 'Active') : anchor("auth/activate/". $user['id'], 'Inactive');?></td>
			</tr>
		<?php endforeach;?>
	</table>
        
</div>    	
<?php $this->load->view('footer')?>
