<?php include 'db_connect.php'; ?>

<div class="container-fluid">
<br />
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
 <h3>Account Details</h3>
 <br>           
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
                                $checked = $conn->query("SELECT * FROM users WHERE validate_user='1' AND username = " . $meta['user_card_no'] . " order by id desc");
                                while($row = $checked->fetch_assoc()):
                                ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" disabled>
		</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact</label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="username">Username (Staff/Matrix)</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" disabled>
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
        </div>
    </div>
</div>
<br>
            <div style="text-align: right;">
			<button class="btn btn-sm btn-primary edit_password" type="button" data-id="<?php echo $meta['id'] ?>"><span class="fas fa-cog"></span> Update Password</button>
</div>
				<?php endwhile; ?>
                <?php endif; ?>
			</div>
            
    <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
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
                                $checked = $conn->query("SELECT * FROM users WHERE validate_user='1' AND username = " . $meta['user_card_no'] . " order by id desc");
                                while($row = $checked->fetch_assoc()):
                                ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" disabled>
		</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['user_email']) ? $meta['user_email']: '' ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
    <label for="contact">Contact</label>
    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['user_phone_no']) ? $meta['user_phone_no']: '' ?>" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="username">Username (Staff/Matrix)</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" disabled>
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
        </div>
    </div>
</div>
<br>
            <div style="text-align: right;">
			<button class="btn btn-sm btn-primary edit_password" type="button" data-id="<?php echo $meta['id'] ?>"><span class="fas fa-cog"></span> Update Password</button>
</div><br>
				<?php endwhile; ?>
                <?php endif; ?>
			</div>            
		</div>
	</div>

</div>
<script>
	$('.edit_password').click(function(){
		uni_modal('Update Account Password','manage_password.php?id='+$(this).attr('data-id'))
	})
</script>