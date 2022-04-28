---------------------------
--CREATE THE SCHEMA
--------------------------
DROP SCHEMA IF EXISTS public CASCADE;
CREATE SCHEMA public;
SET search_path =  public;

CREATE TYPE UTYPE as ENUM ('employee', 'patient', 'casual');
CREATE TABLE usr_user
(
user_id INTEGER,
first_name VARCHAR(255)NOT NULL,
last_name VARCHAR(255) NOT NULL,
full_name VARCHAR(255) NOT NULL,
username VARCHAR(255) UNIQUE NOT NULL,
password TEXT NOT NULL,
user_type UTYPE ,
dob DATE NOT NULL,
age INTEGER NOT NULL,
PRIMARY KEY(user_id),
CONSTRAINT valid_fname CHECK (first_name NOT LIKE '%[0-9]%'),
CONSTRAINT valid_lname CHECK (last_name NOT LIKE '%[0-9]%')
);


CREATE TYPE GENDER as ENUM ('Male', 'Female', 'Non-Binary');
CREATE TYPE JTYPE as ENUM ('dentist', 'receptionist', 'hygienist',  'other',  'supervisor' );
CREATE TABLE usr_employee
(
employee_id INTEGER,
SSN INTEGER UNIQUE NOT NULL,
job_type JTYPE NOT NULL,
salary FLOAT NOT NULL,
user_id INTEGER NOT NULL,
work_clinic INTEGER NOT NULL,
gender GENDER,
address VARCHAR(255),
PRIMARY KEY(employee_id),
FOREIGN KEY(user_id) REFERENCES usr_user (user_id),
CONSTRAINT validsalary CHECK (salary > 0)
);


CREATE TABLE usr_clinic
(
clinic_id INTEGER,
clinic_name VARCHAR(255),
city VARCHAR(255) NOT NULL,
address VARCHAR(255) UNIQUE NOT NULL,
director INTEGER,
PRIMARY KEY(clinic_id),
FOREIGN KEY(director) REFERENCES usr_employee (employee_id)
);

ALTER TABLE usr_employee
ADD CONSTRAINT FK_worksfor
FOREIGN KEY (work_clinic) REFERENCES usr_clinic(clinic_id);


CREATE TABLE usr_patient
(
patient_id INTEGER,
SSN INTEGER UNIQUE NOT NULL,
address VARCHAR(255) NOT NULL,
phone VARCHAR(20) NOT NULL,
email VARCHAR(255),
insurance_type VARCHAR(255),
responsible_id INTEGER,
user_id INTEGER NOT NULL,
gender gender,
is_currently_employee BOOLEAN NOT NULL,
employee_id INTEGER,
PRIMARY KEY(patient_id),
FOREIGN KEY(user_id) REFERENCES usr_user (user_id), 
FOREIGN KEY(responsible_id) REFERENCES usr_user (user_id), 
FOREIGN KEY(employee_id) REFERENCES usr_employee (employee_id) 
);


CREATE TABLE usr_review
(
review_id INTEGER,
comments TEXT,
clinic_id INTEGER NOT NULL,
communication INTEGER,
hygene INTEGER,
value INTEGER,
patient_id INTEGER NOT NULL,
PRIMARY KEY(review_id),
FOREIGN KEY(clinic_id) REFERENCES usr_clinic (clinic_id),
FOREIGN KEY(patient_id) REFERENCES usr_patient (patient_id),
CONSTRAINT checkscores CHECK (communication <= 10 AND communication > 0 AND value <= 10 AND value > 0 AND hygene <= 10 AND hygene >0)
);

CREATE TABLE mdf_medical_folder
(
folder_id INTEGER,
patient_id INTEGER NOT NULL,
creation_date DATE,
language VARCHAR(100),
emergency_contact VARCHAR(100),
emergency_phone VARCHAR(20),
PRIMARY KEY(folder_id),
FOREIGN KEY(patient_id) REFERENCES usr_patient (patient_id)
);


