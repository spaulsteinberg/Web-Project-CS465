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

    </body>
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
					var a = "<a class='section-outcome' href='abet.php'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
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
						var a = "<a class='section-outcome' href='abet.php'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
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
	</script>
</html>