<?php
function connectDB()
{
    return new PDO('mysql:host=localhost;dbname=shelter', 'root', '');
}