CREATE TABLE mdf_vaccination
(
folder_id INTEGER,
line_no INTEGER,
vaccine_name VARCHAR(255),
date_taken DATE,
PRIMARY KEY(line_no, folder_id),
FOREIGN KEY(folder_id) REFERENCES mdf_medical_folder (folder_id),
CONSTRAINT nodoubleline UNIQUE (line_no,folder_id)
);

CREATE TABLE mdf_medication
(
folder_id INTEGER,
line_no INTEGER,
medication_name VARCHAR(255),
description VARCHAR(255),
dosage VARCHAR(25),
PRIMARY KEY(line_no, folder_id),
FOREIGN KEY(folder_id) REFERENCES mdf_medical_folder (folder_id)
);

CREATE TABLE mdf_condition
(
folder_id INTEGER,
line_no INTEGER,
condition_name VARCHAR(100),
description VARCHAR(255),
PRIMARY KEY(line_no, folder_id),
FOREIGN KEY(folder_id) REFERENCES mdf_medical_folder (folder_id)
);


CREATE TYPE APTSTATUS AS ENUM('canceled', 'late cancelation','unforeseen','not determined', 'finished', 'rejected by dentist',  'normal');
CREATE TABLE rdv_appointment
(
apt_id INTEGER,
patient_id INTEGER NOT NULL,
dentist_id INTEGER NOT NULL,
clinic_id INTEGER NOT NULL,
date DATE NOT NULL,
start_time TIME NOT NULL,
end_time TIME NOT NULL,
type VARCHAR(255) NOT NULL,
status APTSTATUS NOT NULL,
room_number VARCHAR(22),
PRIMARY KEY(apt_id),
FOREIGN KEY(patient_id) REFERENCES usr_patient (patient_id),
FOREIGN KEY(dentist_id) REFERENCES usr_employee (employee_id),
FOREIGN KEY(clinic_id) REFERENCES usr_clinic (clinic_id),
CONSTRAINT validtime CHECK (start_time < end_time)
);

CREATE TABLE mdf_visit_treatment
(
folder_id INTEGER,
line_no INTEGER,
specialist_name VARCHAR(255),
enter_date TIMESTAMP, 
summary VARCHAR(255) NOT NULL,
apt_id INTEGER,
apt_type VARCHAR(100) NOT NULL,
diagnosis VARCHAR(255),
tests_made VARCHAR(255),
test_result TEXT,
medication_prescribed VARCHAR(255),
teeths VARCHAR(255),
notes TEXT,
PRIMARY KEY(line_no, folder_id),
FOREIGN KEY(folder_id) REFERENCES mdf_medical_folder (folder_id),
FOREIGN KEY(apt_id) REFERENCES rdv_appointment (apt_id)
);


CREATE TABLE pay_procedure_fee
(
fee_id INTEGER,
procedure_description VARCHAR(255),
fees FLOAT,
procedure_code INTEGER UNIQUE,
PRIMARY KEY(fee_id),
CONSTRAINT good_fee_price CHECK (fees >=0)
);


CREATE TABLE rdv_procedure
(
proc_id INTEGER,
line_no INTEGER,
apt_id INTEGER NOT NULL,
procedure_code INTEGER NOT NULL,
tooth INTEGER,
quantity INTEGER,
PRIMARY KEY(proc_id),
FOREIGN KEY(apt_id) REFERENCES rdv_appointment (apt_id),
FOREIGN KEY(procedure_code) REFERENCES pay_procedure_fee (fee_id)
);




CREATE TYPE CARD AS ENUM ('VISA','Mastercard','Amex','Other');
CREATE TABLE pay_user_balance
(
balance_id INTEGER,
user_id INTEGER NOT NULL,
prepay_authorized BOOLEAN,
card_number BIGINT,
card_type CARD,
unpaid_balance FLOAT,
paid_amount FLOAT,
total FLOAT NOT NULL,
PRIMARY KEY(balance_id),
FOREIGN KEY(user_id) REFERENCES usr_user (user_id)
);


