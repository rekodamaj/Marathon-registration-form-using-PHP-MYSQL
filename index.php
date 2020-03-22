<?php require_once "header.php"; ?>

<div class="row justify-content-center align-content-center h-100">
	<div class="col-6">
		<div class="h-100 2-100 registerationFormContainer">
			<div>
				<h3>
					<i class="far fa-user-circle"></i> Registeration Form
				</h3>
			</div>
			<hr>
			<br>
			<form action="./registerationSuccess.php" >
				<div class="form-group">
					<label for="fullName">Full name:</label>
					<input type="fullName" class="form-control" id="fullName" placeholder="Enter your full name" name="fullName" required minlength="3">
				</div>
				<div class="form-group">
					<label for="dob">Date of Birth (M/D/Y): <span class="hint">Minimum age should not exceed 9 years</span> </label>
					<input type="dob" class="form-control" id="dob"  name="dob" placeholder="Click to select your Date of birth"   required  onkeydown="event.preventDefault()">
				</div>
				<div class="form-group">
					<label for="category">Select your desired category:</label>
					<select class="form-control"  id="category" name="category_id">
						<?php 
						$categories = selectFrom("categories");
						foreach ($categories as $key => $arr) {
							echo '<option value="'.$arr['id'].'">'.$arr['title'].'</option>';
						}
						?> 
					</select>
				</div>
				<button type="submit" class="btn btn-primary " id="button">Submit</button>

			</form>
		</div>
	</div>
</div>
</div>

<!-- BOOTSTRAP JS FILES -->
<script type="text/javascript" src="./assets/js/popper.min.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
<!-- END OF BS JS FIELS -->

<!-- SWAL -->
<script type="text/javascript" src="./assets/js/sweetalert.min.js"></script>
<!-- END OF SWAL -->

<!-- DATE PICKER JS -->
<script type="text/javascript" src="./assets/date-picker-gijgo-combined-1.9.13/js/gijgo.min.js"></script>
<script>

	var dob = getMinDOB();
	$('#dob').datepicker({
		uiLibrary: 'bootstrap4',
		maxDate:  dob,
		value:   dob.getDay() + "/" + dob.getMonth()  + "/" + (dob.getFullYear() - 1) 

	});

	function getMinDOB(){
		var date = new Date();
		date.setDate(date.getDate());

		console.log(new Date(date.getFullYear() - 8, 1, 1));
		return new Date(date.getFullYear() - 8, 1, 1);
	}
</script>
<!-- END OF DATEPICKER JS -->

<!-- AJAX -->
<script type="text/javascript">
	$(".registerationFormContainer form").submit(function(e) {
		e.preventDefault();

		$("#button").prop('disabled', true);
		$("#button").addClass('loading');
		$("#button").html('<i class="fas fa-circle-notch fa-spin fa-1x"></i>');

		var fullName = $("#fullName").val();
		var dob = $("#dob").val();
		var category_id = $("#category").val();

		$.ajax({
			url : './registerationSubmission.php',
			type : 'POST',
			data : {
				'fullName' : fullName,
				'dob' : dob,
				'category_id' : category_id
			},
			success : function(data){
				var obj = jQuery.parseJSON(data);
				// console.log(obj);
				if (obj.status < 0) {
					swal({
						title: "error",
						text: obj.data,
						icon: "error"
					});
					$("#button").prop('disabled', false);
					$("#button").removeClass('loading');
					$("#button").html('SUBMIT');
				} else {
					swal({
						title: "Congratulations!.",
						text: "You will be forwarded to see your Race number assigned",
						icon: "success",	
						button: false,
					});
					setTimeout(function(){
						window.location.href =  "./congrats.php?id="+ obj.value;
					}, 2000);

				}
			}
		});

	});
</script>
<!-- END OF AJAX -->
<?php require_once "footer.php"; ?>