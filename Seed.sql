SET search_path =  public;
INSERT INTO usr_user 
(user_id, first_name, last_name, full_name, username, password,user_type,dob,age)
VALUES
     --Original Admins	
	(1,'Giorgio','Sawaya','Giorgio Sawaya','gio123','weakpassword11','admin','1991-01-09',31),
	(2,'Hedi','Ben Abid','Hedi Ben Abid','hedi456','12345','admin','1980-02-19',42),
	(3,'Pierre','Akladios','Pierre Akladios','pierre789','db123','admin','1901-11-06',99),
	(4,'Zaidane','El Haouari','Zaidane El Haouari','zaidane012','33333','admin','1979-03-19',43),
	(5,'Imad','Eddin Tijani','Imad Eddin Tijani','imad345','56789','admin','1980-10-30',41),
	 --Original patients	
	(6,'Jeff','Sulivan','Jeff Sulivan','jeff111','12345','patient','1986-03-09',36),
	(7,'Dalila','Desktop','Dalila Desktop','dalila9d','12345','patient','1986-05-23',35),
	(8,'Maria','Kafi','Maria Kafi','maria11','12345','patient','1987-06-30',34),
	(9,'John','Bond','John Bond','johnB6','12345','patient','1989-02-19',33),
	(10,'Frederic','Leclair','Frederic Leclair','fred3likesDB','abcd1234','patient','1989-07-11',32),
	(11,'Samantha','Wong','Samantha Wond','samaWong8','abcd1234','patient','1991-01-04',31),
	(12,'Susan','Singh','Susan Singh','Susing44','abcd1234','patient','1991-08-29',30),
	(13,'Lucy','Hue','Lucy Hue','LuckyLucy2','LuckyLucy2','patient','1993-04-01',29),
	(14,'Jennifer','Lopex','Jennifer Lopex','jennyFrom2Block','abcd1234','patient','1993-04-30',28),
	(15,'Jacob','Versace','Jacob Versace','jacobDrip1','abcd1234','patient','1995-02-01',27),
	(16,'Youssef','Ben Arfa','Youssef Ben Arfa','baller13','$1111','patient','2005-11-12',16),
	(17,'William','Black','William Black','williamBlack2U','$1111','patient','2006-12-04',15),
	(18,'Wendy','Mendy','Wendy Mendy','wendys1','$1111','patient','2011-01-10',11),
	(19,'Donna','Smith','Donna Smith','DonnaFromSuits1','$1111','patient','2007-05-19',14),
	(20,'Donovan','Drogba','Donovan Drogba','striker15','$1111','patient','2008-09-21',13),
	(21,'Dave','Duncaster','Dave Duncaster','daveyD77','$1111','patient','2012-06-06',9),
	--Original casual users
	(22,'Lily','Souveraine ','Lily Souveraine','Lily4queen','Lily4queen','casual','1980-02-19',42),
	(23,'Maxime','Fortier','Maxime Fortier','maxFort67','maxFort67','casual','1979-02-20',43),
	(24,'Fatima','Bladi','Fatima Bladi','famfam33','famfam33','casual','1978-02-21',44),
	(25,'Latisha','Armour','Latisha Armour','ArmourLati22','ArmourLati22','casual','2008-02-22',14),
	(26,'Mariam','Mendy','Mariam Mendy','marmendy66','marmendy66','casual','1979-02-26',43),
	(27,'Brandon','Smith','Brandon Smith','bransmithsy22','bransmithsy22','casual','1978-02-25',44),
	--Original doctors/medical staff
	(28,'Christine','Aguilera','Christine Aguilera','voice22','voice22','employee','1976-02-23',46),
	(29,'Jean','Lafleur','Jean Lafleur','jean2dentist','jean2dentist','employee','1975-02-24',47),
	(30,'Martha','Poliski','Martha Poliski','polisher1','polisher1','employee','1974-02-19',48),
	(31,'Emmanuel','Macaron','Emmanuel Macaron','GiletJaune12','GiletJaune12','employee','1973-02-08',49),
	(32,'Mia','Turner','Mia Turner','worker4ever','worker4ever','employee','1962-02-09',60),
	(33,'Michael','Godfrey','Michael Godfrey','Miketooth24','Miketooth24','employee','1952-02-22',70),
	(34,'Zinedine','Zidane','Zinedine Zidane','bluetooth13','siuuu22','employee','1950-07-13',71),
	(35,'Jacob','Versace','Jacob Versace','jacobEmpAccount','$1234$','employee','1995-02-01',27)
