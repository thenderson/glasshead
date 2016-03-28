<?php
    // configuration
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	date_default_timezone_set('America/Los_Angeles');
    require('/includes/constants.php');

	// open connection to sql database via PDO
	try {
		// connect to database
		$glasshead_db = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);
		$glasshead_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);   // ensure that PDO::prepare returns false when passed invalid SQL
		$glasshead_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // thow exceptions when errors arise
	}
	catch (Exception $e) {
		// trigger error
		trigger_error($e->getMessage(), E_USER_ERROR);
		exit;
	}

    // parse POST data
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		$value1 = strip_tags($_POST['value1']);
		$value2 = strip_tags($_POST['value2']);
		$value3 = strip_tags($_POST['value3']);
		
        // validate submission
		if ($value1 != 'todd') exit;
		
		// write data
		$stmt = $glasshead_db->prepare('INSERT INTO data (value1, value2, value3) VALUES (?,?,?)');

		if (!$stmt) {
			trigger_error('Statement failed : ' . $stmt->error, E_USER_ERROR);
			//echo 'error';
			exit;
		}

		try {
			$stmt->bindParam(1, $value1, PDO::PARAM_STR);
			$stmt->bindParam(2, $value2, PDO::PARAM_STR);
			$stmt->bindParam(3, $value3, PDO::PARAM_STR);

			$stmt->execute();
		}             

		catch(PDOException $e) {
			trigger_error('Wrong SQL: ' . $e . ' Error: ' . $e->getMessage(), E_USER_ERROR);
			//echo 'error';
			exit;
		}
    }
    else
    {
        // do nothing
    }
?>
