<?php
	try{
		if (!file_exists('anti_ddos/start.php'))
			throw new Exception ('anti_ddos/start.php does not exist');
		else
			require_once('anti_ddos/start.php'); 
	} 
	//CATCH ngoại lệ nếu có sự cố.
	catch (Exception $ex) {
		echo '<div style="padding:10px;color:white;position:fixed;top:0;left:0;width:100%;background:black;text-align:center;">'.
			'The <a href="https://github.com/bibo318/SystemAntiDDOS" target="_blank">"Hệ thống AntiDDOS "</a> không tải được '.
			'đúng cách trên trang web này, vui lòng bỏ bình luận \'catch Exception\' để xem chuyện gì đang xảy ra!</div>';
		//In ra thông báo ngoại lệ.
		//echo $ex->getMessage();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/flottant.css">
		<title>Trang web mẫu</title>
	</head>
	<body>
		<center>
			<div class="container">
				<a href="https://github.com/bibo318">
					<img src="https://avatars.githubusercontent.com/u/56821442?v=4" style="border-radius: 100%;width:200px;"><br>
					Debugs Github
				</a>
				<h1>Trang web mẫu</h1>
				<p>Trang web này được bảo vệ bởi SystemAntiDDOS PHP.</p>
			</div>
		</center>
	</body>
</html>
