DROP DATABASE IF EXISTS cesi_stages;
CREATE DATABASE cesi_stages CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cesi_stages;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','PILOT','STUDENT') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pilots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  firstname VARCHAR(80) NOT NULL,
  lastname VARCHAR(80) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_pilots_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  firstname VARCHAR(80) NOT NULL,
  lastname VARCHAR(80) NOT NULL,
  pilot_id INT NULL,
  status_search ENUM('PAS_COMMENCE','EN_RECHERCHE','TROUVE') DEFAULT 'PAS_COMMENCE',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_students_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_students_pilot FOREIGN KEY (pilot_id) REFERENCES pilots(id) ON DELETE SET NULL
);

CREATE TABLE companies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  description TEXT NULL,
  email VARCHAR(190) NULL,
  phone VARCHAR(40) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  title VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_offers_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  offer_id INT NOT NULL,
  student_id INT NOT NULL,
  cover_letter_text TEXT NOT NULL,
  cv_path VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_offer_student (offer_id, student_id),
  CONSTRAINT fk_app_offer FOREIGN KEY (offer_id) REFERENCES offers(id) ON DELETE CASCADE,
  CONSTRAINT fk_app_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE wishlists (
  student_id INT NOT NULL,
  offer_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (student_id, offer_id),
  CONSTRAINT fk_wish_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  CONSTRAINT fk_wish_offer FOREIGN KEY (offer_id) REFERENCES offers(id) ON DELETE CASCADE
);

CREATE TABLE company_favorites (
  student_id INT NOT NULL,
  company_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (student_id, company_id),
  CONSTRAINT fk_cf_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  CONSTRAINT fk_cf_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE company_ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  student_id INT NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_company_student_rating (company_id, student_id),
  CONSTRAINT fk_cr_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
  CONSTRAINT fk_cr_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  CONSTRAINT chk_company_rating CHECK (rating BETWEEN 1 AND 5)
);