CREATE TYPE ISTATUS AS ENUM ('paid', 'pending', 'open', 'refunded');
CREATE TABLE pay_invoice
(
invoice_id INTEGER,
creation_date INTEGER,
client_address VARCHAR(255),
for_patient_id INTEGER NOT NULL,
status ISTATUS NOT NULL,
total_fees FLOAT,
late_fee BOOLEAN,
user_balance INTEGER NOT NULL,
total_taxes FLOAT,
PRIMARY KEY(invoice_id),
FOREIGN KEY(for_patient_id) REFERENCES usr_patient (patient_id),
FOREIGN KEY(user_balance) REFERENCES pay_user_balance (balance_id),
CONSTRAINT positivefee CHECK (total_fees >=0 AND total_taxes >= 0)
);

CREATE TYPE  PAYMETH AS ENUM ('Cash','Debit','Credit','Other');
CREATE TABLE pay_payment
(
amount FLOAT,
billing_id INTEGER,
payment_method PAYMETH,
payment_type CARD,
invoice_id INTEGER ,
balance_id INTEGER NOT NULL,
entered_by INTEGER NOT NULL,
PRIMARY KEY(billing_id),
FOREIGN KEY(invoice_id) REFERENCES pay_invoice (invoice_id),
FOREIGN KEY(balance_id) REFERENCES pay_user_balance (balance_id),
FOREIGN KEY(entered_by) REFERENCES usr_employee (employee_id)
);

CREATE TABLE pay_invoice_detail
(
invdet_id INTEGER,
invoice_id INTEGER NOT NULL,
line_no INTEGER NOT NULL,
proc_id INTEGER ,
discount_rate FLOAT,
discount_type VARCHAR(255),
insurance_coverage INTEGER,
tax_rate FLOAT,
PRIMARY KEY(invdet_id),
FOREIGN KEY(invoice_id) REFERENCES pay_invoice (invoice_id),
FOREIGN KEY(proc_id) REFERENCES rdv_procedure (proc_id),
CONSTRAINT nodoubleline4 UNIQUE (line_no,invoice_id)
);

CREATE TYPE CSTATUS as ENUM ('Approved','Rejected','Pending','Cancelled');
CREATE TABLE pay_insurance_claim
(
claim_id INTEGER,
invoice_id INTEGER NOT NULL,
invdet_id INTEGER NOT NULL,
claim_amount FLOAT,
insurance_company VARCHAR(255),
claim_status CSTATUS,
user_id INTEGER NOT NULL,
claim_submission_date DATE,
claim_approved_date DATE,
PRIMARY KEY(claim_id),
FOREIGN KEY(invoice_id) REFERENCES pay_invoice (invoice_id),
FOREIGN KEY(invoice_id) REFERENCES pay_invoice_detail (invdet_id),
FOREIGN KEY(user_id) REFERENCES usr_user (user_id),
CONSTRAINT checkamount CHECK (claim_amount >0)
);



-------------------------------------------
--CREATE THE DATA
--------------------------------------------
SET search_path =  public;
INSERT INTO usr_user 
(user_id, first_name, last_name, full_name, username, password,user_type,dob,age)
VALUES
     --Original Admins/Receptionists	
	(1,'Giorgio','Sawaya','Giorgio Sawaya','gio123','weakpassword11','employee','1991-01-09',31),
	(2,'Hedi','Ben Abid','Hedi Ben Abid','hedi456','12345','employee','1980-02-19',42),
	(3,'Pierre','Akladios','Pierre Akladios','pierre789','db123','employee','1901-11-06',99),
	(4,'Zaidane','El Haouari','Zaidane El Haouari','zaidane012','33333','employee','1979-03-19',43),
	(5,'Imad','Eddin Tijani','Imad Eddin Tijani','imad345','56789','employee','1980-10-30',41),
	(36,'Ally','Newton','Ally Newton','newt2','qwerty','employee','1979-10-30',40),
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
	(35,'Jacob','Versace','Jacob Versace','jacobEmpAccount','$1234$','employee','1995-02-01',27),
	(37,'Bella','Coletto','Bella Coletto','bellacol3','$333$','employee','1996-02-02',26),
	(38,'Sully','Lovely','Sully Lovely','sullove2','$111$','employee','1990-04-21',32)
