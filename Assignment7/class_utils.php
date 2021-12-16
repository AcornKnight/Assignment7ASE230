<?php

// JSON Class and methods
class JSONHelper {
  // Properties
 

  // Methods
  
	# Reading the content of a JSON file into a php array
	function read_json() {
		// Read the JSON file 
		$class = file_get_contents('class.json');
		
		$classarr=[];
		// Decode the JSON file
		$classarr = json_decode($class,true);
		
		return $classarr;
	}
	
	# Reads the content of a JSON file into a php array and returning 1 element
	function read_jsonelement($i) {
			// Read the JSON file 
		$class = file_get_contents('class.json');
  
		$classarr=[];
		// Decode the JSON file
		$classarr = json_decode($class,true);
		
		return $classarr[$i];
	}
	
	# Saves a php array into a JSON file
	function save_phptojson($phparray){
		# Opens the file for writing
		$change=fopen($file,'w+');
		
		# This will take the changed array and save the php array to json
		$jsonarray = json_encode($phparray);
		fwrite($change,$jsonarray);
		fclose($change);
	}
	
	function delete_json($classarr) {
		//		Deletes content of a JSON file
		if(isset($_POST['delete'])) {
					//echo "Deleting at Index block". $_POST['index'];
					unset($classarr[$_POST['index']];
					echo 'That Element was deleted.';
					savephptojson($classarr);
				}
	}
	
	function modify_json($classarr){
		//		Modifies content of a JSON file
		if(isset($_POST['modify'])) {
					//echo "Modifying Element at Index block". $_POST['index'];
					$classarr[$_POST['index']]['name'] = 'Sabaton'; 
					echo 'That Element was modified.';
					savephptojson($classarr);
				}
	}
	
	function create_json($classarr){
		//		creates a new json array into a file
		if(isset($_POST['added'])) {
					//echo "Modifying Element at Index block". $_POST['index'];
					$appendelement = $classarr[0];
					array_push($appendelement);
					echo 'An Element was added.';
					savephptojson($classarr);
				}
	}
}

// CSV Class Methods
class CSVHelper {
  // Properties
  public $name;
  public $color;

  // Methods
	function addContent($userFile, $author,$newContent) {
	//		Adds new content to the csv file
			file_put_contents($userFile,"\n$author,$newContent",FILE_APPEND);
	//			fclose($newFile);
	}
	
	function emptyContent($userFile,$line) {
			//		emptys the content of a element in a csv file
			modifyLine($userFile, $line, '');
	}
	
	function modifyLine($userFile,$line, $change) {
			//		Modifies the content of an element in the file
			$contentArray=readContentHeader($userFile);
			$headers=getHeader($userFile);
			$contentArray[$line]['Quote']= $change;
			array_unshift($contentArray,$headers);
			print_r(quoteToString($contentArray));
			
			file_put_contents($userFile,quoteToString($contentArray));
			
	}
	
	function deleteContent($userFile,$line) {
			// Deletes the content of a csv file
			$modify = fopen($userFile,'r+') or die("That csv file does not exist.");
			
			
			$contentArray=readContentHeader($userFile);
			$headers=getHeader($userFile);
			array_unshift($contentArray,$headers);
			print_r($contentArray);
		
			array_splice($contentArray, $line+1, 1);
		
			file_put_contents($userFile,quoteToString($contentArray));
	}
}

// Authentication Class Methods
class AuthHelper {
  // Properties


  // Methods
  function signin($data, $file){
	// add the body of the function based on the guidelines of signin.php
		if(isset($data['email'])){
			$database=fopen($file,'r');
			while(!feof($database)){
				$line=explode(';',fgets($database));
				if($line[1]==$data['email']){
					fclose($database);
					$_SESSION = $_SESSION['logged'];
					header('location: ../../index.php');
					die('Congratulations, you are logged in!');
				}
			}
			die('The user does not exist.')
		}	
	}
	
	function signout(){
	// Signs a user out and cancels their session
		session_start();
		unset($_SESSION['username']);
		header('location: index.php');
		session_destroy();
	}
	
	function signup($data,$file){
	// Signs a user up
	if(isset($data['email'])){
		$data=implode(';',$data);
		$database=fopen($file,'w');
		fwrite($database,$data['email']);
		echo ('Account registered');
		session_start();
		$_SESSION['userID']=3;
	}
	
	//check if the password is correct and the email is valid
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo 'Your email is invalid';
	}
	if ((isset($_POST['email'])) {
		$username = mysqli_real_escape_string($_POST['name']); 
		$email = mysqli_real_escape_string($_POST['email']); 
		$password = mysqli_real_escape_string($_POST['password']);
		$password2 = mysqli_real_escape_string($_POST['password2']);
		
		if ($password != $password2) {
			echo 'The passwords do not match';
			header('location: index.php');
			session_destroy();
		}
		// Hashes the password
		else {
			$password = md5($password);
		}	
	
	}
}

// Entity Class Methods
class EntityHelper {
  // Properties
 

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
}
?>