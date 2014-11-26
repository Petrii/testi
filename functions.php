<?php
//READ CompanyList.csv / users.csv
function readList($filename){
	//initialize variables
	$list = array();
	$i=0;
	
	if (file_exists($filename)) {
		$fileOpenCSV = fopen($filename, 'r') or die ('Epic fail ( $filename );-P');
		while(! feof($fileOpenCSV)){
			$list[$i] = fgetcsv($fileOpenCSV);
			$i++;
		}
		fclose($fileOpenCSV);
	} else {
		echo "The file $filename does not exist";
	}
	return $list;
}

// WRITE users.csv
// $p_List array pointer of Company or users list
function writeList($filename, $p_list, $name, $loginName, $pwd, $level){
	$identical = false;
	$i=0;
	
	// Compare if there is identical name
	foreach($p_list as $r => $id){
		if($id[1]==$loginName){
			$identical = true;
		}
		$i++;
	}
	if($identical){
		$p_list[$i][0] = $i; //ID
		$p_list[$i][1] = $name;
		$p_list[$i][2] = $loginName;
		$p_list[$i][3] = $pwd;
		$p_list[$i][4] = 1;//Active TRUE
		$p_list[$i][5] = $level;
		
		$filePutCSV = fopen($filename, 'w+') or die ('Epic fail ( "'.$filename.'" ) ;-P');
		foreach ($p_list as $line){
			if($line[0] != ''){
				fputcsv($filePutCSV, $line);
			}
		}
		fclose($filePutCSV);
	}
	else{
		echo "Käyttäjää ei lisätty";
	}
}

//READ (packets.csv)
function readPackets(&$p_Amount){
	//initialize variables
	$filename = 'packets.csv';
	$packetsList = array();
	
	if (file_exists($filename)) {
		$fileOpenCSV = fopen($filename, 'r') or die ('Epic fail ( "'.$filename.'" ) ;-P');
		while(! feof($fileOpenCSV)){
			$packetsList[$p_Amount] = fgetcsv($fileOpenCSV);
			$p_Amount++;
		}
		fclose($fileOpenCSV);
	} else {
		echo "The file $filename does not exist";
	}
	return $packetsList;
}

//WRITE (packets.csv)
function writePackets(&$p_amount, &$p_companyID_POST, &$p_list, &$p_packetsList, &$p_arrayAmount, $radioButton, &$p_info){
	
	//initialize variables
	$ArrayAmount = $p_arrayAmount-1; 	/* Number of the rows -1 */
	$ID = $p_companyID_POST; 			/* if other company then id is current time Hour Minute Second */
	$AddOk = false; 					/* "flag" that if trying add same company twice, but it will not working with otherCompany*/
	$filename = 'packets.csv';
	
	//Find match between name and companyid
	if($radioButton==0){ /*if posted of the option field */
		foreach($p_list as $r => $id){  
			if($id[0]==$p_companyID_POST){
				$company=$id[1];
			}
		}
	} else { /*if posted of the otherCompany field */
		$company = $p_companyID_POST;
		$ID = date("His");
	}
	
	//Search for possible duplicates
	if($radioButton==0){
		while($ArrayAmount>=0){
			if(($p_packetsList[$ArrayAmount][0])==$p_companyID_POST){
				$p_packetsList[$ArrayAmount][2] = $p_packetsList[$ArrayAmount][2]+$p_amount;
				$AddOk = true;
			}
			$ArrayAmount--;
		}
	}
	//If not any found add new in array
	if(!$AddOk){
			$p_arrayAmount++;
			$p_packetsList[$p_arrayAmount][0] = $ID;
			$p_packetsList[$p_arrayAmount][1] = $company;
			$p_packetsList[$p_arrayAmount][2] = $p_amount;
			$p_packetsList[$p_arrayAmount][3] = gmDate("d.m.Y");
			$p_packetsList[$p_arrayAmount][4] = "-";
			$p_packetsList[$p_arrayAmount][5] = "-";
			$p_packetsList[$p_arrayAmount][6] = $p_info;
	}
	// Save array to file
		$filePutCSV = fopen($filename, 'w+') or die ('Epic fail ( "'.$filename.'" ) ;-P');
		foreach ($p_packetsList as $line){
			if($line[0] != ''){
				fputcsv($filePutCSV, $line);
			}
		}
		fclose($filePutCSV);
}

//Delete row (packets.csv)
function deletePacket(&$p_deleteValue, &$p_arrayAmount, &$p_packetsList){
	//initialize variables
	$ArrayAmount=$p_arrayAmount-1;/*Number of the rows -1*/
	$filename = 'packets.csv';
	
	// Delete selected row
	while($ArrayAmount>=0){
		if(($p_packetsList[$ArrayAmount][0])==$p_deleteValue){
			unset($p_packetsList[$ArrayAmount]);
		}
		$ArrayAmount--;
	}

	// Save array to file
	if (file_exists($filename)) {
		$fileDelCSV = fopen($filename, 'w') or die ('Epic fail ;-P');
		foreach ($p_packetsList as $value)
		  {
			if($value[0] != ''){
				fputcsv($fileDelCSV, $value);
			}
		 }
		fclose($fileDelCSV);
	} else {
		echo "The file $filename does not exist";
	}
}

// Edit row (packets.csv)
function editPacket(&$p_editID, &$p_arrayAmount, &$p_packetsList, &$p_editPost, $buttonType, &$p_editInfo){
	//initialize variables
	$ArrayAmount=$p_arrayAmount-1;/*Number of the rows -1*/
	$filename = 'packets.csv';
	
	//Selecting correct index to editing
	if($buttonType==0){
		$index=2;
		$time = '-';
	} else {
		$index=5;
		$time = gmDate("d.m.Y");
	}
	
	// Search selected row and edit
	while($ArrayAmount>=0){
		if(($p_packetsList[$ArrayAmount][0])==$p_editID){
			$p_packetsList[$ArrayAmount][4] = $time;
			// edit provider column
			if($index == 5){
				//if provider is empty, add new
				if($p_packetsList[$ArrayAmount][5]=="-"){
					$p_packetsList[$ArrayAmount][5] = $p_editPost;
				}
			// edit amount column
			} else {
				$p_packetsList[$ArrayAmount][2] = $p_editPost;
				$p_packetsList[$ArrayAmount][6] = $p_editInfo;
			}
			$AddOk = true;
		}
		$ArrayAmount--;
	}

	// Save array to file
	if (file_exists($filename)) {
		$fileEditCSV = fopen($filename, 'w') or die ('Epic fail ;-P');
		foreach ($p_packetsList as $value){
			if($value[0] != ''){
				fputcsv($fileEditCSV, $value);
			}
		}
		fclose($fileEditCSV);
	} else {
		echo "The file $filename does not exist";
	}
}

// order status, control_user.php
function orderStatus(&$submitted){
	if($submitted=='-'){
		$output = "<input type='submit' name='status' class='buttonEdit' value='Toimita'/>";
	} else {
		$output = $submitted;
	}
	return $output;
}
$ArrayAmount = 0;
?>