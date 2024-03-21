<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .flex-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 400px;
            height: auto;
        }

        .flex-container>div {
            padding: 20px;
        }
        .img{
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <?php include('parseXML.php'); ?>
</body>

</html>