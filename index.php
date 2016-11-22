<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?><!doctype html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>LED Display Message Update</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <?php
        // define variables and set to empty values
        $message = "";
		$textdec = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $message = test_input($_POST["message"]);
			$textdec = test_input($_POST["textdec"]);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
        <div>
            <p class="h1">LED Display Message Update</p>
            <p class="content">The LED Display can be updated by putting the new message in the textbox and clicking the Send to Display button.</p>
            <p class="content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">Message: <input type="text" name="message" value="" width="600px">
            </p>
            <p>
            Sign options:
            </p>
            <p>
            <input type="radio" name="textdec"
            <?php if (isset($textdec) && $textdec=="SCROLL") echo "checked";?>
value="SCROLL">Scrolling Text
			</p>
			<p>
			<input type="radio" name="textdec"
            <?php if (isset($textdec) && $textdec=="BLINK") echo "checked";?>
value="BLINK">Blinking Text
			</p>
            <p>
			<input type="radio" name="textdec"
            <?php if (isset($textdec) && $textdec=="NONE") echo "checked";?>
value="NONE">None
			</p>
                <p class="h1"><input type="submit" name="submit" value="Send to Display"></p>
            </form>
        </p>
            
        <?php
        $DBServer = 'localhost';
        $DBUser = 'client';
        $DBPass = 'admin';
        $DBName = 'messagedb';
        $conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
        // check connection
        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
        }

        //Select
        $sql = 'SELECT * FROM t';
        $rs = $conn->query($sql);

        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        } else {
//            $rows_returned2 = $rs->num_rows;
//            $rs->data_seek(0);
//            while ($row = $rs->fetch_row()) {
//                echo 'The old message was: ' . $row[0] . '<br>';
//            }

            $v1 = $conn->real_escape_string($message);
			$scrollON = FALSE;
			$blinkON = FALSE;
			if ($textdec=="NONE") {
				$scrollON = FALSE;
				$blinkON = FALSE;
			}
			else if ($textdec=="BLINK") {
				$blinkON = TRUE;
				$scrollON = FALSE;
			}
			else if ($textdec=="SCROLL") {
				$blinkON = FALSE;
				$scrollON = TRUE;
			}
			
			//$scrollON = "'" . $conn->real_escape_string($scroll) . "'";
			
			//$blinkON = "'" . $conn->real_escape_string($blink) . "'";         
            
            $sql = "UPDATE t SET message='$v1', isupdated='FALSE', scrollon='$scrollON', blinkon='$blinkON'";
            echo "<br />$sql<br />";

            if ($conn->query($sql) === false) {
                trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
            } else if ($message !== "") {
                $affected_rows = $conn->affected_rows;
//			exec("java -jar RS232_Example.jar", $output);
                echo "<script type='text/javascript'>alert('The message, \"$message\", was sent successfully to the display.');</script>";
            }
        }
        ?>
        
    </div>
</body>
</html>