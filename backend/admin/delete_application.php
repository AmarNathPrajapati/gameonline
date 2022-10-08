<?php 
  include('../config.php');
    if ($_POST["doc_id"]) {

        $from_location=$_POST['from_location'];
    $stmt="UPDATE `applications_by_agents` SET deleted_at=? WHERE id=(?)";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    $timestamp=date("Y-m-d H:i:s");
    mysqli_stmt_bind_param($sql,"si",$timestamp,$_POST['doc_id']);

    $result=mysqli_stmt_execute($sql);
        if ($result) {
            mysqli_stmt_close($sql);
            mysqli_close($conn);
            echo "<script>alert('Successfully deleted.');
                        window.location.href='../../frontend/admin/".$from_location."';
                        </script>";
        } else {
        echo mysqli_error($conn);
        mysqli_stmt_close($sql);
        mysqli_close($conn);
        echo "<script>alert('Something went wrong. We are facing some technical issue. It will be resolved soon.');
        window.location.href='../../frontend/admin/".$from_location."';
        </script>";
        }
    } 
    else {

        mysqli_close($conn);
        echo '<script>
        alert("Something went wrong. We are facing some technical issue. It will be resolved soon. "'.mysqli_error($conn).')
        window.location.href="../../frontend/admin/'.$from_location.'"
        <script>';
    }
    
?>