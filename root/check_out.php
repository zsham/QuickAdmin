<?php include('db_connect.php'); 
$cat = $conn->query("SELECT * FROM item_categories");
$cat_arr = array();
while($row = $cat->fetch_assoc()){
	$cat_arr[$row['id']] = $row;
}
$item = $conn->query("SELECT * FROM items");
$item_arr = array();
while($row = $item->fetch_assoc()){
	$item_arr[$row['id']] = $row;
}
?>
<style>
.badge-maroon {
    background-color: maroon;
    color: white; /* Optionally, you can adjust the text color for better contrast */
}
.badge-purple {
    background-color: purple;
    color: white; /* Optionally, you can adjust the text color for better contrast */
}
.badge-navy {
    background-color: navy;
    color: white; /* Optionally, you can adjust the text color for better contrast */
}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th>#</th>
								<th>Category</th>
								<th>Item</th>
								<th>Reference</th>
                                <th>Booker Type</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$checked = $conn->query("SELECT * FROM checked where status != 0 AND item_id != '' order by status ASC, date_in desc ");
								while($row=$checked->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo $cat_arr[$item_arr[$row['item_id']]['category_id']]['name'] ?></td>
									<td class=""><?php echo $item_arr[$row['item_id']]['item'] ?></td>
									<td class=""><?php echo $row['ref_no'] ?></td>
                                    <?php if($row['booked_type'] == 1): ?>
										<td class="text-center"><span class="badge badge-purple">Register</span></td>
									<?php elseif($row['booked_type'] == 2): ?>
										<td class="text-center"><span class="badge badge-maroon">Not Register</span></td>
									<?php elseif($row['booked_type'] == 3): ?>
                                  	    <td class="text-center"><span class="badge badge-navy">Walk-In</span></td>
                                    <?php else : ?>
                                  	    <td class="text-center"><span class="badge badge-default">-</span></td>
									<?php endif; ?>
									<?php if($row['status'] == 1): ?>
										<td class="text-center"><span class="badge badge-warning">Booked-In</span></td>
									<?php elseif($row['status'] == 2): ?>
										<td class="text-center"><span class="badge badge-success">Booked-Out</span></td>
                                    <?php elseif($row['status'] == 3): ?>
										<td class="text-center"><span class="badge badge-danger">Cancel</span></td>
									<?php else: ?>
										<td class="text-center"><span class="badge badge-success">Booked</span></td>
									<?php endif; ?>
									<td class="text-center">
											<button class="btn btn-sm btn-primary check_out" type="button" data-id="<?php echo $row['id'] ?>"><span class="fas fa-edit"></span></button>
                                    <?php if($row['status'] != 2 && $row['status'] != 3): ?>
                                            <button class="btn btn-sm btn-danger cancel" type="button" data-id="<?php echo $row['id'] ?>">Cancel <span class="fas fa-user-times"></span></button>
                                     <?php endif; ?>
									</td>
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('table').dataTable()
	//$('.check_out').click(function(){
		//uni_modal("Booked Out","manage_booked_out.php?checkout=1&id="+$(this).attr("data-id"))
	//})
	$(document).on('click', '.check_out', function(){
    uni_modal("Booked Out", "manage_booked_out.php?checkout=1&id=" + $(this).data("id"));
	});
	$('#filter').submit(function(e){
		e.preventDefault()
		location.replace('index.php?page=check_in&category_id='+$(this).find('[name="category_id"]').val()+'&status='+$(this).find('[name="status"]').val())
	})
	$('.cancel').click(function(){
		_conf("Are you sure to cancel this booking?","cancel",[$(this).attr('data-id')])
	})
	function cancel($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=cancel_book_admin',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully cancel",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>