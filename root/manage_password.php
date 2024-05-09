<?php 
include('db_connect.php');

	session_start();
  if(!isset($_SESSION['login_id']))
  
$meta = []; // Initialize $meta as an empty array

if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users WHERE id =" . $_GET['id']);
    if($user && $user->num_rows > 0){
        $meta = $user->fetch_assoc();
        // You might need to check if $meta is not empty before using its values
    } else {
        // Handle case where user with the specified ID is not found
        echo "User not found!";
    }
}
?>
<div class="container-fluid">
 <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
	<form action="" id="manage-password">
		<input type="hidden" name="id" value="<?php echo $meta['id'] ?>">
        <div class="form-group">
			<label for="password">Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="password" id="password" class="form-control" value="" required>
        </div>
		<div class="form-group">
			<label for="password">Confirm Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="updt_password" id="updt_password" class="form-control" value="" required>
		</div>
	</form>
<script>
		$('#manage-password').submit(function(e){
			e.preventDefault(); // Prevent the default form submission
			
			// Check if the password field is empty
			if ($('#password').val().trim() === '') {
				alert_toast('Please create your new password', 'danger');
				return; // Exit the function to prevent form submission
			}
		
			// Check if the confirmation password field is empty
			if ($('#updt_password').val().trim() === '') {
				alert_toast('Please Confirm your password', 'danger');
				return; // Exit the function to prevent form submission
			}
			
			// Check if the passwords match
			if ($('#password').val().trim() !== $('#updt_password').val().trim()) {
				alert_toast('Passwords do not match', 'danger');
				return; // Exit the function to prevent form submission
			}
		
			// If all checks pass, proceed with form submission
			start_load();
			$.ajax({
				url: 'ajax.php?action=save_password',
				method: 'POST',
				data: $(this).serialize(),
				success: function(resp){
					if(resp == 1){
						alert_toast("Thank you, your account password has been updated succesfully.",'success');
						setTimeout(function(){
							location.reload();
						},1500);
					}
				}
			});
		});
</script>
<?php else: ?>
	<form action="" id="manage-password">
		<input type="hidden" name="id" value="<?php echo $meta['id'] ?>">
        <div class="form-group">
			<label for="password">Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="password" id="password" class="form-control" value="" required>
        </div>
		<div class="form-group">
			<label for="password">Confirm Password &nbsp;<span class="text-danger font-weight-bold" aria-hidden="true" title="required">*</span></label>
			<input type="password" name="updt_password" id="updt_password" class="form-control" value="" required>
		</div>
	</form>
<script>
		$('#manage-password').submit(function(e){
			e.preventDefault(); // Prevent the default form submission
			
			// Check if the password field is empty
			if ($('#password').val().trim() === '') {
				alert_toast('Please create your new password', 'danger');
				return; // Exit the function to prevent form submission
			}
		
			// Check if the confirmation password field is empty
			if ($('#updt_password').val().trim() === '') {
				alert_toast('Please Confirm your password', 'danger');
				return; // Exit the function to prevent form submission
			}
			
			// Check if the passwords match
			if ($('#password').val().trim() !== $('#updt_password').val().trim()) {
				alert_toast('Passwords do not match', 'danger');
				return; // Exit the function to prevent form submission
			}
		
			// If all checks pass, proceed with form submission
			start_load();
			$.ajax({
				url: 'ajax.php?action=save_password',
				method: 'POST',
				data: $(this).serialize(),
				success: function(resp){
					if(resp == 1){
						alert_toast("Thank you, your account password has been updated succesfully.",'success');
						setTimeout(function(){
							location.reload();
						},1500);
					}
				}
			});
		});
</script>
<?php endif; ?>
</div>
