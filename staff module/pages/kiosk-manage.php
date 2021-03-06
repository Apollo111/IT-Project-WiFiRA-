<!DOCTYPE html>
<?php
require '../classes/UserAccount.php';
?>
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Allura|Arima+Madurai|Cinzel+Decorative|Corben|Dancing+Script|Galindo|Gentium+Book+Basic|Great+Vibes|Henny+Penny|Indie+Flower|Kaushan+Script|Kurale|Life+Savers|Love+Ya+Like+A+Sister|Milonga|Miltonian+Tattoo|Niconne|Oregano|Original+Surfer|Pangolin|Parisienne|Philosopher|Princess+Sofia|Rancho|Risque|Salsa|Schoolbell|Special+Elite" rel="stylesheet">		
    </head>
<?php
    include 'fragments/head.php';
?>
<body>
       <?php
        //Start your session
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
            echo "You are logged in as, " . $_SESSION['username'] . "!";
        } else {
            header("location: login.php");
        }

        function echoActiveClassIfRequestMatches($requestUri){
            $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

            if ($current_file_name == $requestUri)
                echo 'class="active-menu"';
        }

    ?>
    
    <div id="wrapper">
        <?php include 'fragments/page-head.php'; ?>
        <!-- /. NAV TOP  -->
        <?php include 'fragments/sidebar-nav.php'; ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 style = "font-family: special elite; color:#000000">Manage Kiosks</h1>
                        
    <form id="search-form" name="search" action="" method="get">
    <input id="search-input" name="search" type="text">
    <input type="submit" name='submit' class="btn btn-warning" value="Search" class="col s6" class='submit' style="background-color:#686667; font-family:monospace; font-size:18px;"/>
                    </div>    
                </div>
                <div class="jumbotron"> 
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" name="anothercontent">
                        <?php
                            include 'fragments/kiosk-query.php';
                            if(isset($_POST['request_done'])){
                                $rid=$_POST['requestId'];
                                $sql = $pdo->prepare("update service_request set request_status=4, end_servicing = curdate()  where request_id = '$rid';");
                                $sql->execute();
                                //echo "<meta http-equiv='refresh' content='0'>";
                            }

                            if(isset($_POST['request_cancel'])){
                                $rid=$_POST['requestId'];
                                $sql = $pdo->prepare("update service_request set request_status=5 where request_id = '$rid';");
                                $sql->execute();
                                //echo "<meta http-equiv='refresh' content='0'>";
                            }
                        ?>
                    </table>
                </div>
                       <!--  <input type="submit" name='submit' class="btn btn-warning" value="Print" class="col s6" class='submit' style="background-color:#686667; font-family:monospace; font-size:18px;"/><br />    -->
                    <a class="btn btn-primary" href="#">
                    <i class="fa fa-pencil fa-lg"></i> Edit Kiosk</a>
                    <a class="btn btn-danger" href="#">
                    <i class="fa fa-trash-o fa-lg"></i> Delete</a>
            </div>
        </div>
    </div>

    <!-- The Modal -->
   <div id="reply_modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Request Details</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php
                         require_once 'fragments/connection.php';

                         $usr = $_SESSION['username'];
                         echo $usr;

                        $query = $pdo->prepare("
                                      SELECT * from kioskmachine;");
                        $query->execute();
                        $result = $query->fetchAll();

                        
                        foreach($result as $query){
                            echo "<tr>";
                            echo "<td>" . $query['kioskId'] . "</td>";
                            echo "<td>" . $query['kioskName'] . "</td>";
                            echo "<td>" . $query['location'] . "</td>";
                            echo "<td>" . $query['ipAddress'] . "</td>";
                            echo "<td>" . $query['kioskStatus'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";

                        ?>


                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Accept</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Reject</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>    
