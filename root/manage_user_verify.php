<?php 
include('db_connect.php');

if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
<div class="container-fluid">
	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" disabled>
            <input type="hidden" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" disabled>
        <input type="hidden" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" disabled>
    <input type="hidden" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="username">Username (Staff/Matrix)</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" disabled>
			<input type="hidden" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select" disabled>
            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1):  ?>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Faculty Administrator</option>
            <?php endif; ?>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Booker (Staff / Student)</option>
			</select>
			<input type="hidden" name="type" id="type" class="form-control" value="<?php echo isset($meta['login_type']) ? $meta['login_type']: '' ?>" required>
        </div>
    </div>
</div>
		<div class="form-group">
			<label for="verify">Verification for Access FBMS</label>
			<select name="verify" id="verify" class="custom-select">
				<option value="1" <?php echo isset($meta['validate_user']) && $meta['validate_user'] == 1 ? 'selected': '' ?>>Verified</option>
				<option value="2" <?php echo isset($meta['validate_user']) && $meta['validate_user'] == 2 ? 'selected': '' ?>>Not Verified</option>
			</select>
		</div>
	</form>
<script>
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user_verify',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("User successfully Verify",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
</div>
