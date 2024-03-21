<?php
$db_name = 'radovi';
$dir = "databaseBackup/$db_name";
//If backup directory can't be created throw a message
if (!is_dir($dir)) {
    if (!@mkdir($dir)) {
        die("<p>Directory can't be created$dir.</p></body></html>");
    }
}

$time = time();
//connect to database
$dbc = @mysqli_connect('localhost','root','',$db_name
) or
    die("<p>Can't connect to database $db_name.</p></body></html>");
    
//run query to get all tables
$r = mysqli_query($dbc, 'SHOW TABLES');
if (mysqli_num_rows($r) > 0) {
    echo "<p>Backup for database '$db_name'.</p>";

    //for each table
    while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {
        //run query to get all table data
        $q = "SELECT * FROM $table";
        $r2 = mysqli_query($dbc, $q);
        if (mysqli_num_rows($r2) > 0) {
            //open backup file
            if ($fp = gzopen("$dir/{$table}_{$time}.txt.gz", 'w9')) {
                //save all column names
                $fields = mysqli_fetch_fields($r2);
                foreach ($fields as $field) {
                    $columns[] = $field->name;
                }

                //for each row in table
                while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {
                    //write a query string using implode and column names
                    gzwrite($fp,"INSERT INTO $table (" . implode(', ', $columns) . ")\nVALUES(");

                    //write values
                    gzwrite($fp, "'" . implode("', '", $row) . "');\n");
                }
                gzclose($fp);
                echo "<p>Backup of table '$table' is complete.</p>";
            } else {
                echo "<p>File $dir/{$table}_{$time}.sql.gz cannot be openned.</p>";
                break;
            }
        }
    }
} else {
    echo "<p>Database $db_name has no tables.</p>";
}
