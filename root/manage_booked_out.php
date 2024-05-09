<?php 
include('db_connect.php');
if($_GET['id']){
	$id = $_GET['id'];
	$qry = $conn->query("SELECT * FROM checked where id =".$id);
	if($qry->num_rows > 0){
		foreach($qry->fetch_array() as $k => $v){
			$$k=$v;
		}
	}
	if($item_id > 0){
	$item = $conn->query("SELECT * FROM items where id =".$item_id)->fetch_array();
	$cat = $conn->query("SELECT * FROM item_categories where id =".$item['category_id'])->fetch_array();
}else{
	$cat = $conn->query("SELECT * FROM item_categories where id =".$booked_cid)->fetch_array();

}
 $calc_days = abs(strtotime($date_out) - strtotime($date_in)) ; 
 $calc_days = floor($calc_days / (60*60*24)  );
 $calc_days = max($calc_days, 1);
}
?>
<style>
	.container-fluid p{
		margin: unset
	}
	#uni_modal .modal-footer{
		display: none;
	}
</style>
<div class="container-fluid">
	<p><b>Items : </b><?php echo isset($item['item']) ? $item['item'] : 'NA' ?></p><br />
	<p><b>Item Category : </b><?php echo $cat['name'] ?></p><br />
	<p><b>Reference no : </b><?php echo $ref_no ?></p><br />
	<p><b>Name : </b><?php echo $name ?></p><br />
	<p><b>Contact no : </b><?php echo $contact_no ?></p><br />
	<p><b>Booked-in Date/Time : </b><?php echo date("M d, Y h:i A",strtotime($date_in)) ?></p><br />
	<p><b>Booked-out Date/Time : </b><?php echo date("M d, Y h:i A",strtotime($date_out)) ?></p><br />
	<p><b>Days : </b><?php echo $calc_days ?></p><br />
	
		<div class="row">
			<?php if(isset($_GET['checkout']) && $status != 2): ?>
<?php if($item_id != NULL): ?>
    <div class="col-md-6">
    <?php if($status != 3): ?>
        <button type="button" class="btn btn-primary" id="checkout">Booked-out / Return</button>
        <?php endif ?>
    </div>
<?php else: ?>
    <div class="col-ms-1">
        <?php echo isset($item['item']) ? $item['item'] : ''; ?>
    </div>
<?php endif; ?>
				<div class="col-md-3">
                <?php if($status != 3): ?>
					<button type="button" class="btn btn-primary" id="edit_checkin"><span class="fas fa-edit"></span></button>
                     <?php endif ?>
				</div>
		<?php endif; ?>	
				<div class="col-md-3">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fas fa-reply"></span></button>
				</div>
		
		</div>
</div>
<script>
	$(document).ready(function(){
		
	})
	$('#edit_checkin').click(function(){
		uni_modal("Edit Booked Request Into Booked-In","manage_booked_in.php?id=<?php echo $id ?>&rid=<?php echo $item_id ?>")
	})
	$('#checkout').click(function(){
		start_load()
		$.ajax({
			url:'ajax.php?action=save_checkout',
			method:'POST',
			data:{id:'<?php echo $id ?>',rid:'<?php echo $item_id ?>'},
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>