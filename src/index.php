<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DEMO by Morteza Khaki</title>
	<!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap"/>
    <!-- MDB -->
    <link rel="stylesheet" href="assets/css/mdb.min.css" />
	
	<!-- Custom Style -->
	<link rel="stylesheet" href="assets/css/main.css" />
	
	
  </head>
  <body>
  <div class="container p-5">
  
		<?php
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://localhost/d3/api/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json;charset=UTF-8'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$response = json_decode($response, true);

		echo '<h4 class="mt-2">All Records (using cURL and REST API):</h4>';
		echo '<div class="table-responsive allRecords mb-3">';
		echo '<table class="table table-bordered table-sm table-hover bg-white">';
		echo '<thead class="bg-light">

			<tr>

			  <th>ID</th>

			  <th>First Name</th>

			  <th>Last Name</th>

			  <th>City</th>

			  <th>Num Val #1</th>
			  
			  <th>Date</th>
			  
			  <th>Num Val #2</th>

			</tr>

		  </thead>';
		  
		  echo '<tbody>';
			foreach ($response as $row) {
				echo '<tr>';
				foreach ($row as $col) {
					echo '<td>';
					echo $col;
					echo '</td>';
				}
				echo '</tr>';
			}
		  echo '</tbody>';
		echo '</table>';
		echo '</div>';
		?>


	<div class="row mt-4 mb-4">
		<div class="col-md-4">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">PUL request</h5>
				<hr>
				<p class="card-text small">This will send a PUL request to the server via RESTful API.</p>
				<form id="pulRequest">
					<div class="form-outline mb-3">
						<input type="text" id="pul1" class="form-control" name="postID"/>
						<label class="form-label" for="pul1">Post ID</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul2" class="form-control"  name="first_name"/>
						<label class="form-label" for="pul2">First Name</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul3" class="form-control"  name="last_name"/>
						<label class="form-label" for="pul3">Last Name</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul4" class="form-control"  name="city"/>
						<label class="form-label" for="pul4">City</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul5" class="form-control"  name="nummeric_one"/>
						<label class="form-label" for="pul5">Nummeric Val #1</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul6" class="form-control"  name="date"/>
						<label class="form-label" for="pul6">Date</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pul7" class="form-control"  name="nummeric_two"/>
						<label class="form-label" for="pul7">Nummeric Val #2</label>
					</div>
					<button id="pulRequestSubmit" class="btn btn-warning" type="submit">Update</button>
					<div id="pulRequestSubmitRes"></div>
				</form>
			  </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">POST request</h5>
				<hr>
				<p class="card-text small">This will send a POST request to the server via RESTful API.</p>
				<form id="postRequest">
					<div class="form-outline mb-3">
						<input type="text" id="pos1" class="form-control" name="postID" disabled/>
						<label class="form-label" for="pos1">Post ID (AUTO)</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos2" class="form-control"  name="first_name"/>
						<label class="form-label" for="pos2">First Name</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos3" class="form-control"  name="last_name"/>
						<label class="form-label" for="pos3">Last Name</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos4" class="form-control"  name="city"/>
						<label class="form-label" for="pos4">City</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos5" class="form-control"  name="nummeric_one"/>
						<label class="form-label" for="pos5">Nummeric Val #1</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos6" class="form-control"  name="date"/>
						<label class="form-label" for="pos6">Date</label>
					</div>
					<div class="form-outline mb-3">
						<input type="text" id="pos7" class="form-control"  name="nummeric_two"/>
						<label class="form-label" for="pos7">Nummeric Val #2</label>
					</div>
					<button id="posRequestSubmit" class="btn btn-success" type="submit">Post</button>
					<div id="posRequestSubmitRes"></div>
				</form>
				
			  </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card mb-4">
			  <div class="card-body">
				<h5 class="card-title">DELETE request</h5>
				<hr>
				<p class="card-text small">This will send a DELETE request to the server via RESTful API.</p>
				<form id="deleteRequest">
					<div class="form-outline mb-3">
						<input type="text" id="del1" class="form-control" name="postID"/>
						<label class="form-label" for="del1">Post ID</label>
					</div>
					<button id="delRequestSubmit" class="btn btn-danger" type="submit">Delete</button>
					<div id="delRequestSubmitRes"></div>
				</form>
				
			  </div>
			</div>
			
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">Create Dummy Records</h5>
				<hr>
				<p class="card-text small">This will send a request to the server via Ajax to create 100 dummy records.</p>
				<form id="createRecords">
					<button id="createRecordsSubmit" class="btn btn-primary position-relative" type="submit">Create 100 records</button> 						
				</form>
				
			  </div>
			</div>
		</div>
		
	</div>



	
	<div class="row mb-3">
		<div class="col">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">Last 5 Records using jQuery Ajax and REST API (auto refresh every 5 sec) <div class="spinner-grow spinner-grow-sm text-secondary float-end" role="status"><span class="visually-hidden">Loading...</span></div></h5>
				<hr>
				<div id="getAllAjax"></div>
				
			  </div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">Data visualization using D3.js (auto refresh every 5 sec) <div class="spinner-grow spinner-grow-sm text-primary float-end" role="status"><span class="visually-hidden">Loading...</span></div></h5>
				<hr>
				<div id="d3BarChart"></div>
				
			  </div>
			</div>
		</div>
	</div>


		
	

</div>

<script src="assets/js/jquery-3.6.1.min.js"></script>
<!-- MDB -->
<script type="text/javascript" src="assets/js/mdb.min.js"></script>
<!-- d3 -->
<script type="text/javascript" src="assets/js/d3.v7.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>