;

INSERT INTO usr_clinic
(clinic_id, clinic_name, city, address, director)
VALUES
	(1,'National Dentist Clinic Ottawa', 'Ottawa, ON','66 Rideau Street', NULL ),
	(2,'Ontario Provincial Dentist Clinic Toronto ', 'Toronto,ON','255 Garter Avenue', NULL),
	(3,'Vancouver Dentist Clinic Canada', 'Vancouver, BC','721 Duncast Road', NULL),
	(4,'Quebec Provincial Dentist Clinic Montreal',  'Montreal,QC', '322 Eliron Street', NULL),
	(5,'Acadie Dentist Clinic Canada',  'Fredericton, NB',  '392 Colton Street', NULL),
	(6,'Prairies Dentist Clinic Canada',  'Regina, SK', '445 Queen Crescent', NULL)
;

INSERT INTO usr_employee
(employee_id,SSN,job_type,salary,user_id,work_clinic,gender,address)
VALUES
	(1,234998331,'receptionist', 120000.00,	1,1,	'Male', '416 Carter Drive, Ottawa, ON'),
	(2,495721390,'receptionist', 138000.00,	2,2,	'Male',	'2000 Rager Crescent, Toronto, ON'),
	(3,943353225,'receptionist', 134000.00,	3,3,	'Male',	'700 Duncast Road, Vancouver, BC'),
	(4,515265778,'receptionist', 90000.00,	4,4,	'Male',	'131 Catherine Street, Montreal, QC'),
	(5,245574475,'receptionist', 81000.00,	5,5,	'Male',	'49 Gallagher Drive, Fredericton, NB'),
	(6,164715437,'receptionist', 99000.00,	6,6,	'Male',	'12 Hawthorne, Regina, SK'),
	(7,323841052,'receptionist', 103000.00,	36, 1,	'Female',	'47 Innes Road, Ottawa, ON'),
	(8,222832411,'supervisor',	139000.00,	28, 2,	'Non-Binary','99 Young Street, Toronto, ON'),
	(9,900123452, 'dentist',	190000.00,	29,	3,  'Female',	'57 Calibas Street, Vancouver, BC'),
	(10,742874723,'hygienist',	56000.00,	30, 1,  'Female',	'44 George-Etienne Drive, Ottawa, ON'),
	(11,478219361,'dentist',	212000.00,	31, 5,	'Male',		'209 Maverick Street, Halifax, NS'),
	(12,194281333,'dentist',	311000.00,	32,	6,	'Female',	'442 Pompon Road, Regina , SK'),
	(13,542529127,'dentist', 	140000.00,	33,	1, 	'Male',		'12 Kayak Street, Ottawa, ON'),
	(14,935285265,'dentist', 	200000.00,	34, 4,	'Male',		'3135 Labelle Promenade, Montreal, QC'),
	(15,992366668,'hygienist',	35000.00,	35, 6,	'Male',		'1921 Designer Avenue, Winnipec, MB'),
	(16,542600891,'dentist',  	150000.00,	37, 2,	'Female',	'19 Spadina Avenue, Toronto, ON'),
	(17,542631635,'dentist',  	150000.00,	38, 1,	'Female',	'33 Sussex Drive,Ottawa, ON')
;

UPDATE usr_clinic
SET director = 
	CASE clinic_id
	WHEN 1 THEN 13
	WHEN 2 THEN 8
	WHEN 3 THEN 9
	WHEN 4 THEN 14
	WHEN 5 THEN 10
	WHEN 6 THEN 12
