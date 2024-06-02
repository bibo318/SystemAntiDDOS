<?php

/**
 * AntiDDOS System
 * FILE: index.php
 * By Debugs
 */
function safe_print($value)
{
	$value .= "";
	return strlen($value) > 1 && (strpos($value, "0") !== false) ? ltrim($value, "0") : (strlen($value) == 0 ? "0" : $value);
}
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['standby'])) {

	// Có tất cả cấu hình của bạn
	$_SESSION['standby'] = $_SESSION['standby'] + 1;

	$ad_ddos_query = 5; // ​​số lượng yêu cầu mỗi giây để phát hiện các cuộc tấn công DDOS
	$ad_check_file = 'check.txt'; // tập tin để ghi trạng thái hiện tại trong quá trình giám sát
	$ad_all_file = 'all_ip.txt'; // temporary file
	$ad_black_file = 'black_ip.txt'; // sẽ được nhập vào ip máy zombie
	$ad_white_file = 'white_ip.txt'; // khách truy cập đã đăng nhập ip
	$ad_temp_file = 'ad_temp_file.txt'; // khách truy cập đã đăng nhập ip
	$ad_dir = 'anti_ddos/files'; // thư mục có script
	$ad_num_query = 0; // ​​số lượng yêu cầu hiện tại mỗi giây từ một tệp $check_file
	$ad_sec_query = 0; // ​​thứ hai từ một tệp $check_file
	$ad_end_defense = 0; // ​​kết thúc trong khi bảo vệ tệp $check_file
	$ad_sec = date("s"); // giây hiện tại
	$ad_date = date("is"); // thời điểm hiện tại
	$ad_defense_time = 100; // thời gian phát hiện cuộc tấn công ddos ​​​​tính bằng giây tại thời điểm dừng giám sát


	$config_status = "";
	function Create_File($the_path, $ad)
	{
		if (!file_exists($ad)) mkdir($ad, 0755, true);
		$handle = fopen($the_path, 'a+') or die('Cannot create file:  ' . $the_path);
		return "Creating " . $the_path . " .... done";
	}


	// Kiểm tra xem tất cả các tập tin có tồn tại hay không trước khi khởi chạy kiểm tra
	$config_status .= (!file_exists("{$ad_dir}/{$ad_check_file}")) ? Create_File("{$ad_dir}/{$ad_check_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_check_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_temp_file}")) ? Create_File("{$ad_dir}/{$ad_temp_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_temp_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_black_file}")) ? Create_File("{$ad_dir}/{$ad_black_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_black_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_white_file}")) ? Create_File("{$ad_dir}/{$ad_white_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_white_file}<br>";
	$config_status .= (!file_exists("{$ad_dir}/{$ad_all_file}")) ? Create_File("{$ad_dir}/{$ad_all_file}", $ad_dir) : "ERROR: Creating " . "{$ad_dir}/{$ad_all_file}<br>";

	if (!file_exists("{$ad_dir}/../anti_ddos.php")) {
		$config_status .= "anti_ddos.php doesn't exist!";
	}

	if (
		!file_exists("{$ad_dir}/{$ad_check_file}") or
		!file_exists("{$ad_dir}/{$ad_temp_file}") or
		!file_exists("{$ad_dir}/{$ad_black_file}") or
		!file_exists("{$ad_dir}/{$ad_white_file}") or
		!file_exists("{$ad_dir}/{$ad_all_file}") or
		!file_exists("{$ad_dir}/../anti_ddos.php")
	) {

		$config_status .= "Some files doesn't exist!";
		die($config_status);
	}

	// ĐỂ xác minh phiên bắt đầu hay không
	require("{$ad_dir}/{$ad_check_file}");

	if ($ad_end_defense and $ad_end_defense > $ad_date) {
		require("{$ad_dir}/../anti_ddos.php");
	} else {
		$ad_num_query = ($ad_sec == $ad_sec_query) ? $ad_num_query++ : '1 ';
		$ad_file = fopen("{$ad_dir}/{$ad_check_file}", "w");

		$ad_string = ($ad_num_query >= $ad_ddos_query) ? '<?php $ad_end_defense=' . safe_print($ad_date + $ad_defense_time) . '; ?>' : '<?php $ad_num_query=' . safe_print($ad_num_query) . '; $ad_sec_query=' . safe_print($ad_sec) . '; ?>';

		fputs($ad_file, $ad_string);
		fclose($ad_file);
	}
} else {

	$_SESSION['standby'] = 1;

	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Refresh: 5, " . $actual_link);
?>
	<style type="text/css">
		.loading {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.loading__msg {
			font-family: Roboto;
			font-size: 16px;
		}

		.loading__dots {
			display: flex;
			flex-direction: row;
			width: 100%;
			justify-content: center;
			margin: 100px 0 30px 0;
		}

		.loading__dots__dot {
			background-color: #44BBA4;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			margin: 0 5px;
			color: #587B7F;
		}

		.loading__dots__dot:nth-child(1) {
			animation: bounce 1s 1s infinite;
		}

		.loading__dots__dot:nth-child(2) {
			animation: bounce 1s 1.2s infinite;
		}

		.loading__dots__dot:nth-child(3) {
			animation: bounce 1s 1.4s infinite;
		}

		@keyframes bounce {
			0% {
				transform: translate(0, 0);
			}

			50% {
				transform: translate(0, 15px);
			}

			100% {
				transform: translate(0, 0);
			}
		}
	</style>
	<div class="loading" style="margin-top: 11%;">
		<div class="loading__dots">
			<div class="loading__dots__dot"></div>
			<div class="loading__dots__dot"></div>
			<div class="loading__dots__dot"></div>
		</div>
		<div class="loading__msg">
			<div style="margin:auto; text-align:center;">
				<b style="font-size: 22px;">
					<a href="https://github.com/bibo318/SystemAntiDDOS" target="_blank" style="color: black;">ANTIDDOS</a> đang kiểm tra....
				</b>
				<br><br>
				Xin chào, đừng lo lắng, đây là bước xác minh bảo mật đơn giản,
				bạn sẽ chỉ nhìn thấy điều này một lần;<br> trang web của bạn sẽ sớm hiển thị!
				<br> Bức tường an ninh này được xây dựng bởi
				<a href="https://github.com/bibo318" target="_blank">Debugs</a>
			</div>
		</div>
	</div>

<?php exit();
}
?>