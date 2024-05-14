<?php
    include("reports.php");
    require("database.php");
    if(isset($_POST["submitd"])){
        $dateee=$_POST["daate"];
        $queryi = "SELECT * from income where date='$dateee'";
        $resulti = mysqli_query($conn,$queryi);
        $querye = "SELECT * from expense where date='$dateee'";
        $resulte = mysqli_query($conn,$querye);
        $queryob = "SELECT 
                    (SELECT COALESCE(SUM(iamount), 0) FROM income WHERE date < '$dateee') -
                    (SELECT COALESCE(SUM(eamount), 0) FROM expense WHERE date < '$dateee') AS net_balance;";
        $resultob = mysqli_query($conn,$queryob);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        #pcb{
            justify-content: center;
            text-align: center;
        }
        #myTablei{
            width: 50%;
        }
        #tble{
            display: flex;
            flex-direction: row;
        }
</style>
</head>
<body>
    <!-- <h3>select date : </h3> -->
    <br><br>
    <form method="post" action="dailyreport.php">
        <label for="date">Select a Date:</label>
        <input type="date" id="date" name="daate" value="<?php echo date('Y-m-d') ?>">
        <br><br>
        <input type="submit" value="Submit" name="submitd">
    </form>
    <br><br>
    <?php
        if(isset($_POST["submitd"])){
            if(mysqli_num_rows($resulti) == 0 && mysqli_num_rows($resulte) == 0) {
                echo "No records found for the selected date.";
            }
            else{
    ?>
    <table>
        <thead>
            <tr>
                <!-- <th colspan="1">Petty Cash Book</th> -->
                <th id="pcb" colspan="4" scope="col-group">Petty Cash Book</th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th width="25%">Date:</th>
                <td width="25%" id="idd">
                    <?php
                        echo $dateee;
                    ?>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td width="25%"></td>
                <td width="25%"></td>
                <th width="25%">Opening balance:</th>
                <td width="25%">
                    <?php
                        $row=mysqli_fetch_assoc($resultob);
                        $ob = $row["net_balance"];
                        echo $ob;
                    ?>
                </td>
            </tr>
        </thead>
    </table>
    <div id="tble">
        <table id="myTablei">
            <tr>
                <th width="25%">Income Head</th>
                <th width="25%">Amount</th>
                
            </tr>
            <tr>
                <?php 
                    $it=0;
                    while($row=mysqli_fetch_assoc($resulti)){
                ?>
                <td><?php echo $row["ihead"] ?></td>
                <td><?php
                        echo $row["iamount"];
                        $it=$it+$row["iamount"]; 
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <table id="myTablei">
            <tr>
                
                <th width="25%">Expense Head</th>
                <th width="25%">Amount</th>
            </tr>
            <tr>
                <?php
                    $et=0;
                    while($row=mysqli_fetch_assoc($resulte)){
                ?>
                <td><?php echo $row["ehead"] ?></td>
                <td><?php
                        echo $row["eamount"];
                        $et=$et+$row["eamount"];
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <div id="tble">
        <table id="myTablei">
            <thead>
                <tr>
                    <th width="25%">Income Total:</th>
                    <td width="25%"><?php echo "$it" ?></td>
                </tr>
            </thead>
        </table>
        <table id="myTablei">
            <thead>
                <tr>
                    <th width="25%">Expense Total:</th>
                    <td width="25%"><?php echo "$et" ?></td>
                </tr>
            </thead>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <td width="25%"></td>
                <td width="25%"></td>
                <th width="25%">Closing balance:</th>
                <td width="25%">
                    <?php
                        $cb=$ob+($it-$et);
                        echo $cb;
                    ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php } } ?>
</body>
</html>