END
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
	(10,992366668,'1921 Designer Avenue, Winnipec, MB',	'533-234-8874',	'JacobVersace@gucci.com',		'Employee Benefit Insurance'	,NULL,	15,	'Male',		true , 8),
	(11,963737651,'212 Maverick Street, Halifax, NS',	'452-905-8447',	'YoussefBenArfa@yahoo.com',		'Greenshield Student Insurance'	,NULL,	16,	'Male',		false,NULL),
	(12,233267843,'882 Mully Drive, Ottawa, ON',		'613-443-4664',	'WilliamBlack@gmail.com',		'Greenshield Student Insurance'	,NULL,	17,	'Male',		false,NULL),
	(13,923465674,'12 Rideau Street, Ottawa, ON',		'613-841-5431',	'WendyMendy@gmail.com',			'SureHealth Youth Insurance'	,26,	18,	'Female',	false,NULL),
	(14,935785351,'3131 Labelle Promenade, Montreal, QC','438-542-9403',	'DonnaSmith@outlook.com',	'SureHealth Youth Insurance'	,27,	19,	'Female',	false,NULL),
	(15,143353661,'444 Didier Road, Toronto, ON',		'648-950-2534',	'DonovanDrogba@yahoo.com',		'Greenshield Youth Insurance'	,22,	20,	'Male',		false,NULL),
	(16,578539714,'241 Visenaut Avenue, Fredericton, NB','765-904-4456',	'DaveDuncaster@gmail.com',	'SureHealth Youth Insurance'	,23,    21,	'Male',		false,NULL)
;																																								

INSERT INTO usr_review
(review_id, comments, clinic_id, communication, hygene, value, patient_id)
VALUES 
	(1, 'This clinic is great, the staff is lovely and its always clean', 1,10,9,7,12),
	(2, 'The national clinic in ottawa is wonderful, it is massive and the wait time is minimal. It is pricy however!', 1,9,8,4,13),
	(3, 'I had a terrible time at the Ottawa clinic, my appointment was for 1:00pm but they only took me in for my teeth cleaning at 4:00pm! Completely ridiculous', 1,1,5,5,1),
	(4, 'Always reliable the National clinic in Ottawa. My go to clinic.', 1,8,9,7,9),
	(5, 'This clinic is terrible and dirty . DONT GO', 2,4,1,6,4),
	(6, 'The Vancouver clinic is the best dentist clinic I have ever seen', 3,10,10,10,7),
	(7, 'Good dentist spot for a good price', 4,6,7,10,14),
	(8, 'This clinic is okay, the staff could be friendlier but its always clean', 5,5,10,6,16)
;

INSERT INTO mdf_medical_folder
(folder_id, patient_id, creation_date, language, emergency_contact, emergency_phone)
VALUES 
	(1,1,   '2018-04-23',	'English',	'Mathieu Cote',		'343-555-2345'),
	(2,2,   '2018-12-12',	'English',	'Benjamin Franklin','306-132-3144'),
	(3,3,   '2018-02-16',	'English',	'Borris Lorris',	'416-765-3452'),
	(4,4,   '2018-06-06',	'English',	'Mila Friter',		'648-233-9870'),
	(5,5,   '2018-03-29', 	'French', 	'Candice Teller',	'623-841-3321'),
	(6,6,   '2018-08-22',	'English',	'Caroline Berger',	'416-432-6555'),
	(7,7,   '2018-09-29',	'English',	'Raphael Fort',		'514-565-0031'),
	(8,8,   '2018-09-22',   'English',	'Kalia Erik',		'438-544-7129'),
	(9,9,   '2018-09-22',   'English',	'Dieu-Donne Espoir','343-223-3267'),
	(10,10, '2019-03-21',	'English',	'Peter Parker',		'533-234-8874'),
	(11,11, '2019-03-15',	'English',	'Elliot alderson',	'452-905-8447'),
	(12,12, '2019-05-12',	'English',	'Bob Leponge',		'613-443-4664'),
	(13,13, '2019-04-07',	'English',	'Mariam Mendy',		'613-841-5431'),
	(14,14, '2019-01-04',	'French', 	'Dominic Leblanc',	'438-542-9403'),
	(15,15, '2019-03-15',	'English',	'Levi Arthur',	 	'648-950-2534'),
	(16,16, '2019-02-18',	'English',	'Lemy smith',	 	'765-904-4456')	
