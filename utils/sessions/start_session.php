<?php

function startSession()
{
	if (!isset($_SESSION))
		session_start();
}

?>