INSERT INTO users (id, email, password_hash, role) VALUES
(1, 'admin@cesi.fr', '$2y$12$pX2RT6SzKKaBCVo/1//FP.TGCCg8f15Dn4ZUr0vcMg3e9n/Q5BRaa', 'ADMIN'),
(2, 'thomas.leroy@cesi.fr', '$2y$12$626IoHX9VasXmwVsYVHZ5.54Uvkx2f9e/mW1iDcbqlmQAEB31Drem', 'PILOT'),
(3, 'julie.moreau@cesi.fr', '$2y$12$77m9H1N11jO0AKLsCiQ27uNFwomfLqkhpq2WTO1G14it438mHtGju', 'PILOT'),
(4, 'nicolas.bernier@cesi.fr', '$2y$12$X3zX47I0VrT.gwfmzmuLmui/2FUDsjWtKSw8O21FpMheX/f8JqR.y', 'PILOT'),
(5, 'emma.martin@cesi.fr', '$2y$12$xA7UUx8/szaRUpS6Aenj7u0jOyDtYT0MN6QFpRwbCUofCHuf7/8EW', 'STUDENT'),
(6, 'lucas.bernard@cesi.fr', '$2y$12$dI5nJ1uRCgYLt9a8zWI.9.0Vo3j1m9ufO75OJt309k8FmnqQR1cfC', 'STUDENT'),
(7, 'lea.dubois@cesi.fr', '$2y$12$a.abZhKMABj.7lXdHtrtlOx4aZJB3C0sVbNhFF8n1Aa3t7ok.Z1du', 'STUDENT'),
(8, 'hugo.thomas@cesi.fr', '$2y$12$B/zzI74aApRlBplQ58/dcO6e.tQJCoJSzgfwbRWKUnNKsVuUhKZ3C', 'STUDENT'),
(9, 'clara.robert@cesi.fr', '$2y$12$d7jWr8RQOsBHr00WSZL.3.02Kf3XoG0lLbf51tk8vxa8HsKXU2ewe', 'STUDENT'),
(10, 'enzo.richard@cesi.fr', '$2y$12$z2Ts8h.HmQE5vjL2iMuNZO5IJxP.2jUL4ydzNQSXplR3.fGZMj82q', 'STUDENT'),
(11, 'jade.petit@cesi.fr', '$2y$12$CaA8amTAd.xDtabhV12pauzyWnAVzZS7XKFpEQYgEp9y.EmmcpxbC', 'STUDENT'),
(12, 'gabriel.laurent@cesi.fr', '$2y$12$DRac/BJXsZtnAwTrv9UFzufXRfsxT1U.BPyPZ6mu4xR3HSBmgz2XO', 'STUDENT'),
(13, 'camille.simon@cesi.fr', '$2y$12$oMGYrS3OMS5jDVldl6tcRedHoan1uEtvKn2p0jheen1wEXNAGCrF6', 'STUDENT'),
(14, 'louis.michel@cesi.fr', '$2y$12$81Y23NtIDShO29J.ASYuH.Ep.rvwmJPIqGZ1cYTnIHqSe3aBhknAK', 'STUDENT'),
(15, 'zoe.garcia@cesi.fr', '$2y$12$nLLKVVy9SpokNI.n9INyROmokP.9CAk5V0cdagXb9KeTKJO0y77S2', 'STUDENT'),
(16, 'noah.david@cesi.fr', '$2y$12$0PMoK5Db74tWP013Y2cEuui8Y4bWDtqmvdhqjJqtcPSt.hcq/77bW', 'STUDENT'),
(17, 'alice.roux@cesi.fr', '$2y$12$dwtLWbAMvvJicbducamXZOC4FGRhWvdzJ11OPU3XGmZ09FBGCDiWy', 'STUDENT'),
(18, 'arthur.vincent@cesi.fr', '$2y$12$/nA3ELcqekzX1ngNPLiH6.njW.22etF1bksrRmipybhl7wDsiya3q', 'STUDENT'),
(19, 'lina.fournier@cesi.fr', '$2y$12$sjwAIMNtRK.BZjzOUeIEy.6peNHFvQzY2oC9v68bYSFzv/bGNgFqu', 'STUDENT'),
(20, 'mael.girard@cesi.fr', '$2y$12$DvMbAoTQwv9AlF.XsKxJRe6C2vnLhrcTofoi6mtxLgwm5m61262me', 'STUDENT'),
(21, 'sarah.andre@cesi.fr', '$2y$12$ykvDYK5rwKzs6KWyYW9qYexmOGn3x9eUObJMAmKYCiyY7ik4GFoQu', 'STUDENT'),
(22, 'tom.lefebvre@cesi.fr', '$2y$12$XUFpVf9mTVvZtwczPBSMKOqrgtSEg.EaT6MBMihVa9M4Kroa7zHCG', 'STUDENT'),
(23, 'louise.mercier@cesi.fr', '$2y$12$6McnlkVN6GU6ea7APxhyzefqwoth/qAYlL1tTSjeJPV2YTmBe6F72', 'STUDENT'),
(24, 'nathan.blanc@cesi.fr', '$2y$12$msyYgbf.o0WdO8poOxCLe.7ewpM0PoxCzGD6Nk8ReubCyunpT/mKu', 'STUDENT');

INSERT INTO pilots (id, user_id, firstname, lastname) VALUES
(1, 2, 'Thomas', 'Leroy'),
(2, 3, 'Julie', 'Moreau'),
(3, 4, 'Nicolas', 'Bernier');

INSERT INTO students (id, user_id, firstname, lastname, pilot_id, status_search) VALUES
(1, 5, 'Emma', 'Martin', 1, 'EN_RECHERCHE'),
(2, 6, 'Lucas', 'Bernard', 1, 'EN_RECHERCHE'),
(3, 7, 'Léa', 'Dubois', 1, 'TROUVE'),
(4, 8, 'Hugo', 'Thomas', 1, 'PAS_COMMENCE'),
(5, 9, 'Clara', 'Robert', 1, 'EN_RECHERCHE'),
(6, 10, 'Enzo', 'Richard', 1, 'TROUVE'),
(7, 11, 'Jade', 'Petit', 1, 'EN_RECHERCHE'),
(8, 12, 'Gabriel', 'Laurent', 2, 'PAS_COMMENCE'),
(9, 13, 'Camille', 'Simon', 2, 'EN_RECHERCHE'),
(10, 14, 'Louis', 'Michel', 2, 'TROUVE'),
(11, 15, 'Zoé', 'Garcia', 2, 'EN_RECHERCHE'),
(12, 16, 'Noah', 'David', 2, 'PAS_COMMENCE'),
(13, 17, 'Alice', 'Roux', 2, 'EN_RECHERCHE'),
(14, 18, 'Arthur', 'Vincent', 2, 'TROUVE'),
(15, 19, 'Lina', 'Fournier', 3, 'PAS_COMMENCE'),
(16, 20, 'Maël', 'Girard', 3, 'EN_RECHERCHE'),
(17, 21, 'Sarah', 'Andre', 3, 'EN_RECHERCHE'),
(18, 22, 'Tom', 'Lefebvre', 3, 'TROUVE'),
(19, 23, 'Louise', 'Mercier', 3, 'PAS_COMMENCE'),
(20, 24, 'Nathan', 'Blanc', 3, 'EN_RECHERCHE');

