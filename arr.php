<?php


$surnames = array('Makgato','Tjabadi','Xhala','Khumalo','Mailula','Moima',
'Sehla','Dimba','Sehlako','Rakgoropo','Dube','Sebola','Motlokwa','Chewa','Kgowa',
'Setswa','Batlodi','Kwena','Tlou','Mahlangu');
$names = array('Maropeng Sinah','Matiye Ponthso','Alexander  Marno','Alford','Senzo','Sihle','Alston','Nelson','Asanda','Minenhle',
'Andrew','Donald','Arnold','William','Ashley','Sibahle','Ntwentle','Ayanda','Ayala','Neilwe');



$iterations = $_GET["value"];
if($iterations>20 || $iterations<1)
{
	echo '<a href="form.php">Click here to Re-Enter</a><br><br>';
	exit("Invalid entry, please try again");

	
}
?>

The file will generate <?php echo $iterations; ?> rows <br><br>

<?php

echo '<a href="form.php">Click here to try try again</a><br><br>';


?>

<?php
$rand_names = array_rand($names, $iterations);
$rand_surnames = array_rand($surnames, $iterations);

$final_name = [];
$final_surname = [];
$v=[];

date_default_timezone_set('Africa/Johannesburg');


$fp = fopen('output/output.csv', 'w');


foreach ($rand_names as $name) {
    $final_name[] = $names[$name];


    $years =  rand(date('Y')-130, date('Y'));
    $month =  rand(1, 12);
	if($month==2 && $years%4==0)
	{	
	$day =  rand(1, 29);
	}
	else
		if($month==2)
		{
			$day =  rand(1, 28);
		}
		else
			if($month%2==1|| $month==12)
			{	
			$day =  rand(1, 31);
			}
			else
				$day =  rand(1, 30);


    $complete_date[] = $day . '/' . $month . '/' . $years;

    $generated_date = (array_unique($complete_date));

    $age[] = date('Y')-$years;
}

$count_name = count($final_name);

  

$final_name = array_chunk($final_name, 1);
$final_age = array_chunk($age, 1);
$final_date = array_chunk($generated_date, 1);


// Surnames
foreach ($rand_surnames as $surname) {
    $final_surname[] = $surnames[$surname];
}
$final_surname = array_chunk($final_surname, 1);





fputcsv($fp, ['id', 'name', 'surname','initials', 'age', 'date_of_birth']);

for ($i = 0; $i < $iterations; $i++) {

    $name_data = ($final_name[$i]);
    $surname_data = ($final_surname[$i]);
    $age = $final_age[$i];
    $date = $final_date[$i];
	
$names=strval($name_data[0]); 
$name1 = explode(" ", $names);
$initials = "";

foreach ($name1 as $w) {
  $initials .= mb_substr($w, 0, 1);
}

    fputcsv($fp, [$i+1, $name_data[0], $surname_data[0],$initials, $age[0], $date[0]]);
}


fclose($fp);


