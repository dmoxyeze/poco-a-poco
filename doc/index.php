<?php 
//define your databse connection
//you can use objects or pdo instead
$con = mysqli_connect('localhost','root','password','quora');
include 'Doc.php';
$filepath = 'the file path to where your docx file is';
//instiantiate the DocxConversion class and pass your file path as an argument 
$document =  new Doc($filepath);
// call the read_docx method in the DocxConversion class to read the document
$res =  $document->read_docx();
///convert the read document to text format
$test_result =  $document->convertToText();

///write the converted file to a text file. here  i used schools.txt
//feel free to choose another name
//NB: you can write to existing text file or create a new one using fopen function
$myfile = fopen("schools.txt", "w");
//now we write to the text file(schools.txt) created
fwrite($myfile, $test_result);
//fclose
fclose($myfile);
//open file for reading this time
//NB: we are able to read from schools.txt because we already created it above
$myfile = fopen("schools.txt", "r");
$number = 1;
// use a while loop to get each line in the text file
while(!empty($line = fgets($myfile))){
	//populate a table int the database using data from each line in the text file
	$query= mysqli_query($con,"INSERT INTO institution(name)VALUES('$line')");
	if ($query) {
		//we are incrementing this to check how many times the query passed
		$number = $number+1;
	}
	//echo $number++ ."  ". $line."<br>";
}
//prints out the number of files sent to the database
echo $number;
//var_dump($line);








?>