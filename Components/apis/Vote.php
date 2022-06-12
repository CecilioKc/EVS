<?php
    error_reporting(1);
    include ('config.php');

    $Voter = $_POST['Voter'];
    $voterEmail = $_POST['voterEmail'];
    $President = $_POST['president'];
    $vicePresident = $_POST['vP'];
    $vicePresidentGirl = $_POST['vPG'];
    $generalSec = $_POST['gS'];
    $Trs = $_POST['Trs'];
    $infoMinister = $_POST['infoM'];
    $educationMinister = $_POST['educM'];
    
   
    $voterChecker = "SELECT * FROM students WHERE studentNo='$Voter' LIMIT 1";
    $voterCheckerRun = mysqli_query($conn, $voterChecker);
    $voterCheckerRunFinal = mysqli_fetch_array($voterCheckerRun);


    if($voterCheckerRunFinal == null) {?>
        <div class="w3-panel w3-small w3-sand w3-round" style="margin-left: 30px; margin-right: 30px;"><h2 class="w3-medium w3-text-red" style="margin: 10px;">
            <p><?php echo "Student's Number doesn't exist"; ?></p></h2>
        </div>
        <?php
        exit(0);
    } elseif ($voterCheckerRunFinal['voted'] == 'No' || $voterCheckerRunFinal['voted'] == '') {
        if (voteCaster($President) && voteCaster($vicePresident) 
            && voteCaster($vicePresidentGirl) && voteCaster($generalSec)
            && voteCaster($Trs) && voteCaster($infoMinister)
            && voteCaster($educationMinister) == true) {?>
            <div class="w3-panel w3-small w3-sand w3-round" style="margin-left: 30px; margin-right: 30px;"><h2 class="w3-medium w3-text-blue" style="margin: 10px;">
                <p><?php echo "Vote casted successfully, results at the closure of the voting process"; ?></p></h2>
            </div>
            <?php
            $voterStatusChanger = "UPDATE `students` SET `voted`='Yes' WHERE `studentNo`='$Voter'";
            $voterEmailUpdate = "UPDATE `students` SET `email`='$voterEmail' WHERE `studentNo`='$Voter'";
            mysqli_query($conn, $voterStatusChanger);
            mysqli_query($conn, $voterEmailUpdate);

            exit(0);
        } else {
            echo "Error during vote";
            exit(0);
        }

    } elseif ($voterCheckerRunFinal['voted'] == 'Yes') {?>
        <div class="w3-panel w3-small w3-sand w3-round" style="margin-left: 30px; margin-right: 30px;"><h2 class="w3-medium w3-text-red" style="margin: 10px;">
            <p><?php echo "Vote already casted, results at the closure of the voting process"; ?></p></h2>
        </div>
        <?php
        exit(0);
    } else {
        echo '';
    }

    function voteCaster($candidate) {
        global $conn;
        /* 
            get the post from the database
            matching the number
            get the count of that number
            then increamemnt the count by 1
            and alter the count in the database
        */
        $Query = "SELECT * FROM registeration WHERE studentNo='$candidate' LIMIT 1";
        $queryRun = mysqli_query($conn, $Query);
        $queryRunFinal = mysqli_fetch_array($queryRun);
        
        $newCount = $queryRunFinal['counts']+1;
        $castQuery = "UPDATE `registeration` SET `counts`='$newCount' WHERE `studentNo`='$candidate'";
        $castQueryRun = mysqli_query($conn, $castQuery); 
        return true;
    }
