<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['setting_faculty_name'] ?></title>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
	position: absolute;
	left: 1px;
	width: 60%;
	height: calc(100%);
	background: #00000061;
	display: flex;
	align-items: center;
	}
	#login-right .card{
		margin: auto
	}
	.logo {
	    margin: auto;
	    font-size: 8rem;
	    background: white;
	    padding: .5em 0.8em;
	    border-radius: 50% 50%;
	    color: #000000b3;
	}
	#login-left {
	  background: url(../assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
	  background-repeat: no-repeat;
	  background-size: cover;
	}
</style>

<body>
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <main id="main" class=" alert-info">
    <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()"><span class="fas fa-save"></span></button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fas fa-reply"></span></button>
      </div>
      </div>
    </div>
  </div>
  		<div id="login-left">
  			<!-- == logo or image here == -->
		<div style="background: #0000002e;">
			<a class="nav-link js-scroll-trigger" href="../index.php"><h3 class="text-uppercase text-white font-weight-bold" style="text-align: center;"><?php echo $_SESSION['setting_faculty_name'] ?></h3></a>
			<hr class="divider my-3" />
		</div>
  		</div>
  		<div id="login-right">
  			<div class="card col-md-9"><br>
			                    	 <h5 class="text-orange font-weight-bold" style="text-align: center;">Faculty Booking Mangement System</h5><br><h1 class="text-orange font-weight-bold" style="text-align: center;">FBMS</h1>
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">User ID</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
  				</div>
				<center>
				
				<button class="btn-sm btn-block btn-wave col-md-9 btn-default mt-6" id="register_user">Register as New Booker</button>
				</center><br>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
    $(document).ready(function(){
        $('#login-form').submit(function(e){
            e.preventDefault();
            $('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
            if($(this).find('.alert-danger').length > 0 )
                $(this).find('.alert-danger').remove();
            $.ajax({
                url:'ajax.php?action=login',
                method:'POST',
                data:$(this).serialize(),
                error:function(err){
                    console.log(err);
                    $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                },
                success:function(resp){
                    if(resp == 1){
                        location.href ='index.php?page=home';
                    }else if(resp == 2){
                        location.href ='index.php?page=home';
                    }else{
                        $('#login-form').prepend('<div class="alert alert-danger">User ID or password is incorrect.</div>');
                        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });

        $('#register_user').click(function(){
            uni_modal('New Booker Registration Form ', 'manage_user.php');
        });

        window.start_load = function(){
            $('body').prepend('<div id="preloader2"></div>');
        };

        window.end_load = function(){
            $('#preloader2').fadeOut('fast', function() {
                $(this).remove();
            });
        };

        window.uni_modal = function($title = '', $url=''){
            start_load();
            $.ajax({
                url: $url,
                error: function(err){
                    console.log(err);
                    alert("An error occurred");
                },
                success: function(resp){
                    if(resp){
                        $('#uni_modal .modal-title').html($title);
                        $('#uni_modal .modal-body').html(resp);
                        $('#uni_modal').modal('show');
                        end_load();
                    }
                }
            });
        };

        window._conf = function($msg='', $func='', $params = []){
            $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
            $('#confirm_modal .modal-body').html($msg);
            $('#confirm_modal').modal('show');
        };

        window.alert_toast = function($msg = 'TEST', $bg = 'success'){
            $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');

            if($bg == 'success')
                $('#alert_toast').addClass('bg-success');
            if($bg == 'danger')
                $('#alert_toast').addClass('bg-danger');
            if($bg == 'info')
                $('#alert_toast').addClass('bg-info');
            if($bg == 'warning')
                $('#alert_toast').addClass('bg-warning');

            $('#alert_toast .toast-body').html($msg);
            $('#alert_toast').toast({delay:3000}).toast('show');
        };

        $('#preloader').fadeOut('fast', function() {
            $(this).remove();
        });
    });
</script>


</html>