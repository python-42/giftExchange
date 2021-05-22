<?php
//9 args
function nav($about, $account, $create, $index, $lists, $login, $manage, $nav, $notes){
	echo "<div class='col-sm-2 pb-3 bg-secondary'><h2>Navigation</h2><div class='btn-group-vertical btn-block'>";
	
	$which = array($about, $account, $create, $index, $lists, $login, $manage, $nav, $notes);
	foreach ($which as $page){
		$page = explode("+", $page);
		if($page[0] == "active"){
			echo "<button type='button' class='btn btn-primary btn-block active border border-body'>".$page[1]."</button>";
		}elseif ($page[0] == "shown" ){
			echo "<button type='button' class='btn bg-white btn-block border border-body' onclick='location.assign(".$page[1].".php)'>".$page[1]."</button>";
		}
	}//loop end
		echo "</div>";
}//function end
	
//pass args like: [status]+[name] status is either active or shown. Whatever can be passed for the rest, pass 0 for uniformity and ease
//example: nav("active+about", "shown+account", "shown+create", 0 ,0 ,0 ,0 ,0, 0);
?>