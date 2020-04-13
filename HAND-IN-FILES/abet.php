<!DOCTYPE html>
<html lang="en">
    <head>
      <title>ABET Website</title>
      <link rel="stylesheet" type="text/css" href="abet.css">
      <meta charset="UTF-8">
	  <?php session_start(); ?>
    </head>
  <body>
	<header>
      <div id="abet"> <h2>UTK ABET</h2> </div>
      <div id="profile">
        <h2> 
          <input type="image" class="person" src="person.png" alt="person.png"> 
          <input type="image" class="caret" src="caret-bottom-2x.png" alt="caret.png">
        </h2>
      </div>
    </header>
    <div id="container">
      <nav class="nav-container">
        <h1 class="container-section-title">Section:</h1>
        <div class="section-dropdown">
          <select class="course-dropdown" size="1">
			<?php
				foreach($_SESSION['menuItems'] as $item){
			?>
            <option value="<?php echo $item; ?>"><?php echo $item;?></option>
            <?php
				}
			?>
          </select>
      </div>
      <div class="outcome-links">
        <hr class="new-hr"> <!-- will need to do these programatically in JS-->
        <a class="section-outcome" href="#"> <div>Outcome 2</div></a>
        <hr class="new-hr">
        <a class="section-outcome" href="#" > <div>Outcome 3</div> </a>
        <hr class="new-hr">
        <a class="section-outcome" href="#" > <div>Outcome 4</div> </a>
        <hr class="new-hr">
        <a class="section-outcome" href="#" > <div>Outcome 5</div> </a>
        <hr class="new-hr">
      </div>
      </nav>
      <main class="main-container">
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
      </main>
    </div>
  </body>
</html>
