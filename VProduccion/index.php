<!DOCTYPE html>

<html>

	<head>

		<title>Basic Example with Twitter Bootstrap</title>

        <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='css/DateTimePicker.css' />
		
	
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>	
		<script type="text/javascript" src="js/DateTimePicker.js"></script>
    
		
	
	</head>

	<body>

		<div class="container">

			<div class="row">
			
				<!------------------------ Date Picker ---------------------->
				
				<div class="form-group">
					<p>Date : </p>
					<input type="text"  data-field="date" data-format="yyyy-mm-dd" readonly>
				</div>
			
				<!------------------------ Time Picker ---------------------->
				<div class="form-group">
					<p>Time : </p>
					<input type="text" class="form-control" data-field="time" data-format="hh:mm" readonly>
				</div>
			
				<!---------------------- DateTime Picker -------------------->
				<div class="form-group">
					<p>DateTime : </p>
					<input type="text" class="form-control" data-field="datetime" data-format="yyyy-MM-dd HH:mm:ss" readonly>
				</div>
	
			</div>

		</div>

		<div id="dtBox"></div>
    
		<script type="text/javascript">
		
			$(document).ready(function()
			{
				$("#dtBox").DateTimePicker({
				
					dateFormat: "yyyy-MM-dd",
					timeFormat: "HH:mm",
					dateTimeFormat: "MM-dd-yyyy HH:mm:ss AA"
				
				});
			});
		
		</script>
	
		<!-- Default dateFormat: "dd-MM-yyyy" 
			
				dateFormat Options : 
					1. "dd-MM-yyyy"
					2. "MM-dd-yyyy"
					3. "yyyy-MM-dd"
				
				Specify (data-min & data-max) / (minDate & maxDate) values in the same dateFormat specified in settings parameters	
		-->
	
		<!-- Default timeFormat: "HH:mm"  
			
				timeFormat Options : 
					1. "HH:mm"
					2. "hh:mm AA"
				
				Specify (data-min & data-max) / (minTime & maxTime) values in the same timeFormat specified in settings parameters			
		-->
	
		<!-- Default dateTimeFormat: "dd-MM-yyyy HH:mm:ss"  
		
				dateTimeFormat Options : 
					1. "dd-MM-yyyy HH:mm:ss"
					2. "dd-MM-yyyy hh:mm:ss AA"
					3. "MM-dd-yyyy HH:mm:ss"
					4. "MM-dd-yyyy hh:mm:ss AA"
					5. "yyyy-MM-dd HH:mm:ss"
					6. "yyyy-MM-dd hh:mm:ss AA"
			
				Specify (data-min & data-max) / (minDateTime & maxDateTime) values in the same dateTimeFormat specified in settings parameters		
		-->
	
	</body>

</html>