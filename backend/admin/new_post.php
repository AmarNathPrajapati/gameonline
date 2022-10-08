<?php

include('../config.php');

$redirect_to="../../frontend/admin/manage_posts.php";
if (!empty($_POST['post_title']) && !empty($_POST['active']) && $_FILES["document"] ) {
        $file=$_FILES['document'];
        $post_title=$_POST['post_title'];
        $active=$_POST["active"];
        // echo $file;
        // $fromlocation=$_POST["from_location"];
        $fileName=$_FILES['document']['name'];
        $fileTmpName=$_FILES['document']['tmp_name'];
        $fileSize=$_FILES['document']['size'];
        $fileError=$_FILES['document']['error'];
        $fileType=$_FILES['document']['type'];
        $fileExt=explode('.',$fileName);
        $fileActualExt=strtolower(end($fileExt));
        $allowed=array('pdf','jpg','png','jpeg','docs','docx',"mp4");
        $fileNameNew= $fileExt[0].uniqid('',true).".".$fileActualExt;
       if (in_array($fileActualExt,$allowed)) {
           if ($fileError==0) {
               if ($fileSize<=6000000) {
                   $structure = '../../documents/posts';
                        if(!is_dir($structure)){
                          
                            //Directory does not exist, so lets create it.
                            mkdir($structure, 0777, true);
                            $fileDestination=$structure."/".$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);

                            $stmt="INSERT INTO `posts` (post_title,post_description,file,file_type,active) VALUES (?,?,?,?,?)";
                            $sql=mysqli_prepare($conn, $stmt);
                        
                            //binding the parameters to prepard statement
                           
                            if ($_POST["post_description"]) {
                                $post_description=$_POST["post_description"];
                            } else {
                                $post_description="Not Available";
                            }
                            
                            mysqli_stmt_bind_param($sql,"ssssi",$post_title,$post_description,$fileNameNew,$fileActualExt,$active);
                        
                            $result=mysqli_stmt_execute($sql);
                        
                            if ($result) {
                                echo '<script>
                            alert("Successfully!! Uploaded the file.");
                            window.location.href="'.$redirect_to.'";
                            </script>';
                            } 
                            else {
                               echo mysqli_error($conn);
                        
                                echo '<script>
                                alert("Something went wrong. We are facing some technical issue. It will be resolved soon. "'.mysqli_error($conn).')
                                window.location.href="'.$redirect_to.'"
                                <script>';
                            }
                            
                        }
                        else{
                            $fileDestination=$structure."/".$fileNameNew;

                            move_uploaded_file($fileTmpName, $fileDestination);
                            $stmt="INSERT INTO `posts` (post_title,post_description,file,file_type,active) VALUES (?,?,?,?,?)";
                            $sql=mysqli_prepare($conn, $stmt);
                        
                            //binding the parameters to prepard statement
                           
                            if ($_POST["post_description"]) {
                                $post_description=$_POST["post_description"];
                            } else {
                                $post_description="Not Available";
                            }
                            
                            mysqli_stmt_bind_param($sql,"ssssi",$post_title,$post_description,$fileNameNew,$fileActualExt,$active);
                        
                        
                            $result=mysqli_stmt_execute($sql);
                        
                            if ($result) {
                                echo '<script>
                                        alert("Successfully!! Uploaded the file.");
                                        window.location.href="'.$redirect_to.'";
                                      </script>';
                            } 
                            else {
                               echo mysqli_error($conn);
                        
                                    echo '<script>
                                            alert("Something went wrong. We are facing some technical issue. It will be resolved soon. "'.mysqli_error($conn).')
                                            window.location.href="'.$redirect_to.'"
                                        <script>';
                            }
                            
                            
                        }

                }

                else {
                    // error is due to larger file
                    $fileSizeInMb=$fileSize/1000;
                   
                    echo '<script>
                     alert("Your file size is'. $fileSizeInMb.'kb. Only less than 6MB files are supported.");
                     window.location.href="'.$redirect_to.'";
                    </script>';
                }

           }
           else{
            echo $fileError;
            echo '<script>
            alert("Sorry there is an error in your file ->'.$fileError.'");
            window.location.href="'.$redirect_to.'";
           </script>';
           }
       }
       else {
        echo '<script>
        alert("Your file of type *'.end($fileExt).'* . This type of File formate is not supported.");
        window.location.href="'.$redirect_to.'";
        </script>';
       }
    
}
else{
    echo '<script>
    alert("Technical Issue.");
    window.location.href="'.$redirect_to.'";
    </script>';   
}

?>