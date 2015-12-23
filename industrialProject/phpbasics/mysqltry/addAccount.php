<body>

    <form method="get" action="http://www.yourwebskills.com/files/examples/process.php">
        
        <select id="cd" name="cd">
        
            <?php
            
            $mysqlserver="localhost";
            $mysqlusername="test";
            $mysqlpassword="test";
            $link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());
            
            $dbname = 'test';
            mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());
            
            $cdquery="SELECT cdTitle FROM firsttable";
            $cdresult=mysql_query($cdquery) or die ("Query to get data from firsttable failed: ".mysql_error());
            
            while ($cdrow=mysql_fetch_array($cdresult)) {
            $cdTitle=$cdrow["cdTitle"];
                echo "<option>
                    $cdTitle
                </option>";
            
            }
                
            ?>
    
        </select>
        
    </form>
    
</body> 