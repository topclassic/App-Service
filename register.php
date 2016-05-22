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

		// GET PARAMETER FROM ANDROID
		$strFirstname = $_POST["sFirstname"];
		$strLastname = $_POST["sLastname"];
		$strFirstMobileNo = $_POST["sFirstMobileNo"];
		$strSecondMobileNo = $_POST["sSecondMobileNo"];
		$strHouseNo = $_POST["sHouseNo"];
		$strStreet = $_POST["sStreet"];
		$strSubdistrict = $_POST["sSubdistrict"];
		$strDistrict = $_POST["sDistrict"];
		$strProvince= $_POST["sProvince"];
		$strEmail = $_POST["sEmail"];
		$strPassword = $_POST["sPassword"];
		$strLineID = $_POST["sLineID"];

		$file_path = "uploads/";

		if(is_uploaded_file($_FILES["sImage"]["tmp_name"])){
				$file_name = $_FILES["sImage"]["name"];
                $newString = preg_replace('/\s+/', '', $file_name);
                $file_name = time().$newString;
				    if(move_uploaded_file($_FILES["sImage"]["tmp_name"], $file_path.$file_name)){
				        $sqlImage = $file_name;
				    }
		} else {
			$sqlImage = "default.png";
		}

		// GENERATE ID
		    $sqlUserID = "SELECT MAX(RelativeID) FROM relative";
		    $resultUserID = mysql_query($sqlUserID);
		    $rowUserID = mysql_fetch_array($resultUserID);

		if(COUNT($rowUserID[0]) < 1) {
		        $valID = "REL0001";
		    } else {
		        $str = $rowUserID[0];
		        $mod = substr($str,0,3);
            	$num = substr($str,3,7)+1;
		        $genID = $mod.$num;
		        $getLenght = strlen($genID);
		             if($getLenght == 4){
		              $valID = $mod.'000'.$num;
		             } else if ($getLenght == 5){
		              $valID = $mod.'00'.$num;
		             } else if ($getLenght == 6){
		              $valID = $mod.'0'.$num;
		        }
		    }

		$sql = "INSERT INTO relative (RelativeID, RelativeFirstname, RelativeLastname, RelativeFirstMobileNo, RelativeSecondMobileNo, RelativeHouseNo, RelativeStreet, RelativeSubdistrict, RelativeDistrict, RelativeProvince, RelativePicture, RelativeEmail, RelativePassword, RelativeLineID)
VALUES ('$valID', '$strFirstname', '$strLastname', '$strFirstMobileNo', '$strSecondMobileNo', '$strHouseNo', '$strStreet', '$strSubdistrict', '$strDistrict', '$strProvince', '$sqlImage', '$strEmail', '$strPassword', '$strLineID')";
		// echo $sql;
		$result = mysql_query($sql);

		$StateDenied = 0;
		$StateOK = 1;

		if($result){
			$json = array('success' => $StateOK, 'error_message' => 'สมัครสมาชิกเรียบร้อยแล้ว');
		} else {
			$json = array('success' => $StateDenied, 'error_message' => 'สมัครสมาชิกไม่สำเร็จ');
		}
		print(json_encode($json));
		mysql_close();
	// }
?>
