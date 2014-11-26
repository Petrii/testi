<?php

include 'functions.php';
function test($name){
	$list = readList($name);
	foreach($list as $r => $id){
           echo $id[0]." - ". $id[1]."<br />";
        }
}
echo "<h1>1.</h1>";
test('CompanyList.csv');
echo "<h1>2.</h1>";
test('logout.php');
echo "<h1>3.</h1>";
test('www.google.fi/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#sourceid=chrome-psyapi2&ie=UTF-8&q=google');
echo "<h1>4.</h1>";
test('../jee.txt');
echo "<h1>5.</h1>";
test('eiTiedostoa');
echo "<h1>6.</h1>";
test('nope');
?>
