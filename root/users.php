<?php 

?>

<div class="container-fluid">
<br />	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
                    <th class="text-center">User Type</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM users WHERE validate_user='1' AND name NOT LIKE '%Administrator%' order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td>
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo $row['name'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
                    <td>
				 		<?php echo $row['type'] == 1 ? 'Faculty Administrator' : 'Booker (Staff / Student)' ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>					<button type="button" class="btn btn-primary" id="edit_user"><span class="fas fa-edit"></span></button></a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_booker" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>					<button type="button" class="btn btn-danger"><span class="fas fa-trash"></span></button></a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable()
	$('#new_user').click(function(){
		uni_modal('New User','manage_user.php')
	})
	$('.edit_user').click(function(){
		uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
	})
	$('.delete_booker').click(function(){
		_conf("Are you sure to delete this User?","delete_booker",[$(this).attr('data-id')])
	})
	function delete_booker($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}

</script>