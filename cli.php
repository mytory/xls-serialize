<?php
if($argc != 5){
	echo "syntax) php cli.php {filepath} {sheet_index} {key row index} {output type}\n";
	echo "ex) php cli.php ~/Documents/my.xlsx 0 1 serialize\n";
	echo "ex) php cli.php ~/Documents/my.xlsx 0 1 json\n";
	exit;
}

include 'functions.php';
$arr = get_arr_from_xls ($argv[1], $argv[2], $argv[3]);
if($argv[4] == 'serialize'){
	echo serialize($arr);
}else if($argv[4] == 'json'){
	echo json_encode($arr);
}else{
	echo "Output type is invalid. serialize or json.\n";
	exit;
}

