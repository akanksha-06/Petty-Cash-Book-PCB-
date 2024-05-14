<?php
    include("reports.php");
    require("database.php");
    if(isset($_POST["submitm"])){
        $year = $_POST["sel"];
        $querym = "SELECT 
        MONTH(date) AS month,
        SUM(IncomeTotal) AS total_income,
        SUM(ExpenseTotal) AS total_expense,
        (
            SELECT OpeningBalance 
            FROM dailyreport AS t2 
            WHERE MONTH(t2.date) = MONTH(t1.date) AND YEAR(t2.date) = YEAR(t1.date) 
            ORDER BY t2.date ASC 
            LIMIT 1
        ) AS total_ob,
        (
            SELECT ClosingBalance 
            FROM dailyreport AS t3 
            WHERE MONTH(t3.date) = MONTH(t1.date) AND YEAR(t3.date) = YEAR(t1.date) 
            ORDER BY t3.date DESC 
            LIMIT 1
        ) AS total_cb,
        date
    FROM 
        dailyreport AS t1
    GROUP BY 
        MONTH(date)
    ORDER BY 
        MONTH(date);";
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
    <form method="post" action="yearlyreport.php">
        <label for="sel">Enter year : </label>
        <input type="number" name="sel" value="<?php echo date('Y') ?>">
        <input type="submit" value="submit" name="submitm">
    </form>
    <br><br>
    <?php
        if(isset($_POST["submitm"])){
            if(mysqli_num_rows($resultm)==0){
                echo "No records found for the selected year";
            }else{
    ?>
    <center>
        <table id="myTablei">
            <thead>
                <th>Month</th>
                <th>Total Income</th>
                <th>Total Expense</th>
                <th>Opening Balance</th>
                <th>Closing Balance</th>
            </thead>
            <tr>
                <?php
                    $monthh="";
                    while($row = mysqli_fetch_assoc($resultm)){
                        switch($row["month"]){
                            case 1:
                                $monthh="January";
                                break;
                            case 2:
                                $monthh="February";
                                break;
                            case 3:
                                $monthh="March";
                                break;
                            case 4:
                                $monthh="April";
                                break;
                            case 5:
                                $monthh="May";
                                break;
                            case 6:
                                $monthh="June";
                                break;
                            case 7:
                                $monthh="July";
                                break;
                            case 8:
                                $monthh="August";
                                break;
                            case 9:
                                $monthh="September";
                                break;
                            case 10:
                                $monthh="October";
                                break;
                            case 11:
                                $monthh="November";
                                break;
                            case 12:
                                $monthh="December";
                                break;
                        }
                ?>
                <td><?php echo $monthh ?></td>
                <td><?php echo $row["total_income"] ?></td>
                <td><?php echo $row["total_expense"] ?></td>
                <td><?php echo $row["total_ob"] ?></td>
                <td><?php echo $row["total_cb"] ?></td>
            </tr>
            <?php } } } ?>
        </table>
    </center>
    
</body>
</html>