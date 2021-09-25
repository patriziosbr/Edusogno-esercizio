CREATE TABLE IF NOT EXISTS `eventi` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome_evento` varchar(255) NOT NULL,
  `desc_evento` text NOT NULL,
  `data_evento` date NOT NULL,
  `ora_evento` time NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome_utente` varchar(30) NOT NULL,
  `cognome_utente` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp
);