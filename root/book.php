<?php 
include('db_connect.php');

	session_start();
  if(!isset($_SESSION['login_id']))


$rid = '';

$calc_days = abs(strtotime($_GET['out']) - strtotime($_GET['in']));

$calc_days = ceil($calc_days / (60 * 60 * 24));

?>
<div class="container-fluid">
<?php if(!isset($_SESSION['login_type'])): ?>	
	<form action="" id="manage-check">
		<input type="hidden" name="cid" value="<?php echo isset($_GET['cid']) ? $_GET['cid']: '' ?>">
		<input type="hidden" name="rid" value="<?php echo isset($_GET['rid']) ? $_GET['rid']: '' ?>">
        <input type="hidden" name="booker_type" value="2">

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
			<input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo isset($_GET['in']) ? date("Y-m-d",strtotime($_GET['in'])): date("Y-m-d") ?>"  required readonly>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
			<label for="date_in_time">Booked Time</label>
			<input type="time" name="date_in_time" id="date_in_time" class="form-control" value="<?php echo isset($_GET['date_in']) ? date("H:i:s",strtotime($_GET['date_in'])): date("H:i:s") ?>"  required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label for="days">Days</label>
			<!--input class="form-control" value="<?php echo isset($_GET['in']) ? $calc_days: 1 ?>" readonly-->
            
            <input type="number" min ="1" name="days" id="days" class="form-control" value="<?php echo isset($_GET['in']) ? $calc_days: 1 ?>" required readonly>
        </div>
    </div>
</div>
	</form>
<?php endif; ?>

<?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2):  ?>
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
?>
	<form action="" id="manage-check">
		<input type="hidden" name="cid" value="<?php echo isset($_GET['cid']) ? $_GET['cid']: '' ?>">
		<input type="hidden" name="rid" value="<?php echo isset($_GET['rid']) ? $_GET['rid']: '' ?>">
		<input type="hidden" name="booker_type" value="1">

		<div class="form-group">
			<label for="name">Name Booker</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required readonly>
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
                    <input type="text" name="std_stff_num" id="std_stff_num" class="form-control" value="<?php echo isset($meta['user_card_no']) ? $meta['user_card_no']: '' ?>" required readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
            <label for="email">Email &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
            <label for="contact">Contact &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" required readonly>
                </div>
            </div>
        </div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
			<label for="date_in">Booked Date</label>
			<input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo isset($_GET['in']) ? date("Y-m-d",strtotime($_GET['in'])): date("Y-m-d") ?>"  required readonly>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
			<label for="date_in_time">Booked Time</label>
			<input type="time" name="date_in_time" id="date_in_time" class="form-control" value="<?php echo isset($_GET['date_in']) ? date("H:i:s",strtotime($_GET['date_in'])): date("H:i:s") ?>"  required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
			<label for="days">Days</label>
			<!--input class="form-control" value="<?php echo isset($_GET['in']) ? $calc_days: 1 ?>" readonly-->
            
            <input type="number" min ="1" name="days" id="days" class="form-control" value="<?php echo isset($_GET['in']) ? $calc_days: 1 ?>" required readonly>
        </div>
    </div>
</div>
	</form>
<?php endif; ?>       
</div>
<?php if(!isset($_SESSION['login_type'])): ?>
<script>
		$('#manage-check').submit(function(e){
    e.preventDefault();
    if ($('#name').val().trim() === '') {
        alert_toast('Please fill out the name field', 'danger');
        return; // Exit the function to prevent form submission
    }
		if ($('#std_stff_num').val().trim() === '') {
        alert_toast('Please fill out the card number field', 'danger');
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
		start_load()
		$.ajax({
			url:'root/ajax.php?action=save_book',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Booking successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
<?php endif; ?>
<?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2):  ?>
<script>
		$('#manage-check').submit(function(e){
    e.preventDefault();
    if ($('#name').val().trim() === '') {
        alert_toast('Please fill out the name field', 'danger');
        return; // Exit the function to prevent form submission
    }
	if ($('#std_stff_num').val().trim() === '') {
        alert_toast('Please fill out the card number', 'danger');
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
		start_load()
		$.ajax({
			url:'ajax.php?action=save_book',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Booking successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
<?php endif; ?>   