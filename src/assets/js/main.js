$(document).ready(function() {
	
	

	// Retrive last 5 records
	var timeout;
	function getLastFive() {
		var settings = {
		  "url": "http://localhost/d3/api/five",
		  "method": "GET",
		  "timeout": 0,
		  "headers": {
			"Content-Type": "application/json;charset=UTF-8"
		  },
		};

		$.ajax(settings).then(function(data) {
			
			var getAllAjax;
			getAllAjax = '<div class="table-responsive"><table class="table table-bordered table-sm table-hover bg-white"><thead class="bg-light"><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>City</th><th>Num Val #1</th><th>Date</th><th>Num Val #2</th></tr></thead><tbody>';
			
			for (const row of data) {
				
				getAllAjax +='<tr><td>'+row.id+'</td><td>'+row.first_name+'</td><td>'+row.last_name+'</td><td>'+row.city+'</td><td>'+row.nummeric_one+'</td><td>'+row.date+'</td><td>'+row.nummeric_two+'</td></tr>';
				
			}
			
			getAllAjax +='</tbody></table>';
			
			$('#getAllAjax').html(getAllAjax);
		});
		
		timeout = setTimeout(getLastFive,5000);
	}
	
	getLastFive();
	
	

	// Create 100 dummy records
	$('#createRecords').on('submit', function (e) {

          e.preventDefault();
		
          $('#createRecordsSubmit').html('Create 100 records'); 
		
          $.ajax({
            type: 'post',
            url: 'create_records.php',
            data: '',
            beforeSend: function() {
                $('#createRecordsSubmit').attr('disabled', true);
                $('#createRecordsSubmit').html('<div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            complete: function() {
                $('#createRecordsSubmit').attr('disabled', false);             
            },  
            success: function(data) {
				$('#createRecordsSubmit').html('Create 100 records <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-success">Added<span class="visually-hidden">Added</span></span>'); 
            }
			
          });

    });
	
	
	
	// pulRequest
	$('#pulRequest').on('submit', function (e) {

          e.preventDefault();
		
          var values = {
			"first_name": 	$("#pul2").val(),
			"last_name": 	$("#pul3").val(),
			"city": 		$("#pul4").val(),
			"nummeric_one": 	$("#pul5").val(),
			"date": 			$("#pul6").val(),
			"nummeric_two": 	$("#pul7").val(),
          };
		
          $('#pulRequestSubmit').html('Update'); 
		  $('#pulRequestSubmitRes').html(''); 
		  
		  
          $.ajax({
            type: 'PUT',
            url: 'api/'+ $("#pul1").val(),
            data: JSON.stringify(values),
            beforeSend: function() {
                $('#pulRequestSubmit').attr('disabled', true);
                $('#pulRequestSubmit').html('<div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            complete: function() {
                $('#pulRequestSubmit').attr('disabled', false);   
				$('#pulRequestSubmit').html('Update'); 				
            },  
            success: function(data) {
				$('#pulRequestSubmitRes').html('<div class="alert alert-success mt-2 small" role="alert" data-mdb-color="success">Successfully updated.</div>'); 
            },
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				$('#pulRequestSubmitRes').html('<div class="alert alert-danger mt-2 small" role="alert" data-mdb-color="success">Error: '+ errorThrown +'</div>');
			} 
			
          });

    });
	
	
	
	// postRequest
	$('#postRequest').on('submit', function (e) {

          e.preventDefault();
		
          var values = {
			"first_name": 	$("#pos2").val(),
			"last_name": 	$("#pos3").val(),
			"city": 		$("#pos4").val(),
			"nummeric_one": 	$("#pos5").val(),
			"date": 			$("#pos6").val(),
			"nummeric_two": 	$("#pos7").val(),
          };
		
          $('#posRequestSubmit').html('Post'); 
		  $('#posRequestSubmitRes').html(''); 
		  
		  
          $.ajax({
            type: 'POST',
            url: 'api/',
            data: JSON.stringify(values),
            beforeSend: function() {
                $('#posRequestSubmit').attr('disabled', true);
                $('#posRequestSubmit').html('<div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            complete: function() {
				$('#posRequestSubmit').attr('disabled', false);   
				$('#posRequestSubmit').html('Post'); 				
            },
            success: function(data) {
				$('#posRequestSubmitRes').html('<div class="alert alert-success mt-2 small" role="alert" data-mdb-color="success">Successfully posted.</div>'); 
            },
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				$('#posRequestSubmitRes').html('<div class="alert alert-danger mt-2 small" role="alert" data-mdb-color="success">Error: '+ errorThrown +'</div>');
			} 
			
          });

    });
	
	
	// deleteRequest
	$('#deleteRequest').on('submit', function (e) {

          e.preventDefault();
			
          $('#delRequestSubmit').html('Delete'); 
		  $('#delRequestSubmitRes').html(''); 		  
		  
          $.ajax({
            type: 'DELETE',
            url: 'api/'+$("#del1").val(),
            data: '',
            beforeSend: function() {
                $('#delRequestSubmit').attr('disabled', true);
                $('#delRequestSubmit').html('<div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            complete: function() {
                $('#delRequestSubmit').attr('disabled', false);   
				$('#delRequestSubmit').html('Delete'); 				
            },  
            success: function(data) {
				$('#delRequestSubmitRes').html('<div class="alert alert-success mt-2 small" role="alert" data-mdb-color="success">Successfully deleted.</div>'); 
            },
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				$('#delRequestSubmitRes').html('<div class="alert alert-danger mt-2 small" role="alert" data-mdb-color="success">Error: '+ errorThrown +'</div>');
			} 
          });
    });
});



/*****************************
********* D3.js Bar Chart
******************************/
let xmlhttp = new XMLHttpRequest();
let svg;

const svgSize = {
	width: 1150,
	height: 500
}

const padding = {
	x: 60,
	y: 30
}

const createCanvas = () => {

	const svg = d3.select("#d3BarChart")
					.html("")
					.append("svg")
					.attr("width", svgSize.width)
					.attr("height", svgSize.height);
					
	return svg;
	
}

const sendRequestToAPI = (xmlhttp) => {
	const url = "http://localhost/d3/api/";
	const method = "GET";
	xmlhttp.open(method, url, true);
	return xmlhttp;
}

const defineScales = (dates, numVals) => {
	
	// find min and max of whole array of dates (convert string to Js Date)
	const minDate = d3.min(dates, (d) => new Date(d));
	const maxDate = d3.max(dates, (d) => new Date(d));
	
	// we just need max numVals because min is 0
	const maxNumVal = d3.max(numVals, (d) => d);
	
	const xScale = d3.scaleTime()
						.domain([minDate, maxDate])
						.range([padding.x, svgSize.width - padding.x / 3]); // 3 is just a number to set the right padding less than left padding
						
	const yScale = d3.scaleLinear()
						.domain([0, maxNumVal])
						.range([svgSize.height - padding.y, padding.y]);
						
	return {xScale, yScale};
	
};

const createAxes = (scales, svg) => {
	svg.append('g')
		.attr("id", "x-axis")
		.call(d3.axisBottom(scales.xScale))
		.attr("transform", `translate(0, ${svgSize.height - padding.y + 2})`);
		
	svg.append('g')
		.attr("id", "y-axis")
		.call(d3.axisLeft(scales.yScale))
		.attr("transform", `translate(${padding.x - 2})`);
};


const createBars = (dates, numVals, scales) => {
	svg.selectAll("rect")
		.data(numVals)
		.enter()
		.append("rect")
		.attr("x", (d, i) => scales.xScale(new Date (dates[i]))) //(d, i) d: single data, i: index
		.attr("y", (d) => scales.yScale(d))
		.transition()
		.attr("width", (svgSize.width - padding.x * 1.33) / numVals.length)
		.attr("height", (d) => svgSize.height - scales.yScale(d) - padding.y)
		.attr("class", "bar")
		.attr("data-date", (d, i) => dates[i])
		.attr("data-numVal", (d) => d)
};

xmlhttp.onload = () => {
	const dates = [];
	const numVals = [];
	const dataset = JSON.parse(xmlhttp.responseText);
	dataset.forEach(element => {
		numVals.push(element.nummeric_one);
		dates.push(element.date);
	});
	
	const scales = defineScales(dates,numVals);
	createAxes(scales, svg);
	createBars(dates, numVals, scales);
}

var timeoutChart;

const myChartInit = () => {
	svg = createCanvas();
	xmlhttp = sendRequestToAPI(xmlhttp);
	xmlhttp.send();
	
	timeoutChart = setTimeout(myChartInit,500000);	
}
myChartInit();