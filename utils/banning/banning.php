<?php

/*
 * DEPENDENCIES =====================================================
 * 
 * THIS FILE REQUIRES INCLUDING THESE:
 * errors/logs.php
 * time/timezone.php
 * also an open database connection
 * 
 * NOTES ============================================================
 * 
 * Functions return 0 on error and non-0 on success
 * database/datab_functions.php and time/time_convert.php might be useful
 * 
 * HOW TO USE ========================================================
 * 
 * 1. Call these functions once to create the tables automatically
 * createTaskTable($dbConnection, $tablename);
 * createBanTable($dbConnection, $tablename);
 * 
 * 2. Initialize the limited-access task
 * $task1 = new limitedTask($dbConnection, $task_table_name, $ban_table_name, $attempts, $reset_time, $ban_time);
 * where the attributes are as follows:
 * dbConnection - an open database connection
 * task_table_name - the name of the table where the attempts will be stored
 * ban_table_name - the name of the table where the banning will be stored
 * attempts - the maximum number of allowed attempts
 * reset_time - the time after which the attempts counter resets
 * ban_time - the ammount of time the user will be banned from the moment of his last attempt
 *          - it can also be "-1", in this case the user will be banned until the end of the reset_time from the moment of his first attempt
 * EXAMPLE:
 * - for a login task:
 * <attempts><reset_time><ban_time> = 10, one day, three days
 * this means that the user is allowed to do 10 unsuccessful login attempts per day
 * if he makes more than 10 in the same day, he is banned for three days starting from his last attempt
 * - for a signup task
 * <attempts><reset_time><ban_time> = 3, one week, -1
 * this means that the user is allowed to register 3 accounts per week
 * if he registers one account on tuesday, one on wednesday and one on friday
 * he won't be able to register a new one until the next tuesday (when the reset time expires)
 * 
 * 3. Register the new attempt when the user creates a new attempt
 * $task1->newAttempt();
 * 
 * 4. Check if the user is banned
 * if ($task1->isBanned())
 * 
 * COMPLETE EXAMPLE
 * 
 * $dbconn = connectToDB();
 * // only once
 * // createTaskTable($dbconn, "tasktb");
 * // createBanTable($dbconn, "bantb");
 * $wronglogin = new limitedTask($dbconn, "tasktb", "bantb", 10, 1*DAY, 3*DAY);
 * if (user made a failed login attempt)
 * {
 *      $wronglogin->newAttempt();
 * }
 * if ($wronglogin->isBanned())
 * {
 *      echo "YOU ARE BANNED";
 * }
 * else
 * {
 *      echo "YOU ARE NOT BANNED YET, YOU CAN TRY AGAIN";
 * }
 */



