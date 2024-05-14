<?php
    $today = date("Y-m-d");
    if(isset($_POST["submite"])){
        $ehead=$_POST["ehead"];
        $eamount=$_POST["eamount"];
        $date=date("Y-m-d");
        if(!empty($ehead)){
            if(!empty($eamount)){
                require("database.php");
                $sql="INSERT INTO expense (ehead, eamount,date) VALUES(?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sis", $ehead, $eamount, $date);
                    if (mysqli_stmt_execute($stmt)) {
                        header("location: index.php");
                    } else {
                        echo "Something went wrong... cannot redirect!";
                        echo "Error: " . mysqli_stmt_error($stmt); // New error handling code
                    }
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if(isset($_POST["submiti"])){
        $ihead=$_POST["ihead"];
        $iamount=$_POST["iamount"];
        $date=date("Y-m-d");
        if(!empty($ihead)){
            if(!empty($iamount)){
                require("database.php");
                $sql="INSERT INTO income (ihead, iamount,date) VALUES(?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "sis", $ihead,$iamount,$date);
                    if (mysqli_stmt_execute($stmt))
                    {
                        header("location: index.php");
                    }
                    else{
                        echo "Something went wrong... cannot redirect!";
                    }
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    require("database.php");
    $dateee=date("Y-m-d");
    $queryi = "SELECT * from income where date='$dateee'";
    $resulti = mysqli_query($conn,$queryi);
    $querye = "SELECT * from expense where date='$dateee'";
    $resulte = mysqli_query($conn,$querye);
    $queryob = "SELECT 
                (SELECT COALESCE(SUM(iamount), 0) FROM income WHERE date < CURRENT_DATE) -
                (SELECT COALESCE(SUM(eamount), 0) FROM expense WHERE date < CURRENT_DATE) AS net_balance;";
    $resultob = mysqli_query($conn,$queryob);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            width: 20%;
            height: 50%; 
            border-radius: 15px;
        }

        .form-container form {
            width: 333px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container h2 {
            text-align: center;
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 6px;
            border-radius: 3px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .form-container input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .forms {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
        } */

    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align: center;
    }

    .forms {
        display: flex;
        flex-wrap: wrap; /* Allow flex items to wrap to next line */
        justify-content: space-evenly;
    }

    .form-container {
        width: 30%; /* Adjust width for larger screens */
        margin-bottom: 20px;
        border-radius: 15px;
    }

    .form-container form {
        width: 100%; /* Fill the available width */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container h2 {
        text-align: center;
        margin-top: 0;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
    }

    .form-container input[type="text"],.form-container input[type="number"],
    .form-container textarea {
        width: 97%;
        padding: 6px;
        border-radius: 3px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .form-container input[type="submit"] {
        width: 100%; /* Fill the available width */
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .form-container input[type="submit"]:hover {
        background-color: #45a049;
    }

    @media screen and (max-width: 768px) {
        .form-container {
            width: 100%; /* On smaller screens, take up full width */
        }
    }
        #date {
            padding: 0 6px;
        }

        /* table {
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
        } */
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
        ul.topnav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        ul.topnav li {float: left;}

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) {background-color: #111;}

        ul.topnav li a.active {background-color: #04AA6D;}

        ul.topnav li.right {float: right;}

        @media screen and (max-width: 600px) {
            ul.topnav li.right, 
            ul.topnav li {float: none;}
        }
    </style>
</head>
<body>
    <h1>Petty Cash Book</h1>
    <ul class="topnav">
        <li><a class="active" href="#home">Home</a></li>
        <li><a href="reports.php">View Reports</a></li>
        <li class="right"><a href="#">Logout</a></li>
    </ul>
    <br><br>
    <div class="forms">
        <div class="form-container">
            <form id="form1" method="post" action="index.php">
                <h2>Income Head</h2>
                <label for="name1">incomehead</label>
                <input type="text" name="ihead" id="ihead" required><br><br>
                <label for="amount1">Amount:</label>
                <input type="number" name="iamount" id="iamount" required><br><br>
                <input type="submit" name="submiti" value="Submit">
            </form>
        </div>

        <div class="form-container">
            <form id="form2" method="post" action="index.php">
                <h2>Expense Head</h2>
                <label for="name2">expensehead</label>
                <input type="text" name="ehead" id="ehead" required><br><br>
                <label for="amount2">Amount:</label>
                <input type="number" name="eamount" id="eamount" required><br><br>
                <input type="submit" name="submite" value="Submit">
            </form>
        </div>
    </div>
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
                        echo date("Y-m-d");
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
    <br><br>
    
</body>
</html>