INSERT INTO companies (id, name, description, email, phone, is_active) VALUES
(1, 'Capgemini', 'Entreprise de services numériques.', 'contact@capgemini.fr', '0102030401', 1),
(2, 'Thales', 'Technologies avancées et systèmes critiques.', 'contact@thales.fr', '0102030402', 1),
(3, 'Sopra Steria', 'Conseil et transformation digitale.', 'contact@soprasteria.fr', '0102030403', 1),
(4, 'Orange', 'Télécoms et services numériques.', 'contact@orange.fr', '0102030404', 1),
(5, 'Atos', 'Services informatiques et cloud.', 'contact@atos.fr', '0102030405', 1),
(6, 'Dassault Systèmes', 'Solutions logicielles et 3D.', 'contact@3ds.fr', '0102030406', 1),
(7, 'STMicroelectronics', 'Semi-conducteurs et électronique.', 'contact@st.com', '0102030407', 1),
(8, 'Airbus CyberSecurity', 'Cybersécurité et infrastructures.', 'contact@airbus-cyber.fr', '0102030408', 1),
(9, 'Alten', 'Ingénierie et conseil IT.', 'contact@alten.fr', '0102030409', 1),
(10, 'Apside', 'Informatique, data et cybersécurité.', 'contact@apside.fr', '0102030410', 1),
(11, 'Extia', 'Conseil en ingénierie IT.', 'contact@extia.fr', '0102030411', 1),
(12, 'SII', 'Services numériques et innovation.', 'contact@sii.fr', '0102030412', 1),
(13, 'Open', 'Transformation digitale et applicative.', 'contact@open.fr', '0102030413', 1),
(14, 'SQLI', 'Agence digitale et technique.', 'contact@sqli.fr', '0102030414', 1),
(15, 'Infotel', 'Développement logiciel et systèmes.', 'contact@infotel.fr', '0102030415', 1),
(16, 'Astek', 'Ingénierie et développement logiciel.', 'contact@astek.fr', '0102030416', 1),
(17, 'CS Group', 'Systèmes critiques et défense.', 'contact@csgroup.fr', '0102030417', 1),
(18, 'Inetum', 'Services digitaux et modernisation SI.', 'contact@inetum.fr', '0102030418', 1),
(19, 'Hardis Group', 'Logistique, cloud et data.', 'contact@hardis-group.fr', '0102030419', 1),
(20, 'Proelan', 'Développement web et mobile.', 'contact@proelan.fr', '0102030420', 1),
(21, 'Smile', 'Open source et digital.', 'contact@smile.fr', '0102030421', 1),
(22, 'Zenika', 'Expertise web, cloud et agile.', 'contact@zenika.fr', '0102030422', 1),
(23, 'Devoteam', 'Cloud, cybersécurité et modern workplace.', 'contact@devoteam.fr', '0102030423', 1),
(24, 'Accenture', 'Conseil, technologie et opérations.', 'contact@accenture.fr', '0102030424', 1),
(25, 'IBM France', 'Cloud, IA et solutions d’entreprise.', 'contact@ibm.fr', '0102030425', 1),
(26, 'Sogeti', 'Testing, développement et infra.', 'contact@sogeti.fr', '0102030426', 1),
(27, 'CGI', 'Conseil et services numériques.', 'contact@cgi.fr', '0102030427', 1),
(28, 'Worldline', 'Paiement et services transactionnels.', 'contact@worldline.fr', '0102030428', 1),
(29, 'OVHcloud', 'Cloud souverain et hébergement.', 'contact@ovhcloud.fr', '0102030429', 1),
(30, 'Scalian', 'Ingénierie, data et systèmes.', 'contact@scalian.fr', '0102030430', 1),
(31, 'Gfi', 'Services numériques et solutions métiers.', 'contact@gfi.fr', '0102030431', 1),
(32, 'Ippon', 'Dev, data et cloud.', 'contact@ippon.fr', '0102030432', 1),
(33, 'Klanik', 'Conseil IT et innovation.', 'contact@klanik.fr', '0102030433', 1),
(34, 'Onepoint', 'Transformation numérique.', 'contact@onepoint.fr', '0102030434', 1),
(35, 'Micropole', 'Data et pilotage de la performance.', 'contact@micropole.fr', '0102030435', 1),
(36, 'Talan', 'Conseil, data et innovation.', 'contact@talan.fr', '0102030436', 1),
(37, 'Eviden', 'Cloud, sécurité et IA.', 'contact@eviden.fr', '0102030437', 1),
(38, 'Akka', 'Ingénierie et systèmes embarqués.', 'contact@akka.fr', '0102030438', 1),
(39, 'Neurones', 'Infogérance et cybersécurité.', 'contact@neurones.fr', '0102030439', 1),
(40, 'Synchrone', 'Cybersécurité et infrastructures.', 'contact@synchrone.fr', '0102030440', 1),
(41, 'Wavestone', 'Conseil IT et cybersécurité.', 'contact@wavestone.fr', '0102030441', 1),
(42, 'Keyrus', 'Data intelligence et digital.', 'contact@keyrus.fr', '0102030442', 1),
(43, 'Niji', 'Digital design et développement.', 'contact@niji.fr', '0102030443', 1),
(44, 'Lunatech', 'Développement web et architecture.', 'contact@lunatech.fr', '0102030444', 1),
(45, 'Ekino', 'Digital, cloud et innovation.', 'contact@ekino.fr', '0102030445', 1),
(46, 'Back Market Tech', 'Plateforme e-commerce et services web.', 'contact@backmarket.fr', '0102030446', 1),
(47, 'Contentsquare', 'Analytics produit et data.', 'contact@contentsquare.fr', '0102030447', 1),
(48, 'Doctolib', 'Plateforme web et santé numérique.', 'contact@doctolib.fr', '0102030448', 1),
(49, 'Ledger', 'Sécurité, embarqué et blockchain.', 'contact@ledger.fr', '0102030449', 1),
(50, 'Qonto', 'Fintech et applications web.', 'contact@qonto.fr', '0102030450', 1);

