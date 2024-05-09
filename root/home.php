    <?php
    include('db_connect.php');
?>
<link href="../css/styles.css" rel="stylesheet" />
<style>
	.custom-menu {
        z-index: 1000;
	    position: absolute;
	    background-color: #ffffff;
	    border: 1px solid #0000001c;
	    border-radius: 5px;
	    padding: 8px;
	    min-width: 13vw;
}
a.custom-menu-list {
    width: 100%;
    display: flex;
    color: #4c4b4b;
    font-weight: 600;
    font-size: 1em;
    padding: 1px 11px;
}
	span.card-icon {
    position: absolute;
    font-size: 3em;
    bottom: .2em;
    color: #ffffff80;
}
.file-item{
	cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
    background: #80808024;
}
table th,td{
	/*border-left:1px solid gray;*/
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}
.candidate {
    margin: auto;
    width: 23vw;
    padding: 0 10px;
    border-radius: 20px;
    margin-bottom: 1em;
    display: flex;
    border: 3px solid #00000008;
    background: #8080801a;

}
.candidate_name {
    margin: 8px;
    margin-left: 3.4em;
    margin-right: 3em;
    width: 100%;
}
	.img-field {
	    display: flex;
	    height: 8vh;
	    width: 4.3vw;
	    padding: .3em;
	    background: #80808047;
	    border-radius: 50%;
	    position: absolute;
	    left: -.7em;
	    top: -.7em;
	}
	
	.candidate img {
    height: 100%;
    width: 100%;
    margin: auto;
    border-radius: 50%;
}
.vote-field {
    position: absolute;
    right: 0;
    bottom: -.4em;
}
</style>
<br />
<?php if($_SESSION['login_type'] == 1): ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3">
                        <div class="card bg-info">
                            <div class="card-body text-white">
                                <h5><b>Booking</b></h5>
                                <hr>
                                <span class="card-icon"><i class="fa fa-users"></i></span>
                                <h3 class="text-right"><b>
                                    <?php 
                                    echo $conn->query("SELECT * FROM `checked` WHERE `status`=0 ")->num_rows;
                                    ?>
                                </b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card bg-danger ml-3">
                            <div class="card-body text-white">
                                <h5><b>Cancel Booking</b></h5>
                                <hr>
                                <span class="card-icon"><i class="fa fa-users"></i></span>
                                <h3 class="text-right"><b>
                                    <?php 
                                    echo $conn->query("SELECT * FROM `checked` WHERE `status`=3 ")->num_rows;
                                    ?>
                                </b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card bg-warning ml-3">
                            <div class="card-body text-white">
                                <h5><b>Items Available</b></h5>
                                <hr>
                                <span class="card-icon"><i class="fa fa-tag"></i></span>
                                <h3 class="text-right"><b>                    
                                    <?php 
                                    echo $conn->query("SELECT * FROM `items` WHERE `status`=0 ")->num_rows;
                                    ?></b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card bg-success ml-3">
                            <div class="card-body text-white">
                                <h5><b>Items In-Used</b></h5>
                                <hr>
                                <span class="card-icon"><i class="fa fa-tag"></i></span>
                                <h3 class="text-right"><b>                    
                                    <?php 
                                    echo $conn->query("SELECT * FROM `items` WHERE `status`=1 ")->num_rows;
                                    ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="col-lg-12" style="background: #0000002e;">
     <h5><b>Total Per-Item Available</b></h5>
    </div>
	<div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row no-gutters" style="height: 150px;">
                	<?php
                	$qry = $conn->query("SELECT 
													item_categories.cover_img, 
													item_categories.name, 
													COUNT(items.item) AS sum_row 
												FROM 
													item_categories 
												JOIN 
													items ON item_categories.id = items.category_id
												WHERE
													items.status = 0 
												GROUP BY 
													item_categories.cover_img, 
													item_categories.name 
												ORDER BY 
													RAND();
												
												");
                	while($row = $qry->fetch_assoc()):
                	?>
                    <div class="col-lg-4 col-sm-5">
                        <a class="portfolio-box" href="#">
                            <img class="img-fluid" src="../assets/img/<?php echo $row['cover_img'] ?>" alt="" />
                            <div class="portfolio-box-caption">
                  <div class="project-name"><?php echo $row['name'] ?></div><br />
                         <div><h3><?php echo $row['sum_row'] ?></h3></div>
                            </div>
                        </a>
                    </div>
                	<?php endwhile; ?>

                </div>
            </div>
        </div>
    
</div>
<?php endif; ?>

<?php if($_SESSION['login_type'] == 2): ?>
        <link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<?php
$date_in = isset($_POST['date_in']) ? $_POST['date_in'] : date('Y-m-d');
$date_out = isset($_POST['date_out']) ? $_POST['date_out'] : date('Y-m-d',strtotime(date('Y-m-d').' + 1 days'));
?>

<div class="col-lg-12">	
						<div class="card">
							<div class="card-body">	
									<form action="index.php?page=home" id="filter" method="POST">
			        					<div class="row">
			        						<div class="col-md-3">
			        							<label for="">Start Date</label>
			        							<input type="text" class="form-control datepicker" name="date_in" autocomplete="off" value="<?php echo isset($date_in) ? date("Y-m-d",strtotime($date_in)) : "" ?>">
			        						</div>
			        						<div class="col-md-3">
			        							<label for="">End Date</label>
			        							<input type="text" class="form-control datepicker" name="date_out" autocomplete="off" value="<?php echo isset($date_out) ? date("Y-m-d",strtotime($date_out)) : "" ?>">
			        						</div>
			        						<div class="col-md-3">
			        							<br>
			        							<button class="btn-btn-block btn-primary mt-3">Check Availability</button>
			        						</div>

			        					</div>
			        				</form>
							</div>
						</div>	

						<hr>	
						
						<?php 
						
						 $cat = $conn->query("SELECT * FROM item_categories");
						$cat_arr = array();
						while($row = $cat->fetch_assoc()){
							$cat_arr[$row['id']] = $row;
						}
						
					$qry = $conn->query("SELECT DISTINCT i.category_id, i.category_id
											FROM items AS i
											LEFT JOIN checked AS c ON i.id = c.item_id
											WHERE (c.item_id IS NULL 
												   OR ('$date_in' NOT BETWEEN date(c.date_in) AND date(c.date_out) 
													   AND '$date_out' NOT BETWEEN date(c.date_in) AND date(c.date_out)))
												AND i.status='0'");

							while($row= $qry->fetch_assoc()):

						?>
						<div class="card item-items mb-3">
							<div class="card-body">
								<div class="row">
								<div class="col-md-5">
									<img src="../assets/img/<?php echo $cat_arr[$row['category_id']]['cover_img'] ?>" alt="">
								</div>
								<div class="col-md-5" height="100%">

									<h4><b>
										<?php echo $cat_arr[$row['category_id']]['name'] ?>
									</b></h4>
                                    <br />
									<h6><?php echo $cat_arr[$row['category_id']]['desc'] ?></h6>

									<div class="align-self-end mt-5">
										<button class="btn btn-primary  float-right book_now" type="button" data-id="<?php echo $row['category_id'] ?>">Book now</button>
									</div>
								</div>
							</div>

							</div>
						</div>
						<?php endwhile; ?>
				</div>	
		</div>	
<style type="text/css">
	.item-items img {
    width: 23vw;
}
</style>
<script>
	$('.book_now').click(function(){
		uni_modal('Book','book.php?in=<?php echo $date_in ?>&out=<?php echo $date_out ?>&cid='+$(this).attr('data-id'))
	})
</script>
 <script>
 	$('.datepicker').datepicker({
 		format:"yyyy-mm-dd"
 	})
 	 window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }

 	window.uni_modal = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                $('#uni_modal').modal('show')
                end_load()
            }
        }
    })
}
window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
 </script>
 <!-- Bootstrap core JS-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
<?php endif; ?>