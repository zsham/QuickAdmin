<?php include('db_connect.php');?>

<div class="container-fluid">
	<br />
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-item">
				<div class="card">
					<div class="card-header">
						    Item List Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Item</label>
								<input type="text" class="form-control" name="item">
							</div>
							<div class="form-group">
								<label class="control-label">Category</label>
								<select class="custom-select browser-default" name="category_id">
									<?php 
									$cat = $conn->query("SELECT * FROM item_categories order by name asc ");
									while($row= $cat->fetch_assoc()) {
										$cat_name[$row['id']] = $row['name'];
										?>
										<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Availability</label>
								<select class="custom-select browser-default" name="status">
									<option value="0">Available</option>
									<option value="1">Unavailable</option>

								</select>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"><span class="fas fa-window-restore"></span></button>
								<button class="btn btn-sm btn-warning col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"><span class="fas fa-reply"></span></button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Category</th>
									<th class="text-center">Item</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$items = $conn->query("SELECT * FROM items order by id asc");
								while($row=$items->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>

								
									<td class="text-center"><?php echo $cat_name[$row['category_id']] ?></td>
									<td class=""><?php echo $row['item'] ?></td>
									<?php if($row['status'] == 0): ?>
										<td class="text-center"><span class="badge badge-success">Available</span></td>
									<?php else: ?>
										<td class="text-center"><span class="badge badge-danger">Unavailable</span></td>
									<?php endif; ?>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-item="<?php echo $row['item'] ?>" data-category_id="<?php echo $row['category_id'] ?>" data-status="<?php echo $row['status'] ?>"><span class="fas fa-edit"></span></button>
										<button class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>"><span class="fas fa-trash"></span></button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>

<script>
$('table').dataTable()
	$('#manage-item').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_item',
			method:"POST",
			data: $(this).serialize(),
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_cat').click(function(){
		start_load()
		var cat = $('#manage-item')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='item']").val($(this).attr('data-item'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		cat.find("[name='status']").val($(this).attr('data-status'))
		end_load()
	})
	$('.delete_cat').click(function(){
		_conf("Are you sure to delete this item?","delete_cat",[$(this).attr('data-id')])
	})
	function delete_cat($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_item',
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