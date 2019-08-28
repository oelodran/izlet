<?php
/**
 * Created by PhpStorm.
 * User: leona
 * Date: 26.8.2019.
 * Time: 16:21
 */

$database = new mysqli('localhost', 'wind', 'wind', 'northwind');

if ($database->connect_errno)
{
    $msg = 'Database connection failed: ';
    $msg .= $database->connect_error . "( " . $database->connect_errno . " )";
    exit($msg);
}


if (isset($_POST['submit']))
{
    $q = $database->real_escape_string($_POST['q']);
    $column = $database->real_escape_string($_POST['column']);
    $date1 = $database->real_escape_string($_POST['order_date']);
    $date2 = $database->real_escape_string($_POST['order_date1']);

//    if ($column == "" || ($column != "ship_name" && $column != "ship_city"))
//    {
//        $column = "ship_name";
//    }

    if ($column)
    {
        $sql = $database->query("SELECT * FROM orders WHERE $column LIKE '$q%'");
        if ($sql->num_rows > 0)
        {
            while ($result = $sql->fetch_assoc())
            {
                echo $result["{$column}"] . '<br>';
            }
        }
        else
        {
            echo "Your search query doesn't match any data!";
        }
    }
    else
    {
        $sql = $database->query("SELECT order_date FROM orders WHERE order_date BETWEEN '$date1' AND '$date2'");

        if ($sql->num_rows > 0)
        {
            while ($result = $sql->fetch_assoc())
            {
                echo $result['order_date'] . '<br>';
            }
        }
        else
        {
            echo "Your search query doesn't match any data!";
        }
    }

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
</head>
<body>
<form action="zadatak1.php" method="post">
    <input type="text" name="q" placeholder="search">
    <select name="column">
        <option value="">Select Filter</option>
        <option value="ship_name">Ship Name</option>
        <option value="ship_city">Ship City</option>
    </select> from
    <input type="date" name="order_date"> to
    <input type="date" name="order_date1">
    <input type="submit" name="submit" value="Find">
</form>
</body>
</html>
