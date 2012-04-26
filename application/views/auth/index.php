<?php $this->load->view('header')?>
<div id="sub_page_container">
	<h1>Users</h1>
	<p>Below is a list of the users.</p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
	<table cellpadding="10" width="80%">
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
	
	<p><a href="<?php echo site_url('auth/create_user');?>">Create a new user</a></p>
	
	<p><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></p>
</div>    	
<?php $this->load->view('footer')?>