INSERT INTO offers (id, company_id, title, description, is_active) VALUES
(1, 1, 'Stage développeur PHP', 'Développement backend PHP et MySQL.', 1),
(2, 2, 'Stage cybersécurité', 'Audit de sécurité et analyse de vulnérabilités.', 1),
(3, 3, 'Stage data analyst', 'Analyse de données et tableaux de bord.', 1),
(4, 4, 'Stage réseau', 'Configuration et supervision d’infrastructures réseau.', 1),
(5, 5, 'Stage développeur web', 'Développement d’applications web internes.', 1),
(6, 6, 'Stage QA logiciel', 'Tests fonctionnels et automatisation.', 1),
(7, 7, 'Stage électronique embarquée', 'Validation de cartes et capteurs.', 1),
(8, 8, 'Stage SOC analyst', 'Surveillance d’événements de sécurité.', 1),
(9, 9, 'Stage support IT', 'Support utilisateurs et maintenance.', 1),
(10, 10, 'Stage développeur JavaScript', 'Interfaces web et APIs.', 1),
(11, 11, 'Stage cloud junior', 'Déploiements et conteneurisation.', 1),
(12, 12, 'Stage BI', 'Reporting et data visualisation.', 1),
(13, 13, 'Stage full-stack', 'Développement front et back.', 1),
(14, 14, 'Stage intégrateur web', 'Intégration HTML/CSS/JS.', 1),
(15, 15, 'Stage développeur C#', 'Outils métiers et applications internes.', 1),
(16, 16, 'Stage DevOps', 'CI/CD et automatisation.', 1),
(17, 17, 'Stage systèmes Linux', 'Administration et scripts.', 1),
(18, 18, 'Stage analyste fonctionnel', 'Recueil de besoins et recette.', 1),
(19, 19, 'Stage data engineering', 'Pipelines et traitement de données.', 1),
(20, 20, 'Stage mobile', 'Application Flutter ou Android.', 1),
(21, 21, 'Stage open source', 'Contributions et maintenance web.', 1),
(22, 22, 'Stage architecture logicielle', 'Refactoring et bonnes pratiques.', 1),
(23, 23, 'Stage cybersécurité cloud', 'IAM et bonnes pratiques cloud.', 1),
(24, 24, 'Stage consultant junior IT', 'Assistance projets SI.', 1),
(25, 25, 'Stage IA générative', 'Expérimentation d’outils IA.', 1),
(26, 26, 'Stage test automation', 'Scénarios et automatisation QA.', 1),
(27, 27, 'Stage développeur .NET', 'Applications métier et APIs.', 1),
(28, 28, 'Stage backend Java', 'Services transactionnels.', 1),
(29, 29, 'Stage cloud ops', 'Hébergement et supervision cloud.', 1),
(30, 30, 'Stage scripting Python', 'Outils internes et automatisation.', 1),
(31, 31, 'Stage support applicatif', 'Suivi incidents et correctifs.', 1),
(32, 32, 'Stage data science', 'Exploration et modèles simples.', 1),
(33, 33, 'Stage développeur React', 'Interfaces SPA.', 1),
(34, 34, 'Stage UX technique', 'Maquettes et intégration.', 1),
(35, 35, 'Stage analyste data', 'Segmentation et tableaux de bord.', 1),
(36, 36, 'Stage consultant data', 'Aide à l’analyse métier.', 1),
(37, 37, 'Stage sécurité défensive', 'Hardening et contrôle d’accès.', 1),
(38, 38, 'Stage embarqué C', 'Firmware et validation.', 1),
(39, 39, 'Stage administrateur systèmes', 'Windows/Linux et virtualisation.', 1),
(40, 40, 'Stage ingénieur réseau', 'Monitoring et configuration.', 1),
(41, 41, 'Stage gouvernance cybersécurité', 'Politiques et sensibilisation.', 1),
(42, 42, 'Stage data viz', 'KPI et dashboarding.', 1),
(43, 43, 'Stage développeur frontend', 'Interfaces responsives.', 1),
(44, 44, 'Stage développeur backend', 'Architecture API et services.', 1),
(45, 45, 'Stage innovation web', 'Prototype et POC.', 1),
(46, 46, 'Stage e-commerce tech', 'Catalogue et backoffice.', 1),
(47, 47, 'Stage product analytics', 'Tracking et mesures produit.', 1),
(48, 48, 'Stage plateforme web', 'Outils internes et APIs.', 1),
(49, 49, 'Stage sécurité produit', 'Analyse sécurité hardware/web.', 1),
(50, 50, 'Stage fintech backend', 'Fonctionnalités métier et APIs.', 1);

