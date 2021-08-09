<?php

/*

Author: Obie Burns

MAKE SURE THIS FILE IS IN SETUP FOLDER!

REMEMBER TO DELETE PREVIOUS DATABASE ENTRIES

*/

require "../dbConnection.php";

// sql that inserts buses
$busSql = "

INSERT INTO `buses` 
(`BusNumber`, `DepartureDate`, `TravelOrigin`, `TravelTerminal`, `BusComfortType`, `Fleet`) 
VALUES 


('1',  '2021-05-14', 'Canberra CBD',     'Goulburn',         'Luxury',      'SCANIA'),
('2',  '2021-05-14', 'Goulburn',         'Canberra CBD',     'Luxury',      'SCANIA'),

('3',  '2021-05-15', 'Collector',        'Canberra CBD',     'Standard',    'MAN'), 
('4',  '2021-05-15', 'Canberra CBD',     'Collector',        'Standard',    'MAN'), 

('5',  '2021-05-15', 'Canberra CBD',     'Crookwell',        'Semi-Luxury', 'MAN'),
('6',  '2021-05-16', 'Crookwell',        'Canberra CBD',     'Semi-Luxury', 'MAN'),

('7',  '2021-05-16', 'Canberra CBD',     'Sydney CBD',       'Luxury',      'VOLVO'),
('8',  '2021-05-17', 'Sydney CBD',       'Canberra CBD',     'Luxury',      'VOLVO'),

('9',  '2021-05-17', 'Gunning',          'Crookwell',        'Standard',    'SCANIA'),

('10',  '2021-05-18', 'Crookwell',        'Sydney CBD',       'Semi-Luxury', 'MAN'),
('11',  '2021-05-19', 'Sydney CBD',       'Crookwell',        'Semi-Luxury', 'MAN'),

('12',  '2021-05-19', 'Sydney CBD',       'Goulburn',         'Standard',    'MAN'),
('13',  '2021-05-20', 'Goulburn',         'Sydney CBD',       'Standard',    'MAN'),

('14',  '2021-05-20', 'Crookwell',        'Collector',        'Semi-Luxury', 'SCANIA'),
('15',  '2021-05-20', 'Collector',        'Crookwell',        'Semi-Luxury', 'SCANIA'),

('16',  '2021-05-21', 'Collector',        'Goulburn',         'Standard',    'MAN'),

('17', '2021-05-22', 'Canberra CBD',     'Yass',             'Standard',    'SCANIA'),
('18', '2021-05-22', 'Yass',             'Canberra CBD',     'Standard',    'SCANIA'),

('19', '2021-05-23', 'Collector',        'Yass',             'Semi-Luxury', 'SCANIA'),

('20', '2021-05-24', 'Yass',             'Murrumbateman',    'Standard',    'MAN'),
('21', '2021-05-24', 'Murrumbateman',    'Yass',             'Standard',    'MAN'),

('22', '2021-05-25', 'Murrumbateman',    'Crookwell',        'Semi-Luxury', 'SCANIA'),

('23', '2021-05-26', 'Crookwell',        'Yass',             'Semi-Luxury', 'SCANIA'),
('24', '2021-05-28', 'Yass',             'Crookwell',        'Semi-Luxury', 'SCANIA'),

('25', '2021-05-27', 'Canberra CBD',     'Yass',             'Semi-Luxury', 'SCANIA'),
('26', '2021-05-27', 'Yass',             'Canberra CBD',     'Semi-Luxury', 'SCANIA'),

('27', '2021-05-28', 'Yass',             'Sydney CBD',       'Luxury',      'VOLVO'),
('28', '2021-05-28', 'Sydney CBD',       'Yass',             'Luxury',      'VOLVO'),

('29', '2021-05-29', 'Crookwell',        'Gunning',          'Standard',    'SCANIA'),
('30', '2021-05-29', 'Gunning',          'Crookwell',        'Standard',    'SCANIA'),

('31', '2021-05-30', 'Gunning',          'Reid (Canberra)',  'Semi-Luxury', 'SCANIA'),
('32', '2021-05-30', 'Reid (Canberra)',  'Gunning',          'Semi-Luxury', 'SCANIA'),

('33', '2021-05-31', 'Reid (Canberra)',  'Yass',             'Luxury',      'VOLVO'),
('34', '2021-06-01', 'Yass',             'Reid (Canberra)',  'Luxury',      'VOLVO'),

('35', '2021-06-01', 'Yass',             'Crookwell',        'Standard',    'SCANIA');

";

$result = mysqli_query($conn, $busSql) or die ("Error - " . mysqli_error($conn));

// sql that inserts tickets without discounts
$ticketBasicSql = "

INSERT INTO `tickets` 
(`BusNumber`, `Price`, `TicketAvailable`, `TripType`) 
VALUES 

('1',  '30', '20',  1), 
('2',  '30', '20',  1), 

