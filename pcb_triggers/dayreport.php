<?php
    session_start(); 
    require("database.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST")   {
        $date=date("Y-m-d");
        $IncomeTotal=$_POST["IncomeTotal"];
        $ExpenseTotal=$_POST["ExpenseTotal"];
        $OpeningBalance=$_POST["OpeningBalance"];
        $ClosingBalance=$_POST["ClosingBalance"];
        $sql="INSERT INTO dailyreport (IncomeTotal, ExpenseTotal, OpeningBalance, ClosingBalance, date) VALUES(?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iiiis", $IncomeTotal,$ExpenseTotal,$OpeningBalance,$ClosingBalance, $date);
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
            } else {
                echo "Something went wrong... cannot redirect!";
                echo "Error: " . mysqli_stmt_error($stmt); // New error handling code
            }
        }
        $_SESSION['lastreported'] = date("Y-m-d");
        mysqli_stmt_close($stmt);
    }
    include("index.php");
    exit;
?>
<script>

</script>