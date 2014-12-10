<?php

include 'functions.php';
function test($file, $e0, $isArray/*Onko $e0 array*/){
	$list = readList($file);
	$i=0;
	$j=1;
	$result = "OK";
	if($isArray){
		foreach($list as $r => $id){
				if($id[0] != $e0[0][$i] && $id[1] != $e0[$j=$j+2]){
					$result = "ERROR";
				}
				//echo $id[0]." - ". $id[1]."<br />";
				$i++;
		}
	} else {
		if($list != $e0)
			echo "ERROR";
		else
			echo "OK";
	}
	return $result;
}
echo "<h1>1.</h1>";
echo test('CompanyList.csv', $values = array('0', 'yritys0', 
'1', 'yritys1',
'2', 'yritys2',
'3', 'yritys3',
'4', 'yritys4',
'5', 'yritys5',
'6', 'yritys6',
'7', 'yritys7',
'8', 'yritys8',
'9', 'yritys9',
'10', 'yritys10',), TRUE);
echo "<h1>2.</h1>";
test('logout.php', 'Wrong file format!', FALSE);
echo "<h1>3.</h1>";
test('www.google.fi/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#sourceid=chrome-psyapi2&ie=UTF-8&q=google', 'The file www.google.fi/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#sourceid=chrome-psyapi2&ie=UTF-8&q=google does not exist' , FALSE);
echo "<h1>4.</h1>";
test('../jee.txt', 'Wrong file format!', FALSE);
echo "<h1>5.</h1>";
test('eiTiedostoa' , 'The file eiTiedostoa does not exist' , FALSE);
echo "<h1>6.</h1>";
test('nope', 'Epic fail "nope";-P', FALSE);
?>
