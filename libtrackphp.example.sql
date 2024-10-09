-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 02:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libtrackphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `isbn` bigint(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `stock` int(4) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `img`, `title`, `author`, `description`, `stock`, `category`) VALUES
(1, 9781760630720, 'public/img/9781760630720.jpg', 'The Courage To Be Disliked', 'Ichiro Kishimi and Fumitake Koga', 'The Courage to Be Disliked, already an enormous bestseller in Asia with more than 3.5 million copies', 5, 'Philosophy'),
(2, 9781975333867, 'public/img/9781975333867.jpg', 'Miracles of the Namiya General Store', 'Keigo Higashino', 'When three delinquents hole up in an abandoned general store after their most recent robbery, to their great surprise, a letter drops through the mail slot in the store\'s shutter. This seemingly simple request for advice sets the trio on a journey of discovery as, over the course of a single night, they step into the role of the kindhearted former shopkeeper who devoted his waning years to offering thoughtful counsel to his correspondents. Through the lens of time, they share insight with those seeking guidance, and by morning, none of their lives will ever be the same.\n\nBy acclaimed author Keigo Higashino, The Miracles of the Namiya General Store is a work that has touched the hearts of readers around the world.', 3, 'Mystery'),
(3, 9786020301129, 'public/img/9786020301129.jpg', 'Bumi', 'Tere Liye', 'Namaku Raib, usiaku 15 tahun, kelas sepuluh. Aku anak perempuan seperti kalian, adik-adik kalian, tetangga kalian. Aku punya dua kucing, namanya si Putih dan si Hitam. Mama dan papaku menyenangkan. Guru-guru di sekolahku seru. Teman-temanku baik dan kompak.\n\nAku sama seperti remaja kebanyakan, kecuali satu hal. Sesuatu yang kusimpan sendiri sejak kecil. Sesuatu yang menakjubkan.\n\nNamaku, Raib. Dan aku bisa menghilang.', 1, 'Adventure'),
(4, 9786020314112, 'public/img/9786020314112.jpg', 'Bulan', 'Tere Liye', 'Namanya Seli, usianya 15 tahun, kelas sepuluh. Dia sama seperti remaja yang lain. Menyukai hal yang sama, mendengarkan lagu-lagu yang sama, pergi ke gerai fast food, menonton serial drama, film, dan hal-hal yang disukai remaja.\r\n\r\nTetapi ada sebuah rahasia kecil Seli yang tidak pernah diketahui siapa pun. Sesuatu yang dia simpan sendiri sejak kecil. Sesuatu yang menakjubkan dengan tangannya.\r\n\r\nNamanya Seli. Dan tangannya bisa mengeluarkan petir.', 1, 'Adventure'),
(5, 9786020332116, 'public/img/9786020332116.jpg', 'Matahari', 'Tere Liye', 'Namanya Ali, 15 tahun, kelas X. Jika saja orangtuanya mengizinkan, seharusnya dia sudah duduk di tingkat akhir ilmu fisika program doktor di universitas ternama. Ali tidak menyukai sekolahnya, guru-gurunya, teman-teman sekelasnya. Semua membosankan baginya.\r\n\r\nTapi sejak dia mengetahui ada yang aneh pada diriku dan Seli, teman sekelasnya, hidupnya yang membosankan berubah seru. Aku bisa menghilang, dan Seli bisa mengeluarkan petir.Ali sendiri punya rahasia kecil. Dia bisa berubah menjadi beruang', 1, 'Adventure'),
(6, 9786020351179, 'public/img/9786020351179.jpg', 'Bintang', 'Tere Liye', 'Kami bertiga teman baik. Remaja, murid kelas sebelas. Penampilan kami sama seperti murid SMA lainnya. Tapi kami menyimpan rahasia besar.\r\n\r\nNamaku Raib, aku bisa menghilang. Seli, teman semejaku, bisa mengeluarkan petir dari telapak tangannya. Dan Ali, si biang kerok sekaligus si genius, bisa berubah menjadi beruang raksasa. Kami bertiga kemudian bertualang ke dunia paralel yang tidak diketahui banyak orang, yang disebut Klan Bumi, Klan Bulan, Klan Matahari, dan Klan Bintang. Kami bertemu tokoh-tokoh hebat. Penduduk klan lain.\r\n\r\nIni petualangan keempat kami. Setelah tiga kali berhasil menyelamatkan dunia paralel dari kehancuran besar, kami harus menyaksikan bahwa kamilah yang melepaskan “musuh besar”-nya.\r\nIni ternyata bukan akhir petualangan, ini justru awal dari semuanya…\r\nBuku keempat dari serial “BUMI”', 1, 'Adventure'),
(7, 9786020385914, 'public/img/9786020385914.jpg', 'Ceros dan Batozar', 'Tere Liye', 'Awalnya kami hanya mengikuti karyawisata biasa seperti murid-murid sekolah lain. Hingga Ali, dengan kegeniusan dan keisengannya, memutuskan menyelidiki sebuah ruangan kuno. Kami tiba di bagian dunia paralel lainnya, menemui petarung kuat, mendapat kekuatan baru serta teknik-teknik menakjubkan.\r\n\r\nDunia paralel ternyata sangat luas, dengan begitu banyak orang hebat di dalamnya. Kisah ini tentang petualangan tiga sahabat. Raib bisa menghilang. Seli bisa mengeluarkan petir. Dan Ali bisa melakukan apa saja.', 1, 'Adventure'),
(8, 9786020385938, 'public/img/9786020385938.jpg', 'Komet', 'Tere Liye', 'Setelah “musuh besar” kami lolos, dunia paralel dalam situasi genting. Hanya soal waktu, pertempuran besar akan terjadi. Bagaimana jika ribuan petarung yang bisa menghilang, mengeluarkan petir, termasuk teknologi maju lainnya muncul di permukaan Bumi? Tidak ada yang bisa membayangkan kekacauan yang akan terjadi. Situasi menjadi lebih rumit lagi saat Ali, pada detik terakhir, melompat ke portal menuju Klan Komet. Kami bertiga tersesat di klan asing untuk mencari pusaka paling hebat di dunia paralel.\r\n\r\nBuku ini berkisah tentang petualangan tiga sahabat. Raib bisa menghilang. Seli bisa mengeluarkan petir. Dan Ali bisa melakukan apa saja. Buku ini juga berkisah tentang persahabatan yang mengharukan, pengorbanan yang tulus, keberanian, dan selalu berbuat baik. Karena sejatinya, itulah kekuatan terbesar di dunia paralel.', 1, 'Adventure'),
(9, 9786024246945, 'public/img/9786024246945.jpg', 'Laut Bercerita', 'Leila S. Chudori', 'Di sebuah senja, di sebuah rumah susun di Jakarta, mahasiswa bernama Biru Laut disergap empat lelaki tak dikenal. Bersama kawan-kawannya, Daniel Tumbuan, Sunu Dyantoro, Alex Perazon, dia dibawa ke sebuah tempat yang tak dikenal. Berbulan-bulan mereka disekap, diinterogasi, dipukul, ditendang, digantung, dan disetrum agar bersedia menjawab satu pertanyaan penting: siapakah yang berdiri di balik gerakan aktivis dan mahasiswa saat itu.\n\nJakarta, Juni 1998\n\nKeluarga Arya Wibisono, seperti biasa, pada hari Minggu sore memasak bersama, menyediakan makanan kesukaan Biru Laut. Sang ayah akan meletakkan satu piring untuk dirinya, satu piring untuk sang ibu, satu piring untuk Biru Laut, dan satu piring untuk si bungsu Asmara Jati. Mereka duduk menanti dan menanti. Tapi Biru Laut tak kunjung muncul.\n\nJakarta, 2000\n\nAsmara Jati, adik Biru Laut, beserta Tim Komisi Orang Hilang yang dipimpin Aswin Pradana mencoba mencari jejak mereka yang hilang serta merekam dan mempelajari testimoni mereka yang kembali. Anjani, kekasih Laut, para orangtua dan istri aktivis yang hilang menuntut kejelasan tentang anggota keluarga mereka. Sementara Biru Laut, dari dasar laut yang sunyi bercerita kepada kita, kepada dunia tentang apa yang terjadi pada dirinya dan kawan-kawannya.\n\nLaut Bercerita, novel terbaru Leila S. Chudori, bertutur tentang kisah keluarga yang kehilangan, sekumpulan sahabat yang merasakan kekosongan di dada, sekelompok orang yang gemar menyiksa dan lancar berkhianat, sejumlah keluarga yang mencari kejelasan akan anaknya, dan tentang cinta yang tak akan luntur.', 2, 'Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(20) NOT NULL,
  `isbn` int(50) NOT NULL,
  `member_id` int(20) NOT NULL,
  `since` timestamp NULL DEFAULT current_timestamp(),
  `until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(1, 'rexec', 'akbardafandi@gmail.com', '$2y$10$/./q5ZXsLGTyotiUBCpH2e5xShMyl8wqyndUXGeJJqTFdWocLxRwu', 'admin'),
(2, 'Admin', 'akbar.for.live@gmail.com', '$2y$10$XT5WY1nrTBt0gyiexW/2fOAAvmG87mozD/DTh2z5LdYDBWh1WCCYy', 'admin'),
(3, 'user', 'user@aafd.com', '$2y$10$UtiniPNX/c43iJVk8LkZOu2QVGBRoYvAhArTX1iGM.2GONf2ZzlQ6', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
