
[
<?php
	$st = false;
	
	foreach($spItemGroups as $c){
		if($st) echo ",";
		CreateNode($c);
		$st = true;
	}
	
	function CreateNode($node){
		echo "{\n";
		echo "id:'" . $node['id'] . "',\n";
		echo "name:'" . $node['name'] . "',\n";
		echo "created:'" . $node['created'] . "',\n";
		if(count($node['children']) > 0){
			echo ( $node['name'] == 'All')? "expanded: true,\n":  "expanded: false,\n";
			echo "children:[\n";
			$started = false;
			foreach($node['children'] as $cnode){
				if($started) echo ",\n";
				CreateNode($cnode);
				$started = true;
			}
			echo "],\n";
		} else {
			echo "leaf:true\n";
		}
		echo "}\n";
	}
?>
]