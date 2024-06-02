<?php

// Có tất cả cấu hình của bạn

$ad_ddos_query = 5; // ​​số lượng yêu cầu mỗi giây để phát hiện các cuộc tấn công DDOS
$ad_check_file = 'check.txt'; // tập tin để ghi trạng thái hiện tại trong quá trình giám sát
$ad_all_file = 'all_ip.txt'; // temporary file
$ad_black_file = 'black_ip.txt'; // sẽ được nhập vào ip máy zombie
$ad_white_file = 'white_ip.txt'; // khách truy cập đã đăng nhập ip
$ad_temp_file = 'ad_temp_file.txt'; // khách truy cập đã đăng nhập ip
$ad_dir = 'anti_ddos/files'; // thư mục có script
$ad_num_query = 0; // ​​số lượng yêu cầu hiện tại mỗi giây từ một tệp $check_file
$ad_sec_query = 0; // ​​thứ hai từ một tập tin $check_file
$ad_end_defense = 0; // ​​kết thúc trong khi bảo vệ tệp $check_file
$ad_sec = date("s"); // giây hiện tại
$ad_date = date("is"); // thời điểm hiện tại
$ad_defense_time = 100; // thời gian phát hiện cuộc tấn công ddos ​​​​tính bằng giây tại thời điểm dừng giám sát


$config_status = "";
function Create_File($the_path)
{
	$handle = fopen($the_path, 'w') or die('Không thể mở dữ liệu:  ' . $the_path);
	return "Tạo " . $the_path . " .... Xong";
}


// function AppendToFile($the_path, $newdata){
// 	$my_file = $the_path;
// 	if(!fopen($my_file, 'a')){
// 		$handle = fopen($my_file, 'w');
// 		fwrite($handle, $newdata);
// 	}else{
// 		fwrite($handle, $newdata);
// 	}

// }

// Kiểm tra xem tất cả các tập tin có tồn tại hay không trước khi khởi chạy kiểm tra
$config_status .= (!file_exists("{$ad_dir}/{$ad_check_file}")) ? Create_File("{$ad_dir}/{$ad_check_file}") : "ERROR: Creating " . "{$ad_dir}/{$ad_check_file}<br>";
$config_status .= (!file_exists("{$ad_dir}/{$ad_temp_file}")) ? Create_File("{$ad_dir}/{$ad_temp_file}") : "ERROR: Creating " . "{$ad_dir}/{$ad_temp_file}<br>";
$config_status .= (!file_exists("{$ad_dir}/{$ad_black_file}")) ? Create_File("{$ad_dir}/{$ad_black_file}") : "ERROR: Creating " . "{$ad_dir}/{$ad_black_file}<br>";
$config_status .= (!file_exists("{$ad_dir}/{$ad_white_file}")) ? Create_File("{$ad_dir}/{$ad_white_file}") : "ERROR: Creating " . "{$ad_dir}/{$ad_white_file}<br>";
$config_status .= (!file_exists("{$ad_dir}/{$ad_all_file}")) ? Create_File("{$ad_dir}/{$ad_all_file}") : "ERROR: Creating " . "{$ad_dir}/{$ad_all_file}<br>";

if (!file_exists("{$ad_dir}/../anti_ddos.php")) {
	$config_status .= "anti_ddos.php không tồn tại!";
}

if (
	!file_exists("{$ad_dir}/{$ad_check_file}") or
	!file_exists("{$ad_dir}/{$ad_temp_file}") or
	!file_exists("{$ad_dir}/{$ad_black_file}") or
	!file_exists("{$ad_dir}/{$ad_white_file}") or
	!file_exists("{$ad_dir}/{$ad_all_file}") or
	!file_exists("{$ad_dir}/../anti_ddos.php")
) {

	$config_status .= "Một số tập tin không tồn tại!";
	die($config_status);
}
