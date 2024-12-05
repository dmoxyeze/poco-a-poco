<?php
        if(isset($_POST['submit'])){
          if (isset ($_FILES['new_image'])){
            //upload path
              $storage_path = 'uploads/';
              //get the name of the uploaded image
              $imagename = $_FILES['new_image']['name'];
              //temporal storage location
              $source = $_FILES['new_image']['tmp_name'];
              //turn the name of the image into an array
              $imagename = explode(".", $imagename);
              //image extension
              $ext = end($imagename);
              //rename the image
              $imagename = md5($imagename[0]).".".$ext;
              //path to upload new image
              $target = "uploads/".$imagename;
              move_uploaded_file($source, $target);
              //where the new image is going to be saved and the new name it will take
              $destination = $storage_path.sha1(microtime()).".jpg";
              $tn_w = 400;
              $tn_h = 400;
              $quality = 100;
              //the image that will be used as watermark
              $wmsource = 'uploads/11.png';
              // this function does the watermarking
              $success = image_handler($target,$destination,$tn_w,$tn_h,$quality,$wmsource);
              //die($destination);
              $imagepath = $destination;
              //die($imagepath);
              $save = $destination; //This is the watermarked image we want to resize
              //we are duplicating it so as to create a thumbnail from it
              $file = $destination;
              list($width, $height) = getimagesize($file) ;
              //this is the width we will be resizing it to
              $modwidth = 200;

              $diff = $width / $modwidth;
              //this is the height
              //you can  use a number instead and forget about all these gibberish
              $modheight = $height / $diff;
              //create a blank image width our predefined width and height
              $tn = imagecreatetruecolor($modwidth, $modheight) ;
              //places the watermarked image unto the just created blank image
              $image = imagecreatefromjpeg($file) ;

              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
              //creates an image from the second image for the thumnail
              imagejpeg($tn, $save, 100) ;
              //rename it to know which is which
              $save = str_replace(".", "sml_.",$imagepath); //This is the name of the thumbnail
              $file = $imagepath; //This is the original file

              list($width, $height) = getimagesize($file) ;
              //thumbnail width
              $modwidth = 50;

              $diff = $width / $modwidth;
              //thumbnail height
              $modheight = $height / $diff;
              $tn = imagecreatetruecolor($modwidth, $modheight) ;
              $image = imagecreatefromjpeg($file) ;
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

              imagejpeg($tn, $save, 100) ;
              //this deletes the original image
              unlink($target);
          }
        }


        ///this function is for watermarking the image
    function image_handler($source_image,$destination,$tn_w = 100,$tn_h = 100,$quality = 80,$wmsource = false) {
    #find out what type of image this is
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);
    #assuming the mime type is correct
    switch ($imgtype) {
    case 'image/jpeg':
    $source = imagecreatefromjpeg($source_image);
    break;
    case 'image/gif':
    $source = imagecreatefromgif($source_image);
    break;
    case 'image/png':
    $source = imagecreatefrompng($source_image);
    break;
    default:
    die('Invalid image type.');
    }
    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);
    $src_ratio = $src_w/$src_h;
    #Do some math to figure out which way we will need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed
    if ($tn_w/$tn_h > $src_ratio) {
    $new_h = $tn_w/$src_ratio;
    $new_w = $tn_w;
    } else {
    $new_w = $tn_h*$src_ratio;
    $new_h = $tn_h;
    }
    $x_mid = $new_w/2;
    $y_mid = $new_h/2;
    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    imagecopyresampled($final, $newpic, 0, 0, ($x_mid-($tn_w/2)), ($y_mid-($tn_h/2)), $tn_w, $tn_h, $tn_w, $tn_h);
    #if we need to add a watermark
    if($wmsource) {
    #find out what type of image the watermark is
    $info = getimagesize($wmsource);
    $imgtype = image_type_to_mime_type($info[2]);
    #assuming the mime type is correct
    switch ($imgtype) {
    case 'image/jpeg':
    $watermark = imagecreatefromjpeg($wmsource);
    break;
    case 'image/gif':
    $watermark = imagecreatefromgif($wmsource);
    break;
    case 'image/png':
    $watermark = imagecreatefrompng($wmsource);
    break;
    default:
    die('Invalid watermark type.');
    }
    #if we are adding a watermark, figure out the size of the watermark
    #and then place the watermark image on the bottom right of the image
    $wm_w = imagesx($watermark);
    $wm_h = imagesy($watermark);
    imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);
    }
    if(Imagejpeg($final,$destination,$quality)) {

      //die($destination);
    return true;
    }
    return false;
    }

?>
<form action="" method="post" enctype="multipart/form-data" id="something" class="uniForm">
        <input name="new_image" id="new_image" size="30" type="file" class="fileUpload" />
        <button name="submit" type="submit" class="submitButton">Upload Image</button>
</form>



