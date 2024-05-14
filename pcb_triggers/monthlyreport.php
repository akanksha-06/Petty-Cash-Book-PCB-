<?php
    include("reports.php");
    require("database.php");
    if(isset($_POST["submitm"])){
        $month = $_POST["sel"];
        $year = $_POST["yr"];
        $querym = "SELECT * from dailyreport where MONTH(date)='$month' and YEAR(date)='$year'";
        $resultm=mysqli_query($conn,$querym);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    th,td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    #myTablei{
        width: 80%;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
</style>
</head>
<body>
    <br><br>
    <form method="post" action="monthlyreport.php">
        <label for="sel" >Select a month : </label>
        <select name="sel">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <br><br>
        <label for="yr">enter year : </label>
        <input name="yr" type="number" value="2024">
        <br><br>
        <input type="submit" value="submit" name="submitm">
        <hr>
    </form>
    <br><br>
    <?php
        if(isset($_POST["submitm"])){
            if(mysqli_num_rows($resultm)==0){
                echo "No records found for the selected month";
            }else{
    ?>
    <center>
        <table id="myTablei">
            <thead>
                <th>date</th>
                <th>Total Income</th>
                <th>Total Expense</th>
                <th>Opening Balance</th>
                <th>Closing Balance</th>
            </thead>
            <tr>
                <?php
                    while($row = mysqli_fetch_assoc($resultm)){
                ?>
                <td><?php echo $row["date"] ?></td>
                <td><?php echo $row["IncomeTotal"] ?></td>
                <td><?php echo $row["ExpenseTotal"] ?></td>
                <td><?php echo $row["OpeningBalance"] ?></td>
                <td><?php echo $row["ClosingBalance"] ?></td>
            </tr>
            <?php } } } ?>
        </table>
    </center>
    
</body>
</html>