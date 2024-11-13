CREATE TABLE `business_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(255) NOT NULL,
  `owner_fname` varchar(255) NOT NULL,
  `owner_mname` varchar(255) NOT NULL,
  `owner_lname` varchar(255) NOT NULL,
  `owner_suffix` varchar(255) NOT NULL,
  `businessName` varchar(100) NOT NULL,
  `typeOfBusiness` varchar(100) NOT NULL,
  `businessAddress` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `date_issued` date NOT NULL,
  `amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `cert_amount` varchar(100) NOT NULL,
  `date_of_pickup` date NOT NULL,
  `note` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO business_cert (id, ownerId, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) VALUES ('8', '2', '', '', '', '', 'Eat Na!', 'Resto', 'Narra, North Poblacion, Gabaldon, Nueva Ecija', '', '', '', '', '0000-00-00', '', 'Approved', '', '2024-09-18', '');
INSERT INTO business_cert (id, ownerId, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) VALUES ('16', '0', 'Jean', '', 'Dee', '', 'Gasthatione', 'Gasoline', '', 'Acasia', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', '2024-10-05', '', 'Walk-in', '50', '0000-00-00', '');
INSERT INTO business_cert (id, ownerId, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) VALUES ('18', '2', 'John', 'Doeeee', 'r`', '', 'w', '53w', 'y', 'Banaba', '', '', '', '2024-10-29', '', 'New', '3431', '0000-00-00', '');
INSERT INTO business_cert (id, ownerId, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) VALUES ('19', '0', 'Juan', 'S', 'Tadili', '', 'Kopi Ko', 'Coffee shop', 'North', 'Mulawin', '', '', '', '2024-11-05', '', '', '652', '0000-00-00', '');
INSERT INTO business_cert (id, ownerId, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) VALUES ('20', '0', 'Melvin', 'S', 'Tadili', '', 'Kopi Ko', 'Coffee shop', 'North', 'Mabolo', '', '', '', '2024-11-05', '', 'Walk-in', '652', '0000-00-00', '');


CREATE TABLE `clearance_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `clearanceNo` varchar(100) NOT NULL,
  `resident_id` varchar(100) NOT NULL,
  `findings` varchar(100) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `bcNo` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_issued` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `pickup_date` varchar(100) NOT NULL,
  `rs` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('15', '15', 'Josamine', 'R.', 'Parungao', '22', '', '18', '', 'School Requirement', '81-75', '70', '0000-00-00', 'Done', '2025-06-25', 'Single', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('34', '12', 'Dane', '', 'Sisor', '25', '', '12', '', '', '81-90', '70', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('35', '3', 'Juan', '', 'Dela Cruz', '18', '', '3', '', '', '60-70', '70', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('36', '5', 'Nina Sara', 'D', 'Sayaman', '26', '', '', '', '', '70-31', '70', '0000-00-00', 'Done', '2024-06-03', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('38', '2', 'Josamine', 'R', 'Parungao', '22', '', '', '', '', '85-80', '70', '0000-00-00', 'Done', '2024-06-10', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('39', '2', 'Josamine', 'R', 'Parungao', '22', '', '', '', '', '', '', '0000-00-00', 'Disapproved', '2024-06-11', '', 'duplicate requestss');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('40', '4', 'Marielle', 'P', 'Dacuscus', '24', '', '4', '', '', '85-69', '70', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('41', '16', 'John', '', 'Doe', '24', '', '', '', '', '90-12', '70', '0000-00-00', 'Done', '2024-08-01', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('42', '3', 'Juana', 'D', 'Cruz', '44', '', '3', '', '', '001', '1', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('43', '9', 'Marlon ', '', 'Cruz', '29', '', '9', '', '', 'abc-123', '70', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('44', '3', 'Juana', 'D', 'Cruz', '44', '', '3', '', '', 'ABC-897', '70', '0000-00-00', 'Done', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('45', '1', 'Josamine', 'R', 'Parungao', '23', '', '', '', '', '30', '300', '0000-00-00', 'New', '2024-10-07', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('46', '1', 'Josamine', 'R', 'Parungao', '23', '', '', '', '', '', '', '0000-00-00', 'Approved', '2024-10-08', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('47', '9', 'Elena', '', 'Bataler', '24', '', '', '', 'tests', '30', '30', '2024-10-17', 'Approved', '2024-10-08', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('48', '0', 'John', 'S', 'Doe', '24', '', '32', '', '', '80-32', '70', '0000-00-00', 'New', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('49', '0', 'John', 'S', 'Doe', '23', '32', '32', '', 'test', '80-09', '23', '2024-10-22', 'Walk-in', '', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('51', '2', 'John', '', 'Doe', '24', '', '', '', '', '', '', '0000-00-00', 'New', '2024-10-29', '', '');
INSERT INTO clearance_cert (id, ownerId, fname, mname, lname, age, clearanceNo, resident_id, findings, purpose, bcNo, amount, date_issued, status, pickup_date, rs, note) VALUES ('52', '2', 'John', '', 'Doe', '24', '', '', '', '', '', '', '2024-10-29', 'New', '2024-10-25', '', '');


CREATE TABLE `indigency_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `bday` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `year_stayed` varchar(100) NOT NULL,
  `date_issued` date NOT NULL,
  `amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `pickup` varchar(100) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('5', '5', 'Elena', 'S.', 'Bataller', '27', '1999-12-25', 'Narra', '2000', '2024-04-24', '', 'Done', 'medical assistance', '2025-05-26', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('7', '10', 'Manuel', 'S', 'Cruz', '25', '1998-12-07', 'Banaba', '2001', '2024-06-07', '50', 'Done', '', '', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('8', '2', 'John Doe', 'M', 'Sy', '25', '2000-12-05', 'Calumpit', 'Since Birth', '2024-06-07', '50', 'Disapproved', 'test', '2025-05-12', 'test');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('9', '12', 'Dane', '', 'Sisor', '25', '1999-01-01', 'kamagong', '2003', '2024-06-06', '50', 'Walk-in', '', '', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('10', '2', 'John', 'S', 'Doe', '27', '1996-12-25', 'Kamagong', '4', '2024-10-17', '70', 'Walk-in', '', '', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('11', '3', 'Juana', 'D', 'Cruz', '44', '1980-01-03', 'Kamagong', '3', '2024-10-17', '70', 'Done', 'test', '', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('12', '2', 'John', '', 'Doe', '24', '2000', '', '2', '2024-10-29', '0', 'New', '', '', '');
INSERT INTO indigency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) VALUES ('13', '1', 'Josamine', 'R', 'Parungao', '23', '2001-06-06', 'Kamagong', '4', '2024-11-05', '150', 'Walk-in', 'for cash assist', '', '');


CREATE TABLE `land_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerName` varchar(255) NOT NULL,
  `sellerAddress` varchar(255) NOT NULL,
  `buyerName` varchar(255) NOT NULL,
  `buyerAddress` varchar(100) NOT NULL,
  `landArea` varchar(100) NOT NULL,
  `propertySold` varchar(100) NOT NULL,
  `amount` int(255) NOT NULL,
  `amount_words` varchar(255) NOT NULL,
  `legalAgree` varchar(100) NOT NULL,
  `paymentConfirm` varchar(100) NOT NULL,
  `confirmationPay` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `witness` varchar(100) NOT NULL,
  `notarizeDate` date NOT NULL,
  `locationNota` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `cert_amount` varchar(100) NOT NULL,
  `date_of_pickup` date NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO land_cert (id, sellerName, sellerAddress, buyerName, buyerAddress, landArea, propertySold, amount, amount_words, legalAgree, paymentConfirm, confirmationPay, date, witness, notarizeDate, locationNota, status, cert_amount, date_of_pickup, note) VALUES ('1', 'Josamine Parungao', 'Mulawin, North Poblacion Gabaldon', 'Honeylhei Santos', 'Malinao, Gabaldon', '123', 'North', '70000', 'SEVENTY THOUSAND PESOS', 'yes', 'cash', 'cash', '2020-04-15', 'Nina', '2020-04-14', 'Gabaldon', 'Disapproved', '', '0000-00-00', '');
INSERT INTO land_cert (id, sellerName, sellerAddress, buyerName, buyerAddress, landArea, propertySold, amount, amount_words, legalAgree, paymentConfirm, confirmationPay, date, witness, notarizeDate, locationNota, status, cert_amount, date_of_pickup, note) VALUES ('5', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '1', '', 'asd', 'asd', 'asd', '2024-09-17', 'asd', '2024-09-18', 'asd', 'Walk-in', '200', '0000-00-00', '');
INSERT INTO land_cert (id, sellerName, sellerAddress, buyerName, buyerAddress, landArea, propertySold, amount, amount_words, legalAgree, paymentConfirm, confirmationPay, date, witness, notarizeDate, locationNota, status, cert_amount, date_of_pickup, note) VALUES ('6', 'Josamine', 'Sawmill', 'Juan', 'Nprth', '123sqm', 'North', '0', '', 'asd', 'asd', 'asd', '2024-09-17', 'asd', '2024-09-18', 'asd', 'Done', '', '0000-00-00', '');
INSERT INTO land_cert (id, sellerName, sellerAddress, buyerName, buyerAddress, landArea, propertySold, amount, amount_words, legalAgree, paymentConfirm, confirmationPay, date, witness, notarizeDate, locationNota, status, cert_amount, date_of_pickup, note) VALUES ('8', 'test', '', '', '', '', '', '0', '', '', '', '', '0000-00-00', '', '0000-00-00', '', 'Done', '', '0000-00-00', '');


CREATE TABLE `livestock_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerName` varchar(100) NOT NULL,
  `sellerAddress` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `amount_words` varchar(255) NOT NULL,
  `buyerName` varchar(100) NOT NULL,
  `buyerAddress` varchar(100) NOT NULL,
  `itemSold` varchar(100) NOT NULL,
  `quantity` int(255) NOT NULL,
  `age` varchar(100) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `cowlicks` varchar(100) NOT NULL,
  `brandMun` varchar(100) NOT NULL,
  `brandOwn` varchar(100) NOT NULL,
  `transacDate` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `cert_amount` varchar(100) NOT NULL,
  `date_of_pickup` date NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('5', 'Josamine Parungao', 'Mulawin, North Poblacion Gabaldon', '70', 'One Thousand pesos', 'Jhocel B. Melindo', 'Mabini, Cabanatuan City', 'Dog', '1', '4 Months', 'Male', '', 'Gabaldon', 'Gabaldon', '2024-04-20', 'Done', '150', '0000-00-00', '', '0');
INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('13', 'asd', 'asd', '10000', '', 'sad', 'asd', 'asd', '0', 'asd', 'asd', 'asd', 'asd', 'asd', '2024-09-16', 'Done', '150', '0000-00-00', '', '0');
INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('14', 'asd', 'asd', '1000', '', 'asd', 'asd', 'asd', '0', 'asd', 'asd', 'asd', 'asd', 'asd', '2024-09-18', 'Approved', '150', '0000-00-00', '', '0');
INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('15', 'Josamine', 'Sawmill', '10000', '', 'Nina Sara', 'Bagting', 'Pig', '0', '6 Months', 'Male and Female', '-', '-', '-', '2024-10-05', 'Disapproved', '70', '0000-00-00', '', '0');
INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('16', '', '', '0', '', '', '', '', '0', '', '', '', '', '', '0000-00-00', 'Done', '0', '0000-00-00', '', '0');
INSERT INTO livestock_cert (id, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, itemSold, quantity, age, sex, cowlicks, brandMun, brandOwn, transacDate, status, cert_amount, date_of_pickup, note, created_by) VALUES ('17', 'test', 'test', '23', 'test', 'test', 'test', '', '23', 'test', 'test', 'test', 'test', 'test', '2024-10-18', 'Done', '23', '2024-10-18', '', '0');


CREATE TABLE `residency_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `age` varchar(20) NOT NULL,
  `bday` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `year_stayed` varchar(100) NOT NULL,
  `date_issued` date NOT NULL,
  `amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `pickup_date` varchar(100) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('18', '18', 'Honeylehi', 'M.', 'Santos', '22', '2001-12-04', 'Mahogany', '2001', '2024-04-21', '50', 'Done', '2025-04-30', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('19', '16', 'Josamine', 'M.', 'Parungao', '22', '2001-06-06', 'Kamagong', '2001', '2024-05-15', '50', 'Done', '2024-06-06', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('25', '12', 'Dane', '', 'Sisor', '25', '1999-01-01', 'kamagong', '2001', '2024-05-24', '50', 'Done', '', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('26', '5', 'Pedro', '', 'Reyes', '20', '2003-02-10', 'Narra', '2001', '2024-05-24', '50', 'Done', '', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('33', '3', 'Juan', '', 'Dela Cruz', '18', '2006-04-05', 'Mabolo', '2001', '2024-05-26', '50', 'Walk-in', '', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('34', '2', 'Josamine', 'R', 'Parungao', '22', '06-06-2000', 'Kamagong', '2001', '2024-06-07', '70', 'Done', '2024-06-10', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('36', '2', 'John', '', 'Doe', '24', '2000', 'Mulawin', '2005', '2024-08-01', '50', 'Done', '2024-08-02', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('37', '2', 'John', '', 'Doe', '24', '2000', 'Mulawin', '2010', '2024-10-05', '50', 'Approved', '2024-09-10', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('38', '1', 'Josamine', 'R', 'Parungao', '23', '2001-06-06', 'Kamagong', '2002', '0000-00-00', '', 'Done', '2024-10-08', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('39', '1', 'Josamine', 'R', 'Parungao', '23', '2001-06-06', 'Kamagong', '2002', '0000-00-00', '', 'Approved', '2024-10-08', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('40', '10', 'Honeylhei', '', 'Santos', '22', '2002', 'Kamagong', '2002', '0000-00-00', '', 'Approved', '2024-10-08', '');
INSERT INTO residency_cert (id, ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, pickup_date, note) VALUES ('41', '2', 'John', '', 'Doe', '24', '2000', '', '1', '2024-10-29', '0', 'New', '', '');


CREATE TABLE `tblactivity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateofactivity` date NOT NULL,
  `activity` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tblactivity (id, dateofactivity, activity, description, image) VALUES ('1', '2024-08-24', 'Clean - Up Drive', 'Weekly Batarisan', '1724210064271_clean-up.png');
INSERT INTO tblactivity (id, dateofactivity, activity, description, image) VALUES ('2', '2024-12-15', 'Happy Fiesta', 'Barangay Fiesta', '1724210694596_fiesta.png');


CREATE TABLE `tblblotter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yearRecorded` varchar(4) NOT NULL,
  `date` date NOT NULL,
  `complainant` varchar(255) NOT NULL,
  `caddress` varchar(255) NOT NULL,
  `personToComplaint` varchar(255) NOT NULL,
  `paddress` varchar(255) NOT NULL,
  `complaint` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `reference` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('8', '2024', '2024-07-18', 'John Doe', 'North', 'Pedro Garcia', 'South', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis libero eget ante ultricies, sit amet vestibulum enim convallis. Quisque pretium metus eget elit euismod tincidunt. Fusce laoreet semper libero, id pretium nunc cursus ut. Sed aliquam', '1st Option', 'New', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('26', '2024', '2024-07-18', 'Jane Ny', 'Sawmill', 'John Cruz', 'Cuyapa', 'abcdefghijklmamslksahdlhdoq', '1st Option', 'Referred', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('27', '2024', '2024-07-18', 'Jane Dye', 'Sawmill', 'John Dee', 'Pantoc', 'abcdefghijklmamslksahdlhdoq', '2nd Option', 'Referred', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('28', '2024', '2024-07-29', 'Juan Dela Cruz', 'Cuyapa', 'Jean Garcia', 'North', 'Quisque vehicula lobortis nulla, quis volutpat ante porta at. Vivamus laoreet, orci vitae sodales lacinia, ex dui suscipit tellus, sit amet consequat nisi ligula nec enim. Phasellus sed tincidunt ex. Nam porta sit amet ex at pulvinar. Praesent ut libero m', '1st Option', 'New', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('29', '2024', '2024-07-29', 'Juan Dela Cruz', 'Cuyapa', 'Jean Garcia', 'North', 'Quisque vehicula lobortis nulla, quis volutpat ante porta at. Vivamus laoreet, orci vitae sodales lacinia, ex dui suscipit tellus, sit amet consequat nisi ligula nec enim. Phasellus sed tincidunt ex. Nam porta sit amet ex at pulvinar. Praesent ut libero m', '1st Option', 'New', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('30', '2024', '2024-07-29', 'Juan Dela Cruz', 'Cuyapa', 'Jean Garcia', 'North', 'Quisque vehicula lobortis nulla, quis volutpat ante porta at. Vivamus laoreet, orci vitae sodales lacinia, ex dui suscipit tellus, sit amet consequat nisi ligula nec enim. Phasellus sed tincidunt ex. Nam porta sit amet ex at pulvinar. Praesent ut libero m', '1st Option', 'New', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('31', '2024', '2024-10-09', 'test', 'test', 'test', 'test', 'test', '1st Action - Brgy. Captain', 'New', '');
INSERT INTO tblblotter (id, yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) VALUES ('32', '2024', '2024-10-09', 'test', 'test', 'test', 'test', 'test', '1st Action - Brgy. Captain', 'New', '');


CREATE TABLE `tblblotter_pagpapatunay` (
  `blotterId` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `descriptionn` varchar(255) NOT NULL,
  PRIMARY KEY (`blotterId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblblotter_pagpapatunay (blotterId, id, descriptionn) VALUES ('4', '26', 'test');
INSERT INTO tblblotter_pagpapatunay (blotterId, id, descriptionn) VALUES ('5', '26', 'test');


CREATE TABLE `tblheadfam` (
  `hID` int(11) NOT NULL AUTO_INCREMENT,
  `residentID` int(11) DEFAULT NULL,
  `houseNo` int(11) NOT NULL,
  `purok` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`hID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tblhealthworker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `houseNo` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `bday` varchar(255) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblhealthworker (id, fname, mname, lname, suffix, position, contact, houseNo, purok, brgy, municipality, province, bday, image) VALUES ('1', 'John', 'S', 'Doe', '', '', '0928 857 2322', '712', 'Narra', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', '1970-01-25', '1718005741468_casual-default-pfp-aesthetic-xbt951r8ftf29b58.jpg');
INSERT INTO tblhealthworker (id, fname, mname, lname, suffix, position, contact, houseNo, purok, brgy, municipality, province, bday, image) VALUES ('3', 'test', 'test', 'test', 'tests', 'BHW', 'sss', '', '', '', '', '', '2024-10-15', 'default.jpg');


CREATE TABLE `tblhousehold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `houseno` int(11) NOT NULL,
  `purok` varchar(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tblkabataan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `bday` varchar(100) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblkabataan (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('1', 'Maria Victoria', '', 'Diozon', '', 'Chairperson', '0956 235 9843', '2000-01-19', '1718065227332_436421739_438713842177667_8267226559720000240_n.jpg');
INSERT INTO tblkabataan (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('5', 'Ken', '', 'Kuramoto', '', 'Kagawad', '', '', '1725622520636_profile.jpg');


CREATE TABLE `tbllogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `logdate` datetime NOT NULL,
  `action` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=639 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tbllogs (id, user, logdate, action) VALUES ('2', 'asd', '2017-01-04 00:00:00', 'Added Resident namedjayjay, asd asd');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('3', 'asd', '2017-01-04 19:13:40', 'Update Resident named Sample1, User1 Brgy1');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('4', 'sad', '2017-01-05 13:22:10', 'Update Official named eliezer a. vacalares, jr.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('7', 'sad', '2017-01-05 13:54:40', 'Update Household Number 1');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('8', 'sad', '2017-01-05 14:00:08', 'Update Blotter Request sda, as das');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('9', 'sad', '2017-01-05 14:15:39', 'Update Clearance with clearance number of 123131');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('10', 'sad', '2017-01-05 14:25:03', 'Update Permit with business name of asda');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('11', 'sad', '2017-01-05 14:25:25', 'Update Resident named Sample1, User1 Brgy1');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('12', 'Administrator', '2017-01-24 16:32:40', 'Added Permit with business name of hahaha');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('13', 'Administrator', '2017-01-24 16:35:41', 'Added Clearance with clearance number of 123');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('14', 'Administrator', '2017-01-24 18:43:35', 'Added Activity sad');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('15', 'Administrator', '2017-01-24 18:45:49', 'Added Activity qwe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('16', 'Administrator', '2017-01-24 18:46:20', 'Added Activity ss');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('17', 'Administrator', '2017-01-24 18:47:39', 'Added Activity e');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('18', 'Administrator', '2017-01-24 18:55:20', 'Added Activity activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('19', 'Administrator', '2017-01-24 18:58:23', 'Added Activity Activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('20', 'Administrator', '2017-01-24 19:00:07', 'Added Activity activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('21', 'Administrator', '2017-01-24 19:02:32', 'Added Activity Activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('22', 'Administrator', '2017-01-24 19:04:54', 'Added Activity activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('23', 'Administrator', '2017-01-24 19:08:40', 'Update Activity activity');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('24', 'Administrator', '2017-01-27 23:23:40', 'Added Activity teets');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('25', 'Administrator', '2017-01-27 23:24:14', 'Update Resident named Sample1, User1 Brgy1');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('26', 'Administrator', '2017-01-27 23:25:10', 'Update Resident named sda, as das');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('27', 'Administrator', '2017-01-30 10:45:13', 'Added Resident named 2, 2 2');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('28', 'Administrator', '2017-01-30 10:45:54', 'Added Resident named 2, 2 2');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('29', 'Administrator', '2017-02-06 08:58:23', 'Update Resident named sda, as das');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('30', 'Administrator', '2017-02-06 09:00:14', 'Update Resident named sda, as das');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('31', 'Administrator', '2017-02-06 09:03:57', 'Added Household Number 2');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('32', 'Administrator', '2017-02-06 09:04:25', 'Added Household Number 2');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('33', 'Administrator', '2024-03-23 14:36:04', 'Added Official named BERNARD S. SORIANO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('34', 'Administrator', '2024-03-23 14:44:26', 'Update Official named EDISON L. GINES JR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('35', 'Administrator', '2024-03-23 14:44:54', 'Update Official named BERNARD S. SORIANO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('36', 'Administrator', '2024-03-23 14:45:22', 'Update Official named FRANKLIN C. BOCALERE');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('37', 'Administrator', '2024-03-23 14:45:22', 'Update Official named FRANKLIN C. BOCALERE');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('38', 'Administrator', '2024-03-23 14:46:13', 'Update Official named PAUL MC JOANNER T. SOTTO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('39', 'Administrator', '2024-03-23 14:47:06', 'Update Official named RANDY N. PAGARAGAN');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('40', 'Administrator', '2024-03-23 14:47:49', 'Update Official named NORWEL P. TANAFRANCA');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('41', 'Administrator', '2024-03-23 14:48:58', 'Update Official named REMIGIO B. VINO JR.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('42', 'Administrator', '2024-03-23 14:49:39', 'Update Official named JACINTO C. BALBIDO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('43', 'Administrator', '2024-03-23 14:50:38', 'Added Official named VICTORINO B. SOTTO JR.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('44', 'Administrator', '2024-03-23 14:58:30', 'Update Staff with name of sad');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('45', 'Administrator', '2024-03-23 14:59:05', 'Update Staff with name of sad');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('46', 'Administrator', '2024-03-23 15:00:18', 'Added Staff with name of Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('47', 'Administrator', '2024-03-23 16:29:58', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('48', 'Administrator', '2024-03-23 16:30:26', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('49', 'Administrator', '2024-03-23 16:53:49', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('50', 'Administrator', '2024-03-23 16:54:28', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('51', 'Administrator', '2024-03-23 16:56:06', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('52', 'Administrator', '2024-03-23 16:57:19', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('53', 'Administrator', '2024-03-23 17:00:26', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('54', 'Administrator', '2024-03-23 17:03:53', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('55', 'Administrator', '2024-03-23 17:04:18', 'Added Resident named DARACAN, ROBELYN D');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('56', 'Administrator', '2024-03-23 17:04:43', 'Added Resident named Parungao, Josamine Rillon');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('57', 'Administrator', '2024-03-23 17:08:29', 'Added Resident named Parungao, Josamine Rillon');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('58', 'Administrator', '2024-03-23 17:08:53', 'Added Resident named melindo, jho parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('59', 'Administrator', '2024-03-23 17:08:57', 'Added Resident named melindo, jho parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('60', 'Administrator', '2024-03-23 17:09:16', 'Added Resident named melindo, jho parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('61', 'Administrator', '2024-03-23 17:27:06', 'Added Staff named Parungao, jho melindo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('62', 'Administrator', '2024-03-23 17:27:55', 'Added Staff named MELINDO, JHO PARUNGAO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('63', 'Administrator', '2024-03-23 17:32:01', 'Added Staff named Josamine, Rillon Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('64', 'Administrator', '2024-03-23 17:34:42', 'Added Staff named JHO, PARUNGAO MELINDO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('65', 'Administrator', '2024-03-23 17:42:20', 'Added Staff named Josamine, Rillon Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('66', 'Administrator', '2024-03-23 17:43:14', 'Added Staff named JHO, PARUNGAO MELINDO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('67', 'Administrator', '2024-03-23 17:57:58', 'Added Staff named ROBELYN, D DARACAN');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('68', 'Administrator', '2024-03-23 17:58:03', 'Added Staff named ROBELYN, D DARACAN');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('69', 'Administrator', '2024-03-23 17:58:30', 'Added Staff named ROBELYN, D DARACAN');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('70', 'Administrator', '2024-03-23 18:07:04', 'Added Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('71', 'Administrator', '2024-03-23 18:07:36', 'Added Staff named Robelyn , D.  Dacaran');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('72', 'Administrator', '2024-03-23 18:08:10', 'Added Staff named Ferdinand, V.  Sagat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('73', 'Administrator', '2024-03-23 18:08:34', 'Added Staff named Ferdinand, V.  Sagat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('74', 'Administrator', '2024-03-23 18:09:08', 'Added Staff named Paulino,  Balgos');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('75', 'Administrator', '2024-03-23 18:09:35', 'Added Staff named Dolores, B. Pascual');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('76', 'Administrator', '2024-03-23 18:09:59', 'Added Staff named Sosima, V. Colorado');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('77', 'Administrator', '2024-03-23 18:40:15', 'Added Staff named Josamine, Rillon Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('78', 'Administrator', '2024-03-23 18:46:48', 'Added Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('79', 'Administrator', '2024-03-23 18:48:23', 'Added Staff named Robelyn , D. Dacaran');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('80', 'Administrator', '2024-03-23 18:48:48', 'Added Staff named Ferdinand, V.  Sagat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('81', 'Administrator', '2024-03-23 18:49:23', 'Added Staff named Paulino,  Balgos');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('82', 'Administrator', '2024-03-23 18:49:51', 'Added Staff named Dolores, B. Pascual');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('83', 'Administrator', '2024-03-23 18:50:22', 'Added Staff named Sosima, V.  Colorado');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('84', 'Administrator', '2024-03-23 18:51:15', 'Added Staff named Rolly,  Jose');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('85', 'Administrator', '2024-03-23 18:51:45', 'Added Staff named Marlito,  Sagat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('86', 'Administrator', '2024-03-23 18:52:14', 'Added Staff named Nestor, P. Vegiga JR.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('87', 'Administrator', '2024-03-23 18:53:33', 'Added Staff named Berialdo, N. Agustin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('88', 'Administrator', '2024-03-23 18:54:16', 'Added Staff named Antonio, P. Novilla');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('89', 'Administrator', '2024-03-23 18:55:00', 'Added Staff named Jean,  Felipe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('90', 'Administrator', '2024-03-23 18:55:45', 'Added Staff named Rachelle, D. Albinto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('91', 'Administrator', '2024-03-23 18:56:27', 'Added Staff named Jayson , P. Vegiga');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('92', 'Administrator', '2024-03-23 19:30:23', 'Added Official named SORIANO, BERNARD S.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('93', 'Administrator', '2024-03-23 20:04:41', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('94', 'Administrator', '2024-03-23 20:04:53', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('95', 'Administrator', '2024-03-23 20:06:39', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('96', 'Administrator', '2024-03-23 20:06:48', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('97', 'Administrator', '2024-03-23 20:09:40', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('98', 'Administrator', '2024-03-23 20:09:50', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('99', 'Administrator', '2024-03-23 20:10:08', 'Update Staff named Robelyn , 9 Robelyn ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('100', 'Administrator', '2024-03-23 20:13:14', 'Update Staff named Antonio, 18 Antonio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('101', 'Administrator', '2024-03-23 20:18:50', 'Update Staff named Berialdo, 17 Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('102', 'Administrator', '2024-03-23 20:33:19', 'Update Staff named Jean, 19 Jean');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('103', 'Administrator', '2024-03-23 20:34:55', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('104', 'Administrator', '2024-03-23 20:35:33', 'Update Staff named Robelyn , 9 Robelyn ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('105', 'Administrator', '2024-03-23 20:35:56', 'Update Staff named Ferdinand, 10 Ferdinand');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('106', 'Administrator', '2024-03-23 20:37:26', 'Update Staff named Ferdinand, 10 Ferdinand');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('107', 'Administrator', '2024-03-23 20:37:37', 'Update Staff named Ferdinand, 10 Ferdinand');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('108', 'Administrator', '2024-03-23 20:37:49', 'Update Staff named Dolores, 12 Dolores');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('109', 'Administrator', '2024-03-23 20:39:32', 'Update Staff named Marlito, 15 Marlito');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('110', 'Administrator', '2024-03-23 20:39:43', 'Update Staff named Nestor, 16 Nestor');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('111', 'Administrator', '2024-03-24 09:13:44', 'Added Staff named Josamine, Rillon Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('112', 'Administrator', '2024-03-24 09:14:32', 'Added Staff named Josamine, Rillon Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('113', 'Administrator', '2024-03-24 09:15:03', 'Added Staff named JHO, PARUNGAO MELINDO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('114', 'Administrator', '2024-03-24 09:15:58', 'Update Staff named Josamine, 12 Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('115', 'Administrator', '2024-03-24 09:17:46', 'Update Staff named Josamine, 12 Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('116', 'Administrator', '2024-03-24 09:18:27', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('117', 'Administrator', '2024-03-24 09:20:39', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('118', 'Administrator', '2024-03-24 09:26:52', 'Update Staff named Josamine, 12 Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('119', 'Administrator', '2024-03-24 09:27:00', 'Update Staff named JHOCEL, 13 JHOCEL');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('120', 'Administrator', '2024-03-24 09:30:56', 'Update Staff named Divino, 8 Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('121', 'Administrator', '2024-03-24 09:33:12', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('122', 'Administrator', '2024-03-24 09:34:39', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('123', 'Administrator', '2024-03-24 09:46:23', 'Added Staff named Edison, L.  Gines JR.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('124', 'Administrator', '2024-03-24 09:47:58', 'Added Staff named Bernard, S. Soriano');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('125', 'Administrator', '2024-03-24 09:49:08', 'Added Staff named Franklin, C. Bocalere');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('126', 'Administrator', '2024-03-24 09:50:21', 'Added Staff named Paul Mc Joanner, T. Sotto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('127', 'Administrator', '2024-03-24 09:51:10', 'Added Staff named Randy, N. Pagaragan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('128', 'Administrator', '2024-03-24 09:51:10', 'Added Staff named Randy, N. Pagaragan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('129', 'Administrator', '2024-03-24 09:52:00', 'Added Staff named Norwel, P. Tanafranca');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('130', 'Administrator', '2024-03-24 09:53:04', 'Added Staff named Remegio, B. Vino SR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('131', 'Administrator', '2024-03-24 09:53:47', 'Added Staff named Jacinto, C. Balbido');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('132', 'Administrator', '2024-03-24 09:54:45', 'Added Staff named Victorino, B. Sotto JR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('133', 'Administrator', '2024-03-24 09:55:36', 'Added Staff named Ruel, J. De Lara');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('134', 'Administrator', '2024-03-24 09:55:45', 'Update Staff named Jacinto, 8 Jacinto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('135', 'Administrator', '2024-03-24 10:23:17', 'Added SK named Glaiza, A. Novilla');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('136', 'Administrator', '2024-03-24 10:23:54', 'Added SK named Lei Anne, E. Tablang');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('137', 'Administrator', '2024-03-24 10:24:35', 'Added SK named Fernando Philip, B. Verdad');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('138', 'Administrator', '2024-03-24 10:25:03', 'Added SK named Wains Jonaline, V. De Guzman');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('139', 'Administrator', '2024-03-24 10:25:39', 'Added SK named John Kenneth, T. Meradios');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('140', 'Administrator', '2024-03-24 10:26:04', 'Added SK named Ariel, E. Peralta');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('141', 'Administrator', '2024-03-24 10:26:38', 'Added SK named Andrei, T. Novilla');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('142', 'Administrator', '2024-03-24 10:27:08', 'Added SK named Jomar, N. Valdez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('143', 'Administrator', '2024-03-24 10:52:41', 'Added Purok Leader named Rocky,  Victorio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('144', 'Administrator', '2024-03-24 10:53:13', 'Added Purok Leader named Reynaldo, T. Jose');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('145', 'Administrator', '2024-03-24 10:53:38', 'Added Purok Leader named Gilberto, M. Sisor');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('146', 'Administrator', '2024-03-24 10:54:28', 'Added Purok Leader named Gregorio,  Flores');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('147', 'Administrator', '2024-03-24 10:54:55', 'Added Purok Leader named Alfredo,  Portin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('148', 'Administrator', '2024-03-24 10:55:19', 'Added Purok Leader named Alipio,  Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('149', 'Administrator', '2024-03-24 10:55:44', 'Added Purok Leader named Alipio,  Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('150', 'Administrator', '2024-03-24 10:56:50', 'Added Purok Leader named Rebecca,  Hila');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('151', 'Administrator', '2024-03-24 10:57:53', 'Update Purok Leader named Reynaldo, 2 Reynaldo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('152', 'Administrator', '2024-03-24 11:00:10', 'Added Purok Leader named Richard, L. Yasay');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('153', 'Administrator', '2024-03-24 11:09:20', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('154', 'Administrator', '2024-03-24 11:09:52', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('155', 'Administrator', '2024-03-24 11:10:30', 'Added Purok Leader named Rebecca,  Hila');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('156', 'Administrator', '2024-03-24 11:11:21', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('157', 'Administrator', '2024-03-25 13:22:42', 'Added Resident named Parungao, Josamine Rillon');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('158', 'Administrator', '2024-03-25 13:34:44', 'Added Clearance with clearance number of 12');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('159', 'Administrator', '2024-03-26 10:33:53', 'Update Staff named Edison, 1 Edison');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('160', 'Administrator', '2024-03-26 11:03:56', 'Update Activity Clean- up Drive');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('161', 'Administrator', '2024-03-26 11:04:52', 'Update Activity Fiesta');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('162', 'Administrator', '2024-03-26 11:08:14', 'Update Permit with business name of Kape Ko');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('163', 'Administrator', '2024-03-28 10:34:22', 'Added Barangay Police named Berialdo, N. Agustin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('164', 'Administrator', '2024-03-28 10:35:50', 'Added Barangay Police named Berialdo, N. Agustin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('165', 'Administrator', '2024-03-28 10:36:32', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('166', 'Administrator', '2024-03-28 10:37:36', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('167', 'Administrator', '2024-03-28 10:42:31', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('168', 'Administrator', '2024-03-28 10:44:03', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('169', 'Administrator', '2024-03-28 10:45:37', 'Added Barangay Police named Antonio, P. Novilla');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('170', 'Administrator', '2024-03-28 10:47:04', 'Added Barangay Police named Jean,  Felipe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('171', 'Administrator', '2024-03-28 10:48:03', 'Added Barangay Police named Jean,  Felipe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('172', 'Administrator', '2024-03-28 10:48:28', 'Added Barangay Police named Jean,  Felipe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('173', 'Administrator', '2024-03-28 10:51:53', 'Added Barangay Police named Rachelle, D. Albinto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('174', 'Administrator', '2024-03-28 10:52:29', 'Added Barangay Police named Jayson, P. Vegiga');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('175', 'Administrator', '2024-03-28 10:53:35', 'Added Barangay Police named Manny, A. Mannuel');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('176', 'Administrator', '2024-03-28 10:54:17', 'Added Barangay Police named Romulado,  Mariano');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('177', 'Administrator', '2024-03-28 10:54:41', 'Added Barangay Police named Genie,  Victorio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('178', 'Administrator', '2024-03-28 10:55:06', 'Added Barangay Police named Genie,  Romulado');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('179', 'Administrator', '2024-03-28 10:55:35', 'Added Barangay Police named Larry,  Bulalayao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('180', 'Administrator', '2024-03-28 10:56:22', 'Added Barangay Police named Mary Ann,  Espiritu');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('181', 'Administrator', '2024-03-28 10:57:47', 'Update Staff named Jayson,  Jayson');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('182', 'Administrator', '2024-03-28 10:58:23', 'Added Barangay Police named Jonathan, L. Antonio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('183', 'Administrator', '2024-03-28 10:58:52', 'Added Barangay Police named Nestor, B. Novilla');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('184', 'Administrator', '2024-03-28 10:59:21', 'Added Barangay Police named Lope , T. Trinidad');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('185', 'Administrator', '2024-03-28 10:59:53', 'Added Barangay Police named Michael, V. Cabaltera');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('186', 'Administrator', '2024-03-28 11:00:25', 'Added Barangay Police named Leoncio, S. Cabico');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('187', 'Administrator', '2024-03-28 11:03:44', 'Added Barangay Police named Reynaldo,  Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('188', 'Administrator', '2024-03-28 11:04:18', 'Added Barangay Police named Edwin,  Padua');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('189', 'Administrator', '2024-03-28 11:04:51', 'Added Barangay Police named Wilmino, D. Aquino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('190', 'Administrator', '2024-03-28 11:05:13', 'Added Barangay Police named Lito,  Portin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('191', 'Administrator', '2024-03-28 11:05:37', 'Added Barangay Police named Dominador,  Galope JR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('192', 'Administrator', '2024-03-28 11:06:11', 'Added Barangay Police named Angelito, R. Manusig');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('193', 'Administrator', '2024-03-28 11:06:47', 'Added Barangay Police named Romeo, A. Lopez JR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('194', 'Administrator', '2024-03-28 11:07:19', 'Added Barangay Police named Danilo,  Saludaga');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('195', 'Administrator', '2024-03-28 11:11:50', 'Added Barangay Police named Catalino,  Tolentino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('196', 'Administrator', '2024-03-28 11:13:23', 'Added Barangay Police named Osmando,  Espiritu');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('197', 'Administrator', '2024-03-28 11:13:48', 'Added Barangay Police named Jonathan,  Palara');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('198', 'Administrator', '2024-03-30 12:18:10', 'Update Staff named Bernard, 2 Bernard');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('199', 'Admin', '2024-03-30 19:39:41', 'Update Staff named Edison, 1 Edison');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('200', 'Administrator', '2024-04-02 10:08:47', 'Update Staff named Franklin, 3 Franklin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('201', 'Administrator', '2024-04-02 10:09:12', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('202', 'Administrator', '2024-04-09 18:46:17', 'Added SK named Marivic,  Diozon');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('203', 'Administrator', '2024-04-09 20:25:50', 'Added Permit with business name of Kape Ko');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('204', 'Administrator', '2024-04-09 20:48:16', 'Added Clearance with clearance number of 0224354');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('205', 'Administrator', '2024-04-10 19:30:21', 'Added Staff named Edwin, P. Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('206', 'Administrator', '2024-04-10 19:30:55', 'Added Staff named Jeorge, C. Bucaneg');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('207', 'Administrator', '2024-04-10 19:31:39', 'Added Staff named Joey, L. Ordonez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('208', 'Administrator', '2024-04-10 19:33:34', 'Added Staff named Rodrigo, P. Danao JR');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('209', 'Administrator', '2024-04-10 19:34:07', 'Added Staff named Engracia, G. Sumawang');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('210', 'Administrator', '2024-04-10 19:34:28', 'Added Staff named Jefrey,  Moreno');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('211', 'Administrator', '2024-04-10 19:35:04', 'Added Staff named John Bryan, D. Riparip');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('212', 'Administrator', '2024-04-10 19:35:35', 'Added Staff named Rommel,  Dalacat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('213', 'Administrator', '2024-04-10 19:37:07', 'Update Staff named Ma. Victoria, 1 Ma. Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('214', 'Administrator', '2024-04-10 19:37:52', 'Added Staff named Nelson, G. Vilacillo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('215', 'Administrator', '2024-04-10 19:38:24', 'Added Staff named Sherlita,  Caluducan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('216', 'Administrator', '2024-04-10 19:38:55', 'Added Staff named Rosemarie, O. Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('217', 'Administrator', '2024-04-10 20:11:04', 'Update Staff named Jeorge, 12 Jeorge');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('218', 'Administrator', '2024-04-10 20:11:10', 'Update Staff named Joey, 13 Joey');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('219', 'Administrator', '2024-04-10 20:11:15', 'Update Staff named Rodrigo, 14 Rodrigo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('220', 'Administrator', '2024-04-10 20:12:00', 'Update Staff named Engracia, 15 Engracia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('221', 'Administrator', '2024-04-10 20:12:08', 'Update Staff named Jefrey, 16 Jefrey');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('222', 'Administrator', '2024-04-10 20:12:16', 'Update Staff named John Bryan, 17 John Bryan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('223', 'Administrator', '2024-04-10 20:12:23', 'Update Staff named Rommel, 18 Rommel');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('224', 'Administrator', '2024-04-12 10:07:07', 'Added Resident named Parungao, Josamine R.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('225', 'Administrator', '2024-04-12 10:09:46', 'Added Resident named Josamine, R. Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('226', 'Captain', '2024-04-17 09:38:25', 'Update Staff named Ma. Victoria, 1 Ma. Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('227', 'Administrator', '2024-04-17 09:45:08', 'Update Staff named Edwin, 11 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('228', 'Administrator', '2024-04-17 11:05:22', 'Update Staff named Josamine,  Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('229', 'Administrator', '2024-04-17 11:06:24', 'Update Staff named Josamine,  Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('230', 'Administrator', '2024-04-17 11:06:33', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('231', 'Administrator', '2024-04-17 11:06:52', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('232', 'Administrator', '2024-04-17 11:07:46', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('233', 'Administrator', '2024-04-17 11:08:08', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('234', 'Administrator', '2024-04-17 11:09:36', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('235', 'Administrator', '2024-04-17 11:10:40', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('236', 'Administrator', '2024-04-17 11:10:50', 'Update Staff named Josamine, R. Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('237', 'Administrator', '2024-04-26 08:52:31', 'Added Resident named Juan,  de');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('238', 'Administrator', '2024-04-26 08:54:04', 'Added Resident named Juan,  Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('239', 'Administrator', '2024-04-26 08:55:03', 'Added Resident named Maria,  Santos');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('240', 'Administrator', '2024-04-26 08:55:59', 'Added Resident named Pedro,  Reyes');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('241', 'Administrator', '2024-04-26 09:20:35', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('242', 'Administrator', '2024-04-26 09:21:12', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('243', 'Administrator', '2024-04-26 09:22:26', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('244', 'Administrator', '2024-04-26 09:23:16', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('245', 'Administrator', '2024-04-26 09:25:12', 'Added Staff named Luzviminda,  Javier');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('246', 'Administrator', '2024-04-26 09:26:02', 'Added Staff named Luzviminda,  Javier');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('247', 'Administrator', '2024-04-26 09:31:01', 'Added Staff named Luzviminda,  Javier');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('248', 'Administrator', '2024-04-26 09:31:56', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('249', 'Administrator', '2024-04-26 09:32:32', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('250', 'Administrator', '2024-04-26 09:37:58', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('251', 'Administrator', '2024-04-26 09:38:21', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('252', 'Administrator', '2024-04-26 09:39:41', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('253', 'Administrator', '2024-04-26 09:41:44', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('254', 'Administrator', '2024-04-26 09:42:06', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('255', 'Administrator', '2024-04-26 09:42:27', 'Added Staff named Evelyn,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('256', 'Administrator', '2024-04-26 09:58:39', 'Added Resident named Juana,  Martinez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('257', 'Administrator', '2024-04-26 10:05:07', 'Added Resident named Josefa,  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('258', 'Administrator', '2024-04-26 10:07:18', 'Added Resident named Antonio,  Hernandez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('259', 'Administrator', '2024-04-26 10:08:23', 'Added Resident named Francisca,  Lopez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('260', 'Administrator', '2024-04-26 10:09:32', 'Added Resident named Manuel,  Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('261', 'Administrator', '2024-04-26 10:10:48', 'Added Resident named Rosario,  Torres');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('262', 'Administrator', '2024-04-26 10:10:58', 'Update Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('263', 'Administrator', '2024-04-26 10:33:42', 'Added Blotter Request by BERNARD S. SORIANO');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('264', 'Administrator', '2024-04-26 10:35:27', 'Added Blotter Request by Nina Sara Sayaman');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('265', 'Administrator', '2024-04-26 10:44:00', 'Added Staff named Edwin, P. Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('266', 'Administrator', '2024-04-26 10:44:49', 'Added Staff named Jeorge, C. Bucaneg');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('267', 'Administrator', '2024-04-26 10:45:28', 'Added Staff named Joey, L. Ordonez');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('268', 'Administrator', '2024-04-26 10:46:40', 'Added Staff named Rodrigo, P. Danao JR.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('269', 'Administrator', '2024-04-26 10:47:12', 'Added Staff named Engracia, G. Sumawang');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('270', 'Administrator', '2024-04-26 10:47:43', 'Added Staff named Jefrey,  Moreno');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('271', 'Administrator', '2024-04-26 10:48:30', 'Added Staff named John Bryan, D. Riparip');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('272', 'Administrator', '2024-04-26 10:49:10', 'Added Staff named Rommel,  Dalacat');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('273', 'Administrator', '2024-04-26 10:49:38', 'Added Staff named Nelson, G. Vilacillo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('274', 'Administrator', '2024-04-26 10:50:04', 'Added Staff named Sherlita,  Caluducan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('275', 'Administrator', '2024-04-26 10:50:32', 'Added Staff named Rosemarie, O.  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('276', 'Administrator', '2024-04-26 11:16:08', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('277', 'Administrator', '2024-04-27 09:40:32', 'Added Blotter Request by Marian Ny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('278', 'Administrator', '2024-05-09 20:23:12', 'Added Resident named Dane,  Sisor');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('279', 'admin', '2024-06-09 17:43:47', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('280', 'admin', '2024-06-09 17:49:20', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('281', 'admin', '2024-06-09 20:16:41', 'Update Staff named Rodrigo, 25 Rodrigo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('282', 'admin', '2024-06-09 20:43:47', 'Update Staff named Rodrigo, 25 Rodrigo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('283', 'admin', '2024-06-09 20:55:46', 'Update Staff named Ma. Victoria, 1 Ma. Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('284', 'admin', '2024-06-09 21:12:16', 'Update Staff named Ma. Victoria, 1 Ma. Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('285', 'admin', '2024-06-09 21:12:28', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('286', 'admin', '2024-06-09 21:13:57', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('287', 'admin', '2024-06-09 21:14:07', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('288', 'admin', '2024-06-09 21:14:12', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('289', 'admin', '2024-06-09 21:20:36', 'Added Purok Leader named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('290', 'admin', '2024-06-09 21:26:06', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('291', 'admin', '2024-06-09 21:27:28', 'Update Purok Leader named Reynaldo, 2 Reynaldo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('292', 'admin', '2024-06-09 21:28:09', 'Update Purok Leader named Reynaldo, 2 Reynaldo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('293', 'admin', '2024-06-09 21:29:51', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('294', 'admin', '2024-06-09 21:36:18', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('295', 'admin', '2024-06-09 21:39:27', 'Added Purok Leader named John, S. Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('296', 'admin', '2024-06-10 09:06:01', 'Update Staff named Nestor,  Nestor');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('297', 'admin', '2024-06-10 09:06:55', 'Update Purok Leader named Reynaldo, 2 Reynaldo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('298', 'admin', '2024-06-10 09:07:39', 'Update Purok Leader named Reynaldo, 2 Reynaldo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('299', 'admin', '2024-06-10 09:30:38', 'Added Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('300', 'admin', '2024-06-10 09:30:49', 'Added Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('301', 'admin', '2024-06-10 09:35:56', 'Added Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('302', 'admin', '2024-06-10 09:37:55', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('303', 'admin', '2024-06-10 09:42:08', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('304', 'admin', '2024-06-10 09:42:33', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('305', 'admin', '2024-06-10 09:42:53', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('306', 'admin', '2024-06-10 09:43:52', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('307', 'admin', '2024-06-10 09:44:03', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('308', 'admin', '2024-06-10 09:47:08', 'Update Staff named Juan,  Juan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('309', 'admin', '2024-06-10 10:19:09', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('310', 'admin', '2024-06-10 10:20:17', 'Added Barangay Tanod named John, S. Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('311', 'admin', '2024-06-10 10:21:14', 'Added Barangay Tanod named John, S. Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('312', 'admin', '2024-06-10 10:21:26', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('313', 'admin', '2024-06-10 10:23:20', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('314', 'admin', '2024-06-10 10:23:41', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('315', 'admin', '2024-06-10 10:24:26', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('316', 'admin', '2024-06-10 10:27:58', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('317', 'admin', '2024-06-10 10:28:50', 'Update Staff named John,  John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('318', 'admin', '2024-06-10 10:30:08', 'Update Staff named Manny,  Manny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('319', 'admin', '2024-06-10 10:32:17', 'Update Staff named Berialdo,  Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('320', 'admin', '2024-06-10 10:34:13', 'Update Staff named Berialdo, N. Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('321', 'admin', '2024-06-10 10:35:47', 'Update Staff named Antonio, P. Antonio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('322', 'admin', '2024-06-10 10:36:05', 'Update Staff named Antonio, P. Antonio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('323', 'admin', '2024-06-10 10:37:11', 'Update Staff named Antonio, P. Antonio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('324', 'admin', '2024-06-10 10:37:45', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('325', 'admin', '2024-06-10 10:40:18', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('326', 'admin', '2024-06-10 10:40:56', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('327', 'admin', '2024-06-10 10:41:15', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('328', 'admin', '2024-06-10 10:42:55', 'Update Staff named Divino,  Divino');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('329', 'admin', '2024-06-10 10:47:13', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('330', 'admin', '2024-06-10 10:47:54', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('331', 'admin', '2024-06-10 10:48:19', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('332', 'admin', '2024-06-10 10:48:49', 'Update Staff named Robelyn , D. Dacaran');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('333', 'admin', '2024-06-10 10:49:03', 'Update Staff named Jean,  Jean');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('334', 'admin', '2024-06-10 15:49:01', 'Added Staff named John, S. Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('335', 'admin', '2024-06-10 15:49:11', 'Update Staff named John, S. Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('336', 'admin', '2024-06-10 15:50:56', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('337', 'admin', '2024-06-10 16:25:06', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('338', 'admin', '2024-06-10 16:25:11', 'Update Staff named Jeorge, 23 Jeorge');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('339', 'admin', '2024-06-10 16:25:14', 'Update Staff named Joey, 24 Joey');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('340', 'admin', '2024-06-10 16:25:22', 'Update Staff named Rodrigo, 25 Rodrigo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('341', 'admin', '2024-06-10 16:25:50', 'Update Staff named Engracia, 26 Engracia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('342', 'admin', '2024-06-10 16:25:56', 'Update Staff named John Bryan, 28 John Bryan');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('343', 'admin', '2024-06-10 16:26:02', 'Update Staff named Nelson, 30 Nelson');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('344', 'admin', '2024-06-10 16:26:07', 'Update Staff named Rosemarie, 32 Rosemarie');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('345', 'admin', '2024-06-10 16:41:46', 'Added Staff named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('346', 'admin', '2024-06-10 17:47:52', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('347', 'admin', '2024-06-10 17:57:00', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('348', 'admin', '2024-06-10 18:33:05', 'Added SK named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('349', 'admin', '2024-06-10 18:34:53', 'Added SK named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('350', 'admin', '2024-06-10 18:35:10', 'Added Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('351', 'admin', '2024-06-10 18:35:52', 'Added Staff named ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('352', 'admin', '2024-06-11 08:20:27', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('353', 'admin', '2024-06-11 09:02:32', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('354', 'admin', '2024-06-11 09:02:38', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('355', 'admin', '2024-06-11 09:02:44', 'Update Purok Leader named Rocky, 1 Rocky');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('356', 'admin', '2024-06-11 09:35:43', 'Added Purok Leader named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('357', 'admin', '2024-06-11 09:36:21', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('358', 'admin', '2024-06-11 09:36:25', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('359', 'admin', '2024-06-11 09:36:54', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('360', 'admin', '2024-06-11 09:37:32', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('361', 'admin', '2024-06-11 09:41:40', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('362', 'admin', '2024-06-11 09:51:27', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('363', 'admin', '2024-06-11 10:24:01', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('364', 'admin', '2024-06-11 18:37:45', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('365', 'admin', '2024-06-11 18:37:45', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('366', 'admin', '2024-06-11 18:42:57', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('367', 'admin', '2024-06-11 18:47:23', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('368', 'admin', '2024-06-11 18:55:42', 'Update Staff named Divino,  Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('369', 'admin', '2024-06-11 18:56:19', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('370', 'admin', '2024-06-11 19:11:06', 'Added Barangay Tanod named Juan, D Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('371', 'admin', '2024-06-11 19:13:34', 'Update Staff named Divino, P Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('372', 'admin', '2024-06-11 19:14:56', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('373', 'admin', '2024-06-11 20:23:09', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('374', 'admin', '2024-06-11 20:23:30', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('375', 'admin', '2024-06-11 20:29:09', 'Update Staff named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('376', 'admin', '2024-06-11 21:12:04', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('377', 'admin', '2024-06-11 21:12:13', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('378', 'admin', '2024-06-11 21:12:20', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('379', 'admin', '2024-06-11 21:16:00', 'Update Staff named Jeorge, 23 Jeorge');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('380', 'admin', '2024-06-11 21:17:09', 'Update Staff named Joey, 24 Joey');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('381', 'admin', '2024-06-13 11:05:40', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('382', 'admin', '2024-06-13 11:08:08', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('383', 'admin', '2024-06-13 11:08:12', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('384', 'admin', '2024-06-13 11:10:23', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('385', 'admin', '2024-06-13 11:15:24', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('386', 'admin', '2024-06-13 11:15:30', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('387', 'admin', '2024-06-13 11:16:21', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('388', 'admin', '2024-06-13 11:19:45', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('389', 'admin', '2024-06-13 11:38:20', 'Added Resident named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('390', 'admin', '2024-06-13 11:38:25', 'Added Resident named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('391', 'admin', '2024-06-13 11:40:05', 'Added Resident named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('392', 'admin', '2024-06-13 11:40:42', 'Added Resident named Juana,  Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('393', 'admin', '2024-06-13 16:50:00', 'Added Resident named John, R Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('394', 'admin', '2024-06-19 09:21:02', 'Update Staff named Divino, P Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('395', 'admin', '2024-06-19 09:21:42', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('396', 'admin', '2024-06-19 09:22:22', 'Update Staff named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('397', 'admin', '2024-06-19 09:22:42', 'Update Staff named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('398', 'admin', '2024-06-19 09:23:09', 'Update Staff named Juana,  Juana');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('399', 'admin', '2024-06-19 09:26:36', 'Update Staff named Juana,  Juana');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('400', 'admin', '2024-06-19 09:33:46', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('401', 'admin', '2024-06-19 09:34:33', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('402', 'admin', '2024-06-19 09:35:20', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('403', 'admin', '2024-06-19 09:36:09', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('404', 'admin', '2024-06-19 09:36:22', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('405', 'admin', '2024-06-19 09:36:53', 'Added Resident named Marielle,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('406', 'admin', '2024-06-19 09:38:42', 'Update Staff named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('407', 'admin', '2024-06-19 09:41:24', 'Update Staff named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('408', 'admin', '2024-06-19 09:51:33', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('409', 'admin', '2024-06-19 09:53:39', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('410', 'admin', '2024-06-19 09:53:59', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('411', 'admin', '2024-06-19 09:54:10', 'Update Resident named Juana,  Juana');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('412', 'admin', '2024-06-19 09:56:17', 'Update Resident named Juana,  Juana');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('413', 'admin', '2024-06-19 09:56:23', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('414', 'admin', '2024-06-19 09:58:11', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('415', 'admin', '2024-06-19 09:58:16', 'Update Resident named Marielle, P Marielle');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('416', 'admin', '2024-06-19 09:58:51', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('417', 'admin', '2024-06-19 09:59:14', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('418', 'admin', '2024-06-19 09:59:19', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('419', 'admin', '2024-06-19 10:00:03', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('420', 'admin', '2024-06-19 10:02:40', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('421', 'admin', '2024-06-19 10:02:50', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('422', 'admin', '2024-06-19 10:06:06', 'Added Resident named Dee, D Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('423', 'admin', '2024-06-19 10:09:12', 'Added Resident named Juana, S Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('424', 'admin', '2024-06-19 10:12:43', 'Added Resident named Josamine, R Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('425', 'admin', '2024-06-19 10:26:37', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('426', 'admin', '2024-06-19 10:39:40', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('427', 'admin', '2024-06-19 11:11:58', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('428', 'admin', '2024-06-19 19:41:44', 'Update Resident named Josamine, P Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('429', 'admin', '2024-06-19 21:30:45', 'Added Resident named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('430', 'admin', '2024-06-19 21:32:43', 'Added Resident named Juana, D Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('431', 'admin', '2024-06-19 21:34:28', 'Added Resident named Marielle, P Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('432', 'admin', '2024-06-21 19:25:28', 'Added Resident named John,  Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('433', 'admin', '2024-06-21 19:29:03', 'Added Resident named Joseph,  Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('434', 'admin', '2024-06-21 19:50:41', 'Added Resident named Juana,  Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('435', 'admin', '2024-06-21 19:51:20', 'Added Resident named Pedro,  Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('436', 'admin', '2024-06-21 19:54:35', 'Added Resident named June,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('437', 'admin', '2024-06-21 20:25:44', 'Added Resident named Malou,  Parungao');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('438', 'admin', '2024-06-26 11:04:31', 'Update Resident named Josaminee, R Josaminee');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('439', 'admin', '2024-06-26 11:04:35', 'Update Resident named Josaminee, R Josaminee');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('440', 'admin', '2024-06-26 11:11:16', 'Update Resident named June,  June');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('441', 'admin', '2024-06-26 11:11:20', 'Update Resident named June,  June');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('442', 'admin', '2024-06-26 11:18:29', 'Update Resident named Josaminee, R Josaminee');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('443', 'admin', '2024-07-18 17:49:41', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('444', 'admin', '2024-07-18 17:50:07', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('445', 'admin', '2024-07-18 17:51:53', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('446', 'admin', '2024-07-18 17:52:09', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('447', 'admin', '2024-07-18 17:52:28', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('448', 'admin', '2024-07-18 17:53:28', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('449', 'admin', '2024-07-18 17:54:19', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('450', 'admin', '2024-07-18 17:54:30', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('451', 'admin', '2024-07-18 17:54:54', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('452', 'admin', '2024-07-18 17:55:12', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('453', 'admin', '2024-07-18 17:56:43', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('454', 'admin', '2024-07-18 17:57:03', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('455', 'admin', '2024-07-18 18:05:19', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('456', 'admin', '2024-07-18 18:07:04', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('457', 'admin', '2024-07-18 18:07:22', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('458', 'admin', '2024-07-18 18:09:35', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('459', 'admin', '2024-07-18 18:12:41', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('460', 'admin', '2024-07-18 18:13:27', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('461', 'admin', '2024-07-18 18:15:37', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('462', 'admin', '2024-07-18 18:15:57', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('463', 'admin', '2024-07-18 18:16:25', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('464', 'admin', '2024-07-18 18:16:28', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('465', 'admin', '2024-07-18 18:17:25', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('466', 'admin', '2024-07-18 18:17:29', 'Added Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('467', 'admin', '2024-07-18 18:18:45', 'Added Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('468', 'admin', '2024-07-18 18:18:48', 'Added Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('469', 'admin', '2024-07-18 18:27:38', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('470', 'admin', '2024-07-18 18:28:36', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('471', 'admin', '2024-07-18 18:28:39', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('472', 'admin', '2024-07-18 18:28:58', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('473', 'admin', '2024-07-18 18:30:15', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('474', 'admin', '2024-07-18 18:30:17', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('475', 'admin', '2024-07-18 18:32:19', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('476', 'admin', '2024-07-18 19:19:26', 'Update Blotter Request by Jane Ny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('477', 'admin', '2024-07-18 19:20:38', 'Update Blotter Request by Jane Ny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('478', 'admin', '2024-07-18 19:28:41', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('479', 'admin', '2024-07-18 19:28:45', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('480', 'admin', '2024-07-18 19:33:42', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('481', 'admin', '2024-07-18 19:33:46', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('482', 'admin', '2024-07-18 19:33:56', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('483', 'admin', '2024-07-18 19:34:38', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('484', 'admin', '2024-07-18 19:34:54', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('485', 'admin', '2024-07-18 19:35:09', 'Update Blotter Request by John Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('486', 'admin', '2024-07-19 10:02:45', 'Added Activity Clean Up Drive');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('487', 'admin', '2024-07-29 16:35:04', 'Update Blotter Request by Jane Ny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('488', 'admin', '2024-07-29 16:35:08', 'Update Blotter Request by Jane Ny');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('489', 'admin', '2024-07-29 16:37:48', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('490', 'admin', '2024-07-29 16:39:57', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('491', 'admin', '2024-07-29 16:40:27', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('492', 'admin', '2024-07-29 16:40:55', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('493', 'admin', '2024-07-29 16:41:23', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('494', 'admin', '2024-07-29 16:43:05', 'Added Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('495', 'admin', '2024-07-29 16:43:08', 'Added Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('496', 'admin', '2024-07-29 16:43:36', 'Added Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('497', 'admin', '2024-07-29 16:44:02', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('498', 'admin', '2024-07-29 16:44:06', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('499', 'admin', '2024-07-29 16:44:32', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('500', 'admin', '2024-07-29 16:44:46', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('501', 'admin', '2024-07-29 17:15:43', 'Added Activity Linis Barangay');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('502', 'admin', '2024-08-21 10:33:27', 'Update Resident named Josaminee, R Josaminee');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('503', 'admin', '2024-08-21 10:33:30', 'Update Resident named Josaminee, R Josaminee');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('504', 'admin', '2024-08-21 10:37:50', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('505', 'admin', '2024-08-21 10:37:55', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('506', 'admin', '2024-08-21 10:38:32', 'Update Resident named Joseph,  Joseph');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('507', 'admin', '2024-08-21 10:40:01', 'Update Staff named Divino, P Eugenio');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('508', 'admin', '2024-08-21 10:40:23', 'Update Staff named John, S Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('509', 'admin', '2024-08-21 10:43:54', 'Update Purok Leader named John, 12 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('510', 'admin', '2024-08-21 11:10:53', 'Added New Activity ,  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('511', 'admin', '2024-08-21 11:11:27', 'Added New Activity Clean - Up Drive, 2024-08-24 ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('512', 'admin', '2024-08-21 11:12:34', 'Added New Activity Clean - Up Drive, 2024-08-24 ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('513', 'admin', '2024-08-21 11:14:24', 'Added New Activity Clean - Up Drive, 2024-08-24');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('514', 'admin', '2024-08-21 11:24:54', 'Added New Activity Happy Fiesta, 2024-12-15');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('515', 'admin', '2024-09-06 15:22:46', 'Added Purok Leader named Pacita Rivera,   Diaz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('516', 'admin', '2024-09-06 15:24:19', 'Update Purok Leader named Pacita , 13 Pacita ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('517', 'admin', '2024-09-06 15:26:32', 'Added Purok Leader named Lolita , P Del Rosario');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('518', 'admin', '2024-09-06 15:31:55', 'Added Purok Leader named Jennifer , B Bugarin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('519', 'admin', '2024-09-06 15:33:33', 'Added Purok Leader named Mayla  , R Simeon');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('520', 'admin', '2024-09-06 15:37:55', 'Added Purok Leader named Evelyn , R  Garcia');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('521', 'admin', '2024-09-06 15:41:24', 'Added Purok Leader named Rhodora , P Alfonso');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('522', 'admin', '2024-09-06 18:40:47', 'Update Purok Leader named Pacita , 13 Pacita ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('523', 'admin', '2024-09-06 18:40:54', 'Update Purok Leader named Lolita , 14 Lolita ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('524', 'admin', '2024-09-06 18:41:02', 'Update Purok Leader named Jennifer , 15 Jennifer ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('525', 'admin', '2024-09-06 18:41:12', 'Update Purok Leader named Mayla  , 16 Mayla  ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('526', 'admin', '2024-09-06 18:41:20', 'Update Purok Leader named Evelyn , 17 Evelyn ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('527', 'admin', '2024-09-06 18:41:27', 'Update Purok Leader named Rhodora , 18 Rhodora ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('528', 'admin', '2024-09-06 18:46:54', 'Added SK named Ken,  Kuramoto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('529', 'admin', '2024-09-06 18:47:35', 'Update Staff named Maria Victoria, 1 Maria Victoria');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('530', 'admin', '2024-09-06 18:53:41', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('531', 'admin', '2024-09-06 18:53:45', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('532', 'admin', '2024-09-06 18:56:20', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('533', 'admin', '2024-09-06 18:56:23', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('534', 'admin', '2024-09-06 19:35:20', 'Added SK named Ken,  Kuramoto');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('535', 'admin', '2024-09-12 08:04:41', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('536', 'admin', '2024-09-12 08:04:44', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('537', 'admin', '2024-09-15 21:09:23', 'Update Resident named Josamine, R Josamine');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('538', 'admin', '2024-09-16 21:18:21', 'Added Resident named Marlon ,  Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('539', 'admin', '2024-09-16 21:20:02', 'Update Resident named Marlon ,  Marlon ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('540', 'admin', '2024-09-17 20:48:12', 'Update Resident named Marlon ,  Marlon ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('541', 'admin', '2024-09-18 19:15:12', 'Update Staff named Edwin, 22 Edwin');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('542', 'admin', '2024-09-18 19:53:15', 'Update Purok Leader named Lolita , 14 Lolita ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('543', 'admin', '2024-09-18 19:53:47', 'Update Purok Leader named Pacita , 13 Pacita ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('544', 'admin', '2024-09-18 20:18:15', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('545', 'admin', '2024-09-18 20:18:29', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('546', 'admin', '2024-09-18 20:19:32', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('547', 'admin', '2024-09-18 20:20:03', 'Update Staff named Berialdo, N Berialdo');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('548', 'admin', '2024-09-18 20:27:17', 'Added Barangay Tanod named John,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('549', 'admin', '2024-09-18 20:28:08', 'Update Staff named John,  John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('550', 'admin', '2024-09-18 20:31:41', 'Added Barangay Tanod named Juan,  Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('551', 'admin', '2024-09-18 20:51:43', 'Added Barangay Tanod named John,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('552', 'admin', '2024-09-18 20:52:29', 'Added Barangay Tanod named Josamine,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('553', 'admin', '2024-09-18 20:53:11', 'Added Staff named John,  Asdf');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('554', 'admin', '2024-09-18 20:53:42', 'Added Staff named Ad,  Sd');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('555', 'admin', '2024-09-18 20:59:12', 'Added Barangay Tanod named John,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('556', 'admin', '2024-09-18 21:00:29', 'Added Staff named Juana,  Dacuscus');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('557', 'admin', '2024-09-21 07:53:22', 'Added Staff named John,  Doe');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('558', 'admin', '2024-09-21 07:53:35', 'Update Staff named John, 38 John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('559', 'admin', '2024-10-05 11:27:33', 'Update Staff named John,  John');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('560', 'admin', '2024-10-05 11:28:03', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('561', 'admin', '2024-10-05 11:28:08', 'Update Blotter Request by Jane Dye');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('562', 'admin', '2024-10-08 11:15:41', 'Update Blotter Request by Juan Dela Cruz');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('563', 'admin', '2024-10-09 21:16:09', 'Added Blotter Request by test');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('564', 'admin', '2024-10-09 21:17:01', 'Added Blotter Request by test');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('565', 'admin', '2024-10-27 02:12:54', 'Updated clearance certificate ID 47');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('566', 'admin', '2024-10-29 02:54:47', 'Deleted Sangguniang Kabataan ID 7');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('567', 'john.doe', '2024-10-29 16:26:37', 'Created certificate for w');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('568', 'admin', '2024-10-31 10:42:21', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('569', 'admin', '2024-10-31 10:42:33', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('570', 'admin', '2024-10-31 10:42:41', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('571', 'admin', '2024-10-31 10:43:49', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('572', 'admin', '2024-10-31 10:43:55', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('573', 'admin', '2024-10-31 10:43:59', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('574', 'admin', '2024-10-31 10:45:21', 'Backup failed: Backup failed. Please check the database and permissions.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('575', 'admin', '2024-10-31 10:46:04', 'Backup failed: Backup failed: ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('576', 'admin', '2024-10-31 10:46:07', 'Backup failed: Backup failed: ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('577', 'admin', '2024-10-31 10:47:13', 'Backup failed: Backup failed: ');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('578', 'admin', '2024-10-31 10:47:51', 'Backup created');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('579', 'admin', '2024-10-31 10:51:16', 'Backup created');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('580', 'admin', '2024-10-31 10:51:50', 'Backup created');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('581', 'admin', '2024-10-31 10:52:08', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('582', 'admin', '2024-10-31 10:54:58', 'Backup created: backup_2024-10-31_10-54-58.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('583', 'admin', '2024-10-31 10:56:46', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('584', 'admin', '2024-10-31 10:57:00', 'Backup created: backup_2024-10-31_10-57-00.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('585', 'admin', '2024-10-31 11:00:24', 'Backup created: backup_2024-10-31_11-00-24.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('586', 'admin', '2024-10-31 11:00:39', 'Backup created: backup_2024-10-31_11-00-39.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('587', 'admin', '2024-10-31 11:00:39', 'Backup created: backup_2024-10-31_11-00-39.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('588', 'admin', '2024-10-31 11:00:45', 'Backup created: backup_2024-10-31_11-00-45.sql');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('589', 'admin', '2024-10-31 11:04:22', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('590', 'admin', '2024-10-31 11:04:22', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('591', 'admin', '2024-10-31 11:06:06', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('592', 'admin', '2024-10-31 11:07:24', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('593', 'admin', '2024-10-31 11:07:28', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('594', 'admin', '2024-10-31 11:10:32', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('595', 'admin', '2024-10-31 11:12:27', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('596', 'admin', '2024-10-31 11:13:08', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('597', 'admin', '2024-10-31 11:13:08', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('598', 'admin', '2024-10-31 11:13:13', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('599', 'admin', '2024-10-31 11:13:18', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('600', 'admin', '2024-10-31 11:13:31', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('601', 'admin', '2024-10-31 11:14:06', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('602', 'admin', '2024-10-31 11:14:26', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('603', 'admin', '2024-10-31 11:15:22', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('604', 'admin', '2024-10-31 11:17:16', 'Backup');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('605', 'admin', '2024-11-02 13:29:01', 'Failed to create resident: Field \'image\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('606', 'admin', '2024-11-02 13:29:11', 'Failed to create resident: Field \'image\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('607', 'admin', '2024-11-02 13:30:52', 'Created resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('608', 'admin', '2024-11-02 14:30:13', 'Failed to create resident: Field \'age\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('609', 'admin', '2024-11-02 14:30:43', 'Failed to create resident: Field \'age\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('610', 'admin', '2024-11-02 14:31:03', 'Failed to create resident: Field \'purok\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('611', 'admin', '2024-11-02 14:31:18', 'Failed to create resident: Field \'year_stayed\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('612', 'admin', '2024-11-02 14:31:37', 'Failed to create resident: Field \'voter\' is required.');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('613', 'admin', '2024-11-02 14:31:48', 'Created resident ID 12');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('614', 'admin', '2024-11-02 14:32:54', 'Created resident ID 13');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('615', 'admin', '2024-11-02 14:33:03', 'Retrieved resident ID 12');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('616', 'admin', '2024-11-02 14:33:16', 'Retrieved resident ID 12');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('617', 'admin', '2024-11-02 14:34:40', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('618', 'admin', '2024-11-02 14:34:40', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('619', 'admin', '2024-11-02 14:37:17', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('620', 'admin', '2024-11-02 14:42:50', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('621', 'admin', '2024-11-02 14:42:54', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('622', 'admin', '2024-11-02 14:43:06', 'Updated resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('623', 'admin', '2024-11-02 14:43:10', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('624', 'admin', '2024-11-02 14:48:18', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('625', 'admin', '2024-11-02 14:48:37', 'Updated resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('626', 'admin', '2024-11-02 14:49:00', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('627', 'admin', '2024-11-02 14:50:12', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('628', 'admin', '2024-11-02 14:50:17', 'Updated resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('629', 'admin', '2024-11-02 14:50:29', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('630', 'admin', '2024-11-02 14:50:34', 'Updated resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('631', 'admin', '2024-11-02 14:50:37', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('632', 'admin', '2024-11-02 14:51:22', 'Failed to update resident ID 11: Error updating Resident: Unknown column \'street\' in \'field list\'');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('633', 'admin', '2024-11-02 14:52:10', 'Retrieved resident ID 11');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('634', 'admin', '2024-11-05 09:16:37', 'Retrieved Official ID: 28');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('635', 'admin', '2024-11-05 09:17:20', 'Updated Official ID: 28');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('636', 'admin', '2024-11-05 11:22:37', 'Created certificate for resident ID 1');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('637', 'admin', '2024-11-05 11:25:22', 'Created certificate for Kopi Ko');
INSERT INTO tbllogs (id, user, logdate, action) VALUES ('638', 'admin', '2024-11-05 11:26:18', 'Created certificate for Kopi Ko');


CREATE TABLE `tblofficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `bday` varchar(100) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('22', 'Edwin', 'P', 'Parungao', '', 'Punong Barangay', '+639563461077', '1962-02-10', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('23', 'Jeorge', 'C', 'Bucaneg', '', 'Committee on Education', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('24', 'Joey', 'L', 'Ordonez', '', 'Committee on Peace and Order', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('25', 'Rodrigo', 'P', 'Danao', 'Jr.', 'Committee on Agriculture', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('26', 'Engracia', 'G', 'Sumawang', '', 'Committee on Health', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('27', 'Jefrey', '', 'Moreno', '', 'Committee on Intra.', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('28', 'John Bryan', 'D', 'Riparip', '', 'Committee on Finance', '', '', '462550805_1471394483573163_6031871990564504565_n.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('29', 'Rommel', '', 'Dalacat', '', 'Commitee on Transpo.', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('30', 'Nelson', 'G', 'Vilacillo', '', 'Barangay Treasurer', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('31', 'Sherlita', '', 'Caluducan', '', 'Barangay Secretary', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('32', 'Rosemarie', 'O', 'Garcia', '', 'Barangay Clerk', '', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('38', 'John', '', 'Doe', '', 'Secretary', '+639123456789', '', '1714094472579_default-avatar-icon-of-social-media-user-vector.jpg');
INSERT INTO tblofficial (id, fname, mname, lname, suffix, position, contact, bday, image) VALUES ('60', 'tests', 'test', 'test', 'tests', 'test', 'tests', '2001-01-01', 'boy5.png');


CREATE TABLE `tblpuroklead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `age` varchar(10) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `bday` varchar(100) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('13', 'Pacita ', 'R', ' Diaz', '', '', 'Narra', '+639123456754', '1969-12-12', '1725619247848_profile.jpg');
INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('14', 'Lolita ', 'P', 'Del Rosario', '', '67', 'Narra', '+639602307263', '1956-12-05', '1725619254550_profile.jpg');
INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('15', 'Jennifer ', 'B', 'Bugarin', '', '49', 'Narra', '0909 212 1057', '1975-03-10', '1725619262972_profile.jpg');
INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('16', 'Mayla  ', 'R', 'Simeon', '', '30', 'Narra', '0985 951 5738', '1994-03-05', '1725619272375_profile.jpg');
INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('17', 'Evelyn ', 'R', ' Garcia', '', '48', 'Narra', '0920 825 8833', '1975-11-01', '1725619280067_profile.jpg');
INSERT INTO tblpuroklead (id, fname, mname, lname, suffix, age, purok, contact, bday, image) VALUES ('18', 'Rhodora ', 'P', 'Alfonso', '', '45', 'Narra', '0908 911 1068', '1978-12-10', '1725619287233_profile.jpg');


CREATE TABLE `tblregistered_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `bday` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `houseNo` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_type` varchar(255) NOT NULL,
  `id_file` text NOT NULL,
  `account_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Non Resident, 1 - Resident',
  `image` text NOT NULL,
  `gender` int(11) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT 0,
  `isApproved` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('1', 'Josamine', 'R', 'Parungao', '', '2001-06-06', '23', '+639815382299', '915', 'Kamagong', 'brgy', 'municipality', 'province', 'josaminep@gmail.com', 'josaminep', '$2y$10$3403ejaNqG5n9ENNc1EKtu1TLu51JcSijiZrywG7hI.0IjnscgSFC', '', '', '1', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('2', 'John', '', 'Doe', '', '2000', '24', '+639451313213', '652', 'Mulawin', 'brgy', 'municipality', 'province', 'john.doe@example.com', 'john.doe', '$2y$10$C/fA1hWGfaD1XpXraGbnk.msxV/Gu9rTibdn.o4aY4SoRh5frmcAu', '', '', '1', '', '0', '0', '1');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('3', 'Sheryls', '', 'Caluducans', '', '1997-03-05', '27', '+631245354668', '123', 'Narra', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'admin@gmail.com', 'admin', '$2y$10$PYA08h6vQN/R1O9jcW.2oudDRF/lt95HeA/mBZ7O4HWAie9TLe1sq', '', '1730591551_non-pro-0678.jpg', '1', '1728913627_girl1.png', '0', '2', '1');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('4', 'Pedro', 'G', 'Garcia', '', '1990-12-25', '33', '+639123464654', '652', 'Extension', 'Mabini', 'Cabanatuan', 'Nueva ecija', 'pedrogarcia@gmail.com', 'pedro_g', '$2y$10$hWAY3X3vPIFiSa9sdGPemeBl3xKaFIw52hmIDlBWT.Lx3DJw5renG', '', '', '0', '', '0', '0', '1');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('5', 'John', '', 'Doe', '', '1995', '29', '+639123456778', '101', 'Mulawin', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'johndoe@mail.com', 'john_doe', '$2y$10$b0aybp3LwGeknbXJTBRMB.p4Mg8jClOkcUF/vqC4XJGtQwtmTY6Ci', '', '', '1', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('6', 'Juan', '', 'Cruz', '', '2000', '24', '+639618938549', '110', 'Mulawin', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'juancruz@mail.com', 'juan_cruz', '$2y$10$qF6UlkqlXwGNai8cp7oLdeFS2U6BCar6ZCMkS4uvqYve7YYwTuGMa', '', '', '1', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('7', 'Joey', 'D', 'Cruz', '', '2000', '23', '+639123245478', '1010', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'joeycruz@mail.com', 'joeycruz', '$2y$10$9bV2aFO0QAXRb2Gbkff67eXm0FPdF7KQyNJuGe4eOqLIk8F70wxaK', '', '', '0', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('8', 'Nina', '', 'Sayaman', '', '1995', '29', '+639815382299', '101', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'ninasayaman@gmail.com', 'nina17', '$2y$10$nD2/0h03LzfqFlhyUSAIfOBxit3kgix0X.IsQLp9ONgxUDxEQA4lO', 'Philhealth', '670338f5b2982.jpg', '0', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('9', 'Elena', '', 'Bataler', '', '1999', '24', '+639068629754', '152', 'Mulawin', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'elenabataler@gmail.com', 'elena', '$2y$10$tVKAS6MwmvRxSaQ10oezw.VmnfHVY1PqsRIIO67dxVq9YTCDqbWgu', 'National ID', '6703e55b736de.jpg', '0', '', '0', '0', '0');
INSERT INTO tblregistered_account (id, fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image, gender, isAdmin, isApproved) VALUES ('11', 'test', 'test', 'test', 'test', '2023-01-02', '1', '99999999999', 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', 'testTESTTEST@gmail.com', '', '$2y$10$GTqiPp6f0QDBDUQF6SQyM.um.LAgW/AIRX6h/1Lw4t6uagipZrc3e', '', 'wallpaperflare.com_wallpaper.jpg', '1', '', '0', '1', '0');


CREATE TABLE `tblresident` (
  `resident_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `bday` varchar(255) NOT NULL,
  `age` int(10) NOT NULL,
  `houseNo` int(50) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `year_stayed` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `head_fam` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `voter` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `relation` varchar(255) NOT NULL,
  `employment_status` varchar(244) NOT NULL,
  PRIMARY KEY (`resident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('1', 'Josamine', 'R', 'Parungao', '', '2001-06-06', '23', '186', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Single', '4', 'Bachelors Degree', 'Female', 'Cabanatuan City', 'Yes', 'Single', 'Yes', '1718763163836_images.jpg', '', '');
INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('3', 'Juana', 'D', 'Cruz', '', '1980-01-03', '44', '186', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Married', '3', 'Bachelors Degree', 'Female', 'Metro Manila', 'No', 'Employed', 'Yes', '1718803963757_41454bc1-f220-478c-a86d-b2e34fe37dcf-heartfelt-smiling-anime-girl-adorable-anime-pfp-illustrations-1.png', '', '');
INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('9', 'Marlons', '', 'Cruz', '', '1995-02-15', '29', '3', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Married', '4', 'Vocational', 'Male', 'Cabanatuan City', 'Yes', 'Single', 'Yes', '1726492701027_profile.jpg', '', '');
INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('11', 'test', 'test', 'test', 'test', '2021-01-02', '3', '432', 'Kamagong', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Single', '3', 'test', 'Male', 'Cabanatuan City', 'Yes', 'test', 'Yes', 'wallpaperflare.com_wallpaper (1).jpg', 'test', 'Employed');
INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('12', 'test', 'test', 'test', 'test', '2024-11-02', '0', '432', '', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Single', '', 'test', 'Male', 'Cabanatuan City', 'No', 'test', 'Yes', 'default.png', 'Son', '');
INSERT INTO tblresident (resident_id, fname, mname, lname, suffix, bday, age, houseNo, purok, brgy, municipality, province, civil_status, year_stayed, education, gender, birthplace, head_fam, occupation, voter, image, relation, employment_status) VALUES ('13', 'test', 'test', 'test', 'test', '2024-11-02', '0', '432', '', 'North Poblacion', 'Gabaldon', 'Nueva Ecija', 'Single', '', 'test', 'Male', 'Cabanatuan City', 'No', 'test', 'Yes', 'default.png', 'Son', '');


CREATE TABLE `tblstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tblstaff (id, name, username, password) VALUES ('1', 'sad', 'sad', 'sad');
INSERT INTO tblstaff (id, name, username, password) VALUES ('2', 'Josamine', 'mine', 'mine');


CREATE TABLE `tbltanod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `sched` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `houseNo` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `bday` varchar(15) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbltanod (id, fname, mname, lname, suffix, position, sched, contact, houseNo, purok, brgy, municipality, province, bday, image) VALUES ('4', 'John', 'test', 'Doe', 'test', 'Barangay Tanod', 'Tuesday', 's', '', 'Banaba', '', '', '', '2024-10-15', 'boy2.png');


CREATE TABLE `vehicle_cert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerId` int(255) NOT NULL,
  `sellerName` varchar(100) NOT NULL,
  `sellerAddress` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `amount_words` varchar(255) NOT NULL,
  `buyerName` varchar(100) NOT NULL,
  `buyerAddress` varchar(100) NOT NULL,
  `make` varchar(100) NOT NULL,
  `plateNum` varchar(100) NOT NULL,
  `engineNum` varchar(100) NOT NULL,
  `chasisNum` varchar(100) NOT NULL,
  `denomination` varchar(100) NOT NULL,
  `fuel` varchar(100) NOT NULL,
  `bodyType` varchar(100) NOT NULL,
  `crNo` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `witness` varchar(100) NOT NULL,
  `locationTran` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `cert_amount` varchar(100) NOT NULL,
  `note` varchar(100) NOT NULL,
  `date_of_pickup` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vehicle_cert (id, sellerId, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, make, plateNum, engineNum, chasisNum, denomination, fuel, bodyType, crNo, date, witness, locationTran, status, cert_amount, note, date_of_pickup) VALUES ('1', '1', 'Josamine Parungao', 'Mulawin, North Poblacion Gabaldon', '200', 'One Hundred Thousand Pesos', 'Honeylhei Santos', 'Malinao, Gabaldon', 'Japan', '062324', '12345', '6789', 'NA', 'Gasoline', 'Sedan', '123456', '2026-04-20', 'Nina', 'Gabaldon', 'Approved', '200', '', '0000-00-00');
INSERT INTO vehicle_cert (id, sellerId, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, make, plateNum, engineNum, chasisNum, denomination, fuel, bodyType, crNo, date, witness, locationTran, status, cert_amount, note, date_of_pickup) VALUES ('2', '1', 'sasa', 'sas', '323', '', 'adsds', 'dsd', 'dsads', '3232', '3213', '232', 'dsd', 'dsads', 'ddsd', '323', '2024-04-28', 'dsadsad', 'sdasdsd', 'New', '70', '', '0000-00-00');
INSERT INTO vehicle_cert (id, sellerId, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, make, plateNum, engineNum, chasisNum, denomination, fuel, bodyType, crNo, date, witness, locationTran, status, cert_amount, note, date_of_pickup) VALUES ('3', '0', 'Jean', 'North', '50000', 'Fifty Thousand', 'Juan', 'Macasandal', 'Japan', 'ABC123', '123456778', '890', 'Asd', 'Gasoline', 'Bulk', '123890', '2024-09-18', 'Weee', 'North', 'Done', '200', '', '0000-00-00');
INSERT INTO vehicle_cert (id, sellerId, sellerName, sellerAddress, amount, amount_words, buyerName, buyerAddress, make, plateNum, engineNum, chasisNum, denomination, fuel, bodyType, crNo, date, witness, locationTran, status, cert_amount, note, date_of_pickup) VALUES ('4', '0', 'test', 'test', '23', 'test', 'test', 'test', 'test', '', '', '', 'test', 'test', 'test', '', '2024-10-21', 'test', '', 'Walk-in', '', '', '0000-00-00');