;

INSERT INTO mdf_vaccination
(folder_id, line_no, vaccine_name, date_taken)
VALUES 
	(1,1,'Moderna Covid-19 Vaccine First Dose', '2021-09-10'),
	(1,2,'Moderna Covid-19 Vaccine Second Dose', '2022-03-08'),
	(1,3,'HepA-HepB Twinrix Vaccine', '2012-09-10'),
	(1,4,'Measles MMRV Proquad Vaccine', '2010-09-11'),
	(2,1,'Moderna Covid-19 Vaccine First Dose', '2021-03-12'),
	(2,2,'Pfizer Covid-19 Vaccine Second Dose', '2021-07-30'),
	(3,1,'Moderna Covid-19 Vaccine First Dose', '2021-05-12'),
	(3,2,'Moderna Covid-19 Vaccine Second Dose', '2021-09-21'),
	(3,3,'Moderna Covid-19 Vaccine Booster Dose', '2022-02-18'),
	(4,1,'Pfizer Covid-19 Vaccine First Dose', '2021-09-10'),
	(4,2,'Pfizer Covid-19 Vaccine Second Dose', '2022-03-08'),
	(5,1,'Measles MMRV Proquad Vaccine', '2015-01-10'),
	(6,1,'HepA-HepB Twinrix Vaccine', '2013-03-14'),
	(7,1,'Measles MMRV Proquad Vaccine', '2021-09-10'),
	(8,1,'HepA-HepB Twinrix Vaccine', '2019-03-03'),
	(8,2,'Pfizer Covid-19 Vaccine First Dose', '2021-05-29')
;

INSERT INTO mdf_condition
(folder_id, line_no, condition_name, description)
VALUES 
	(1,1,'Parkinsons', 'Slower movement, trembling, intense muscle pain'),
	(1,2,'Depression', 'Stress, anxiety'),
	(1,3,'Allergy to latex', 'Swelling and airway blocked'),
	(3,1,'Oral Cancer', 'Constant pain in mouth '),
	(4,1,'Cavities', 'Tooth loss'),
	(5,1,'Cavities', 'Tooth loss'),
	(6,1,'Cavities', 'Tooth loss'),
	(7,1,'Cavities', 'Tooth loss'),
	(8,1,'Diabetes', 'Sensitive to sugar and requires insuline'),
	(9,1,'Cavities', 'Tooth loss'),
	(10,1,'Gum Disease', 'Sensitive and thin gums'),
	(11,1,'Gum Disease', 'Sensitive and thin gums'),
	(12,1,'Cavities', '2015-01-10'),
	(13,1,'Osteoporosis', 'Weaker jawbone structure'),
	(12,2,'Diabetes', 'Sensitive to sugar and requires insuline'),
	(14,1,'Nut allergy', 'Swelling and airway blocked'),
	(14,2,'Autism', 'Sensitive to noise and touch , communication struggles, tantrums')
;

INSERT INTO mdf_medication
(folder_id,line_no,medication_name,description,dosage)
VALUES 
	(1,1,'Levodopa', 'Dopamine, to lessen side effects of Parkinson','50mg/day'),
	(1,2,'Prozac', 'anti-depressant', '300mg/day'),
	(2,1,'Allergy to latex', 'Swelling and airway blocked', '150mg/day'),
	(3,1,'Fentanyl', 'Pain Killer', '15mg/day'),
	(6,1,'Chlorhexidine', 'Prevents plaque and strengthen gums', '400mg/day'),
	(7,1,'Chlorhexidine', 'Prevents plaque and strengthen gums', '40mg/day'),
	(7,2,'Insulin', 'Regulates sugar in blood', '2g/day'),
	(7,3,'Advil', 'Eliviates Pain', '300mg/day'),
	(10,1,'Chlorhexidine', 'Prevents plaque and strengthen gums', '600mg/day'),
	(11,1,'Chlorhexidine', 'Prevents plaque and strengthen gums', '150mg/day'),
	(12,1,'Chlorhexidine', 'Prevents plaque and strengthen gums', '200mg/day'),
	(13,1,'Opiod', 'Narcotic for pain', '500mg/day'),
	(12,2,'Insulin', 'Regulates sugar in blood', '1g/daily'),
	(15,1,'Doxycycline', 'kill skin bacteria', '30mg/day'),
	(14,1,' Abilify', 'Antipsychotic to reduce agression and stress', '200mg/day')