('3',  '60', '15',  1),
('4',  '60', '15',  1),

('5',  '10', '50',  1),
('6',  '10', '50',  1),

('7',  '15', '30',  1),
('8',  '15', '30',  1),

('9',  '20', '12',  0),

('10',  '50', '4',   1),
('11',  '50', '4',   1),

('12',  '10', '62',  1),
('13',  '10', '62',  1),

('14',  '35', '17',  1),
('15',  '35', '17',  1),

('16',  '42', '10',  0),

('17',  '20', '25',  1),
('18',  '20', '25',  1),

('19',  '12', '35',  0),

('20',  '10', '60',  1),
('21',  '10', '60',  1)
;

-- Murrumbateman to Crookwell (one way) (SPECIAL TICKET)


-- Crookwell to Yass (SPECIAL TICKET)


-- Canberra to Yass (SPECIAL TICKET)


-- Yass to Sydney (SPECIAL TICKET)


-- Crookwell to Gunning (SPECIAL TICKET)


-- Gunning to Canberra (SPECIAL TICKET)


-- Canberra to Yass (SPECIAL TICKET)


-- Yass to Crookwell (one way) (SPECIAL TICKET)



";

$result = mysqli_query($conn, $ticketBasicSql) or die ("Error - " . mysqli_error($conn));

// sql that inserts tickets with discounts
$ticketDiscountSql = "

INSERT INTO `tickets` 
(`BusNumber`, `Price`, `TicketAvailable`, `Discount`, `TripType`) 
VALUES 

('1', '10', '5', '0.50', 0),
('2', '12', '2', '0.75', 0),
('1', '15', '1', '0.45', 0),
('2', '4', '6', '0.90', 0),

('3', '5', '20', '0.50', 0),
('4', '10', '2', '0.72', 0),
('3', '6', '10', '0.60', 0),
('4', '10', '7', '0.30', 0),

('10', '20', '3', '0.50', 0),
('11', '25', '4', '0.40', 0),


('20',  '10', '20',  '0.50', 0),
('21',  '10', '18',  '0.60', 0),

('9',  '15', '3',  '0.55', 1),
('9',  '16', '10',  '0.60', 1),
('9',  '10', '20',  '0.25', 1),

('19',  '12', '10',  '0.25', 1),
('19',  '10', '8',  '0.50', 1),
('19',  '15', '5',  '0.75', 1),
('19',  '30', '45',  '0.75', 1),

('35', '10', '4', '0.30', 1),
('35', '23', '12', '0.45', 1),


('35', '15', '3', '0.25', 0),

('33', '12', '30',  '0.25', 1),
('34', '12', '30', '0.25', 1),

('31', '15', '8',  '0.20', 1),
('32', '15', '8', '0.20',  1),

('29', '10', '30', '0.30', 1),
('30', '10', '30', '0.30', 1),

('27', '15', '25', '0.50', 1),
('28', '15', '25', '0.50', 1),

('25', '12', '30', '0.25', 1),
('26', '12', '30', '0.25', 1),

('23', '8',  '71',  '0.25', 1),
('24', '8',  '71',  '0.25', 1),

('22',  '15', '55', '0.20', 0)

;

";

$result = mysqli_query($conn, $ticketDiscountSql) or die ("Error - " . mysqli_error($conn));



// sql that inserts routes to the database
$routeSql = "

INSERT INTO `Routes` 
(`BusNumber`, `TravelStop`) 
VALUES 

('1', 'Collector'), 
('1', 'Lake George'),

('2', 'Lake George'),

('3', 'Grabben Gullen'),
('3', 'Gunning'),

('4', 'Gundaroo'),
('4', 'Goulburn'),
('4', 'Campbelltown'),
('4', 'Parramatta'),

('5', 'Grabben Gullen'),
('5', 'North Crookwell'),

('6', 'Goulburn'),
('6', 'Campbelltown'),
('6', 'Parramatta'),
('6', 'Museum of Contemporary Art'),

('7', 'Campbelltown'),
('7', 'Parramatta'),
('7', 'Marulan'),


('10', 'Murrumbateman'),
('10', 'Gunning'),

('11', 'Gunning'),
('11', 'Gundaroo'),

('13', 'Gunning'),
('13', 'Grabben Gullen'),

('14', 'Gunning'),
('14', 'Grabben Gullen'),

('15', 'Murrumbateman'),
('15', 'Belconnen'),

('16', 'Marulan'),
('16', 'Parramatta'),
('16', 'Campbelltown'),

('18', 'Gundaroo'),
('18', 'Belconnen Skatepark'),



('19', 'Murrumbateman'),
('19', 'Gungahlin'),

('20', 'Gunning'),
('20', 'Grabben Gullen')
;

";

$result = mysqli_query($conn, $routeSql) or die ("Error - " . mysqli_error($conn));



// prints success message if the queries were a success
echo "<h1>Success</h1>";

?>