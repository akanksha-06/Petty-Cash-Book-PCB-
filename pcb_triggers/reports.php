<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    h1{
        text-align: center;
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
<body>
    <h1>Petty Cash Book</h1>
    <ul class="topnav">
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="#">View Reports</a></li>
        <li class="right"><a href="index.jsp">Logout</a></li>
    </ul>
    <br><br>
    <ul class="topnav">
        <li><a href="dailyreport.php">Daily report</a></li>
        <li><a href="monthlyreport.php">Monthly report</a></li>
        <li><a href="yearlyreport.php">Yearly report</a></li>
    </ul>
</body>
</html>