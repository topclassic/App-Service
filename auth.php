<?php
header('Content-Type: application/json');

$host = "ap-cdbr-azure-southeast-b.cloudapp.net";
$user = "bc2802e3399651";
$pass = "4476f2df";
$db = "alzdpu";

mysql_connect($host,$user,$pass);
mysql_query("SET NAMES UTF8");
mysql_query("USE $db");

$strID = $_POST["sID"];

	// if($strID == '1'){

		$strUsername = $_POST["username"];
		$strPassword = $_POST["password"];

		$sql = "SELECT COUNT(*) FROM relative WHERE RelativeEmail = '$strUsername' AND RelativePassword = '$strPassword'";
		// echo $sql;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);

		$StateDenied = 0;
		$StateOK = 1;

		// User information
		$sqlUsr = "SELECT * FROM relative WHERE RelativeEmail = '$strUsername' AND RelativePassword = '$strPassword'";

		if($row[0] == 1){
			$resultUsr = mysql_query($sqlUsr);
			$rowUsr = mysql_fetch_array($resultUsr);

			$dataFirstname = $rowUsr["RelativeFirstname"];
			$dataLastname = $rowUsr["RelativeLastname"];
			$dataEmail = $rowUsr["RelativeEmail"];

			$json = array('success' => $StateOK, 'error_message' => 'เข้าสู่ระบบสำเร็จ', 'Firstname' => $dataFirstname, 'Lastname' => $dataLastname, 'Email' => $dataEmail);
		} else {
			$json = array('success' => $StateDenied, 'error_message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
		}

				// if($result){
				// 	while($row = mysql_fetch_array($result))
				// 		$data[] = $row["Questionnaire_name"];
				// 		$json = array('Count'  => count($data), 'PassingScore'  => $masterScore,'Question' => $data);
				// }
		print(json_encode($json));
		mysql_close();
	// }
?>
