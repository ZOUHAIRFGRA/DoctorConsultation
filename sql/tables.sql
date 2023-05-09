CREATE DATABASE IF NOT EXISTS `doctorBD` ;
USE `doctorBD` ; 





CREATE TABLE `consultation` (
  `specialiteID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





CREATE TABLE `patient` (
  `patientID` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `num_tel` varchar(10) NOT NULL,
  `specialite_boolean` tinyint(1) NOT NULL,
  `rdv` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;








CREATE TABLE `specialite` (
  `specialiteID` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;








CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;








ALTER TABLE `consultation`
  ADD KEY `specialiteID` (`specialiteID`),
  ADD KEY `consultation_ibfk_2` (`patientID`);


ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientID`);


ALTER TABLE `specialite`
  ADD PRIMARY KEY (`specialiteID`);


ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);



ALTER TABLE `patient`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `specialite`
  MODIFY `specialiteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;


ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`specialiteID`) REFERENCES `specialite` (`specialiteID`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;


INSERT INTO `specialite` (`specialiteID`, `nom`) VALUES
(1,'ORL'),
(2,'Chirurgien-dentiste'),
(3,'Médecin généraliste'),
(4,'Pédiatre'),
(5,'Gynécologue médical et obstétrique'),
(6,'Ophtalmologue'),
(7,'Dermatologue et vénérologue');

INSERT INTO `user` (`id`, `login`, `pass`) VALUES
(1,'admin', 'admin'),
(2,'admin', 'admin');




