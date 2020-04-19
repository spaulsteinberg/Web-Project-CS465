<!DOCTYPE html>
<html lang="en">
    <head>
      <title>ABET Website</title>
      <link rel="stylesheet" type="text/css" href="abet.css">
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
      <meta charset="UTF-8">
	  <?php session_start(); ?>
	  <script>
	  	var needToSave = false;
	  </script>
    </head>
  <body>
      <?php include 'nav.php' ?>
      <main class="main-container">
        <div class="main-content">
          <div class="results">
            <h1 class="container-header">Results<hr></h1>
            <div class="main-results-description">
              <p>Please enter the number of students who do not meet expectations, meet expectations, and exceed expectations. You can
              type directly into the boxes--you do not need to use arrows.
              </p>
            </div>
            <div class="outcome-description">
              <p id="embedded-description"></p>
            </div>
            <br>
            <table class="expectation-table">
              <tr>
                <th><strong>Not Meets Expectations</strong></th>
                <th ><strong>Meets Expectations</strong></th>
                <th><strong>Exceeds Expectations</strong></th>
                <th><strong>Total</strong></th>
              </tr>
            <tr>
				<form id="results-form" method="POST">
					<td><input type="number" id="notMeetsExpectations" min="0" value="0" required /></td>
					<td><input type="number" id=meetsExpectations min="0" value="0" required /></td>
					<td><input type="number" id=exceedsExpectations min="0" value="0" required /></td>
				</form>
					<td id="total"></td> <!-- keep outside of form to prevent dirty -->
            </tr>
            </table>
            <div class="save-results">
                <button class="save-results-btn" id="saveResults">Save Results</button>
            </div>
			<div id="inner-save"><p id="resultsSuccess"></p></div>
			<div id="inner-save"><p id="resultsFail"></p></div>
           <br><br><br>
            <hr class="end-results" align="center">
          </div>
          <div class="assessments">
            <h1 class="container-header">Assessment Plan<hr></h1>
            <div class="assessments-description">
              <ol>
                <li>Please enter your assessment plan for each outcome. The weights are percentages
                  from 0-100 and the weights should add up to 100%.
                </li>
                <li>Always press "Save Assessments" when finished, even if you removed as assessment. The trash can 
                  only removes an assessment from this screen&#9472;it does not remove it from the database until
                  you press "Save Assessments".
                </li>
              </ol>
            </div>
			<form id="assessment-form" method="POST">
            <table class="assessment-table">
              <tr>
                <th><strong>Weight (%)</strong></th>
                <th ><strong>Description</strong></th>
                <th><strong>Remove</strong></th>
              </tr>
            </table>
        <br>
        <div class="new-img-button">
          <input type="image" class ="new-button" src="new-button.PNG">
        </div>
        <div class="save-assessments">
          <button type="submit" class="save-assessments-btn" id="saveAssessments">Save Assessments</button>
        </div>
        </div>
		</form>
		<div id="inner-save-2"><p id="assessmentsSuccess"></p></div>
		<div id="inner-save-2"><p id="assessmentsFail"></p></div>
		<div id="inner-save-2"><p id="weightsNot100"></p></div>
		<br><br>
        <hr class="end-results" align="center">
        <div class="narrative-summary">
          <h1 class="container-header">Narrative Summary<hr></h1>
          <div class="main-narratives-description">
            <p>Please enter your name for each outcome, including the student strengths for the outcome, student
              weaknesses for the outcomes, and suggested actions for improving student attainment of each outcome.
              <br><br>
			  <form id="narrative-form" method="POST">
			  <div id="n-d">
				<strong class="narrative-separators">Strengths</strong>
				<br>
				<textarea class="narratives-strengths" id="strengths" rows="4" maxlength="2000" placeholder="None" required></textarea>
				<br><br>
				<strong class="narrative-separators">Weaknesses</strong>
				<textarea class="narratives-weaknesses" id="weaknesses" rows="4" maxlength="2000" placeholder="None" required></textarea>
				<br><br>
				<strong class="narrative-separators">Actions</strong>
				<textarea class="narratives-actions" id="actions" rows="4" maxlength="2000" placeholder="None"></textarea>
			</div>
			  </form>
            </p>
          </div>
          <div class="save-narratives">
            <button class="save-narratives-btn" id="saveNarrative">Save Narrative</button>
          </div>
        </div>
        </div>
		<div id="inner-save-3"><p id="narrativeSuccess"></p></div>
		<div id="inner-save-3"><p id="narrativeFail"></p></div>
      </main>
    </div>
	<script>
	/* need function like this because dom made in ajax calls */
	$(document).on("click", ".trash-pic", function(){
		console.log(this.id);
		$.ajax({
			url: 'deleteAssessment',
			method: 'post',
			data : {assessmentId: parseInt(this.id, 10)},
			success:function(response){
				if (response == 1){
					console.log("deleted");
				}
				else {
					console.log("did not delete from db...");
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failed: " + thrownError);
			}
		});
		$(this).closest("tr").remove(); //actually removes row
	});
	function getNarratives(){
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if (isNaN(outcome)){
			outcome = initids[0];
		}
		$.ajax({
			url: 'narrative.php',
			method: 'get',
			dataType: 'json',
			data: {sectionId: section, major: major, outcomeId: outcome},
			success:function(response){
				console.log(response);
				if (response == 0){
					console.log("no results in narratives");
				}
				else {
					/* .html(string).val() will decode the escape chars returned from server */
					for (var i = 0; i < response.length; i++){
						if (response[i]["strengths"] == ''){
							$(".narratives-strengths").attr('placeholder', 'None');
						}
						else {
							$(".narratives-strengths").html(response[i]["strengths"]).val();
						}
						if (response[i]["weaknesses"] == ''){
							$(".narratives-weaknesses").attr('placeholder', 'None');
						}
						else {
							$(".narratives-weaknesses").html(response[i]["weaknesses"]).val();
						}
						if (response[i]["actions"] == ''){
							$(".narratives-actions").attr('placeholder', 'None');
						}
						else {
							$(".narratives-actions").html(response[i]["actions"]).val();
						}
					}
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failed loading narratives");
			}
		});
	}
	function getAssessments(){	
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if (isNaN(outcome)){
			outcome = initids[0];
		}
		console.log("Outcome is: " + outcome + " init id's is: " + initids[0]);
		$.ajax({
			url: 'assessment.php',
			method: 'get',
			dataType: 'json',
			data: { sectionId: section, major: major, outcomeId: outcome },
			success:function(response){
				if (response == 0){
					console.log("Query empty or failed.");
					var table = $(".assessment-table");
					var colOne = '<tr><td class="weights"><input class="w" type="number" min="1" required></td>';
					var colTwo = '<td><textarea class="assess-description" rows="4" cols="110" maxlength="400" required></textarea></td>';
					var colThree = '<td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td></tr>';
					table.append(colOne + colTwo + colThree);
					console.log("created blank row");
				}
				else {
					var table = $(".assessment-table");
					var descriptions = new Array();
					var weights = new Array();
					for (var i = 0; i < response.length; i++){
						descriptions[i] = response[i]["assessmentDescription"];
						weights[i] = response[i]["weight"];
						console.log("ID's: " + response[i]["assessId"]);
						var colOne = '<tr><td class="weights"><input class="w" type="number" min="1" required></td>';
						var colTwo = '<td><textarea class="assess-description" rows="4" cols="110" maxlength="400" required></textarea></td>';
						var colThree = '<td class="trash-can"><input id="'+response[i]["assessId"]+'" type="image" class="trash-pic" src="trash.png" alt="trash.png"></td></tr>';
						table.append(colOne + colTwo + colThree);
					}
					$(".w").each(function(index){
						$(this).val(weights[index]);
					});
					$(".assess-description").each(function(index){
						$(this).html(descriptions[index]).val();
					});
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failed to get assessments");
				console.log(thrownError);
			}
		});
	}
	function getResults(){
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if (isNaN(outcome)){
			outcome = initids[0];
		}
		console.log("Major: " + major + " " + "section: " + section + " outcome: " + outcome);
		$.ajax({
			url: 'results.php',
			method: 'get',
			dataType: 'json',
			data: {sectionId: section, major: major, outcomeId: outcome},
			success:function(response){
				console.log(response);
				if (response == 0){
					$("#notMeetsExpectations").val(0);
					$("#meetsExpectations").val(0);
					$("#exceedsExpectations").val(0);
					$("#total").html(0);
				}
				else {
					$("#notMeetsExpectations").val(response[0]["numberOfStudents"]);
					$("#meetsExpectations").val(response[1]["numberOfStudents"]);
					$("#exceedsExpectations").val(response[2]["numberOfStudents"]);
					$("#total").html(response[0]["numberOfStudents"]+response[1]["numberOfStudents"]+response[2]["numberOfStudents"]);
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log(thrownError);
				console.log("results failed");
			}
		});
	}
	/* on save go through each and make ajax calls for each performance level. update html as well */
	$(".save-results-btn").click(function(e){
		e.preventDefault();
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if(isNaN(outcome)){
			outcome = initids[0];
		}
		var exceeds; var meets; var notMeets;
		if ($("#exceedsExpectations").val() == '' || parseInt($("#exceedsExpectations").val(), 10) < 0 ){
			resultsErrorMessage();
			return false;
		}
		else exceeds = parseInt($("#exceedsExpectations").val(), 10);
		if ($("#meetsExpectations").val() == '' || parseInt($("#meetsExpectations").val(), 10) < 0 ){
			resultsErrorMessage();
			return false;
		}
		else meets = parseInt($("#meetsExpectations").val(), 10);
		if ($("#notMeetsExpectations").val() == '' || parseInt($("#notMeetsExpectations").val(), 10) < 0 ){
			resultsErrorMessage();
			return false;
		}
		else notMeets = parseInt($("#notMeetsExpectations").val(), 10);
		var total = exceeds + meets + notMeets;
		console.log("total: " + total);
		var numberOfStudents = [exceeds, meets, notMeets];
		var performanceLevels = [3, 2, 1];
		var success = true;
		for (var i = 0; i < performanceLevels.length; i++){
			$.ajax({
				url: 'updateResults.php',
				method: 'post',
				data: {
						sectionId: section,
						major: major,
						outcomeId: outcome,
						performanceLevel: performanceLevels[i],
						numberOfStudents: numberOfStudents[i]
				},
				success:function(response){
					if (response == 1){
						success = true;
						console.log("update success");
					}
					else{
						success = false;
						console.log("sum went rong bruh: " + response);
					}
				},
				error:function(xhr, ajaxOptions, thrownError){
					console.log("update failure");
					console.log(thrownError);
					success = false;
				}

			});	
		}
		if (success){
			needToSave = false;
			resultsSuccessMessage();	
			$("#exceedsExpectations").val(exceeds);
			$("#meetsExpectations").val(meets);
			$("#notMeetsExpectations").val(notMeets);
			$("#total").html(total);
		}
		else {
			resultsErrorMessage();
		}
	});
	function resultsSuccessMessage(){
		$("#resultsSuccess").html("Results successfully saved");
		$("#resultsSuccess").css("color", "black");
		$("#resultsSuccess").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	function resultsErrorMessage(){
		$("#resultsFail").html("Results unsuccessfully saved");
		$("#resultsFail").css("color", "red");
		$("#resultsFail").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	/* new assessment button */
	$(".new-button").click(function(e){
		e.preventDefault();
		var table = $(".assessment-table");
		var colOne = '<tr><td class="weights"><input class="w" type="number" min="1"></td>';
		var colTwo = '<td><textarea class="assess-description" rows="4" cols="110" maxlength="400" required></textarea></td>';
		var colThree = '<td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td></tr>';
		table.append(colOne + colTwo + colThree);
	});
	/* save assessments */
	$(".save-assessments-btn").click(function(e){
		e.preventDefault();
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if (isNaN(outcome)){
			outcome = initids[0];
		}
		var weights = new Array();
		var descriptions = new Array();
		var assessmentIds = new Array();
		var weightSum = 0;
		var descriptionFlag = false;
		$(".w").each(function(index){
			if ($(this).val() == '' ||  parseInt($(this).val(), 10) < 0 || $(this).val() == 'e' || $(this).val() == 'E'){
				return false;
			}
			weights[index] = parseInt($(this).val(), 10);
			weightSum += weights[index];
			console.log(weightSum);
		});
		if (weightSum != 100){
			$("#weightsNot100").show();
			$("#weightsNot100").html("Weights must add to 100!");
			return false;
		}
		$("#weightsNot100").html(''); //clear error if successful
		$(".assess-description").each(function(index){
			if ($(this).val() == ''){
				descriptionFlag = true;
				console.log("empty description");
				return false;
			}
			descriptions[index] = $(this).val();
		});
		if (descriptionFlag){
			assessmentsErrorMessage();
			return false;
		}
		/* if it has an id it was loaded. if it doesnt we need to call a new script to insert it and then get it */
		var success = true;
		$(".trash-pic").each(function(index){
			if (this.id == ''){
				console.log("new script here");
				$.ajax({
					url: 'updateNewAssessment.php',
					method: 'post',
					data: {
							sectionId: section,
							major: major,
							outcomeId: outcome,
							weight: weights[index],
							assessmentDescription: descriptions[index]
					},
					success:function(response){
						if (response > 0){
							console.log("success. Response: " + response);
							$(this).attr('id', response); //set the new id
							console.log("id is now: " + $(this).id);
						}
						else {
							success = false;
							console.log("query empty or failed: " + response);
							console.log("succes in the fail is: " + success);
						}
					},
					error:function(xhr, ajaxOptions, thrownError){
						console.log("failure: " + thrownError);
						success = false;
					}
				});
			}
			else {
				$.ajax({
					url: 'updateAssessment.php',
					method: 'post',
					data: {
							sectionId: section,
							major: major,
							outcomeId: outcome,
							weight: weights[index],
							assessmentDescription: descriptions[index],
							assessmentId: parseInt(this.id, 10)
					},
					success:function(response){
						if (response == 1){
							console.log("success");
						}
						else {
							success = false;
							console.log("query empty or failed, success is: " + false);
						}
					},
					error:function(xhr, ajaxOptions, thrownError){
						console.log("failure: " + thrownError);
						success = false;
					}
				});
			}
		});
		console.log("success value is: " + success)
		if (success){
			needToSave = false;
			assessmentsSuccessMessage();
		}
		else {
			assessmentsErrorMessage();
		}
	});
	function assessmentsSuccessMessage(){
		$("#assessmentsSuccess").html("Assessments successfully saved");
		$("#assessmentsSuccess").css("color", "black");
		$("#assessmentsSuccess").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	function assessmentsErrorMessage(){
		$("#assessmentsFail").html("Assessments unsuccessfully saved");
		$("#assessmentsFail").css("color", "red");
		$("#assessmentsFail").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	$(".save-narratives-btn").click(function(e){
		e.preventDefault();
		if ($(".narratives-strengths").val() == '' || $(".narratives-weaknesses").val() == ''){
			narrativeErrorMessage();
			return false;
		}
		var selectedCourse = $("#sectionMenu").val().split(" ");
		var major = selectedCourse[0];
		var section = selectedCourse[1];
		var outcome = window.location.href.slice(-1);
		if(isNaN(outcome)){
			outcome = initids[0];
		}
		var success = true;
		$.ajax({
			url: 'updateNarrative.php',
			method: 'post',
			data: {
					sectionId: section,
					major: major,
					outcomeId: outcome,
					strengths: $(".narratives-strengths").val(),
					weaknesses:$(".narratives-weaknesses").val(),
					actions: $(".narratives-actions").val()
				},
			success:function(response){
				if (response == 1){
					console.log("success");
				}
				else {
					console.log("died in narrative php");
					success = false;
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("narrative failed: " + thrownError);
				success = false;
			}
		});
		if (success){
			needToSave = false;
			narrativeSuccessMessage();
		}
		else {
			narrativeErrorMessage();
		}
	});
	function narrativeSuccessMessage(){
		$("#narrativeSuccess").html("Narratives successfully saved");
		$("#narrativeSuccess").css("color", "black");
		$("#narrativeSuccess").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	function narrativeErrorMessage(){
		$("#narrativeFail").html("Narratives unsuccessfully saved");
		$("#narrativeFail").css("color", "red");
		$("#narrativeFail").fadeIn('slow').delay(3000).fadeOut('fast');
	}
	$("#notMeetsExpectations, #meetsExpectations, #exceedsExpectations").change(function(){
		$('#total').html(parseInt($('#notMeetsExpectations').val()) + parseInt($('#meetsExpectations').val()) + parseInt($('#exceedsExpectations').val()));
		needToSave = true;
	});
	$('#narrative-form textarea').change(function(){
		needToSave = true;
	});
	$('#assessment-form').on('change', 'input', function(){
		needToSave = true;
	});
	$('#assessment-form').on('change', 'textarea', function(){
		needToSave = true;
	});
	$('#assessment-form').on('click', '.trash-pic', function(){
		needToSave = true;
	});
	$('#saveResults, #saveAssessments, #saveNarrative').click(function(){
		needToSave = false;
	});
	$(window).on('beforeunload', function(){
		if(needToSave){
			return "You have unsaved changes! Are you sure you want to leave?";
		}
	})
	</script>
  </body>
</html>
