<?php
$date_in = isset($_POST['date_in']) ? $_POST['date_in'] : date('Y-m-d');
$date_out = isset($_POST['date_out']) ? $_POST['date_out'] : date('Y-m-d',strtotime(date('Y-m-d').' + 1 days'));
?>

	 <!-- Masthead-->
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                    	 <h1 class="text-uppercase text-white font-weight-bold">items</h1>
                        <hr class="divider my-4" />
                    </div>
                    
                </div>
            </div>
        </header>

<section class="page-section bg-dark">
		
		<div class="container">	
				<div class="col-lg-12">	
						<div class="card">
							<div class="card-body">	
									<form action="index.php?page=list" id="filter" method="POST">
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
											   OR ('$date_in' BETWEEN date(c.date_in) AND date(c.date_out) 
												   AND '$date_out' BETWEEN date(c.date_in) AND date(c.date_out) AND c.status IN ('2', '3')))
											AND i.status='0';
										");
 
							while($row= $qry->fetch_assoc()):

						?>
						<div class="card item-items mb-3">
							<div class="card-body">
								<div class="row">
								<div class="col-md-5">
									<img src="assets/img/<?php echo $cat_arr[$row['category_id']]['cover_img'] ?>" alt="">
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
</section>
<style type="text/css">
	.item-items img {
    width: 23vw;
}
</style>
<script>
	$('.book_now').click(function(){
		uni_modal('Book','root/book.php?in=<?php echo $date_in ?>&out=<?php echo $date_out ?>&cid='+$(this).attr('data-id'))
	})
</script>