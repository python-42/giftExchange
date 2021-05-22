<?php
//9 args
function nav($account, $create, $index, $lists, $login, $manage, $nav, $notes){
	echo "<div class='col-sm-2 pb-3 bg-secondary'><h2>Navigation</h2><div class='btn-group-vertical btn-block'>";
	
	$which = array($account, $create, $index, $lists, $login, $manage, $nav, $notes);
	foreach ($which as $page){
		$page = explode("+", $page);
		if($page[0] == "active"){
			//capitilizes first char so it looks nice
			$page[1] = ucfirst($page[1]);
			//replaces bare url-like string with pretty name
			$page[1] = str_replace("Create", "Create Account", $page[1]);
			$page[1] = str_replace("Index", "Home", $page[1]);
			$page[1] = str_replace("Manage", "Your List", $page[1]);
			$page[1] = str_replace("Nav", "Announcements", $page[1]);
			echo "<button type='button' class='btn btn-primary btn-block active border border-body'>".$page[1]."</button>";
		}elseif ($page[0] == "shown" ){
			$page[2] = ucfirst($page[1]);
			$page[2] = str_replace("Create", "Create Account", $page[2]);
			$page[2] = str_replace("Index", "Home", $page[2]);
			$page[2] = str_replace("Manage", "Your List", $page[2]);
			$page[2] = str_replace("Nav", "Announcements", $page[2]);
			echo "<button type='button' class='btn bg-white btn-block border border-body' onclick=\"location.assign('".$page[1].".php')\">".$page[2]."</button>";
		}
	}//loop end
		echo "</div></div>";
}//function end
	
//pass args like: [status]+[name] status is either active or shown. Whatever can be passed for the rest, pass 0 for uniformity and ease
//example: nav("active+Account", "shown+Create", 0 ,0 ,0 ,0 ,0, 0);
?>