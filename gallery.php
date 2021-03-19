<!DOCTYPE html>
<html lang="en">
	<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>

<body style="background-color:#2B60DE">

<!--Drop down for sorting and button redirect--> 
  <label for="sort">Sort By:</label>
  <select name="sort" id="sort">
    <option value="name">Name</option>
    <option value="date">Date</option>
    <option value="location">Location</option>
    <option value="photographer">Photographer</option>
  </select>

  <br><br>
  <input type="button" onclick="window.location='http://ecs.fullerton.edu/~cs431s3/assignment1/';" value="Upload Photo">
  <div class="featured-image-block-grid">
  <div class="featured-image-block-grid-header small-10 medium-8 large-7 columns text-center">
  <h2>Sample Grid</h2>
  </div>
  <div class="row large-up-4 small-up-2">


<?php
 //Creates a directory for uploads and moves tmp to correct folder
 $target_dir = "uploads/";
 $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
 $uploadOk = 1;
 move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"uploads/".$_FILES["fileToUpload"]["name"]);
 $imageFileType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $uploads = 'uploads/';
  $checker = glob($uploads."*.{png,jpeg,jpg, gif}", GLOB_BRACE);

$photoFileNames = array();
//notification for empty gallery
if (empty($checker))
{
	echo 'Your Gallery is empty';
}

//function to create the gallery after the directory is opened
if ($directory = opendir($uploads))
{
   foreach($checker as $pathing)
   {
 //get photo path
   $info = pathinfo($pathing);


 //place file paths into an array
	array_push($photoFileNames, $pathing);

?>
	   <!-- Not Working, disregard
   <div class="featured-image-block column">
	<a href="#">
	<img src='<?php echo $pathing; ?>'/>
	   <p class="text-center featured-image-block-title"></p>
	 </a>
   </div>
   --> 
<?php
   }
}
?>

<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Photo metadata passed from input form from index.html
$photoName = $_POST['photoName'];
$photoDateTaken = $_POST['photoDateTaken'];
$photoPhotographer = $_POST['photoPhotographer'];
$photoLocation = $_POST['photoLocation'];
//This grabs the latest image upload since push adds to the front of the array.
$pathname = $photoFileNames[0];

//string used to write to file
if($photoName != '') {
$outputstring = $pathname. "\t".$photoName."\t".$photoDateTaken."\t"
.$photoPhotographer."\t".$photoLocation
."\t\n";

       // open file for appending
       @$fp = fopen("/home/titan0/cs431s/cs431s3/homepage/assignment1/photos.txt", 'ab');

       if (!$fp) {
         echo "<p><strong> Your photo could not be processed at this time.
               Please try again later.</strong></p>";
         exit;
       }

       flock($fp, LOCK_EX);
       fwrite($fp, $outputstring, strlen($outputstring));
       flock($fp, LOCK_UN);
       fclose($fp);
	}

//read file and create array 
//2d array that will hold photo path and metadata
$photosList = array
(
	
);
$photos= file("/home/titan0/cs431s/cs431s3/homepage/assignment1/photos.txt");

    $number_of_photos = count($photos);
    if ($number_of_photos == 0) {
      echo "<p><strong>No photos.<br />
            Please try again later.</strong></p>";
    }
 
    for ($i=0; $i<$number_of_photos; $i++) {
      //echo $photos[$i]."<br />";
	          //split up each line
			  $line = explode("\t", $photos[$i]);
			  //grab all of the metadata from file
			  array_push($photosList, array($line[0], $line[1], $line[2], $line[3], $line[4]) );
    }

	?>
	<!-- Loop through the 2d array, echo the image through the path and echo each metadata-->
	<div align="center">
<table style="width: 100%; border: 0">
  <tr>
  <?php
  for ($i = 0; $i < count($photosList); $i++) {
	  if($i != 0 && $i % 3 == 0){
		  echo "<tr>";
	  }
	echo "<td style=\"width: 33%; text-align: center\">
		  <img src=\"";
	echo $photosList[$i][0];
	echo "\"/>";
	echo "<br>";
	echo $photosList[$i][1];
	echo "<br>";
	echo $photosList[$i][2];
	echo "<br>";
	echo $photosList[$i][3];
	echo "<br>";
	echo $photosList[$i][4];
	echo "<br>";
	echo $i;
	echo "<br>";
	echo "</td>";
	
  }

  //sort functions, NOT WORKING ATM
  if ($sortby == 'photoName'){
	usort($ar2, function ($a, $b) {
	  return strcmp($a['photoname'], $b['photoname']);
	});
  }
if ($sortby == 'photoDateTaken'){
		  usort($ar2, function ($a, $b) {
			  return strcmp($a['photoname'], $b['photoname']);
		  });
		}
		if ($sortby == 'photoPhotographer'){
				usort($ar2, function ($a, $b) {
				  return strcmp($a['photoname'], $b['photoname']);
				});
			  }
		if ($sortby == 'photoLocation'){
					  usort($ar2, function ($a, $b) {
						  return strcmp($a['photoname'], $b['photoname']);
					  });
					}

  
  ?>
  </tr>
</table>
</div>
		</div>
	</div>
</body>
</html>

