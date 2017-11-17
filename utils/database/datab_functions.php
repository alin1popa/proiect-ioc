<?php

function tableExists($dbconn, $tbname)
{
    $result = mysqli_query($dbconn, "SELECT COUNT(*) FROM $tbname");
    if ($result !== false)
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>