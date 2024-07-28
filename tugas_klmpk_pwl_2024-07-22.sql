/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 8.0.30 : Database - tugas_klmpk_pwl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tugas_klmpk_pwl` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `tugas_klmpk_pwl`;

/*Table structure for table `agenda` */

DROP TABLE IF EXISTS `agenda`;

CREATE TABLE `agenda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `agenda` */

insert  into `agenda`(`id`,`gambar`,`title`,`description`,`created_at`) values 
(2,'agenda_66a4cc2c11e0e5.82013199.jfif','Lokakarya Penulisan Kreatif','Acara ini dirancang untuk membantu penulis pemula dan berpengalaman mengembangkan keterampilan penulisan kreatif mereka. Peserta akan belajar tentang teknik penulisan, pengembangan karakter, dan pembuatan plot melalui sesi interaktif dan latihan menulis.','2024-07-26 08:14:34'),
(4,'agenda_66a4cbf59dc789.81616363.jfif','Diskusi Buku Bulanan','Diskusi buku bulanan ini mengundang pembaca untuk berkumpul dan membahas buku pilihan yang telah dibaca sebelumnya. Agenda ini bertujuan untuk mempromosikan kebiasaan membaca dan memperkaya pengetahuan serta perspektif peserta melalui diskusi yang mendalam.','2024-07-27 17:21:43'),
(5,'agenda_66a4cbc94d5d70.11217084.jfif','Cerita Anak dan Seni Kreatif','Acara ini ditujukan untuk anak-anak usia 4-10 tahun. Selama sesi ini, anak-anak akan mendengarkan cerita menarik yang dibacakan oleh pustakawan, diikuti dengan aktivitas seni kreatif seperti menggambar dan membuat kerajinan yang berkaitan dengan cerita yang dibacakan.','2024-07-27 17:22:20'),
(6,'agenda_66a4cb53840430.21568314.jfif','Seminar Teknologi Informasi','Seminar ini membahas perkembangan terbaru dalam teknologi informasi dan aplikasi praktisnya. Pembicara tamu dari industri IT akan berbagi pengetahuan tentang topik-topik seperti keamanan siber, kecerdasan buatan, dan pengembangan perangkat lunak.','2024-07-27 17:22:44'),
(7,'agenda_66a4cb0a93a951.32542062.jfif','Pameran Koleksi Langka','Pameran ini menampilkan koleksi buku langka dan manuskrip yang dimiliki oleh perpustakaan. Pengunjung dapat melihat dan mempelajari sejarah serta nilai dari koleksi tersebut. Acara ini juga mencakup sesi tanya jawab dengan kurator perpustakaan.','2024-07-27 17:23:19'),
(8,'agenda_66a4cc85659e64.92735171.jfif','Pelatihan Literasi Digital','Pelatihan ini bertujuan untuk meningkatkan keterampilan literasi digital masyarakat. Peserta akan diajarkan cara menggunakan perangkat digital dan internet secara efektif dan aman. Topik yang dibahas meliputi penggunaan aplikasi produktivitas, pencarian informasi yang valid, serta tips menghindari penipuan online dan menjaga privasi.','2024-07-27 17:30:55');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `penerbit_id` int DEFAULT NULL,
  `genre_id` int DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `content` text,
  `gambar` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `penerbit_id` (`penerbit_id`),
  KEY `genre_id` (`genre_id`),
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


/*Data for the table `buku` */

