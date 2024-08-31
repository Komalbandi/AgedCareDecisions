<?php
include_once('./LoadFirst.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aged care decision Dashboard</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
<form class="dashboard__button-group">
    <button type="button" onClick="redirectToCreateCaller()">Create caller</button>
    <br/>
    <button type="button" onClick="redirectToSearchCaller()">Search call</button>
</form>
<script>
    const redirectToCreateCaller = function () {
        window.location.href = 'CallHeaderController.php?page=create';
    }

    const redirectToSearchCaller = function () {
        window.location.href = "CallHeaderController.php?date=&username=&callid=";
    }
</script>
</body>
</html>

