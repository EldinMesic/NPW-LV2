<?php
$xml = simplexml_load_file('LV2.xml');
foreach ($xml->record as $record) {
    echo 
    "
    <div>
        <h2>$record->id. $record->ime $record->prezime</h2>
        <h3>Gender: $record->spol, Contact: $record->email</h3>
        <div class='flex-container'>
            <img src='$record->slika' loading='lazy'>
            <h3>$record->zivotopis</h3>
        </div>
    </div>
    <hr>
    ";
}