function createTaskTable($dbconn, $tablename)
{
    $createtable = ''
  .'CREATE TABLE IF NOT EXISTS `'.$tablename.'` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) COLLATE ascii_bin NOT NULL,
  `attempts` int(11) NOT NULL,
  `dateaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin AUTO_INCREMENT=1 ;';
    
    mysqli_query($dbconn, $createtable);
    
    if (mysqli_errno($dbconn))
    {
        $errmsg = 'Error creating task table. Details: -- MySQL error number '.mysqli_errno($dbconn).' -- MySQL error message '.mysqli_error($dbconn);
        //echo $errmsg;
        logError($errmsg);
        return 0;
    }
    
    return 1;
}

function createBanTable($dbconn, $tablename)
{
    $createtable = ''
    .'CREATE TABLE IF NOT EXISTS `'.$tablename.'` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip` varchar(32) COLLATE ascii_bin NOT NULL,
    `expirydate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ip` (`ip`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin AUTO_INCREMENT=1 ;';
    
    mysqli_query($dbconn, $createtable);
    
    if (mysqli_errno($dbconn))
    {
        $errmsg = 'Error creating task table. Details: -- MySQL error number '.mysqli_errno($dbconn).' -- MySQL error message '.mysqli_error($dbconn);
        //echo $errmsg;
        logError($errmsg);
        return 0;
    }
    
    return 1;
}

class limitedTask
{
    private $dbconn;
    private $tasktablename;
    private $bantablename;
    private $maxattempts;
    private $resettime;
    private $bantime;
    private $ip;
    
    public function isBanned()
    {
        $result = mysqli_query($this->dbconn, "SELECT * FROM $this->bantablename WHERE ip='$this->ip'");
        if (mysqli_num_rows($result)==0)
            return false;
        else
        {
            $entry = mysqli_fetch_array($result);
            $curtime = $entry['expirydate'];
            
            $curtimestamp = strtotime($curtime);
            $now = time();
            
            if ($now>$curtimestamp)
                return false;
            else
                return true;
        }
    }
    
    public function __construct($dbconn, $tasktablename, $bantablename, $maxattempts, $resettime, $bantime)
    {
        $this->dbconn=$dbconn;
        $this->tasktablename=$tasktablename;
        $this->bantablename=$bantablename;
        $this->maxattempts=$maxattempts;
        $this->resettime=$resettime;
        $this->bantime=$bantime;
        
        $this->ip=$_SERVER['REMOTE_ADDR'];
    }
    
    public function newAttempt()
    {
        $check = mysqli_query($this->dbconn, "SELECT * FROM $this->tasktablename WHERE ip='$this->ip'");
        
        if (mysqli_num_rows($check)==0)
        {
            mysqli_query($this->dbconn, "INSERT INTO $this->tasktablename (ip, attempts, dateaction) VALUES ('$this->ip', '1', now())");
        
            if (mysqli_errno($this->dbconn))
            {
                $errmsg = 'Error inserting into task table. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
                //echo $errmsg;
                logError($errmsg);
                return 0;
            }
        }
        else
        {
            $entry = mysqli_fetch_array($check);
            $curattempts = $entry['attempts'];
            
            if ($curattempts<$this->maxattempts)
            {   
                mysqli_query($this->dbconn, "UPDATE $this->tasktablename SET attempts=attempts+1 WHERE ip='$this->ip'");
            
                if (mysqli_errno($this->dbconn))
                {
                    $errmsg = 'Error inserting into task table. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
                    //echo $errmsg;
                    logError($errmsg);
                    return 0;
                }
            }
            else
            {
                $this->performBan();
                $this->reset();
            }
        }
        
        return 1;
    }
    
    private function reset()
    {
        mysqli_query($this->dbconn, "UPDATE $this->tasktablename SET attempts=0, dateaction=now() WHERE ip='$this->ip'");
        
        if (mysqli_errno($this->dbconn))
        {
            $errmsg = 'Error resetting task table. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
            //echo $errmsg;
            logError($errmsg);
            return 0;
        }
        return 1;
    }
    
    private function calculateExpiryDate()
    {
        if ($this->bantime>0)
        {
            return time()+$this->bantime;
        }
        else
        {
            $check = mysqli_query($this->dbconn, "SELECT * FROM $this->tasktablename WHERE ip='$this->ip'");
            
            if (mysqli_errno($this->dbconn))
            {
                $errmsg = 'Error acquiring ban expiry date from DB. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
                //echo $errmsg;
                logError($errmsg);
                return 0;
            }
            
            $entry = mysqli_fetch_array($check);
            $curtime = $entry['dateaction'];

            $timestamp = strtotime($curtime);
            
            return $timestamp+$this->resettime;
        }
    }
    
    private function performBan()
    {
        $check = mysqli_query($this->dbconn, "SELECT * FROM $this->bantablename WHERE ip='$this->ip'");
        $expirydate=$this->calculateExpiryDate();
       // echo $expirydate."<br />";
        if (mysqli_num_rows($check)>0)
        {
            $entry = mysqli_fetch_array($check);
            $curexpirydate = $entry['expirydate'];
            
            if ($curexpirydate>$expirydate)
            {
                return 0;
            }
            else
            {
                mysqli_query($this->dbconn, "UPDATE $this->bantablename SET expirydate=FROM_UNIXTIME('$expirydate') WHERE ip='$this->ip'");
            
                if (mysqli_errno($this->dbconn))
                {
                    $errmsg = 'Error banning user. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
                    //echo $errmsg;
                    logError($errmsg);
                    return 0;
                }
            }
        }
        else
        {
            mysqli_query($this->dbconn, "INSERT INTO $this->bantablename (expirydate, ip) VALUES (FROM_UNIXTIME($expirydate), '$this->ip')");
       
            if (mysqli_errno($this->dbconn))
            {
                $errmsg = 'Error banning user. Details: -- MySQL error number '.mysqli_errno($this->dbconn).' -- MySQL error message '.mysqli_error($this->dbconn);
                //echo $errmsg;
                logError($errmsg);
                return 0;
            }
        }
        
        
        return 1;
    }
    
}


?>