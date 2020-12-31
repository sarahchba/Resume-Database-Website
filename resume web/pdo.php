<?php
$pdo = new PDO('mysql:host=localhost;port=3;dbname='resume', 'sarah', 'one');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