;


INSERT INTO usr_patient 
(patient_id, ssn, address, phone, email, insurance_type,responsible_id,user_id,gender, is_currently_employee,employee_id)
VALUES
	(1,234998123,'45 Duney Street, Gatineau, QC',		'343-555-2345', 'JeffSulivan@gmail.com',		'No current insurance plan'		,NULL,	6,	'Male',		false,NULL),
	(2,456770990,'543 Queen Street, Regina, SK',		'306-132-3144',	'DalilaDesktop@hotmail.com',	'No current insurance plan'		,NULL,	7,	'Female',	false,NULL),
	(3,943353674,'244 Portland Drive, Toronto, ON',		'416-765-3452',	'MariaKafi@deezer.com',			'No current insurance plan'		,NULL,	8,	'Female',	false,NULL),
	(4,913225741,'65 Torres Road, Toronto, ON',			'648-233-9870',	'JohnBond@yahoo.com',			'CAA Full Insurance'			,NULL,	9,	'Male',		false,NULL),
	(5,245570079,'2331 Palais Rue, Quebec City, QC',	'623-841-3321',	'FredericLeclair@icloud.com',	'CAA Full Insurance'			,NULL,	10,	'Male',		false,NULL),
	(6,129453654,'12 Golf Street, Toronto, ON',			'416-432-6555',	'SamanthaWond@gmail.com',		'CAA Partial Insurance'			,NULL,	11,	'Female',	false,NULL),
	(7,843858678,'36 Bailey Avenue, Vancouver, BC',		'514-565-0031',	'SusanSingh@outlook.com',		'CAA Partial Insurance'			,NULL,	12,	'Female',	false,NULL),
	(8,543100688,'100 Darkoak Promenade, Montreal, QC',	'438-544-7129',	'LucyHue@me.com',				'Greenshield Full Insurance'	,NULL,	13,	'Non-Binary',false, NULL),
	(9,453383970,'201 Popular Street, Gatineau, QC',	'343-223-3267',	'JenniferLopex@icloud.com',		'Greenshield Full Insurance'	,NULL,	14,	'Female',	false,NULL),
	--(10,99236666,'1921 Designer Avenue, Winnipec, MB',	'533-234-8874',	'JacobVersace@gucci.com',		'Employee Benefit Insurance'	,NULL,	15,	'Male',		true , 8),
	(11,96373765,'212 Maverick Street, Halifax, NS',	'452-905-8447',	'YoussefBenArfa@yahoo.com',		'Greenshield Student Insurance'	,NULL,	16,	'Male',		false,NULL),
	(12,23326784,'882 Mully Drive, Ottawa, ON',			'613-443-4664',	'WilliamBlack@gmail.com',		'Greenshield Student Insurance'	,NULL,	17,	'Male',		false,NULL),
	(13,92346567,'12 Rideau Street, Ottawa, ON',		'613-841-5431',	'WendyMendy@gmail.com',			'SureHealth Youth Insurance'	,26,	18,	'Female',	false,NULL),
	(14,93578531,'3131 Labelle Promenade, Montreal, QC','438-542-9403',	'DonnaSmith@outlook.com',		'SureHealth Youth Insurance'	,27,	19,	'Female',	false,NULL),
	(15,14335366,'444 Didier Road, Toronto, ON',		'648-950-2534',	'DonovanDrogba@yahoo.com',		'Greenshield Youth Insurance'	,22,	20,	'Male',		false,NULL),
	(16,57853971,'241 Visenaut Avenue, Fredericton, NB','765-904-4456',	'DaveDuncaster@gmail.com',		'SureHealth Youth Insurance'	,23,    21,	'Male',		false,NULL)
;																																								

