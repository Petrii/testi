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
?>
