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
                            <th>Reference</th>
                            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
                            <th>Booker Type</th>
                            <?php endif; ?>
                            <th>Status</th>
                            <th>View</th>
                        </thead>
                        <tbody>
                            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
                                <?php 
                                $i = 1;
                                $checked = $conn->query("SELECT * FROM checked where status NOT IN ('1', '2') order by id desc");
                                while($row = $checked->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="text-center"><?php echo $cat_arr[$row['booked_cid']]['name'] ?></td>
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
                                    <?php if($row['status'] == 3): ?>
										<td class="text-center"><span class="badge badge-danger">Cancel</span></td>
                                    <?php else: ?>
										<td class="text-center"><span class="badge badge-info">Booked</span></td>
									<?php endif; ?>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary check_out" type="button" data-id="<?php echo $row['id'] ?>">View <span class="fas fa-eye"></span></button>
                                    <?php if($row['status'] != 1 && $row['status'] != 2 && $row['status'] != 3): ?>
                                            <button class="btn btn-sm btn-danger cancel" type="button" data-id="<?php echo $row['id'] ?>">Cancel <span class="fas fa-user-times"></span></button>
                                     <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
                                <?php 
								
							if(isset($_SESSION['login_id'])){
								$user = $conn->query("SELECT * FROM users where id =" . $_SESSION['login_id']);
								if($user->num_rows > 0){
									$row = $user->fetch_assoc();
									foreach($row as $k => $v){
										$meta[$k] = $v;
									}
								}
							}
								
                                $i = 1;
                                $checked = $conn->query("SELECT * FROM checked where std_stff_num = " . $meta['user_card_no'] . " order by id desc");
                                while($row = $checked->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="text-center"><?php echo $cat_arr[$row['booked_cid']]['name'] ?></td>
                                        <td class=""><?php echo $row['ref_no'] ?></td>
									<?php if($row['status'] == 1): ?>
										<td class="text-center"><span class="badge badge-warning">Booked-In</span></td>
									<?php elseif($row['status'] == 2): ?>
										<td class="text-center"><span class="badge badge-success">Booked-Out</span></td>
                                    <?php elseif($row['status'] == 3): ?>
										<td class="text-center"><span class="badge badge-danger">Cancel</span></td>
                                    <?php else: ?>
										<td class="text-center"><span class="badge badge-info">Booked</span></td>
									<?php endif; ?>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary check_out" type="button" data-id="<?php echo $row['id'] ?>">View <span class="fas fa-eye"></span></button>
                                    <?php if($row['status'] != 1 && $row['status'] != 2 && $row['status'] != 3): ?>
                                            <button class="btn btn-sm btn-danger cancel" type="button" data-id="<?php echo $row['id'] ?>">Cancel <span class="fas fa-user-times"></span></button>
                                     <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
<script>
	$('table').dataTable()
	$('.check_out').click(function(){
		uni_modal("Booked Request","manage_booked_out.php?checkout=1&id="+$(this).attr("data-id"))
	})
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
			url:'ajax.php?action=cancel_book',
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
<?php endif; ?>
<?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
<script>
	$('table').dataTable()
	$('.check_out').click(function(){
		uni_modal("Details Result","manage_booked_view.php?checkout=1&id="+$(this).attr("data-id"))
	})
	$('.cancel').click(function(){
		_conf("Are you sure to cancel this booking?","cancel",[$(this).attr('data-id')])
	})
	function cancel($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=cancel_book',
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
<?php endif; ?>