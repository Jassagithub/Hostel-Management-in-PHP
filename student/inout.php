<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();
    $cms = $_SESSION['cms'];
    $ret=mysqli_query($mysqli,"select * from student where cms='$cms'");
    $row=mysqli_fetch_array($ret);
    $name = $row['SName'];
    $room = $row['SRNo'];
    if(isset($_POST['submit'])){
        $going = $_POST['going'];
        $return = $_POST['return'];
        $reason = $_POST['reason'];
        $city = $_POST['place']; 
        $sql = "INSERT INTO `studentin_out`(`cms`, `leavedate`, `returndate`, `reason`, `city`) VALUES ('$cms','$going','$return','$reason','$city')";
        $query = $mysqli->query($sql);
        if($query){
            echo "<script>alert('Your status has been updated successfully');</script>";
        }else{
            echo "<script>alert('Something went wrong');</script>";
        }
    }
    elseif(isset($_POST['deleteentry'])){
        $id = $_POST['id'];
        $sql = "DELETE FROM `studentin_out` WHERE id='$id'";
        $query = $mysqli->query($sql);
        if($query){
            echo "<script>alert('Your status has been updated successfully');</script>";
        }else{
            echo "<script>alert('Something went wrong');</script>";
        }

    }
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <script></script>
</head>

<body style="font-family: Raleway;">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <?php include '../includes/student-navigation.php'?>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include '../includes/student-sidebar.php'?>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My In Out Activity</h4>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Going Date</th>
                                            <th>Returning Date</th>
                                            <th>Reason</th>
                                            <th>Place</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT id,LeaveDate, ReturnDate, Reason, City FROM studentin_out WHERE cms = '$cms'";
                                            
                                            $result = mysqli_query($mysqli, $sql);
                                            $row = mysqli_num_rows($result);
                                            if($row > 0){
                                                while($row = mysqli_fetch_array($result)){
                                                    echo "<tr><td>".$row['id']."</td><td>".$row['LeaveDate']."</td><td>".$row['ReturnDate']."</td><td>".$row['Reason']."</td><td>".$row['City']."</td></tr>";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Delete a Record</h4>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">ID of Record</h4>
                                            <div class="form-group mb-4">
                                                <input type="text" id="id" name="id" placeholder="Enter ID of Record" value="" required class="form-control">
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <h4 class="card-title"></h4>
                                    <div class="form-group mb-4" style="padding-top: 41px;">
                                        <button type='submit' class='btn' name='deleteentry'><img src='../assets/images/delete.png' width='25px'></button>
                                    </div>         
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                
                <form method="POST">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Student's In Out Form</h4>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">CMS</h4>
                                            <div class="form-group mb-4">                                        
                                                <input type="text" id="cms" name="cms" placeholder="Enter CMS No." value="<?php echo $cms?>" readonly required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Name</h4>
                                            <div class="form-group mb-4">
                                                <input type="text" id="name" name="name" placeholder="Enter Name" value="<?php echo $name?>" readonly required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Reason</h4>
                                            <div class="form-group">
                                                <input type="text" id="seater" name="reason" placeholder="Reason" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Going Date</h4>
                                            <div class="form-group">
                                                <input type="date" name="going" id="stayf" class="form-control" required>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Returning Date</h4>
                                            <div class="form-group">
                                                <input type="date" name="return" id="stayf" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Place</h4>
                                            <div class="form-group">
                                                <input type="text" id="seater" name="place" placeholder="Place" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                            <div class="form-actions">
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                </div>  
                            </div>
                        </div>
                    </div>
                </form>

                <?php include '../includes/footer.php' ?>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>

</html>