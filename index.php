<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>xls serialize</title>
</head>
<body>
	<form action="action.php" method="post" enctype="multipart/form-data">
		file: <input type="file" name="xls" id="xls">
		<br>
		sheet_index :<input type="number" name="sheet_index" id="sheet_index" value="0">
		<br>
		key_row_index: <input type="number" name="key_row_index" id="key_row_index" value="1">
		<br>
		<input type="submit" value="submit">
	</form>
</body>
</html>