<?php session_start(); ?>
<!DOCTYPE=html>
    <html lang="en">

    <head>
        <title>Manage Your Notes</title>
        <?php
			if (file_exists("include/head-data.html")){
				require "include/head-data.html";
				}else{
					error_log("Eror Code 101: include/head_data.html is missing![create_account.php]");
					die ("<b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9'>notify developer</a> if error persists.  [Error Code: 101]</div>");
					}
					
			if (file_exists("util/nav-block.php")){
				require "util/nav-block.php";
			}else{
				error_log("Eror Code 101: util/nav-block.php is missing![index.php]");
				die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
				}
				?>
    </head>

    <body>
        <?php
		//checks to make sure user is logged in
					if(!isset($_SESSION["logged"])){
						echo "<script>location.replace('login.php?nl=true')</script>";
						}
			$_SESSION["direct"] = "notes.php";
			
		if (file_exists("include/sql.php")){
			require "include/sql.php";
			}else{
				error_log("Eror Code 101: include/sql.php is missing!");
				die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
			}
		?>
        <div class="container-fluid">
            <div class="jumbotron text-center m-2">
                <h1 class="jumbotron-heading" style="font-family: 'Courier New','Courier','monospace';">Your Notes</h1>
            </div>
            <div class="row">
                <?php
			nav("shown+account", 0, 0, "shown+lists", 0, "shown+manage", "shown+nav", "active+notes");
			?>
                <div class="col-sm-10 bg-primary">

                    <ul class="nav nav-tabs bg-white border border-dark">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#add">Add Notes</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit">Edit Notes</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#remove">Remove Notes</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane container active" id="home">
                            <h2>Manage Your Notes</h2>
                            <p class="text-dark">Edit your notes here. Click the corresponding tabs to either add, edit,
                                or delete items from your notes.</p>
                            <h2>Your Current Notes</h2>
                            <?php
				$outputSQL = 'SELECT * FROM '.$_SESSION['logged'].'Notes';
				$outputSelectRaw = $conn->query($outputSQL);
				if($outputSelectRaw->num_rows > 0){
					echo  "<div class='card-columns'>";
					while($outputSelect = $outputSelectRaw -> fetch_assoc()){
						echo "<div class='card'><div class='card-header'><h4 class='card-title'>".$outputSelect['name']."</h4></div><div class='card-body'><p class='card-text'>For: ".$outputSelect['who']."</p><a target='_blank' href='".$outputSelect['url']."' class='card-link'>".$outputSelect['urlTitle']."</a><p class='card-text'>Comment: ".$outputSelect['comment']."</p>";
						echo "</div></div>";
					}
					echo "</div>";
					}else{
						echo "<p class='text-info bg-light border border-danger rounded-sm' style='text-align:center' >You curently have no items!</p>";
						}
				?>
                        </div>
                        <!--end of Home tab-->

                        <div class="tab-pane container fade" id="add">
                            <h2>Add Notes</h2>
                            <p class="text-dark">Add items to your notes here.</p>

                            <form method="post" class="bg-dark text-primary p-3 rounded-lg" autocomplete="off"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                <!-- this should break any attempted injections-->
                                <div class="form-group">
                                    <label for="item-box">Item: </label>
                                    <input type="text" class="form-control" maxlength="50" name="item-box" id="item-box"
                                        placeholder="The name of the item you would like" required>
                                </div>

                                <div class="form-group">
                                    <label for="who-box">For: </label>
                                    <input type="text" class="form-control" maxlength="20" name="who-box" id="who-box"
                                        placeholder="The person who you think would like this item" required>
                                </div>

                                <div class="form-group">
                                    <label for="url-box">URL: </label>
                                    <input type="text" class="form-control" maxlength="250" name="url-box" id="url-box"
                                        placeholder="The link to the item you would like" required>
                                </div>

                                <div class="form-group">
                                    <label for="title-box">Title: </label>
                                    <input type="text" class="form-control" maxlength="20" name="title-box"
                                        id="title-box" placeholder="How the URL will appear when outputted" required>
                                </div>

                                <div class="form-group">
                                    <label for="comment-box">Comment: </label>
                                    <input type="text" class="form-control" maxlength="250" name="comment-box"
                                        id="comment-box" placeholder="Any comment about the item" required>
                                </div>
                                <button class="btn btn-primary" type="submit" name="addBtn" id="addBtn">Add
                                    Item</button>
                            </form>

                        </div>
                        <!--end of Add tab-->

                        <div class="tab-pane container fade" id="edit">
                            <h2>Edit Notes</h2>
                            <p class="text-dark">Edit notes which are already on your list here.</p>
                            <form method="post" class="bg-dark text-primary p-3 rounded-lg"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                <!-- this should break any attempted injections-->
                                <div class="form-group">
                                    <label for="which-box">Select which item you would like to edit:</label>
                                    <select name="which-box" class="custom-select form-control">
                                        <?php
					$editOptionSelect = 'SELECT name FROM '.$_SESSION['logged'].'Notes';
					$editOptionResultRaw = $conn->query($editOptionSelect);
					if($editOptionResultRaw->num_rows > 0){
						while($editOptionResult = $editOptionResultRaw->fetch_assoc()){
							echo "<option>".$editOptionResult['name']."</option>";
							}
					}else{
						echo "<option selected value='none'>There aren't any items on your list! And items in the tab labeled 'Add Items'!</option>";
						}
					?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="editSelectBtn"
                                    id="editSelectBtn">Next</button>
                            </form>
                            <?php
				if($_SERVER["REQUEST_METHOD"] == "POST"){
			//checks which form was submitted
			if(isset($_POST["addBtn"])){
				//gets inputs
				$create["item"] = $_POST["item-box"];
                $create['who'] = $_POST['who-box'];
				$create["url"] = $_POST["url-box"];
				$create["title"] = $_POST["title-box"];
				$create["comment"] = $_POST["comment-box"];
				$create["item"] = str_replace("+", "", $create["item"]);
				//validates input
				if (in_array("", $create)){
					error_log("Input was blank for a required form. Page = notes.php Form = add item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
					}else{
						$createPrep = $conn->prepare('INSERT INTO '.$_SESSION['logged'].'Notes (name, url, comment, urlTitle, who) VALUES (?, ?, ?, ?, ? )');
						$createPrep->bind_param('sssss', $create['item'], $create['url'], $create['comment'], $create['title'], $create['who']);
						$createPrep ->execute();
						$createPrep->close();
						
						echo "<script>location.replace('util/shortstop.php')</script>";
						}
					
				}elseif(isset($_POST["editBtn"])){
					//gets inputs
				$edit["item"] = $_POST["item-edit-box"];
                $edit["who"] = $_POST["who-edit-box"];
				$edit["url"] = $_POST["url-edit-box"];
				$edit["title"] = $_POST["title-edit-box"];
				$edit["comment"] = $_POST["comment-edit-box"];
				//validates input
				if (in_array("", $edit)){
					error_log("Input was blank for a required form. Page = notes.php Form = edit item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
					}else{
						$editPrep = $conn->prepare('UPDATE '.$_SESSION['logged'].'Notes SET name = ? , who = ?, url = ? , comment =? , urlTitle = ? WHERE name = ?');
                        $editPrep->bind_param('ssssss', $edit['item'], $edit['who'], $edit['url'], $edit['comment'], $edit['title'], $_SESSION['old-item']);
						$editPrep ->execute();
						$editPrep->close();
						echo "<script>location.replace('util/shortstop.php')</script>";
						}
					
					}elseif(isset($_POST["rmBtn"])){
						$rmItem = $_POST["rm-box"];
						if($rmItem == ""){
							error_log("Input was blank for a required form. Page = notes.php Form= remove item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
							}else{
								$rmPrep = $conn->prepare('DELETE FROM '.$_SESSION['logged'].'Notes WHERE name = ?');
								$rmPrep -> bind_param("s", $rmItem);
								$rmPrep -> execute();
								$rmPrep -> close();
								
								echo "<script>location.replace('util/shortstop.php')</script>";
								}
						}elseif(isset($_POST["editSelectBtn"])){
							$which = $_POST["which-box"];
							if ($which != "" && $which != "none"){
								$editSelect = "SELECT * FROM ".$_SESSION['logged']."Notes WHERE name='".$which."'";
                                error_log($editSelect);
								$editRawResult = $conn->query($editSelect);
								if($editRawResult -> num_rows == 0){
									error_log("Error Code 202: Expected data in table ".$_SESSION['logged']."Notes, but data was absent. [notes.php]");
									die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> Data is missing from database.  Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 202]</div>");
								}else{
									$_SESSION["tab"] = "#edit";
									$_SESSION["old-item"] = $which;
									$editResult = $editRawResult->fetch_assoc();
									echo "<form method='post' class='bg-dark text-primary p-3 rounded-lg' autocomplete='off' action='".htmlspecialchars($_SERVER['PHP_SELF']) ."'><div class='form-group'><label for='item-edit-box'>Item: </label><input type='text' class='form-control' maxlength='50' name='item-edit-box'  id='item-edit-box' value='".$editResult['name']."' required></div><div class='form-group'><label for='who-edit-box'>For: </label><input type='text' class='form-control' maxlength='20' name='who-edit-box'  id='who-edit-box' value='".$editResult['who']."' required></div><div class='form-group'><label for='url-edit-box'>URL: </label><input type='text' class='form-control'  maxlength='250' name='url-edit-box' id='url-edit-box' value='".$editResult['url']."' required></div><div class='form-group'><label for='title-edit-box'>Title: </label><input type='text'  class='form-control' maxlength='20' name='title-edit-box' id='title-edit-box' value='".$editResult['urlTitle']."' required></div><div class='form-group'><label for='comment-edit-box'>Comment: </label><input type='text'  class='form-control' maxlength='250' name='comment-edit-box' id='comment-edit-box' value='".$editResult['comment']."' required></div><button class='btn btn-primary' type='submit' name='editBtn' id='editBtn'>Edit Item</button></form>";
									}
								}
							}//end of elseif's
			}//end of $_SERVER if
			
				if (isset($_SESSION['tab'])){
				echo "<script>var tab =\"".$_SESSION['tab']."\"</script>";
				$_SESSION["tab"] = "#home";
			}
		?>
                        </div>
                        <!--end of Edit tab-->

                        <div class="tab-pane container fade" id="remove">
                            <h2>Remove Notes</h2>
                            <p class="text-dark">Remove notes from your list here.</p>
                            <form method="post" class="bg-dark text-primary p-3 rounded-lg"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                <!-- this should break any attempted injections-->
                                <div class="form-group">
                                    <label for="rm-box">Select the item you would like to remove: </label>
                                    <select name="rm-box" class="custom-select form-control">
                                        <?php
					$rmSelect = 'SELECT name FROM '.$_SESSION['logged'].'Notes';
					$rmResultRaw = $conn->query($rmSelect);
					if($rmResultRaw->num_rows > 0){
						while($rmResult = $rmResultRaw->fetch_assoc()){
							echo "<option>".$rmResult['name']."</option>";
							}
					}else{
						echo "<option selected>There aren't any notes on your list! Add notes in the tab labeled 'Add notes'!</option>";
						}
					?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="rmBtn" id="rmBtn">Remove
                                    Item</button>
                            </form>
                        </div>
                        <!--end of Remove tab-->
                    </div>

                </div>
                <!--end of large content section-->
            </div>
            <!--end of row-->
        </div>
        <!--end of .container-fluid-->
        <style>
        body {
            background: linear-gradient(to left, #007bff, #6c757d);
        }

        @media (min-width: 576px) {
            .jumbotron-heading {
                font-size: 9rem;
            }
        }
        </style>
        <script>
        $(document).ready(function() {
            if (typeof(tab) == "string") {
                $(".nav-tabs a[href='" + tab + "'] ").tab("show");
                console.log("Tab shown");
            } else {
                console.log("tab is not a string (likely not defined)");
            }
        });
        </script>
    </body>

    </html>