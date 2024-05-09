 <?php 
include('db_connect.php');
$rid = isset($_GET['id']) ? $_GET['id'] : null;
	
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$qry = $conn->query("SELECT * FROM checked where id =".$id);
	if($qry->num_rows > 0){
		foreach($qry->fetch_array() as $k => $v){
			$meta[$k]=$v;
		}
		$booked_cid = $meta['booked_cid'];
		$get_id = $meta['item_id'];
	}
	
	$calc_days = abs(strtotime($meta['date_out']) - strtotime($meta['date_in'])) ; 
 	$calc_days =floor($calc_days / (60*60*24)  );
  	$calc_days = max($calc_days, 1);
 
$cat = $conn->query("SELECT * FROM item_categories");
$cat_arr = array();
while($row = $cat->fetch_assoc()){
	$cat_arr[$row['id']] = $row;
}
}
?>
<div class="container-fluid">
	
	<form action="" id="manage-check">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<?php if(isset($_GET['id'])):
			$items = $conn->query("       
		SELECT * 
        FROM items
        WHERE items.category_id = '".$booked_cid."'
        ORDER BY items.item ASC");

		 ?>

		<div class="form-group">
			<label for="name">Item</label>
			<select name="rid" id="" class="custom-select browser-default">
				
				<?php while($row=$items->fetch_assoc()): ?>
<option value="<?php echo $row['id'] ?>" <?php echo $row['id'] == $get_id ? "selected": ''; ?> <?php echo $row['status'] == 1 ? 'disabled' : ''; ?>>
    <?php echo $row['item'] . " | " . ($cat_arr[$row['category_id']]['name']) . " | " . ($row['status'] == 0 ? 'Available' : 'Unavailable'); ?>
</option>
				<?php endwhile; ?>
			</select>
			
		</div>

		<?php else: ?>
		<input type="hidden" name="rid" value="<?php echo isset($_GET['rid']) ? $_GET['rid']: '' ?>">
        		<?php if(isset($_GET['rid'])) :
			$cate = $conn->query("       
		SELECT * 
        FROM items
        WHERE items.id = '".$_GET['rid']."'
		");

        // Fetch the row from the result set
        $row = $cate->fetch_assoc();
        
        // Access the category_id column
        $category_id = $row['category_id'];
		 ?>
        <input type="hidden" name="cid" value="<?php echo $category_id ?>">
                <input type="hidden" name="booker_type" value="3">
		<?php endif; ?>
        <?php endif; ?>


		<div class="form-group">
    <label for="name">Name &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select name="type" id="type" class="custom-select">
                            <option value="2" <?php echo isset($meta['user_type']) && $meta['user_type'] == 2 ? 'selected': '' ?>>Staff / Student</option>
                        </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="staff_num">Staff / Matrix Num. &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
            <input type="text" name="std_stff_num" id="std_stff_num" class="form-control" value="<?php echo isset($meta['std_stff_num']) ? $meta['std_stff_num']: '' ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email_user']) ? $meta['email_user']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact_no']) ? $meta['contact_no']: '' ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
    <label for="date_in">Booked Date</label>
    <input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo isset($meta['date_in']) ? date("Y-m-d",strtotime($meta['date_in'])): date("Y-m-d") ?>" required>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
			<label for="date_in_time">Booked Time</label>
			<input type="time" name="date_in_time" id="date_in_time" class="form-control" value="<?php echo isset($meta['date_in']) ? date("H:i",strtotime($meta['date_in'])): date("H:i") ?>" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label for="days">Days</label>
			<input type="number" min ="1" name="days" id="days" class="form-control" value="<?php echo isset($meta['date_in']) ? $calc_days: 1 ?>" required>
        </div>
    </div>
</div>
	</form>
</div>
<script>
	$('#manage-check').submit(function(e){
		e.preventDefault();
    if ($('#name').val().trim() === '') {
        alert_toast('Please fill out the name field', 'danger');
        return; // Exit the function to prevent form submission
    }
    if ($('#email').val().trim() === '') {
        alert_toast('Please fill out the email field', 'danger');
        return; // Exit the function to prevent form submission
    }
	if ($('#contact').val().trim() === '') {
        alert_toast('Please fill out the contact number', 'danger');
        return; // Exit the function to prevent form submission
    }
    if ($('#std_stff_num').val().trim() === '') {
        alert_toast('Please fill out the card number field', 'danger');
        return; // Exit the function to prevent form submission
    }
		start_load()
		$.ajax({
			url:'ajax.php?action=save_check-in',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp >0){
					alert_toast("Booking successfully saved",'success')
					uni_modal("Check-in Details","manage_booked_out.php?id="+resp)
					setTimeout(function(){
				//	end_load()
				location.reload()
					},1500)
				}
			}
		})
	})
</script>