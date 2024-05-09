<?php include('db_connect.php'); 

$cat = $conn->query("SELECT * FROM item_categories");
$cat_arr = array();
while($row = $cat->fetch_assoc()){
	$cat_arr[$row['id']] = $row;
}
$item = $conn->query("SELECT * FROM items");
$item_arr = array();
while($row = $item->fetch_assoc()){
	$item_arr[$row['id']] = $row;
}

?>


<link rel="stylesheet" href="assets/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap4.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">
<br />
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="container-fluid">
							<div class="col-md-12">
								<form id="filter">
									<div class="row">
										<div class=" col-md-3">
											<label class="control-label">Category</label>
											<select class="custom-select browser-default" name="category_id">
												<option value="all" <?php echo isset($_GET['category_id']) && $_GET['category_id'] == 'all' ? 'selected' : '' ?>>All</option>
												<?php 
												$cat = $conn->query("SELECT * FROM item_categories order by name asc ");
												while($row= $cat->fetch_assoc()) {
													$cat_name[$row['id']] = $row['name'];
													?>
													<option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['category_id']) && $_GET['category_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
												<?php
												}
												?>
											</select>
										</div>
                                        	<div class="col-md-3">
			        							<label for="">Start Date</label>
			        							<input type="text" class="form-control datepicker" name="date_in" autocomplete="off" value="<?php echo isset($date_in) ? date("Y-m-d",strtotime($date_in)) : "" ?>">
			        						</div>
			        						<div class="col-md-3">
			        							<label for="">End Date</label>
			        							<input type="text" class="form-control datepicker" name="date_out" autocomplete="off" value="<?php echo isset($date_out) ? date("Y-m-d",strtotime($date_out)) : "" ?>">
			        						</div> 
										<div class="col-md-2">
											<label for="" class="control-label">&nbsp</label>
											<button class="btn btn-block btn-primary">Filter<span class="fas fa-filter"></span></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
