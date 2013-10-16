<?php
include_once "functions.php";

//그냥 결과를 화면에 뿌린다.
if($_FILES['xls']['error'] > 0){
	echo '오류 발생 : ';
	//오류 타입에 따라 echo '오류종류"}';
	switch ($_FILES['xls']['error']){
	case 1: echo 'upload_max_filesize 초과';break;
	case 2: echo 'max_file_size 초과';break;
	case 3: echo '파일이 부분만 업로드됐습니다.';break;
	case 4: echo '파일을 선택해 주세요.';break;
	case 6: echo '임시 폴더가 존재하지 않습니다.';break;
	case 7: echo '임시 폴더에 파일을 쓸 수 없습니다. 퍼미션을 살펴 보세요.';break;
	case 8: echo '확장에 의해 파일 업로드가 중지되었습니다.';break;
	}
}

$data = get_arr_from_xls($_FILES['xls']['tmp_name'], $_POST['sheet_index'], $_POST['key_row_index']);
?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>xls serialize result</title>
	<style>
		textarea {
			width: 100%;
			height: 400px;
		}
	</style>
</head>
<body>
	<h2>php serialized data</h2>
	<textarea><?=serialize($data)?></textarea>

	<h2>json encode</h2>
	<textarea><?=json_encode($data)?></textarea>

	<h2>array content</h2>
	<pre><?print_r($data)?></pre>
</body>
</html>