INSERT INTO applications (offer_id, student_id, cover_letter_text, cv_path) VALUES
(1, 1, 'Je souhaite rejoindre votre équipe backend pour progresser sur PHP et SQL.', NULL),
(2, 2, 'La cybersécurité m’intéresse particulièrement et je souhaite développer mes compétences.', NULL),
(3, 3, 'Je suis motivée par l’analyse de données et la création de dashboards.', NULL),
(4, 4, 'Je souhaite travailler sur les réseaux et la supervision.', NULL),
(5, 5, 'Je veux approfondir le développement web en entreprise.', NULL),
(6, 6, 'Je souhaite découvrir la QA et l’automatisation des tests.', NULL),
(7, 7, 'Je suis intéressée par les systèmes embarqués et l’électronique.', NULL),
(8, 8, 'Le domaine SOC et la surveillance sécurité me motivent.', NULL),
(9, 9, 'Je souhaite renforcer mes compétences de support IT.', NULL),
(10, 10, 'Je veux développer mes compétences en JavaScript et API.', NULL);

INSERT INTO wishlists (student_id, offer_id) VALUES
(1, 11),
(2, 12),
(3, 13),
(4, 14),
(5, 15),
(6, 16),
(7, 17),
(8, 18),
(9, 19),
(10, 20);

INSERT INTO company_favorites (student_id, company_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

INSERT INTO company_ratings (company_id, student_id, rating, comment) VALUES
(1, 1, 5, 'Très bonne entreprise, cadre stimulant.'),
(2, 2, 4, 'Missions intéressantes et bon accompagnement.'),
(3, 3, 5, 'Très bon environnement de travail.'),
(4, 4, 3, 'Stage correct avec missions variées.'),
(5, 5, 4, 'Bonne ambiance et outils modernes.'),
(6, 6, 5, 'Excellente expérience technique.'),
(7, 7, 4, 'Équipe sérieuse et bienveillante.'),
(8, 8, 5, 'Très formateur en cybersécurité.'),
(9, 9, 3, 'Bon stage pour découvrir le support IT.'),
(10, 10, 4, 'Projet intéressant et bonne encadrement.');