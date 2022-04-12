<?php
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["icon"]) && $_FILES["photo"]["icon"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["icon"]["name"];
        $filetype = $_FILES["icon"]["type"];
        $filesize = $_FILES["icon"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error! Please select jpg., jpeg, png file.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error!The maximum of file is 5MB");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $filename)){
                echo $filename . " is already exists.";
            } else{
                move_uploaded_file($_FILES["icon"]["tmp_name"], "upload/" . $filename);
                echo "Uploaded successfully.";
            } 
        } else{
            echo "Error! Please upload again."; 
        }
    } else{
        echo "Error: " . $_FILES["icon"]["error"];
    }
}

//stores it in a temporary directory on the web server
if($_FILES["icon"]["error"] > 0){
    echo "Error: " . $_FILES["icon"]["error"] . "<br>";
} else{
    echo "File Name: " . $_FILES["icon"]["name"] . "<br>";
    echo "File Type: " . $_FILES["icon"]["type"] . "<br>";
    echo "File Size: " . ($_FILES["icon"]["size"] / 1024) . " KB<br>";
    echo "Stored in: " . $_FILES["icon"]["tmp_name"];
    move_uploaded_file(file,newloc)
}
?>
