<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="nav.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <div id="abet">
                <a class="utk-abet" href="abet.php"><h2>UTK ABET</h2></a>
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
                <select id="sectionMenu" class="course-dropdown" size="1">
                    <?php
                        for($x=0; $x < count($_SESSION['menuItems']); $x++){
                    ?>
                    <option id="section<?php echo $x+1;?>" value="<?php echo $_SESSION['major'][$x] . " " .$_SESSION['sectionId'][$x]; ?>"><?php echo $_SESSION['menuItems'][$x]?></option>
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

    </body>
    <script>
    var initids = new Array();
    var selectedSection = '<?php echo $_SESSION['selectedSection'];?>';
    var selectedMajor = '<?php echo $_SESSION['selectedMajor'];?>';
    console.log(selectedSection + selectedMajor);
    $(document).ready(function(){
        if(selectedSection && selectedMajor){
            $('#sectionMenu').val(selectedMajor + ' ' + selectedSection);
        }
    })
	/* This function is on initial load and takes care of first nav dropdown */
	$(function(){
        var selectedCourse = $("#sectionMenu").val().split(" ");
        console.log(selectedCourse[0] + " " + selectedCourse[1]);
        var descriptions = new Array();
        var firstOutcome;
		$.ajax({
			url: 'outcomes.php',
			method: 'get',
			dataType: 'JSON',
			data: {sectionId: selectedCourse[1], major: selectedCourse[0]},
			success:function(response){
				var links = $(".outcome-links");
				for (var i = 0; i < response.length; i++){
					var outcomeId = response[i]["outcomeId"];
					initids[i] = outcomeId;
					var outcomeDescription = response[i]["outcomeDescription"];
					descriptions[i] = outcomeDescription;
					var referenceString = "abet.php?outcome=" + outcomeId;
					var anchorId = "outcomeRef-" + outcomeId + "sectionRef-" + selectedCourse[1] + "majorRef-" + selectedCourse[0];
					//need to give these dynamic, unique ID's and query strings -- see referenceString and anchorId
					var a = "<a class='section-outcome' id='"+anchorId+"'><div id='"+outcomeId+"'>" + "Outcome <span class='outId'>" + outcomeId + "</span></div></a><hr class='new-hr'>";
					links.append(a);
					$("#" + anchorId).attr('href', referenceString);
				}
				var description = $("#embedded-description");
                var getOutcome = window.location.href.slice(-1);
                if(isNaN(getOutcome)){
                    getOutcome = initids[0];
                }
				for (var x = 0; x < initids.length; x++){
					if (initids[x] == getOutcome){
						var str = "<strong>Outcome " + getOutcome + " - " + selectedCourse[0] +  ": </strong>" + descriptions[x];
						description.html(str);
					}
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failure");
				console.log(xhr.responseText);
				console.log(thrownError);
            },
            complete: function(){
                getResults();
				getAssessments();
            }

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
                $.post('logout.php', {}, function(){
                    $(location).attr('href',"login.html");
                });
            });

            $("#changePassword").click(function(){
                $(location).attr('href',"password.php");
                /*if($(".main-content").css("display")!="none"){
                    $(".main-content").css("display", "none");
                    $(".password-content").css("display", "block");
                }*/
            });
        });

    $(document).ready(function(){
        $('#sectionMenu').on('change', function() {
            console.log("changing");
			var selection = this.value;
            var sMajor = selection.split(" ")[0];
            var sSection = selection.split(" ")[1];
            console.log(sSection + " " + sMajor);
            $.post('rememberDropdown.php', {
                selectedSection: sSection,
                selectedMajor: sMajor
            },
            function(data, status){
                console.log(status);
                console.log(data);
                $(location).attr('href', 'abet.php');
            });
        });
    });
	</script>
</html>
