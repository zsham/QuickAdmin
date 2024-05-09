
<style>
	nav#sidebar {
    background: url(../assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
</style>
<nav id="sidebar" class='mx-lt-5' >
		
		<div class="sidebar-list">
<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=booked" class="nav-item nav-booked"><span class='icon-field'><i class="fa fa-book"></i></span> Booked Request </a>
				<a href="index.php?page=check_in" class="nav-item nav-check_in"><span class='icon-field'><i class="fa fa-sign-in-alt"></i></span> Booked-Walkin </a>
				<a href="index.php?page=check_out" class="nav-item nav-check_out"><span class='icon-field'><i class="fa fa-sign-out-alt"></i></span> Booked-Out </a>
				<a href="index.php?page=report" class="nav-item nav-report"><span class='icon-field'><i class="fa fa-sign-out-alt"></i></span> Reporting </a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Item Category</a>
				<a href="index.php?page=items" class="nav-item nav-items"><span class='icon-field'><i class="fa fa-list"></i></span> Item List </a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> List Users</a>
				<a href="index.php?page=users_verify" class="nav-item nav-users_verify"><span class='icon-field'><i class="fa fa-user-secret"></i></span> Verify User</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> Site Settings</a>
				<a href="index.php?page=update_user" class="nav-item nav-update_user"><span class='icon-field'><i class="fa fa-users"></i></span> Admin Account </a>
			<?php endif; ?>
			<?php if($_SESSION['login_type'] == 2): ?>
			<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-book"></i></span> Booking Form </a>
			<a href="index.php?page=booked" class="nav-item nav-booked"><span class='icon-field'><i class="fa fa-list"></i></span> Checking Status </a>
			<a href="index.php?page=update_user" class="nav-item nav-update_user"><span class='icon-field'><i class="fa fa-users"></i></span> User Account </a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>