<?php
	class pokemon {
		public function __construct($PID) {
			$this->_connectionstring =mysql_connect("localhost","root");
			if ($this->_connectionstring == 0) die("cannot connect to the db");
			$db = mysql_select_db("4432project", $this->_connectionstring) or die("cannot open the selected db");
			$this->_PID = $PID;
			session_start();
			$this->_UserID = $_SESSION['userid'];
		}

		public function __destruct() {
			if($this->_result) mysql_free_result($this->_result);
			if($this->_connectionstring) mysql_close($this->_connectionstring);
		}

		public function getFoodNum() {
			$queryP = "SELECT PID, PDATAID, T2.FOODID, NUMBER
					FROM((SELECT PID, PDATAID, T.FOODID
						FROM ((SELECT PID, POKEMON.PDATAID, FOODID
							FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID
							WHERE PID=" . $this->_PID . ") T) 
						JOIN FOOD ON T.FOODID=FOOD.FOODID) T2) 
					JOIN FOODSTATUS ON T2.FOODID=FOODSTATUS.FOODID
					WHERE USERID=" . $this->_UserID;
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$this->_FoodID = $rowP['FOODID'];
			$this->_FoodNum = $rowP['NUMBER'];
			return $this->_FoodNum;
		}

		public function getFoodName() {
			$queryP = "SELECT PID, PDATAID, T.FOODID, NAME
					FROM ((SELECT PID, POKEMON.PDATAID, FOODID
						FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID
						WHERE PID=" .$this->_PID. ") T) JOIN FOOD ON T.FOODID=FOOD.FOODID";
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			return $rowP['NAME'];
		}

		public function setFood($amount) {
			// firstly deduce the amount of food stored in the user's account
			$queryP = "UPDATE FOODSTATUS SET NUMBER=" .($this->_FoodNum - $amount). 
						" WHERE FOODID=" .$this->_FoodID. " AND USERID=" .$this->_UserID;
			mysql_query($queryP, $this->_connectionstring);

			// secondly get the num of hungry level this type of food will deduct
			$queryP = "SELECT HUNGRYPLUS FROM FOOD WHERE FOODID=" .$this->_FoodID;
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$hungryPlus = $rowP['HUNGRYPLUS'];

			// get the hungry level of this pokemon
			$queryP = "SELECT HUNGRYLEVEL FROM POKEMON WHERE PID=" .$this->_PID;
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$hungrylevel = $rowP['HUNGRYLEVEL'];

			// then deduce the pokemon's hungry level
			if(($hungrylevel - $hungryPlus) >= 0) {
				$queryP = "UPDATE POKEMON SET HUNGRYLEVEL=" .($hungrylevel - $hungryPlus). " WHERE PID=" .$this->_PID;
				mysql_query($queryP, $this->_connectionstring);
			} else {
				$queryP = "UPDATE POKEMON SET HUNGRYLEVEL=0 WHERE PID=" .$this->_PID;
				mysql_query($queryP, $this->_connectionstring);
			}
		}

		public function marry($MarriageID) {
			// insert a message in database
			$queryP = "INSERT INTO Message VALUES (" .$this->_UserID. ",(SELECT USERID 
				FROM POKEMON WHERE PID=" .$MarriageID. "), " .$this->_PID. ", " .$MarriageID. ",'engage')";
			mysql_query($queryP, $this->_connectionstring);

		}

		public function setWork($WorkID) {
			// get the current number of workstatus
			$queryP = "SELECT MAX(WORKSTATUSID) AS NUM FROM WORKSTATUS";
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$wsNum = $rowP['NUM'];

			// insert new workstatus
			$currentTime = time();
			$_SESSION['WorkStart'] = $currentTime;
			$queryP = "INSERT INTO WORKSTATUS VALUES (" .($wsNum + 1). ", " .$WorkID. ", " .$currentTime. ")";
			mysql_query($queryP, $this->_connectionstring) or die("No information");
			$_SESSION['WORKSTATUSID'] = $wsNum+1;

			// update in the pokemon table
			$queryP = "UPDATE POKEMON SET WORKSTATUSID=" .($wsNum+1). " WHERE PID=" .$this->_PID;
			mysql_query($queryP, $this->_connectionstring) or die("No information");

			// get the working time of this type of work
			$queryP = "SELECT MINTIME FROM WORK WHERE WORKID =" .$WorkID;
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$_SESSION['minTime'] = $rowP['MINTIME'];
		}

		public function stopWork() {
			// update money earned in the user table by his pokemon
			$queryP = "SELECT SALARY FROM WORK WHERE WORKID= (SELECT WORKID FROM WORKSTATUS WHERE WORKSTATUSID=" .$_SESSION['WORKSTATUSID'];
			$resultP = mysql_query($queryP, $this->_connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$queryP = "UPDATE USER SET MONEY=MONEY+" .$rowP['SALARY']. "WHERE USERID=" .$this->_UserID;
			mysql_query($queryP, $this->_connectionstring) or die("No information");

			// delete the current work status
			$queryP = "DELETE FROM WORKSTATUS WHERE WORKSTATUSID=" .$_SESSION['WORKSTATUSID'];
			mysql_query($queryP, $this->_connectionstring) or die("No information");
			unset($_SESSION['WORKSTATUSID']);
			
			// update the workstatus in pokemon table
			$queryP = "UPDATE POKEMON SET WORKSTATUS=0 WHERE PID=" .$this->_PID;
			mysql_query($queryP, $this->_connectionstring) or die("No information");
			unset($_SESSION['WorkStart']);
		}

		private $_PID;
		private $_UserID;
		private $_FoodID;
		private $_FoodNum;
		private $_result;
		private $_connectionstring;
	}
?>