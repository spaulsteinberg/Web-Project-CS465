<!DOCTYPE html>
<html lang="en">
    <head>
      <title>ABET Website</title>
      <link rel="stylesheet" type="text/css" href="abet.css">
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
      <meta charset="UTF-8">
	  <?php session_start(); ?>
    </head>
  <body>
	<header>
      <div id="abet">
        <h2>UTK ABET</h2>
      </div>
      <div id="profile">
        <h2>
          <img class="person" src="person.png" alt="person.png">
          <img class="caret" src="caret-bottom-2x.png" alt="caret.png">
          <div id="userMenu">
            <a href="#" id="changePassword">change password</a>
            <a href="#" id="logout">log out</a>
          </div>
          </ul>
        </h2>
      </div>
    </header>
    <div id="container">
      <nav class="nav-container">
        <h1 class="container-section-title">Section:</h1>
        <div class="section-dropdown">
		<form method="GET">
          <select id="class-dropdown" class="course-dropdown" size="1">
			<?php
				for($x=0; $x < count($_SESSION['menuItems']); $x++){
			?>
            <option value="<?php echo $_SESSION['major'][$x] . " " .$_SESSION['sectionId'][$x]; ?>"><?php echo $_SESSION['menuItems'][$x]?></option>
            <?php
				}
			?>
          </select>
		</form>
      </div>
      <div class="outcome-links">
		<hr class="new-hr">
      </div>
      </nav>
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
              <p id="embedded-description"> <strong>Outcome 2 - CS: </strong>Design, implement, and evaluate a computing-based
              solution to meet a given set of computing requirements in the context of the programs discipline.</p>
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
                <td><input type="number" min="0"></td>
                <td><input type="number" min="0"></td>
                <td><input type="number" min="0"></td>
                <td>Total here</td>
            </tr>
            </table>
            <div class="save-results">
                <button class="save-results-btn">Save Results</button>
            </div>
            <br><br><br><br>
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
            <table class="assessment-table">
              <tr>
                <th><strong>Weight (%)</strong></th>
                <th ><strong>Description</strong></th>
                <th><strong>Remove</strong></th>
              </tr>
        <tr>
          <td class="weights"><input type="number" min="1"></td>
          <td><textarea class="assess-description" rows="4" cols="110" maxlength="400"></textarea></td>
          <td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td>
        </tr>
        <tr>
          <td class="weights"><input type="number" min="1"></td>
          <td><textarea class="assess-description" rows="4" cols="110" maxlength="400"></textarea></td>
          <td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td>
        </tr>
        <tr>
          <td class="weights"><input type="number" min="1"></td>
          <td><textarea class="assess-description" rows="4" cols="110" maxlength="400"></textarea></td>
          <td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td>
        </tr>
        <tr>
          <td class="weights"><input type="number" min="1"></td>
          <td><textarea class="assess-description" rows="4" cols="110" maxlength="400"></textarea></td>
          <td class="trash-can"><input type="image" class="trash-pic" src="trash.png" alt="trash.png"></td>
        </tr>
            </table>
        <br>
        <div class="new-img-button">
          <input type="image" class ="new-button" src="new-button.PNG">
        </div>
        <div class="save-assessments">
          <button class="save-assessments-btn">Save Assessments</button>
        </div>
        </div><br><br>
        <hr class="end-results" align="center">
        <div class="narrative-summary">
          <h1 class="container-header">Narrative Summary<hr></h1>
          <div class="main-narratives-description">
            <p>Please enter your name for each outcome, including the student strengths for the outcome, student
              weaknesses for the outcomes, and suggested actions for improving student attainment of each outcome.
              <br><br>
              <strong class="narrative-separators">Strengths</strong>
              <br>
              <textarea class="narratives-text" rows="4" maxlength="2000" placeholder="None"></textarea>
              <br><br>
              <strong class="narrative-separators">Weaknesses</strong>
              <textarea class="narratives-text" rows="4" maxlength="2000" placeholder="None"></textarea>
              <br><br>
              <strong class="narrative-separators">Actions</strong>
              <textarea class="narratives-text" rows="4" maxlength="2000" placeholder="None"></textarea>
            </p>
          </div>
          <div class="save-narratives">
            <button class="save-narratives-btn">Save Narrative</button>
          </div>
        </div>
        </div>
        <div class="password-content">
          <?php
            include 'password.php'
          ?>
        </div>
      </main>
    </div>
	<script>
	/* This function is on initial load and takes care of first nav dropdown */
	$(function(){
		var selectedCourse = $("#class-dropdown").val().split(" ");
		$.ajax({
			url: 'outcomes.php',
			method: 'get',
			dataType: 'JSON',
			data: {sectionId: selectedCourse[1], major: selectedCourse[0]},
			success:function(response){
				var links = $(".outcome-links");
				for (var i = 0; i < response.length; i++){
					var outcomeId = response[i]["outcomeId"];
					var outcomeDescription = response[i]["outcomeDescription"];
					var a = "<a class='section-outcome' href='#'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
					links.append(a);
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failure");
				console.log(xhr.responseText);
				console.log(thrownError);
			}

		});
	});
	/* On dropdown change, empty old links and put new ones in */
	$(function(){
		$("#class-dropdown").change(function(){
			var selectedCourse = $(this).val().split(" ");
			$.ajax({
				url: 'outcomes.php',
				method: 'get',
				dataType: 'JSON',
				data: {sectionId: selectedCourse[1], major: selectedCourse[0]},
				success:function(response){
					var $links = $(".outcome-links");
					$links.empty();					
					for (var i = 0; i < response.length; i++){
						var outcomeId = response[i]["outcomeId"];
						var outcomeDescription = response[i]["outcomeDescription"];
						var a = "<a class='section-outcome' href='#'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
						$links.append(a);
					}
				},
				error:function(xhr, ajaxOptions, thrownError){
					console.log("failure");
					console.log(xhr.responseText);
					console.log(thrownError);
				}

			});
		});
  });
  /*password and stuff */
  $(document).ready(function(){
    $("#profile").click(function(){
        if($("#userMenu").css("display")=="none"){
            $("#userMenu").css("display", "block");
        } else {
            $("#userMenu").css("display", "none");
        }
    });

    $("#logout").click(function(){
        $(location).attr('href',"login.html");
    });

    $("#changePassword").click(function(){
        if($(".main-content").css("display")!="none"){
            $(".main-content").css("display", "none");
            $(".password-content").css("display", "block");
        }
    });
});
	</script>
  </body>
</html>
