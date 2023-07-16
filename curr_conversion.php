<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <h1>Currency Converter</h1>
        <form action="curr_conversion.php"onsubmit="return validation()" method="post">

        <label for="amount">Amount (RM): </label>
        <input type="text" name="amount" id="amount"/>

        <br>

        <label for="currency">Currency: </label>
        <select name="currency" id="currency">
            <option value="US Dollar">US Dollar</option>
            <option value="Japanese Yen">Japanese Yen</option>
            <option value="Euro">Euro</option>
        </select>

        <div align:"left">
            <input type="submit" name="submit" value="Convert">
        </div>

        </form>
    </body>
</html>

<?php

session_start();
if(isset($_POST['submit'])) {
    $cxn = mysqli_connect('localhost', 'root', '', 'final_assessment');

    $error_validation = array();

    if(empty($_POST['amount'])) {
        $error_validation[] = "Please enter a valid value.";
    }

    if(!is_numeric($_POST['amount'])) {
        $error_validation[] = "Please enter a valid value.";
    }

    if(empty($error_validation)) {
        $amount = $_POST['amount'];
        $currency = $_POST['currency'];
        $result = 0;
        $n = round($amount, 2);
        
        switch($currency) {
            case 'US Dollar':
                $result = $amount/4.62;
                $m = round($result,2);
                $name = "US Dollar";
                break;
            case 'Japanese Yen':
                $result = $amount/0.033;
                $m = round($result,2);
                $name = "Japanese Yen";
                break;
            default:
            $result = $amount/4.97;
            $m = round($result,2);
            $name = "Euro";
        }

        $query = "INSERT INTO curr_conversion (amount, currency, result) VALUES ('$amount', '$currency', '$result')";
        $qresult = mysqli_query($cxn, $query);

        if ($qresult) {
            echo "<h1>Conversion Result</h1>
            $n Malaysian Ringgit is equals $m $name";
        }



    } else {
        echo "<h1>Error!</h1>";
        foreach ((array)$error_validation as $msg) {
            echo "- $msg<br/>";
        }
    }
}

?>