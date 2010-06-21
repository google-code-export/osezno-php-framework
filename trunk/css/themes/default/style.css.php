@CHARSET "ISO-8859-1";

.list {
	background-color:#E2E4FF;
}

.cell_content {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-decoration: none;
	text-align:center;
}

.cell_title_selected {
	background-image: url('<?= $_GET['img']; ?>col_selected.gif');
	text-align:center;
}

.cell_title {
	background-image: url('<?= $_GET['img']; ?>col_default.gif');
	text-align:center;
}

.column_title {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
	font-style: normal;
	text-decoration: none;
	font-weight: bold;
}

.column_title:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #999999;
	font-style: normal;
	text-decoration: none;
	font-weight: bold;
}