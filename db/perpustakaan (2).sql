-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Mar 2024 pada 02.44
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--
CREATE DATABASE IF NOT EXISTS `perpustakaan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `perpustakaan`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `bukuID` int(11) NOT NULL,
  `perpusID` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahunterbit` int(11) NOT NULL,
  `kategoriID` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`bukuID`, `perpusID`, `judul`, `penulis`, `penerbit`, `tahunterbit`, `kategoriID`, `foto`, `deskripsi`, `stok`, `created_at`) VALUES
(3, 2, 'Battle Through The Heaven Pt.2', 'Ryuku Hitoshi', 'Tokusatsu Studio', 2005, 7, '74788a36-2cf2-41ab-932d-accb2cf90753.jpeg', '', 20, '2024-03-01 01:35:38'),
(4, 2, 'Battle Through : Awaken of Sky', 'Ryuku Hitoshi', 'Fanshub Donghua', 2015, 7, 'download (6).jpeg', '', 22, '2024-02-29 12:10:57'),
(5, 2, 'Battle Through : Gods of Heaven', 'Shen Liu', 'Shen Studio', 2021, 3, 'download (7).jpeg', 'Dalam \"Battle Through: Gods of Heaven\", Xiao Yan memulai perjalanan yang epik ke dunia para dewa, di mana dia akan menghadapi serangkaian tantangan yang menentukan takdirnya. Perjalanan ini dimulai dengan perkenalan pertamanya dengan dewa-dewa langit yang memerintah alam semesta, mulai dari dewa-dewa yang penuh kasih seperti Freya, hingga dewa-dewa yang penuh amarah seperti Ares. Setiap pertemuan membawanya lebih dekat dengan pemahaman akan kekuatan kosmos dan peranannya dalam menguasai kekuatan langit. Namun, puncak perjalanannya terjadi ketika dia menemukan gua rahasia yang mengungkapkan rahasia kuasa luar biasa, yaitu Api Biru. Di dalam gua itu, dia bertemu dengan dewa penjaga, Prometheus, yang memberinya ajaran tentang kekuatan Api Biru. Dengan kesabaran dan ketekunan, Xiao Yan berhasil mempelajari dan menguasai Api Biru, sebuah kekuatan yang akan membantu memperkuatnya dalam pertempuran melawan kekuatan jahat yang mengintai dunia. Dengan plot yang dipenuhi dengan pertemuan yang memukau, tantangan yang menegangkan, dan pencerahan spiritual, \"Battle Through: Gods of Heaven\" menjanjikan petualangan yang tak terlupakan dalam mengungkap rahasia-rahasia kosmis dan menghadapi kekuatan yang menguji batas-batas kemanusiaan.', 21, '2024-02-29 16:09:15'),
(6, 2, 'Battle Through : Infinity War', 'Shen Liu', 'Shen Studio', 2022, 3, 'download (8).jpeg', 'Dalam \"Battle Through: Infinity War\", dunia diwarnai oleh perang besar antara para dewa yang memperebutkan kekuasaan absolut. Setiap langkah mereka memicu gelombang kehancuran, dan di tengah kekacauan ini, Xiao Yan, seorang pemuda yang terjebak dalam nasibnya, menemukan dirinya terlibat secara tidak sengaja. Saat perang semakin memanas, dia harus membangun hubungan yang rumit dengan para dewa seperti Zeus, dewa petir yang perkasa, Ra, sang dewa matahari, dan Amaterasu, dewi matahari dari Mitologi Jepang, sementara merangkai aliansi yang rapuh dengan dewa-dewa lainnya. Tantangan demi tantangan melintas di depannya, menuntut Xiao Yan untuk menggunakan segala kecerdasan dan keberanian yang dimilikinya dalam mempertahankan dunia dari kehancuran yang mengintai. Namun, di balik medan perang yang penuh dengan intrik dan bahaya, juga tersembunyi rahasia gelap yang mengancam untuk menghancurkan segalanya. Dengan setiap pukulan yang diberikan dan setiap kesaksian akan ketahanan batinnya, Xiao Yan memperjuangkan takdirnya dalam menentukan nasib dunia yang terancam oleh kekuatan yang tidak terbayangkan. Dengan plot yang sarat dengan intrik dan aksi yang mendebarkan, \"Battle Through: Infinity War\" menggambarkan kisah epik tentang pengorbanan, keberanian, dan perjuangan melawan kekuatan yang tidak terbayangkan.', 23, '2024-02-29 02:49:57'),
(7, 2, 'Battle Through : Rise of Medusa', 'Shen Liu', 'Shen Studio', 2022, 3, '4dd2bbf2-1c22-4b08-a1b3-9430e01a8924.jpeg', '\"Battle Through the Heaven: Rise of Medusa\" membuka babak baru dalam kelanjutan kisah epik dari seri sebelumnya, \"Queen Medusa\". Dalam lanjutan ini, fokus utama cerita beralih kepada Medusa, yang kini memperlihatkan kekuatan terkuatnya. Setelah mengalami berbagai peristiwa dalam \"Queen Medusa\", karakter ini tampil dalam kemegahan penuh, menampilkan kekuatan mistisnya yang memukau. Namun, dengan kekuatan tersebut, Medusa juga harus menghadapi tantangan baru dan musuh yang lebih tangguh. Kehadirannya membawa gelombang baru dalam dunia yang dipenuhi pertarungan dan intrik, memperdalam misteri di balik legenda yang telah dibangun sebelumnya. Dalam perjalanan epik ini, karakter-karakter lain seperti Xiao Yan dan teman-temannya juga terlibat dalam konflik yang semakin rumit, di mana mereka harus bersiap menghadapi ancaman yang lebih besar dari sebelumnya. Dengan plot yang penuh dengan kejutan dan ketegangan, \"Battle Through the Heaven: Rise of Medusa\" menjanjikan petualangan yang tak terlupakan dalam mengungkap rahasia tersembunyi dan menghadapi kekuatan yang mengancam dunia yang mereka kenal.', 24, '2024-02-29 16:10:30'),
(8, 2, 'Vendetta : Battle Through The Heaven', 'Mihoyo Xiao', 'Mihoyo Starlink', 2024, 3, 'XIO YAN (BTTH).jpeg', 'Dalam \"Vendetta: Battle Through the Heaven\", perjalanan epik Xiao Yan mengalami perubahan dramatis saat gurunya spiritualnya, Master Li, meninggal tragis oleh tangan salah satu dewa, Athena, yang telah mengkhianati mereka. Kematian tragis ini memicu api hitam di dalam hati Xiao Yan, membangkitkan niat dendam yang membara terhadap dewa tersebut. Ketika hubungannya dengan Medusa semakin erat, Xiao Yan memulai perjalanan yang gelap dan berbahaya untuk membalas kematian gurunya. Dalam pencariannya akan balas dendam, dia harus menghadapi tantangan yang belum pernah ia alami sebelumnya, menavigasi intrik dan kekuatan gaib yang bersembunyi di balik kegelapan. Dalam pertempuran yang akan datang, Xiao Yan akan diuji sampai batasnya, dan takdirnya yang penuh dengan dendam akan membawa dia ke jalur yang tidak pernah ia bayangkan sebelumnya. Dalam \"Vendetta: Battle Through the Heaven\", kisah tentang keberanian, pengorbanan, dan penebusan diri mencapai puncaknya dalam pertempuran yang epik dan memukau.', 24, '2024-02-29 02:37:12'),
(9, 2, 'Kisah Wali : 100 Malam', 'Junji Ito', 'Indosiar Studio', 2023, 1, '萧炎 ~ Xiao Yan.jpg', '', 25, '2024-02-29 02:00:16'),
(10, 2, 'Cinta Ditolak : Emang Gak Enak Pt.1', 'Samuel Masaki', 'Sakatarumi', 2023, 4, 'f6544b4e-f033-4fe8-a6bd-e9b5308d49f5.jpg', '', 25, '2024-02-29 02:00:16'),
(11, 2, 'One Punch Man Season 1', 'Murata', 'Japan Studio', 2019, 7, 'download (1).jpg', '', 25, '2024-02-29 02:00:16'),
(12, 2, 'Battle Through : Queen Medusa Pt.3', 'Shen Liu', 'Mikasa Studio', 2024, 3, 'download.jpg', '\"Battle Through: Queen Medusa\" membawa kita ke dalam legenda Medusa, seorang wanita dengan kekuatan mistis yang menakutkan, yang memunculkan kekacauan di dunia. Dalam kisah ini, Medusa bertemu dengan karakter utama, Xiao Yan, yang awalnya tidak menyadari kekuatannya. Hubungan mereka dipenuhi dengan ketegangan awalnya, namun seiring berjalannya waktu, mereka menjadi sekutu yang kuat, menghadapi tantangan bersama. Konflik yang muncul tidak hanya antara Medusa dan musuh-musuhnya, tetapi juga di antara Xiao Yan dan kekuatannya sendiri, serta dilema moral yang harus dihadapi Xiao Yan dalam memilih antara kebaikan dan kekuasaan. Dengan plot yang penuh dengan kejutan dan karakter yang mendalam, \"Battle Through: Queen Medusa\" menawarkan pengalaman membaca yang mendebarkan, menjelajahi tema-tema kompleks seperti kekuatan, pengorbanan, dan penerimaan diri sendiri.', 25, '2024-02-29 16:03:31'),
(13, 2, 'Legacy of Angel Season 1', 'Masaki Suda', 'Mihoyo Studio', 0, 1, 'bc94afdc-9c0e-48d4-93e4-c98739b1fa53.jpg', '', 25, '2024-02-29 02:00:16'),
(14, 2, 'One Punch Man Season 2', 'Murata', 'Mihoyo Studio', 2023, 7, 'One punch man.jpg', '', 25, '2024-02-29 02:00:16'),
(15, 2, 'Panduan mengasuh bayi baru lahir', 'Dida Arfiana', 'Roh kudus', 2024, 2, '28 Creepy Photoshopped Pictures Of Mr_ Bean.jpg', '', 25, '2024-02-29 02:00:16'),
(16, 2, 'Buku KISI-KISI Alam Semesta', 'Suichirou Hyuga', 'Asahi 331', 2015, 2, 'c8640a96ed2891f22b395a4260eb1821.jpg', '', 25, '2024-02-29 02:00:16'),
(17, 2, 'Azab Tukang Bully : Edisi 2022', 'Nanami Osaka', 'IndosiarTV', 2022, 6, 'download (2).jpg', '', 25, '2024-02-29 02:00:16'),
(18, 2, 'Albia dan Portal Ajaib', 'Dimas Daffa Yanuar', 'Penerbit Erlangga', 2022, 7, 'download (5).jpeg', 'Albia adalah seorang anak yang sangat ingin tahu. Suatu hari, dia menemukan sesuatu yang sangat menarik di kebun belakang rumahnya: sebuah pintu ajaib yang tidak pernah dia lihat sebelumnya. Dengan penuh keberanian, Albia memutuskan untuk menjelajahi pintu itu. Ternyata, pintu itu adalah sebuah portal ajaib yang membawanya ke dunia yang benar-benar berbeda! Di sana, dia bertemu dengan makhluk-makhluk yang aneh dan menyenangkan, seperti peri dan binatang ajaib. Mereka bersama-sama menjalani petualangan yang menarik, belajar hal-hal baru, dan menemukan persahabatan yang tak terduga. Tetapi Albia juga belajar bahwa dengan keberanian dan kebaikan hati, dia bisa mengatasi semua rintangan yang dia temui di dunia yang baru ini. Akankah Albia berhasil menemukan jalan pulang ke rumahnya, atau dia akan terus menjelajahi dunia yang penuh misteri ini? Ikuti petualangan seru Albia di \"Albia dan Portal Ajaib\"!', 25, '2024-02-29 02:00:16'),
(19, 2, 'Album Freya Jayawardana Vol. 1', 'Dida Arfiana', 'JKT48 Fanhub', 2023, 6, 'Freya Wallpaper Doodle Draw Hissatsu teleport.jpg', 'Buku album perjalanan Freya JKT48 menggambarkan kisah petualangan dan perjalanan karir Freya di industri musik. Di dalamnya, Anda akan menemukan beberapa lagu terkenal yang menjadi ikon perjalanan musiknya. Namun, yang membuat buku ini istimewa adalah potongan-potongan lirik lagu yang memiliki makna khusus bagi Freya. Setiap lirik menggambarkan pengalaman, perasaan, dan cerita hidup Freya secara unik. Melalui lirik-lirik ini, pembaca dapat merasakan emosi yang dirasakan oleh Freya dalam perjalanan karirnya, mulai dari kebahagiaan, kesedihan, hingga keberanian untuk menghadapi tantangan. Dengan gambaran yang sederhana namun mendalam, buku ini memberikan wawasan tentang perjalanan inspiratif seorang idola musik dan makna di balik lagu-lagu yang mengiringi perjalanannya.', 25, '2024-02-29 02:00:16'),
(20, 2, 'Album Azizi Asadel JKT48 Vol. 1', 'Reza Somara', 'JKT48 Fanshub', 2023, 6, 'download (5).jpg', 'Sambutlah dengan penuh semangat album terbaru dari bintang kami, Azizi Asadel JKT48! Dalam buku ini, kita akan diajak mengenal lebih dekat dengan sosok yang memikat hati, Zee! Dengan foto-foto yang indah, kita akan disuguhkan momen-momen berharga dan ekspresi penuh semangat dari Zee yang tak terlupakan. Tidak hanya itu, kita akan dibuat terpukau dengan fakta-fakta menarik tentang Zee yang belum pernah kita ketahui sebelumnya! Namun, tak ketinggalan, buku ini juga akan mengungkapkan gemilangnya karir musik Zee di JKT48, mulai dari debutnya yang gemilang hingga penampilan megah di atas panggung! Dan tunggu, apakah itu? Tentu saja! Kita semua berharap akan ada lebih banyak buku yang mengungkap kisah-kisah inspiratif dari para bintang JKT48 lainnya di masa depan. Jadi, tetaplah terhubung, para penggemar, karena cerita-cerita menarik dan inspiratif dari bintang-bintang kita masih menanti untuk diungkapkan! Jangan lewatkan kesempatan untuk memiliki album ini, yang akan menghidupkan kembali kenangan manis bersama Zee dan memberikan inspirasi tak terbatas bagi kita, para penggemar JKT48! ', 25, '2024-02-29 02:00:16'),
(21, 2, 'Mobile Legends Universe', 'Ishirou Takami', 'MLBB Official', 2023, 2, 'Wallpaper Ling Collector.jpg', 'Mobile Legends Universe adalah panduan lengkap untuk mengenal lebih dekat tentang para hero dalam Mobile Legends, termasuk hero-hero terbaru yang telah dirilis pada tahun 2023 seperti Yu Zhong dan Yin. Dalam buku ini, Anda akan menemukan daftar lengkap nama-nama hero, beserta deskripsi ability dan kekuatannya yang luar biasa, termasuk hero-hero baru yang memperkaya pengalaman bermain Anda. Tidak hanya itu, buku ini juga memberikan wawasan tentang penggalan kisah dari beberapa hero terkenal, seperti Alucard dan Layla, yang akan membuat Anda semakin terhubung dengan karakter-karakter dalam game. Namun, yang lebih penting, buku ini menyediakan informasi penting mengenai role yang tepat untuk setiap hero berdasarkan data update terbaru tahun ini. Apakah Anda seorang Marksman seperti Lesley atau seorang Tank seperti Grock, buku ini akan membantu Anda memahami peran masing-masing hero di medan perang. Tak hanya itu, buku ini juga memberikan saran tentang emblem dan item terbaik untuk setiap hero, membantu Anda merancang strategi yang efektif untuk memenangkan pertempuran. Dengan Mobile Legends Universe, Anda akan menjadi pemain yang lebih ahli dan terampil dalam mengendalikan hero Anda! ', 24, '2024-02-29 02:30:38'),
(24, 2, 'Album Angelina Christy JKT48 Vol.1', 'Dida Arfiana', 'JKT48 Fanhub', 2024, 6, 'CHRISTY JKT48.jpg', 'Hai, para penggemar JKT48 yang hebat! Bersiaplah untuk menghadapi sensasi terbaru dari panggung musik kita, karena sekarang telah tiba waktunya untuk memperkenalkan album terbaru yang dinanti-nantikan dari bintang kita, Angelita Christy JKT48! Setelah kesuksesan gemilang album Zee dan Freya, kini saatnya bagi Christy untuk bersinar dengan pesonanya sendiri. Dalam album ini, kita akan memasuki dunia baru yang dipenuhi dengan energi, keberanian, dan keindahan, yang hanya bisa ditemukan dalam lagu-lagu yang dibawakan oleh Christy dengan begitu apiknya. Jangan lewatkan momen-momen istimewa ini, karena kita akan mendapatkan wawasan eksklusif tentang topik terbaru tentang Christy, serta keceriaan dan pesona yang selalu menyertai setiap langkahnya. Jadi, siapkan hati dan telinga Anda untuk menyambut album terbaru dari Angelita Christy JKT48, yang akan menggetarkan panggung musik dan hati para penggemar! ', 25, '2024-02-29 02:00:16'),
(25, 2, 'Skeleton Man', 'Joseph Bruchac', 'Nvidia Studio', 2024, 7, 'download (12).jpg', 'Dalam cerita \"Skeleton Man\", kita memasuki dunia fantasi yang penuh misteri dan keajaiban. Di tengah hutan yang lebat dan sunyi, seorang anak bernama Jack menemukan sesuatu yang luar biasa: seorang golem bertubuh skeleton yang tersembunyi di dalam gua terpencil. Awalnya, Jack merasa takut dan ragu untuk mendekati makhluk tersebut, tetapi rasa ingin tahu dan keberaniannya mengalahkan ketakutannya. Saat dia berani mendekati golem itu, dia menemukan bahwa golem tersebut sebenarnya adalah penjaga hutan yang baik hati, yang telah tinggal di sana selama berabad-abad. Bersama-sama, Jack dan golem mulai menjalani petualangan yang menakjubkan, menjelajahi hutan yang misterius dan bertemu dengan berbagai makhluk ajaib. Namun, di balik keindahan alam, ada kekuatan jahat yang mengintai, dan Jack harus belajar menghadapi tantangan yang lebih besar daripada yang pernah dia bayangkan sebelumnya. Dengan keberanian, kebijaksanaan, dan bantuan dari golem yang setia, Jack berjuang untuk melindungi hutan dan teman-temannya dari bahaya yang mengancam. \"Skeleton Man\" adalah kisah tentang persahabatan, petualangan, dan keberanian yang menginspirasi, mengajarkan kita bahwa kadang-kadang keajaiban bisa ditemukan di tempat-tempat yang paling tak terduga.', 25, '2024-02-29 02:00:16'),
(26, 2, 'Snow Time', 'Frank Meyer', 'Namade', 2023, 3, '1a16811e-b355-4fdf-8cda-c4574b4e5162.jpg', 'Dalam buku \"Snow Time\", kita disuguhkan dengan kisah yang membawa kita ke dalam keindahan musim dingin yang mempesona. Di sebuah desa kecil yang tersembunyi di antara pegunungan bersalju, hiduplah seorang anak laki-laki bernama Tommy. Tommy adalah seorang anak yang penuh semangat dan penuh dengan rasa ingin tahu tentang dunia di sekitarnya. Suatu hari, ketika Tommy sedang menjelajahi hutan yang tertutup salju, dia menemukan petualangan yang menakjubkan yang tak terlupakan: dia menemukan sebuah gua rahasia yang tersembunyi di dalam hutan. Di dalam gua itu, Tommy menemukan sesuatu yang luar biasa – sebuah jam pasir ajaib yang memiliki kekuatan untuk mengendalikan cuaca. Namun, kekuatan ini jatuh ke tangan yang salah ketika jam pasir itu dicuri oleh seorang penyihir jahat yang bernama Malachi. Dengan bantuan teman-teman barunya, Tommy memulai perjalanan epik untuk merebut kembali jam pasir ajaib dan mengembalikan keseimbangan alam. Namun, mereka harus melintasi berbagai rintangan yang menantang dan menghadapi cuaca yang tidak terduga dalam upaya mereka untuk menyelamatkan desa mereka. \"Snow Time\" adalah kisah petualangan yang menegangkan yang mengajarkan kita tentang keberanian, persahabatan, dan kekuatan dalam menghadapi tantangan yang sulit.', 25, '2024-02-29 02:00:16'),
(27, 2, 'The Legends of Nim', 'Jack Stuards', 'Gramedia', 2023, 3, 'VFX of Nim (Game project), Jacob Stenberg.jpg', 'Dalam \"The Legends of Nims\", kita diajak memasuki dunia yang mempesona di dalam hutan yang penuh misteri. Di hutan yang subur dan penuh kehidupan ini, tinggalah para penduduknya yang istimewa: peri hutan yang cantik dan penuh keajaiban. Namun, di balik keindahan alam, ada rahasia yang tersembunyi, sebuah legenda kuno yang menggema di antara pepohonan. Legenda ini bercerita tentang Nims, seorang peri legendaris yang dipercaya memiliki kekuatan yang tak terbayangkan. Ketika seorang gadis muda bernama Elara menemukan buku tua yang berisi cerita-cerita tentang Nims, dia tak sengaja terlibat dalam petualangan yang tak terlupakan. Bersama dengan teman-temannya, Elara memulai pencarian untuk menemukan kebenaran di balik legenda Nims dan mengungkap rahasia yang tersembunyi di dalam hutan. Namun, perjalanan mereka tidaklah mudah, karena mereka harus menghadapi berbagai rintangan dan menghadapi bahaya yang mengintai di setiap sudut hutan. Dalam \"The Legends of Nims\", kita akan terpesona oleh keajaiban alam, kisah-kisah yang menggetarkan, dan kekuatan persahabatan yang menguatkan.', 25, '2024-02-29 02:00:16'),
(28, 2, 'Lightfall', 'Akane Takuma', 'Mihoyo Studio', 2023, 3, 'Lightfall - Cover.jpg', 'Dalam \"Lightfall\", kita dihadapkan pada petualangan epik di dunia yang mempesona dan penuh misteri. Di sebuah dunia yang diperintah oleh kegelapan dan ketakutan, hiduplah seorang anak laki-laki bernama Beaumont. Beaumont adalah seorang pemuda yang penuh semangat dan berani, tetapi dia juga memiliki rahasia yang sangat berharga: sepotong batu kristal misterius yang memancarkan cahaya yang menyilaukan. Ketika batu itu tiba-tiba hilang, Beaumont memutuskan untuk memulai pencarian yang berbahaya untuk menemukan kembali batu itu dan mengembalikan cahaya kepada dunia yang gelap. Bersama dengan teman-temannya, Beaumont memulai perjalanan melintasi berbagai medan yang menakjubkan, menghadapi rintangan yang menantang, dan menemukan sekutu yang tak terduga di sepanjang jalan. Namun, di balik setiap langkah mereka, ada kekuatan jahat yang mengintai, siap untuk menghentikan mereka dalam misi mereka. Dalam \"Lightfall\", kita akan dibawa ke dalam dunia yang penuh dengan petualangan, keajaiban, dan keberanian yang luar biasa.', 25, '2024-02-29 02:00:16'),
(29, 2, 'The LightFall', 'Junji Takada', 'AirForce Studio', 2025, 7, 'Lightfall - Cover.jpg', 'Buku ini bercerita tentang seorang pahlawan bernama Simpson yang memiliki kekuatan cahaya', 25, '2024-02-29 02:00:16'),
(31, 2, 'Catch Me if Im Runaway', 'Dida Arfiana', 'Aozora Studio', 2022, 3, 'de5e63c8-f34f-4fa0-8375-46176c7fee39.jpg', 'Ini adalah sinopsis buku (dalam bahasa Indonesia)', 25, '2024-02-29 01:52:41'),
(32, 2, 'Justina Xie Album (Limited Edition)', 'Justina Xie ', 'Douyin Official', 2023, 6, 'a69f9cc7-1b6b-484f-b910-d0b2f7071fab.jpg', 'This is limited edition! Get your official album from Justina Xie in albumdouyinsofficial.com', 1, '2024-02-29 17:46:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `c_logs`
--

CREATE TABLE `c_logs` (
  `logsID` int(11) NOT NULL,
  `detail_histori` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `c_logs`
--

INSERT INTO `c_logs` (`logsID`, `detail_histori`, `created_at`) VALUES
(2, 'User bernama didaarfiana berhasil registrasi ke database', '2024-01-22 16:00:38'),
(4, 'User bernama jabalnoor berhasil registrasi ke database', '2024-01-22 16:04:00'),
(5, 'User bernama didaarfiana telah login', '2024-01-24 11:17:51'),
(6, 'User bernama didaarfiana berhasil registrasi ke database', '2024-01-24 14:34:44'),
(7, 'User bernama alijaber berhasil registrasi ke database', '2024-01-24 15:38:56'),
(8, 'User bernama alijaber telah login', '2024-01-24 15:41:02'),
(9, 'User bernama  berhasil registrasi ke database', '2024-01-31 16:47:59'),
(10, 'User bernama  berhasil registrasi ke database', '2024-01-31 16:58:57'),
(11, 'User bernama  berhasil registrasi ke database', '2024-01-31 17:02:07'),
(12, 'User bernama  berhasil registrasi ke database', '2024-01-31 17:18:04'),
(13, 'User bernama didaarfiana berhasil registrasi ke database', '2024-02-01 02:08:22'),
(14, 'User bernama aaa berhasil registrasi ke database', '2024-02-01 02:11:33'),
(15, 'User bernama ccc berhasil registrasi ke database', '2024-02-01 02:13:28'),
(16, 'User bernama eeee berhasil registrasi ke database', '2024-02-01 02:16:30'),
(17, 'User bernama www berhasil registrasi ke database', '2024-02-01 02:38:22'),
(38, 'User bernama ggg berhasil registrasi ke database', '2024-02-01 15:47:47'),
(39, 'User bernama ggg berhasil registrasi ke database', '2024-02-01 16:03:49'),
(40, 'User bernama jjj berhasil registrasi ke database', '2024-02-01 16:04:21'),
(41, 'User bernama dafa berhasil registrasi ke database', '2024-02-03 02:10:32'),
(48, 'User bernama nanasmadu berhasil registrasi ke database', '2024-02-07 00:36:59'),
(49, 'User bernama nanasmadu telah login', '2024-02-07 00:37:24'),
(50, 'Buku dengan judul bajar juara berhasil dibuat dan dimasukkan ke database', '2024-02-07 01:40:41'),
(51, 'Buku dengan judul xiaoyan adv berhasil dibuat dan dimasukkan ke database', '2024-02-07 02:22:38'),
(52, 'Buku dengan judul Battle Through The Heaven Pt.2 berhasil dibuat dan dimasukkan ke database', '2024-02-07 02:31:48'),
(53, 'Buku dengan judul Battle Through : Awaken of Sky berhasil dibuat dan dimasukkan ke database', '2024-02-07 03:00:01'),
(54, 'Buku dengan judul Battle Through : Gods of Heaven berhasil dibuat dan dimasukkan ke database', '2024-02-07 03:46:56'),
(55, 'Buku dengan judul Battle Through : Infinity War berhasil dibuat dan dimasukkan ke database', '2024-02-07 03:48:20'),
(56, 'Buku dengan judul Battle Through : Rise of Medusa berhasil dibuat dan dimasukkan ke database', '2024-02-07 03:50:41'),
(57, 'Buku dengan judul Vendetta : Battle Through The Heaven berhasil dibuat dan dimasukkan ke database', '2024-02-07 03:52:47'),
(58, 'Buku dengan judul Kisah Wali : 100 Malam berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:04:53'),
(59, 'Buku dengan judul Cinta Ditolak : Emang Gak Enak Pt.1 berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:07:44'),
(60, 'Buku dengan judul One Punch Man Season 1 berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:10:20'),
(61, 'Buku dengan judul Battle Through : Queen Medusa Pt.3 berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:15:07'),
(62, 'Buku dengan judul Legacy of Angel Season 1 berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:16:50'),
(63, 'Buku dengan judul One Punch Man Season 2 berhasil dibuat dan dimasukkan ke database', '2024-02-07 04:23:31'),
(64, 'Buku dengan judul Panduan mengasuh bayi baru lahir berhasil dibuat dan dimasukkan ke database', '2024-02-10 05:00:07'),
(65, 'Buku dengan judul Buku KISI-KISI Alam Semesta berhasil dibuat dan dimasukkan ke database', '2024-02-11 11:19:52'),
(66, 'Buku dengan judul Azab Tukang Bully : Edisi 2022 berhasil dibuat dan dimasukkan ke database', '2024-02-11 11:22:15'),
(67, 'User bernama nanasmadu telah login', '2024-02-12 16:19:22'),
(68, 'User nanasmadu telah menambahkan buku berjudul Albia dan Portal Ajaib', '2024-02-12 17:35:44'),
(70, 'User bernama didaarfiana telah login', '2024-02-13 10:44:00'),
(71, 'User didaarfiana telah menambahkan buku berjudul Album Freya Jayawardana Vol. 1', '2024-02-13 16:01:24'),
(72, 'User didaarfiana telah menambahkan buku berjudul Album Azizi Asadel JKT48 Vol. 1', '2024-02-13 16:23:39'),
(73, 'User didaarfiana telah menambahkan buku berjudul Mobile Legends Universe', '2024-02-13 16:57:32'),
(74, 'User didaarfiana telah logout karena sesi berakhir', '2024-02-14 07:04:17'),
(75, 'User bernama didaarfiana telah login', '2024-02-14 07:05:22'),
(76, 'User didaarfiana telah menambahkan buku berjudul Spiderman : RL Universe 991', '2024-02-14 07:10:52'),
(77, 'User didaarfiana telah menambahkan buku berjudul Spiderman : RL Universe 991', '2024-02-14 07:10:53'),
(78, 'User bernama didaarfiana telah login', '2024-02-14 09:53:53'),
(79, 'User bernama didaarfiana telah login', '2024-02-15 01:28:13'),
(80, 'User bernama didaarfiana telah login', '2024-02-15 07:06:31'),
(81, 'User bernama didaarfiana telah login', '2024-02-16 01:47:49'),
(82, 'User bernama didaarfiana telah login', '2024-02-16 14:24:29'),
(83, 'User didaarfiana telah logout karena sesi berakhir', '2024-02-16 22:34:03'),
(84, 'User bernama didaarfiana telah login', '2024-02-16 22:34:33'),
(85, 'User bernama didaarfiana telah login', '2024-02-17 10:45:02'),
(86, 'User bernama nanasmadu telah login', '2024-02-18 03:57:36'),
(87, 'User bernama didaarfiana telah login', '2024-02-19 03:04:11'),
(88, 'User bernama nanasmadu telah login', '2024-02-19 06:47:45'),
(89, 'User bernama didaarfiana telah login', '2024-02-19 10:47:19'),
(90, 'User bernama didaarfiana telah login', '2024-02-19 21:46:23'),
(91, 'User bernama didaarfiana telah login', '2024-02-20 00:45:29'),
(92, 'User bernama eziganteng berhasil registrasi ke database', '2024-02-20 02:03:51'),
(93, 'User bernama didaarfiana telah login', '2024-02-20 02:04:09'),
(94, 'User bernama nanasmadu telah login', '2024-02-20 12:19:49'),
(95, 'User nanasmadu telah menambahkan buku berjudul Album Angelina Christy JKT48 Vol.1', '2024-02-20 14:25:46'),
(96, 'User nanasmadu telah menambahkan buku berjudul Skeleton Man', '2024-02-20 15:20:06'),
(97, 'User nanasmadu telah menambahkan buku berjudul Snow Time', '2024-02-20 15:24:26'),
(98, 'User nanasmadu telah menambahkan buku berjudul The Legends of Nim', '2024-02-20 15:29:26'),
(99, 'User nanasmadu telah menambahkan buku berjudul Lightfall', '2024-02-20 15:35:38'),
(100, 'User bernama eziganteng telah login', '2024-02-20 16:09:18'),
(101, 'User bernama nanasmadu telah login', '2024-02-20 17:06:53'),
(102, 'User bernama eziganteng berhasil ditambahkan oleh  ke database', '2024-02-20 18:45:40'),
(103, 'User bernama ezibaik berhasil ditambahkan oleh  ke database', '2024-02-20 18:47:02'),
(104, 'User bernama jahwan berhasil ditambahkan oleh nanasmadu ke database', '2024-02-20 18:53:40'),
(105, 'User bernama ezipetugas telah login', '2024-02-20 18:58:01'),
(106, 'User bernama didaarfiana telah login', '2024-02-20 23:19:44'),
(107, 'User bernama didaarfiana telah login', '2024-02-21 02:17:40'),
(108, 'User bernama nanasmadu telah login', '2024-02-21 03:18:34'),
(109, 'User bernama dafa berhasil registrasi ke database', '2024-02-21 07:09:00'),
(110, 'User bernama dafa telah login', '2024-02-21 07:09:31'),
(111, 'User bernama didaarfiana telah login', '2024-02-21 07:43:09'),
(112, 'User didaarfiana telah menambahkan buku berjudul The LightFall', '2024-02-21 07:51:01'),
(113, 'User bernama nanasmadu telah login', '2024-02-22 03:19:46'),
(114, 'User bernama ezipetugas telah login', '2024-02-22 03:23:51'),
(115, 'User bernama didaarfiana telah login', '2024-02-22 04:05:52'),
(116, 'User bernama didaarfiana telah login', '2024-02-23 02:36:31'),
(117, 'User bernama didaarfiana telah login', '2024-02-23 02:40:29'),
(118, 'User didaarfiana telah menambahkan buku berjudul Wing Feather Saga', '2024-02-23 02:43:24'),
(119, 'User bernama didaarfiana telah login', '2024-02-23 03:10:39'),
(120, 'User bernama didaarfiana telah login', '2024-02-27 06:07:12'),
(121, 'User bernama didaarfiana telah login', '2024-02-28 00:46:57'),
(122, 'User bernama didaarfiana telah login', '2024-02-28 13:32:32'),
(123, 'User bernama didaarfiana telah login', '2024-02-29 01:19:20'),
(124, 'User didaarfiana telah menambahkan buku berjudul Catch Me if Im Runaway', '2024-02-29 01:52:41'),
(125, 'User bernama didaarfiana telah login', '2024-02-29 03:44:23'),
(126, 'User bernama didaarfiana telah login', '2024-02-29 03:44:48'),
(127, 'User bernama didaarfiana telah login', '2024-02-29 03:45:30'),
(128, 'User bernama didaarfiana telah login', '2024-02-29 03:47:19'),
(129, 'User bernama didaarfiana telah login', '2024-02-29 03:54:00'),
(130, 'User bernama didaarfiana telah login', '2024-02-29 06:33:28'),
(131, 'User bernama didaarfiana telah login', '2024-02-29 11:46:43'),
(132, 'User didaarfiana telah menambahkan buku berjudul Justina Xie Album (Limited Edition)', '2024-02-29 17:20:37'),
(133, 'User bernama nanasmadu telah login', '2024-02-29 17:27:42'),
(134, 'User bernama didaarfiana telah login', '2024-02-29 17:35:44'),
(135, 'User bernama nanasmadu telah login', '2024-02-29 17:45:03'),
(136, 'User bernama didaarfiana telah login', '2024-02-29 17:45:49'),
(137, 'User bernama nanasmadu telah login', '2024-02-29 17:46:30'),
(138, 'User bernama nanasmadu telah login', '2024-03-01 01:15:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoribuku`
--

CREATE TABLE `kategoribuku` (
  `kategoriID` int(11) NOT NULL,
  `namakategori` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoribuku`
--

INSERT INTO `kategoribuku` (`kategoriID`, `namakategori`, `created_at`) VALUES
(1, 'Sejarah', '2024-02-20 13:43:06'),
(2, 'Pengetahuan', '2024-02-20 13:43:06'),
(3, 'Novel', '2024-02-20 13:43:27'),
(4, 'Psikologi', '2024-02-20 13:43:06'),
(5, 'Sains', '2024-01-30 14:48:58'),
(6, 'Sosial', '2024-02-20 13:43:06'),
(7, 'Komik', '2024-02-20 13:43:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksipribadi`
--

CREATE TABLE `koleksipribadi` (
  `koleksiID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bukuID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `koleksipribadi`
--

INSERT INTO `koleksipribadi` (`koleksiID`, `userID`, `bukuID`, `created_at`) VALUES
(9, 55, 6, '2024-02-13 04:46:23'),
(12, 55, 12, '2024-02-13 07:29:21'),
(13, 55, 18, '2024-02-13 07:29:27'),
(18, 16, 5, '2024-02-13 12:23:43'),
(23, 16, 19, '2024-02-13 16:01:50'),
(25, 16, 21, '2024-02-13 16:58:03'),
(30, 16, 8, '2024-02-14 14:00:32'),
(37, 55, 19, '2024-02-18 03:59:15'),
(38, 55, 15, '2024-02-18 03:59:22'),
(39, 16, 3, '2024-02-20 00:54:56'),
(40, 16, 12, '2024-02-20 01:49:42'),
(41, 56, 18, '2024-02-20 16:12:46'),
(42, 56, 4, '2024-02-20 16:12:56'),
(43, 56, 3, '2024-02-20 16:13:05'),
(44, 56, 27, '2024-02-20 16:13:16'),
(45, 56, 19, '2024-02-20 16:13:47'),
(47, 16, 4, '2024-02-28 15:06:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `peminjamanID` int(11) NOT NULL,
  `perpusID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bukuID` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status_pinjam` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`peminjamanID`, `perpusID`, `userID`, `bukuID`, `tanggal_pinjam`, `tanggal_kembali`, `status_pinjam`, `created_at`) VALUES
(9, 2, 16, 12, '2024-02-18', '2024-02-19', 'dikembalikan', '2024-02-19 03:05:09'),
(21, 2, 55, 21, '2024-02-18', '2024-02-20', 'dikembalikan', '2024-02-20 01:33:40'),
(26, 2, 55, 19, '2024-02-18', '2024-02-18', 'dikembalikan', '2024-02-18 15:13:51'),
(27, 2, 55, 11, '2024-02-18', '2024-02-20', 'dikembalikan', '2024-02-20 01:33:58'),
(32, 2, 55, 19, '2024-02-18', '2024-02-18', 'dikembalikan', '2024-02-18 15:16:12'),
(34, 2, 16, 19, '2024-02-19', '2024-02-20', 'dikembalikan', '2024-02-20 02:27:29'),
(44, 2, 55, 19, '2024-02-20', '2024-02-20', 'dikembalikan', '2024-02-20 15:39:06'),
(65, 2, 16, 5, '2024-02-29', '2024-02-29', 'dikembalikan', '2024-02-29 12:17:17'),
(66, 2, 16, 5, '2024-02-29', '2024-02-29', 'dikembalikan', '2024-02-29 14:02:25'),
(67, 2, 16, 12, '2024-02-29', '2024-02-29', 'dikembalikan', '2024-02-29 16:03:31'),
(68, 2, 16, 5, '2024-02-29', '0000-00-00', 'dipinjam', '2024-02-29 16:09:15'),
(69, 2, 16, 3, '2024-02-29', '2024-03-01', 'dikembalikan', '2024-02-29 17:24:58'),
(70, 2, 16, 7, '2024-02-29', '0000-00-00', 'dipinjam', '2024-02-29 16:10:30'),
(71, 2, 16, 32, '2024-02-29', '2024-03-01', 'dikembalikan', '2024-02-29 17:46:05'),
(72, 2, 55, 3, '2024-03-01', '0000-00-00', 'dipinjam', '2024-03-01 01:35:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perpus`
--

CREATE TABLE `perpus` (
  `perpusID` int(11) NOT NULL,
  `nama_perpus` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tlp_hp` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perpus`
--

INSERT INTO `perpus` (`perpusID`, `nama_perpus`, `alamat`, `tlp_hp`, `created_at`) VALUES
(2, 'Perpustakaan Banjar', 'Jl. Purnomo Sidi No.79', '807717938773', '2024-01-21 14:03:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasanbuku`
--

CREATE TABLE `ulasanbuku` (
  `ulasanID` int(11) NOT NULL,
  `peminjamanID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bukuID` int(11) NOT NULL,
  `ulasan` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ulasanbuku`
--

INSERT INTO `ulasanbuku` (`ulasanID`, `peminjamanID`, `userID`, `bukuID`, `ulasan`, `rating`, `created_at`) VALUES
(10, 9, 16, 12, 'Ditunggu sequel selanjutnyaa yahh, seru banget ceritanya apalagi lihat Xiao Yan lagi berantem ama medusa wkwkwk', 4, '2024-02-20 01:32:20'),
(11, 9, 16, 12, '', 5, '2024-02-20 01:38:05'),
(12, 34, 16, 19, 'Ga nyangka JKT 48 bakal ngerilis buku album member merekaa!! apalagi yang dirilis album Freya cuyyy!! auto melekk gue baca setiap halamannya, wangy2 jirrr bukunya juga, banyak foto istri gue (freya) ', 5, '2024-02-20 02:31:01'),
(13, 26, 55, 19, 'Still tetep suka sama buku nya walau udh 2 kali baca', 5, '2024-02-20 15:38:08'),
(14, 65, 16, 5, '', 4, '2024-02-29 13:06:05'),
(15, 27, 55, 11, 'Kekuatan saitama OP banget cuyyy, kasih dulu bintang 3 karena grafiknya kurang bagus', 3, '2024-02-29 18:22:02'),
(16, 44, 55, 19, '', 4, '2024-02-29 18:34:02'),
(17, 32, 55, 19, '', 5, '2024-03-01 01:36:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `perpusID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `acces_level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userID`, `perpusID`, `username`, `password`, `email`, `namalengkap`, `no_hp`, `alamat`, `acces_level`, `created_at`) VALUES
(11, 2, 'alijaber', '$2y$10$CaXdtdsasZNZKSeX3gmBmOzWdCBWuWxY/6zSO9yR1TcqU.zuJI4UC', 'alimubarok2gmail.com', 'Ali Mubarok ', '089917732245', 'Dsn Pananjung Barat Rt.01 Rw.01', 'peminjam', '2024-01-24 15:38:56'),
(16, 2, 'didaarfiana', '$2y$10$3huByy/zKFPiaeItaeeo4efHP1pMN0m3.SPNt0B1eGMaOvgG6mZbG', 'didaarfiana05@gmail.com', 'Dida Arfiana', '087717936662', 'Dsn Pananjung Barat RT01 RW 01', 'super_admin', '2024-02-29 01:33:18'),
(55, 2, 'nanasmadu', '$2y$10$SPG/bW7IEdxvaBZKpIIpz.9JhPSTZ8Gx7tHAuwj8oU0cpxMAmW8KC', 'nanasmadu@gmail.com', 'Nanas Muda', '098874859', 'jalan joyo boyo', 'admin', '2024-02-07 01:36:55'),
(56, 2, 'ezipetugas', '$2y$10$3sdt2zeX0Q9QwwKADY86xuAQx7EbL6/aHLCwkiwo4plS0lnUymQ5G', 'fahrezi@gmail.com', 'Fahrezi Putra Bachtiar', '08997866546', 'Sinartanjung,Perum Griya Asri, Jalan Griya Asri 1', 'petugas', '2024-02-20 18:32:20'),
(60, 2, 'dafa', '$2y$10$1/okF2HSQBI4LSncXjRfaOJK6lbpgNYk2do5yzJfHb8uFVf7xiD7C', 'dafayanuar@gmail.com', 'Savage Null Cortex', '08967745465', 'Jln Sinartanjung No. 37', 'peminjam', '2024-02-21 07:09:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`bukuID`),
  ADD KEY `fk_buku_kategoribuku` (`kategoriID`),
  ADD KEY `fk_buku_perpus` (`perpusID`);

--
-- Indeks untuk tabel `c_logs`
--
ALTER TABLE `c_logs`
  ADD PRIMARY KEY (`logsID`);

--
-- Indeks untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  ADD PRIMARY KEY (`kategoriID`);

--
-- Indeks untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD PRIMARY KEY (`koleksiID`),
  ADD KEY `fk_koleksipribadi_user` (`userID`),
  ADD KEY `fk_koleksipribadi_buku` (`bukuID`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`peminjamanID`),
  ADD KEY `fk_peminjaman_user` (`userID`),
  ADD KEY `fk_peminjaman_buku` (`bukuID`),
  ADD KEY `fk_peminjaman_perpus` (`perpusID`);

--
-- Indeks untuk tabel `perpus`
--
ALTER TABLE `perpus`
  ADD PRIMARY KEY (`perpusID`);

--
-- Indeks untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD PRIMARY KEY (`ulasanID`),
  ADD KEY `fk_ulasanbuku_user` (`userID`),
  ADD KEY `fk_ulasanbuku_buku` (`bukuID`),
  ADD KEY `fk_ulasanbuku_peminjaman` (`peminjamanID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `fk_user_perpus` (`perpusID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `bukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `c_logs`
--
ALTER TABLE `c_logs`
  MODIFY `logsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT untuk tabel `kategoribuku`
--
ALTER TABLE `kategoribuku`
  MODIFY `kategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  MODIFY `koleksiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `peminjamanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `perpus`
--
ALTER TABLE `perpus`
  MODIFY `perpusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  MODIFY `ulasanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategoribuku` FOREIGN KEY (`kategoriID`) REFERENCES `kategoribuku` (`kategoriID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_buku_perpus` FOREIGN KEY (`perpusID`) REFERENCES `perpus` (`perpusID`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD CONSTRAINT `fk_koleksipribadi_buku` FOREIGN KEY (`bukuID`) REFERENCES `buku` (`bukuID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_koleksipribadi_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_buku` FOREIGN KEY (`bukuID`) REFERENCES `buku` (`bukuID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_perpus` FOREIGN KEY (`perpusID`) REFERENCES `perpus` (`perpusID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD CONSTRAINT `fk_ulasanbuku_buku` FOREIGN KEY (`bukuID`) REFERENCES `buku` (`bukuID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ulasanbuku_peminjaman` FOREIGN KEY (`peminjamanID`) REFERENCES `peminjaman` (`peminjamanID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ulasanbuku_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_perpus` FOREIGN KEY (`perpusID`) REFERENCES `perpus` (`perpusID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