<table id="dtble" class="table table-bordered table-hover">
<thead>
								<th>#</th>
								<th>Booker</th>
                                <th>Email</th>
                                <th>Category</th>
								<th>Item</th>
                                <th>Type</th>
                                <th>Date In</th>
                                <th>Date Out</th>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$where = '';
								$where1 = '';
								$where2 = '';
								
					$date_bookin = isset($_GET['date_in']) ? $_GET['date_in'] : date('Y-m-d');
					$date_bookout = isset($_GET['date_out']) ? $_GET['date_out'] : date('Y-m-d');
								
					if(isset($_GET['category_id']) && !empty($_GET['category_id'])  && $_GET['category_id'] != 'all'){
									$where .= " WHERE items.category_id = '".$_GET['category_id']."' ";
								}
					if(isset($_GET['date_in']) && !empty($_GET['date_in'])){
									$where1 .= " AND '".$date_bookin."' BETWEEN DATE(checked.date_in) AND DATE(checked.date_out) ";
								}
					if(isset($_GET['date_out']) && !empty($_GET['date_out'])){
									$where2 .= " AND '".$date_bookout."' BETWEEN DATE(checked.date_in) AND DATE(checked.date_out) ";
								}


					$checked = $conn->query("SELECT * FROM checked 
											INNER JOIN items ON checked.item_id = items.id 
											$where $where1 $where2
											AND checked.status != '0' ORDER BY checked.date_in DESC");
								
								
								while($row=$checked->fetch_assoc()):
								
								$checked2 = $conn->query("SELECT items.item, COUNT(*) AS count FROM checked 
															INNER JOIN items ON checked.item_id = items.id 
															$where $where1 $where2 GROUP BY items.item");
								
								$data = $checked2->fetch_all(MYSQLI_ASSOC);
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['email_user'] ?></td>
                                    <td class="text-center"><?php echo $cat_arr[$item_arr[$row['item_id']]['category_id']]['name'] ?></td>
									<td class=""><?php echo $item_arr[$row['item_id']]['item'] ?></td>
                                    <?php if($row['booked_type'] == 1): ?>
										<td class="text-center"><span class="badge badge-purple">Register</span></td>
									<?php elseif($row['booked_type'] == 2): ?>
										<td class="text-center"><span class="badge badge-maroon">Not Register</span></td>
									<?php elseif($row['booked_type'] == 3): ?>
                                  	    <td class="text-center"><span class="badge badge-navy">Walk-In</span></td>
                                    <?php else : ?>
                                  	    <td class="text-center"><span class="badge badge-default">-</span></td>
									<?php endif; ?>
                                    <td><?php echo $row['date_in'] ?></td>
                                    <td><?php echo $row['date_out'] ?></td>
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
        
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-footer" style="text-align: right;">
                <button class="btn btn-secondary" onclick="printCharts()">Print Charts</button>
            </div><br>
            <div id="print" class="card-body" style="display: flex; justify-content: space-between;">
                <div style="width: 62%;">
                    <canvas id="barChart"></canvas><br>
                </div>
                <div style="width: 30%;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
	</div>
</div>
<script>
    function printCharts() {
        // Get the container element for printing
        var container = document.getElementById('print');

        // Create a new window to contain the charts
        var printWindow = window.open('', '_blank');

        // Write the HTML content to the new window
        printWindow.document.write('<html><head><title>Print Charts</title></head><body>');
        printWindow.document.write('<h3>Statistic Faculty Booking Management System (FBMS)<h3><br>');
        printWindow.document.write(container.innerHTML);

        // Get the canvas elements and their contexts
        var barChartCanvas = printWindow.document.getElementById('barChart');
        var pieChartCanvas = printWindow.document.getElementById('pieChart');
        var barChartContext = barChartCanvas.getContext('2d');
        var pieChartContext = pieChartCanvas.getContext('2d');

        // Get the canvas drawings from the original canvas elements
        var barChartDrawings = document.getElementById('barChart').toDataURL();
        var pieChartDrawings = document.getElementById('pieChart').toDataURL();

        // Create new Image objects and set their src to the canvas drawings
        var barChartImage = new Image();
        var pieChartImage = new Image();
        barChartImage.src = barChartDrawings;
        pieChartImage.src = pieChartDrawings;

        // After the images load, draw them onto the canvas elements in the print window
        barChartImage.onload = function() {
            barChartContext.drawImage(barChartImage, 0, 0);
            pieChartImage.onload = function() {
                pieChartContext.drawImage(pieChartImage, 0, 0);
                // Print the content in the new window
                printWindow.print();
                // Close the new window after printing
                printWindow.close();
            };
        };

        printWindow.document.write('</body></html>');
    }
</script>


<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>
<script src="assets/js/responsive.bootstrap4.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.bootstrap4.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>
<script src="assets/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#dtble").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#dtble_wrapper .col-md-6:eq(0)');
  });
	$('.check_in').click(function(){
		uni_modal("Booked In","manage_booked_in.php?rid="+$(this).attr("data-id"))
	})
$('#filter').submit(function(e){
    e.preventDefault();
    var category_id = $(this).find('[name="category_id"]').val();
	var date_in = $(this).find('[name="date_in"]').val();
    var date_out = $(this).find('[name="date_out"]').val();
    location.replace('index.php?page=report&category_id='+category_id+'&date_in='+date_in+'&date_out='+date_out);
});

</script>
    <script>
        // Data for the charts
        var data = <?php echo json_encode($data); ?>;

        // Prepare data for bar chart
        var barData = {
            labels: data.map(item => item.item),
            datasets: [{
                label: 'Count',
                data: data.map(item => item.count),
                backgroundColor: 'rgba(0, 64, 125)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Prepare data for pie chart
        var pieData = {
            labels: data.map(item => item.item),
            datasets: [{
                data: data.map(item => item.count),
                backgroundColor: [
                    'rgba(235,218,54)',
                    'rgba(54,235,127)',
                    'rgba(235,54,162)',
					'rgba(235,127,54)',
					'rgba(54,235,218)',
					'rgba(235,54,72)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Render bar chart
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: barData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Render pie chart
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: pieData,
        });
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
        </script>