;


INSERT INTO rdv_appointment
(apt_id, patient_id, dentist_id, clinic_id, date, start_time, end_time, type, status, room_number)
VALUES 
	(1,1,17,1,   '2020-02-13','09:45:00','10:45:00','Annual Clean-up','finished','12'),
	(2,1,17,1,   '2021-01-13','10:15:00','12:30:00','Annual Clean-up','finished','122'),
	(26,1,13,1,  '2022-01-08','10:45:00','11:30:00','Annual Clean-up','late cancelation','1B2'),
	(3,1,13,1,   '2022-01-09','10:45:00','11:30:00','Annual Clean-up','finished','45A'),
	(4,1,13,1,   '2023-02-15','13:00:00','15:00:00','Annual Clean-up','normal',  '162'),
	(5,2,12,6,   '2021-05-21','14:45:00','15:45:00','Annual Clean-up','finished','A110'),
	(6,2,12,6,   '2022-06-12','08:30:00','09:00:00','Annual Clean-up','finished','B52'),
	(7,3,16,2,   '2020-07-17','10:15:00','10:45:00','Annual Clean-up','finished','G232'),
	(8,3,17,1,   '2022-01-23','15:30:00','16:00:00','Annual Clean-up','finished','H12'),
	(9,4,16,2,   '2022-02-13','09:45:00','10:45:00','Remove Cavity','finished','36'),
	(10,4,16,2,  '2023-02-13','11:45:00','12:45:00','Annual Clean-up','normal','72'),
	(11,5,14,4,  '2020-08-10','12:00:00','13:00:00','Annual Clean-up','finished','82'),
	(12,7,9,3,   '2021-07-11','16:45:00','17:45:00','Annual Clean-up','finished','28'),
	(13,8,14,4,  '2021-04-12','16:15:00','16:45:00','Annual Clean-up','late cancelation','G12'),
	(14,9,17,1,  '2021-05-16','09:45:00','10:45:00','Annual Clean-up','finished','A298'),
	(15,9,17,4,  '2021-06-18','17:45:00','18:45:00','Annual Clean-up','finished','B21'),
	(16,10,12,6, '2021-02-13','09:45:00','10:45:00','Annual Clean-up','canceled','90'),
	(17,10,12,6, '2022-07-11','10:00:00','10:30:00','Annual Clean-up','normal','12'),
	(18,11,11,5, '2020-02-13','10:30:00','11:00:00','Annual Clean-up','finished','90'),
	(19,11,11,5, '2020-02-13','11:00:00','11:30:00','Annual Clean-up','finished','B21'),
	(20,12,17,1, '2020-02-13','11:30:00','12:00:00','Annual Clean-up','finished','A298'),
	(21,12,17,1, '2022-01-29','12:30:00','13:00:00','Annual Clean-up','rejected by dentist','162'),
	(22,12,17,1, '2023-02-06','13:00:00','13:30:00','Cavity filling','normal','45A'),
	(23,12,13,1, '2023-09-21','14:00:00','14:30:00','Annual Clean-up','normal', '122'),
	(24,13,17,1, '2023-02-13','14:45:00','15:45:00','Wisdom teeth removal','normal','123'),
	(25,14,14,4, '2020-02-13','09:30:00','10:30:00','Annual Clean-up','finished','12')
;

