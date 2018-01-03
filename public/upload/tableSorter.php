<?php

$numeros = array(
	"UNO" => 1,
	"DOS" => 2,
	"TRES" => 3,
	"CUATRO" => 4,
	"CINCO" => 5,
	"SEIS" => 6,
	"SIETE" => 7,
	"OCHO" => 8,
	"NUEVE" => 9,
	"DIEZ" => 10			
);
foreach ($numeros as $key=>$numero){
	echo $key . "<=>" .$numero."\n";
}
$animals = array (
		0 => array (
				'name' => 'Cow',
				'age' => '4',
				'location' => 'Barnyard' 
		) 
);
print_r ( $animals );
$tablerows = array ();
foreach ( $animals as $key => $animal ) {
	$tablerows [] = <<<EOT
			<tr class="dataline">
				<td class='name'>{$animal['name']}</td>
				<td class='age'>{$animal['age']}</td>
				<td class='location'>{$animal['location']}</td>
				<td><a href="#" class="editlink"><img alt="Edit" style="border: 0px none; margin-left: 5px;" src="images/icons/page_edit.gif"/></a></td>
				<td><a href="#" class="removelink"><img alt="Remove" style="border: 0px none; margin-left: 5px;" src="images/icons/bin.gif"/></a></td>
			</tr>
			<tr class="editline" style="display:none;">
				<form>
					<td><input type="text" name="editname" value="{$animal['name']}" /></td>
					<td><input type="text" name="editage" value="{$animal['age']}" /></td>
					<td><input type="text" name="editlocation" value="{$animal['location']}" /></td>
				</form>
				<td colspan="2">
					<a href="#" class="savelink">Save</a> | <a href="#" class="cancellink">Cancel</a>
				</td>
			</tr>
EOT;
}
print_r ( $tablerows );
?>
<html>
<head>
<script type="text/javascript" src="js/jquery/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery.tablesorter.widgets.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/filter.formatter.css">	
<script type="text/javascript">
	$("#mySortable").tablesorter({
		widgets: ['zebra'],
		headers: {
			0: {
				sorter:'inline'
			},
			1: {
				sorter:'inline_number'
			},
			2: {
				sorter:'inline'
			},   
			3: { 
				sorter: false 
			}, 
			4: {
				sorter: false 
			} 
		}
	});

	$.tablesorter.addParser({ 
		   id: 'inline', 
		   is: function(s) { 
		   			return false; 
				}, 
		   format: function(s) { 
		   var pattern = 'value=(?:\"?)([^"]*)(?:\"?)\\s';
		   matches = s.match(pattern);

			if (matches != null) {
		  		 jQuery.makeArray(matches);
		  		 result = matches[1];
			} else {
	   			 result = s;
			}
			return result; 
		}, 
			type: 'text' 
	});
</script>
</head>
<body>
<div id="content">
	<p id="updatemessage"></p>
	<button id="addrowbutton" name="addrow">Add row</button>
	<table id='mySortable' class='tablesorter'>
		<thead>
			<tr>
				<th>Name</th>
				<th>Age</th>
				<th>Location</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<tr id="addrow" style="display: none;">
				<!-- Our add new row -->
				<form>
					<td><input type="text" name="addname" value="" /></td>
					<td><input type="text" name="addage" value="" /></td>
					<td><input type="text" name="addlocation" value="" /></td>
					<td><a href="#" id="saveadd">Save</a> | <a href="#" id="canceladd">Cancel</a>
					</td>
				</form>

			</tr>
		</thead>
		<tbody>
	<?php foreach ($tablerows as $row) { echo $row; } ?>
	</tbody>
		</table>
	</div>
</body>
</html>