insert  into `buku`(`id`,`judul`,`penerbit_id`,`genre_id`,`tahun_terbit`,`content`,`gambar`,`created_at`) values 
(8,'Laskar Pelangi',4,3,2005,'Buku ini menceritakan tentang perjuangan sekelompok anak dari daerah Belitung dalam meraih pendidikan meskipun menghadapi berbagai keterbatasan dan tantangan. Kisah ini terfokus pada persahabatan, semangat belajar, dan optimisme yang ditunjukkan oleh anak-anak di sekolah Muhammadiyah yang hampir tutup.\r\n','book_66a4c21caff473.52772506.jpg','2024-07-25 18:52:45'),
(10,'The Power of Habit',4,4,2014,'Buku ini menjelaskan bagaimana kebiasaan terbentuk dan bagaimana mengubahnya untuk mencapai kesuksesan dalam berbagai aspek kehidupan. Penulis, Charles Duhigg, menggunakan penelitian ilmiah dan studi kasus untuk menunjukkan kekuatan kebiasaan dalam kehidupan pribadi, bisnis, dan masyarakat.','book_66a4c3dec81eb2.07589038.PNG','2024-07-25 18:52:45'),
(11,'Negeri 5 Menara',5,3,2009,'Novel ini menceritakan perjalanan hidup seorang anak bernama Alif Fikri dari sebuah desa di Sumatra Barat yang melanjutkan pendidikan ke sebuah pesantren di Jawa. Di sana, ia bertemu dengan teman-teman dari berbagai daerah yang memiliki mimpi besar, serta belajar nilai-nilai kehidupan dan persahabatan.','book_66a4c47dc21bc5.92599880.jpg','2024-07-25 18:52:45'),
(12,'Matematika untuk SMA/MA Kelas XII',6,2,2020,'Buku ini merupakan buku teks pelajaran yang dirancang untuk membantu siswa kelas XII SMA/MA dalam memahami konsep-konsep matematika yang lebih lanjut. Buku ini mencakup berbagai topik seperti kalkulus, aljabar, geometri, dan statistik, dengan latihan dan contoh soal untuk memperkuat pemahaman siswa.','book_66a4c52285efb1.80434079.jpg','2024-07-25 18:52:45'),
(13,'Python untuk Programmer Pemula',3,5,2019,'Setiap orang yang mau belajar pemrograman akan jatuh cinta dengan Python. Mengapa? Karena mudah dipelajari sekaligus sangat prospektif untuk karier di masa depan. Dengan mengandalkan kemudahan cara menulis baris perintah dan didukung ribuan modul siap-pakai, Python termasuk bahasa pemrograman yang ramah bagi para pemula dan orang awam, baik bagi pengguna MS Windows maupun Linux. Buku ini dapat menjadi teman yang baik bagi para pemula untuk mengenal pemrograman. Bahasa di dalam buku ini adalah seputar dasar-dasar Python dan pemrograman database menggunakan Python serta MySQL.','book_66a4c6a7eabbe6.18235947.PNG','2024-07-25 18:52:45'),
(14,'Panduan UI/UX Aplikasi Digital',3,5,2024,'Desain UI/UX menjadi sangat penting untuk menciptakan pengalaman pengguna yang luar biasa. Dalam era digital yang semakin maju, ada banyak perusahaan yang membutuhkan desainer UI/UX berkualitas sehingga prospek belajar UI/UX menjadi sangat menjanjikan.','book_66a4c77209ed94.82488454.PNG','2024-07-25 18:52:45');

/*Table structure for table `genre` */

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `genre` */

insert  into `genre`(`id`,`nama`,`created_at`) values 
(2,'Pendidikan','2024-07-22 10:04:42'),
(3,'Fiksi','2024-07-27 16:38:30'),
(4,'Non-Fiksi','2024-07-27 16:38:41'),
(5,'Teknologi & Komputer','2024-07-27 16:39:03'),
(6,'Anak & Remaja','2024-07-27 16:39:47');

/*Table structure for table `our_location` */

DROP TABLE IF EXISTS `our_location`;

CREATE TABLE `our_location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gambar` text,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `our_location` */

insert  into `our_location`(`id`,`gambar`,`title`,`description`,`created_at`) values 
(2,'our_location_66a4c965713e16.60408631.jfif','Pusat Perpustakaan Pustika','Perpustakaan Pustika pusat adalah pusat informasi dan koleksi terbesar, menyediakan berbagai bahan bacaan dari buku-buku akademis, literatur, hingga majalah dan jurnal. Fasilitasnya mencakup ruang baca nyaman, area komputer, dan ruang pertemuan. Alamat: Jl. Merdeka No. 1, Jakarta Pusat, Jakarta 10110, Indonesia\r\n','2024-07-27 08:14:54');

/*Table structure for table `penerbit` */

DROP TABLE IF EXISTS `penerbit`;

CREATE TABLE `penerbit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penerbit` */

insert  into `penerbit`(`id`,`nama`,`alamat`,`created_at`) values 
(3,'Elex Media Komputindo','Gedung Kompas Gramedia, Jl. Palmerah Barat No. 29-37, Jakarta 10270, Indonesia','2024-07-22 09:31:06'),
(4,'Gramedia Pustaka Utama','Kompas Gramedia Building, Jl. Palmerah Barat No. 29-37, Jakarta 10270, Indonesia','2024-07-27 16:33:32'),
(5,'Mizan Pustaka','Jl. Cinambo No. 135, Ujungberung, Bandung, Jawa Barat 40294, Indonesia\r\n','2024-07-27 16:34:12'),
(6,'Erlangga','Jl. H. Baping Raya No. 100, Ciracas, Jakarta Timur 13740, Indonesia','2024-07-27 16:34:29');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`no_telp`,`role`,`created_at`) values 
(1,'admin','$2y$10$ZvEb2/U6vNfv1y04DJb6buVSESWkIEYfZx.17tNhMpFU3nNKcoh7G','admin@example.com','1234567890','admin','2024-07-21 11:44:07');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
