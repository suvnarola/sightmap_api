<?php
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL            => 'https://api.sightmap.com/v1/assets/1273/multifamily/units',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => '',
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => 'GET',
		CURLOPT_HTTPHEADER     => array(
			'API-Key: 7d64ca3869544c469c3e7a586921ba37'
		)
	));

	$response = curl_exec($curl);
	curl_close($curl);

	$data = json_decode($response);

	$unit_data = $data->data;

	$area_with_1    = array();
	$area_without_1 = array();

	$area_with_1 = array_filter($unit_data, function($var){
		if ($var->area == 1) {
	    	return $var;
		}else{
			return null;
		}
	});

	$area_without_1 = array_filter($unit_data, function($var){
		if ($var->area == 1) {
			return null;
		}else{
	    	return $var;
		}
	});
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

	<style type="text/css">
		@media screen and (max-width: 767px) {
		    li.paginate_button.previous {
		        display: inline;
		    }
		 
		    li.paginate_button.next {
		        display: inline;
		    }
		 
		    li.paginate_button {
		        display: none;
		    }
		}
	</style>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
</head>
<body class="p-3">
	<div class="row mt-3">
		<div class="col-md-12">
			<h3 class="pb-3">Unit List</h3>
			<div class="card">
				<div class="card-header">
				    <h5 class="card-title">Unit List with area 1</h5>
				</div>
				<div class="card-body">
					<table class="table table-striped table-bordered dt-responsive nowrap unit-table" style="width:100%">
					    <thead>
					        <tr>
					            <th>#</th>
					            <th>Unit Number</th>
					            <th>Area (SqFt)</th>
					            <th>Updated at</th>
					        </tr>
					    </thead>
					    <tbody>
					        <?php  
						        if (!empty($area_with_1)) {
						        	$i = 0;
						        	foreach ($area_with_1 as $key => $data_with) {
						        	$i = $i+1;
						    ?>
					    		<tr>
					    		    <td><?php echo $i; ?></td>
					    		    <td><?php echo $data_with->unit_number; ?></td>
					    		    <td><?php echo $data_with->area; ?></td>
					    		    <td><?php echo date('d-F-Y H:i:s', strtotime($data_with->updated_at)); ?></td>
					    		</tr>
						    <?php
						        	}
						        }
					        ?>
					    </tbody>
					    <tfoot>
					        <tr>
					            <th>#</th>
					            <th>Unit Number</th>
					            <th>Area (SqFt)</th>
					            <th>Updated at</th>
					        </tr>
					    </tfoot>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12 mt-5">
			<div class="card">
				<div class="card-header">
				    <h5 class="card-title">Unit List without area 1</h5>
				</div>
				<div class="card-body">
					<table class="table table-striped table-bordered dt-responsive nowrap unit-table" style="width:100%">
					    <thead>
					        <tr>
					            <th>#</th>
					            <th>Unit Number</th>
					            <th>Area (SqFt)</th>
					            <th>Updated at</th>
					        </tr>
					    </thead>
					    <tbody>
			                <?php  
			        	        if (!empty($area_without_1)) {
			        	        	$i = 0;
			        	        	foreach ($area_without_1 as $key => $data_without) {
			        	        	$i = $i+1;
			        	    ?>
			            		<tr>
			            		    <td><?php echo $i; ?></td>
			            		    <td><?php echo $data_without->unit_number; ?></td>
			            		    <td><?php echo $data_without->area; ?></td>
			            		    <td><?php echo date('d-F-Y H:i:s', strtotime($data_without->updated_at)); ?></td>
			            		</tr>
			        	    <?php
			        	        	}
			        	        }
			                ?>
					    </tbody>
					    <tfoot>
					        <tr>
					            <th>#</th>
					            <th>Unit Number</th>
					            <th>Area (SqFt)</th>
					            <th>Updated at</th>
					        </tr>
					    </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function () {
		    $('.unit-table').DataTable();
		});
	</script>
</body>
</html>