<?php
	header('Content-type: application/json');
	$response = array();
	if (isset($_GET['syear'])&&isset($_GET['eyear'])&&isset($_GET['smonth'])&&isset($_GET['emonth'])&&isset($_GET['sday'])&&isset($_GET['eday'])) {		     		
        	          //显示test表中的数据
        $response['code']=1;
        $response['events']=array(
        	array('syear'=>2012,'smonth'=>6,'sday'=>1,'eyear'=>2012,'emonth'=>6,'eday'=>3,'content'=>"Republicans Fuming Over Chris Christie's Decision"),
        	array('syear'=>2012,'smonth'=>6,'sday'=>5,'eyear'=>2012,'emonth'=>6,'eday'=>8,'content'=>"The Only Thing More Expensive Than Kids Is Kids Who Are Bullies"),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"Jennifer Love Hewitt Pregnant With First Child With Client List Co-Star Brian Ha "),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"The Voice's Amber Carrington On Forgetting Lyrics To Skid Row's I'll Remember You "),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"Game Of Thrones: Stars React To The Red Wedding (Updated)"),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"Christie’s challenger tries to gain traction in N.J."),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"Defiant Chrysler refuses to recall vehicles"),
        	array('syear'=>2012,'smonth'=>6,'sday'=>10,'eyear'=>2012,'emonth'=>6,'eday'=>13,'content'=>"Jack White saves historic Detroit venue"),
        	array('syear'=>2012,'smonth'=>7,'sday'=>1,'eyear'=>2012,'emonth'=>7,'eday'=>3,'content'=>"Report: Alex Rodriguez, others face suspension for doping"),
        	array('syear'=>2012,'smonth'=>8,'sday'=>1,'eyear'=>2012,'emonth'=>8,'eday'=>3,'content'=>"Houston police chief: Videotaped beating sickening"),
        	array('syear'=>2012,'smonth'=>9,'sday'=>1,'eyear'=>2012,'emonth'=>9,'eday'=>3,'content'=>"Top 'American Idol' producers apparently fired"),
        	array('syear'=>2012,'smonth'=>10,'sday'=>1,'eyear'=>2012,'emonth'=>10,'eday'=>3,'content'=>"FHA may need $1B bailout for reverse mortgage losses"),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"FBI searches offices of California state senator, Latino caucus "),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"Minn. cheerleader accused of prostituting girl "),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"Pa. school won't say transgender male's name at graduation "),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"Court martial probes motivation of WikiLeaks soldier"),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"Tea Party groups say rights violated by IRS reviews"),
        	array('syear'=>2012,'smonth'=>12,'sday'=>1,'eyear'=>2012,'emonth'=>12,'eday'=>3,'content'=>"Komen breast cancer charity cancels walks in seven U.S. cities"),
        	array('syear'=>2013,'smonth'=>2,'sday'=>1,'eyear'=>2013,'emonth'=>2,'eday'=>3,'content'=>"10-year-old fights off robbers in his home"),
        	array('syear'=>2013,'smonth'=>2,'sday'=>1,'eyear'=>2013,'emonth'=>2,'eday'=>3,'content'=>"Colorado judge accepts James Holmes’ insanity plea in theater shooting …"),
        	array('syear'=>2013,'smonth'=>2,'sday'=>1,'eyear'=>2013,'emonth'=>2,'eday'=>3,'content'=>"China has 'mountains of data' about U.S. cyber attacks: official"),
        	array('syear'=>2013,'smonth'=>2,'sday'=>1,'eyear'=>2013,'emonth'=>2,'eday'=>3,'content'=>"France says tests prove Syria used nerve gas; U.S. sends Patriots to J …"),
		);
				
	}
	else {
		$response['code'] = 0;
		
	}
	echo json_encode($response);
?>