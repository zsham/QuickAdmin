<?php 
include('db_connect.php');

	session_start();
  if(!isset($_SESSION['login_id']))

?>
<div class="container-fluid">
 <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): 
 
 if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="username">Username (Staff/Matrix)</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
			<label for="password">Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="password" id="password" class="form-control" value="" required>
        </div>
    </div>
</div>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1):  ?>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Faculty Administrator</option>
            <?php endif; ?>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Booker (Staff / Student)</option>
			</select>
		</div>
	</form>
<script>
	$('#manage-user').submit(function(e){
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
    if ($('#username').val().trim() === '') {
        alert_toast('Please fill out the card number field', 'danger');
        return; // Exit the function to prevent form submission
    }
    if ($('#password').val().trim() === '') {
        alert_toast('Please create your password', 'danger');
        return; // Exit the function to prevent form submission
    }
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("User successfully Register",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
<?php else: ?>
	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="username">Username (Staff/Matrix) &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
			<label for="password">Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="password" id="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['id']: '' ?>" required>
        </div>
    </div>
</div>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1):  ?>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Faculty Administrator</option>
            <?php endif; ?>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Booker (Staff / Student)</option>
			</select>
		</div>
	</form>
<script>
	$('#manage-user').submit(function(e){
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
    if ($('#username').val().trim() === '') {
        alert_toast('Please fill out the card number field', 'danger');
        return; // Exit the function to prevent form submission
    }
    if ($('#password').val().trim() === '') {
        alert_toast('Please create your password', 'danger');
        return; // Exit the function to prevent form submission
    }		
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Thank you, successful registration. Please wait for the faculty to confirm.",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
<?php endif; ?>
</div>