INSERT INTO mdf_visit_treatment
(folder_id, line_no, specialist_name, enter_date, summary, apt_id, apt_type, diagnosis, tests_made,test_result, medication_prescribed, teeths, notes)
VALUES
	(1,1, 'Therese Bielsa', '2019-03-15', 'MDF Transfered from outside system, Annual cleanup and checkup 2019', NULL, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, nothing that is troubling at the moment , we can schedule next annual checkup.'),
	-- (1,2, 'Bella Colleto', '2020-02-13', 'Annual cleanup and checkup 2020', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, nothing that is troubling at the moment , we can schedule next annual checkup.'),
	-- (1,3, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	-- (1,4, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	-- (1,5, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	-- (1,2, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	-- (1,2, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	-- (1,2, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.'),
	(1,2, 'Bella Colleto', '2020-01-13', 'Annual cleanup and checkup 2021', 1, 'Annual clean-up', NULL, NULL, NULL, NULL,'all teeth', 'Standard checkup, a larger accumulation of plaque are now appearing , we can schedule next annual checkup and add plaque removal procedure to it.')

;

INSERT INTO pay_procedure_fee
(fee_id, procedure_description, fees, procedure_code)
VALUES
	(1,'Late cancellation fee',14.00, 94303),
	(2,'Fluorure pour le dent', 33.00, 1223)
;
	


-- 	--Original doctors/medical staff
-- 	(28,'Christine','Aguilera','Christine Aguilera','voice22','voice22','employee','1976-02-23',46),
-- 	(29,'Jean','Lafleur','Jean Lafleur','jean2dentist','jean2dentist','employee','1975-02-24',47),
-- 	(30,'Martha','Poliski','Martha Poliski','polisher1','polisher1','employee','1974-02-19',48),
-- 	(31,'Emmanuel','Macaron','Emmanuel Macaron','GiletJaune12','GiletJaune12','employee','1973-02-08',49),
-- 	(32,'Mia','Turner','Mia Turner','worker4ever','worker4ever','employee','1962-02-09',60),
-- 	(33,'Michael','Godfrey','Michael Godfrey','Miketooth24','Miketooth24','employee','1952-02-22',70),
-- 	(34,'Zinedine','Zidane','Zinedine Zidane','bluetooth13','siuuu22','employee','1950-07-13',71),
-- 	(35,'Jacob','Versace','Jacob Versace','jacobEmpAccount','$1234$','employee','1995-02-01',27),
-- 	(37,'Bella','Coletto','Bella Coletto','bellacol3','$333$','employee','1996-02-02',26),
-- 	(38,'Sully','Lovely','Sully Lovely','sullove2','$111$','employee','1990-04-21',32)
-- ;
-- 	(9,900123452, 'dentist',	190000.00,	29,	3,  'Female',	'57 Calibas Street, Vancouver, BC'),
-- 	(10,742874723,'hygienist',	56000.00,	30, 1,  'Female',	'44 George-Etienne Drive, Ottawa, ON'),
-- 	(11,478219361,'dentist',	212000.00,	31, 5,	'Male',		'209 Maverick Street, Halifax, NS'),
-- 	(12,194281333,'dentist',	311000.00,	32,	6,	'Female',	'442 Pompon Road, Regina , SK'),
-- 	(13,542529127,'dentist', 	140000.00,	33,	1, 	'Male',		'12 Kayak Street, Ottawa, ON'),
-- 	(14,935285265,'dentist', 	200000.00,	34, 4,	'Male',		'3135 Labelle Promenade, Montreal, QC'),
-- 	(15,992366668,'hygienist',	35000.00,	35, 6,	'Male',		'1921 Designer Avenue, Winnipec, MB'),
-- 	(16,542600891,'dentist',  	150000.00,	37, 2,	'Female',	'19 Spadina Avenue, Toronto, ON'),
-- 	(17,542631635,'dentist',  	150000.00,	37, 1,	'Female',	'33 Sussex Drive,Ottawa, ON')
-- ;

