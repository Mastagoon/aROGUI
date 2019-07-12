<?php 
	require_once "Core/init.php";
	if((!Input::get("submit"))) {
		Redirect::to("index.php");
	} else {
		$accountname = Input::get("accountname");
		$password = Input::get("password");
		$charname = Input::get("charname");
		$email = (Input::get("email")) ? Input::get("Email") : "@g";
		$db = DB::getInstance();
		$aid = $db->getAID("[charname]", "=", $charname);
		$db->identity("ON");
		$db->insertToMSSQL("[nlogin].[dbo].[login]", array(
			"AID" => $aid,
			"ID" => $accountname,
			"passwd" => $password,
			"LastConnecTime" => NULL,
			"grade" => 1,
			"isConfirmed" => 3,
			"regDate" => "getdate()",
			"endblockdate" => NULL
		));
		$db->insertToMSSQL("[nlogin].[dbo].[account]", array(
			"AID" => $aid,
			"Name" => $accountnme,
			"Adress" => "Tahadi",
			"Phone" => "1",
			"HPone" => " ",
			"RegNum" => $accountname,
			"zipcode" => "1",
			"sex" => $gender,
			"Email" => $email,
			"http" => NULL,
			"News" => 1,
			"job" => NULL,
			"hobby" => NULL,
			"game" => NULL,
			"comment" => NULL,
			"nation" => "ME",
			"city" => NULL,
			"ip" => "0",
			"lasttime" => NULL
		));
		$db->identity("OFF");
		echo "success";
		Redirect::to("index.php");
	}