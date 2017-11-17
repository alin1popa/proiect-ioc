<?php

function testExistence($db_result)
{
    if (mysqli_num_rows($db_result)==0)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function testUnicity($db_result)
{
    if (mysqli_num_rows($db_result)>1)
    {
        return false;
    }
    else
    {
        return true;
    }
}

?>