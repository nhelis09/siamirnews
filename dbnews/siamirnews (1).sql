-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2024 pada 06.32
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siamirnews`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL,
  `kategori` char(1) NOT NULL COMMENT '1 input, 2 approve\r\n',
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `telepon` text NOT NULL,
  `jeniskelamin` char(1) NOT NULL,
  `alamat` text NOT NULL,
  `tempatlahir` text NOT NULL,
  `tanggallahir` date NOT NULL,
  `status` char(1) NOT NULL COMMENT '0 tidak aktif, 1 aktif',
  `password` text NOT NULL,
  `idportal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`idadmin`, `kategori`, `nama`, `email`, `telepon`, `jeniskelamin`, `alamat`, `tempatlahir`, `tanggallahir`, `status`, `password`, `idportal`) VALUES
(1, '1', 'KORNELIS ANDRIAN KABO', 'andyapc09@gmail.com', '082237487497', '1', 'LEWOLEBA Lembata Jalan trans atadei lusikawak', 'lewoleba', '2024-03-23', '2', '12', 0),
(2, '1', 'Nhellys Rmx', 'bastianlenggu11072003@gmail.com', '082237487497', '1', 'LEWOLEBA Lembata Jalan trans atadei lusikawak', 'Alakw', '2024-03-23', '1', '845003', NULL),
(4, '1', 'IMACULATA DELSI BEDA', 'Delsybeda2804@gmail.com', '1234', '2', 'kayu putih', 'kupang', '2024-04-04', '1', '192994', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `idberita` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `idadmin` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `tanggalpublikasi` date NOT NULL,
  `status` char(1) NOT NULL COMMENT '1=draft, 2=publikasi, 3=arsip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`idberita`, `tanggal`, `idadmin`, `idkategori`, `judul`, `isi`, `tanggalpublikasi`, `status`) VALUES
(1, '2024-02-29 03:47:04', 1, 1, 'Jokowi Effect di Pilpres 2024 Disebut Berkaitan Dengan Nama yang Sensitif', 'Jokowi Effect di Pilpres 2024 Disebut Berkaitan Dengan Nama yang Sensitif', '2024-02-28', '2'),
(2, '2024-02-29 03:37:28', 1, 1, 'Saat Gus Ipul Sampaikan \'Pesan dari TPS\' Agar PKB Segera Merapat ke Prabowo', 'Sekjen PBNU Saifullah Yusuf yang akrab disapa Gus Ipul kembali menyampaikan pesan kepada PKB. Kali ini dia menyampaikan pesan yang diklaim dari Tempat Pemungutan Suara (TPS).\nPesan pertama dari TPS itu, kata Gus Ipul, meminta untuk PKB menerima hasil Pemilu 2024. Terutama berkaitan dengan hasil Pilpres yang mana pemenangnya adalah Prabowo-Gibran.\n\n\"Pesan dari TPS, PKB harus menerima hasil pemilu. Ini bukan pesan dari siapa-siapa. Jangan dibalik-balik,\" ujar Gus Ipul di sela-sela Karnaval Kebonsari, Kota Pasuruan, Minggu (25/2/2024).\n', '2024-01-31', '2'),
(3, '2024-03-06 17:32:27', 1, 4, 'Tunjukkan Solidaritas Kemanusiaan, Ribuan Pelari Ikuti “Indonesia Run ', 'Sekitar dua ribu lebih masyarakat ambil bagian dalam kegiatan “Indonesia Run For Palestine”, Minggu (25/2) pagi. Kegiatan lari dalam rangka solidaritas kemanusiaan untuk Palestina ini dibuka dan dilepas di lapangan Graha Kementerian Pemuda dan Olahraga Republik Indonesia (Kemenpora RI), Jalan Gerbang Pemuda Nomor 3, Senayan.Deputi Bidang Pemberdayaan Pemuda Asrorun Ni’am Sholeh mewakili Menpora Dito Ariotedjo membuka dan melepas para peserta lari. Deputi menyampaikan terima kasih kepada masyarakat yang ikut berpartisipasi dalam kegiatan lari santai ini. Menurut Deputi Ni’am, kehadiran ribuan peserta ini menunjukkan posisi Indonesia dalam mendukung kemerdekaan Palestina.', '2024-01-31', '2'),
(4, '2024-03-05 16:30:20', 1, 1, 'Ini Sumber Duit Bangun Rumah Mewah Menteri di IKN', 'Beberapa pejabat hingga menteri akan mulai bekerja di Ibu Kota Nusantara (IKN). Untuk itu, beberapa fasilitas yang akan digunakan mereka telah dibangun.\n\nPembangunan fasilitas tersebut menggunakan biaya yang tidak sedikit. Lantas dari mana sumber pendanaan yang digunakan untuk membangun IKN. Pertama dari APBN, hybrid antara APBN dan sumber lain, serta sumber lain yang sah.', '2024-01-30', '2'),
(5, '2024-03-05 16:31:20', 1, 1, 'Pemkab Mojokerto Salurkan BLT DBHCHT ke 142 Buruh Pabrik Rokok dan 211 KPM', 'Pemerintah Kabupaten (Pemkab) Mojokerto menyalurkan bantuan langsung tunai (BLT) kepada 142 buruh pabrik rokok yang bekerja diluar daerah Kabupaten Mojokerto dan 211 keluarga penerima manfaat (KPM) di Eks Pembantu Bupati wilayah Mojokerto. Dana bantuan tersebut berasal dari dari Dana Bagi Hasil Cukai Hasil Tembakau (DBHCHT).Sebanyak 142 buruk pabrik dan 211 KPM menerima BLT senilai total Rp 1.800.000 yang disalurkan secara bertahap Rp 300.000 selama 6 bulan.  Adapun KPM penerima BLT meliputi ibu hamil KEK, balita kurang gizi, lansia, disabilitas dan usia produktif yang perlu ditingkatkan ekonominya.', '2024-02-09', '2'),
(26, '2024-04-05 14:10:08', 1, 1, 'Ia mengatakan pembahasan masih seputar program besar atau pagu besar', 'Ia mengatakan pembahasan masih seputar program besar atau pagu besar', '2024-04-05', '2'),
(30, '2024-04-05 18:23:11', 1, 1, 'Bakal Pimpin Para Seniornya di TNI AU, KSAU ', 'Bakal Pimpin Para Seniornya di TNI AU, KSAU Tonny: Saya Yakin Mereka Hargai Posisi Saya', '2024-04-06', '2'),
(32, '2024-04-05 19:59:16', 1, 1, 'PPATK Ungkap Banyak Modus Usai Semua Aset Suami Sandra Dewi Disita', 'PPATK Ungkap Banyak Modus Usai Semua Aset Suami Sandra Dewi Disita', '2024-04-06', '2'),
(33, '2024-04-05 20:45:55', 1, 4, 'Gia Main di Proliga 2024, Bakal Jadi Rival Megawati', 'Gia Main di Proliga 2024, Bakal Jadi Rival Megawati', '2024-04-07', '3'),
(34, '2024-04-05 20:49:11', 1, 4, 'Lawan Saudi, Timnas Indonesia U-23 Hanya Diperkuat 2 Naturalisasi', 'Lawan Saudi, Timnas Indonesia U-23 Hanya Diperkuat 2 Naturalisasi', '2024-04-09', '1'),
(36, '2024-04-05 20:57:17', 1, 4, 'Peringatan Legenda: Lee Zii Jia Harus Main Thomas Cup', 'Peringatan Legenda: Lee Zii Jia Harus Main Thomas Cup', '2024-04-12', '3'),
(37, '2024-04-05 20:59:50', 1, 4, '\"Turnamen Piala Thomas adalah turnamen besar dan kebanggaan negara dipertaruhkan.\"', '\"Turnamen Piala Thomas adalah turnamen besar dan kebanggaan negara dipertaruhkan.\"', '2024-04-09', '3'),
(38, '2024-04-05 21:03:05', 1, 7, 'aturan Baru Menteri Nadiem: Pramuka Tak Lagi Jadi Ekskul Wajib bagi Siswa', 'turan Baru Menteri Nadiem: Pramuka Tak Lagi Jadi Ekskul Wajib bagi Siswa', '2024-04-12', '2'),
(39, '2024-04-05 21:07:23', 1, 8, 'Apa yang Bisa Dilakukan Jika Harimau Jawa Belum Punah?', 'Bagaimana jika harimau Jawa masih ada? Penemuan kembali harimau Jawa akan menjadi berita yang luar biasa dan akan memberikan harapan baru untuk spesies ikonik ini. Meskipun harimau Jawa secara resmi dinyatakan punah, ada harapan bahwa spesies ini masih hidup di alam liar. Jika harimau Jawa belum punah, beberapa hal seperti penelitian, konservasi, dan edukasi dapat dilakukan untuk mempelajari lebih lanjut mengenai kemunculan satwa tersebut. 1. Penelitian Didik Raharyono, Direktur Peduli Karnivora Jawa saat diskusi FOKSI mengenai &quot;Kembalinya Sang Predator Terbesar Hutan Jawa&quot; pada Rabu (3/4/2024) mengatakan, penelitian yang dapat dilakukan tidak hanya seputar satwa itu sendiri, tetapi juga mengenai hubungan masyarakat sekitar tempat ditemukannya harimau. Kearifan apa yang memungkinkan harimau masih ada di daerah itu? Bahaimana respon warga jika terbukti ada keberadaan harimau Jawa di daerahnya? Jika dijadikan sebagai objek wisata, harus seperti apa regulasinya? Kemunculan harimau Jawa akan menghidupkan kembali tradisi yang berkaitan dengan satwa besar tersebut. Upaya penelitian juga dapat digunakan untuk memastikan populasi harimau Jawa, habitat, dan perilakunya. Hal ini akan membantu dalam mengembangkan strategi konservasi yang efektif. Baca juga: Mirip Harimau Jawa Berhasil Dipotret Warga Pinggiran Hutan 2. Konservasi Konservasi dapat dilakukan dengan melindungi habitat, seperti penataan kawasan hutan, penegakan hukum terhadap perambahan hutan, dan program reboisasi. Program penangkaran juga dapat dilakukan untuk meningkatkan populasi harimau Jawa dan mempersiapkan reintroduksi ke alam liar. Jika harimau Jawa benar-benar masih ada, maka upaya konservasi yang intensif akan diperlukan untuk memastikan kelangsungan hidup spesies ini.  3. Edukasi Edukasi dilakukan untuk meningkatkan kesadaran masyarakat mengenai pentingnya harimau Jawa dan perannya dalam ekosistem. Hal tersebut juga sebagai upaya menghindari perburuan liar terhadap satwa yang dilindungi. Upaya pelestarian harimau Jawa memerlukan kerjasama semua pihak. Baik pemerintah dan masyarakat dibutuhkan untuk ikut berpartisipasi melestarikan populasinya.', '2024-04-20', '2'),
(40, '2024-04-05 21:10:45', 1, 3, 'Sinopsis CJ7, Bioskop Trans TV 5 April 2024', 'hari ini, Jumat (5/4), akan menayangkan film CJ7 (2008) pada pukul 21.45 WIB. Berikut sinopsis CJ7 yang dibintangi Stephen Chow dan Xu Jiao. Film ini menyelami kehidupan seorang buruh konstruksi miskin bernama Chow Ti (Stephen Chow). Dia tinggal dengan anaknya, Dicky (Xu Jiao), di rumah usang yang sebagian telah rusak karena dibongkar.', '2024-04-20', '2'),
(41, '2024-04-05 21:15:24', 1, 3, 'Dragon Ball dan Hidup Abadi Akira Toriyama', 'Sekitar satu bulan setelah Akira Toriyama meninggal, Goku pergi ke rumah Burma untuk meminjam radar Dragon Ball. Ia lalu berusaha secepatnya mengumpulkan tujuh bola naga yang tersebar di seluruh penjuru dunia. Tujuannya satu, menghidupkan kembali Akira Toriyama bertepatan dengan hari ulang tahunnya, 5 April.  Dalam dunia Dragon Ball ciptaan Akira Toriyama, hidup abadi adalah salah satu fantasi yang dimiliki oleh beberapa tokoh di dalamnya. Bezita dan Freeza adalah dua tokoh yang punya mimpi hidup abadi lewat Dragon Ball.  Bezita ingin hidup abadi demi bisa punya kesempatan tak terbatas untuk mengalahkan Freeza. Sedangkan Freeza ingin hidup abadi demi bisa menguasai alam semesta untuk kurun waktu yang lama.  Tak satu pun dari dua keinginan fantastis itu bisa terwujud.  ADVERTISEMENT  Dragon Ball adalah dunia luar biasa yang diciptakan Akira Toriyama. Dragon Ball seolah jadi pintu pembuka yang menarik minat banyak orang di seluruh dunia untuk menyelami dan menikmati serbuan manga Jepang di periode-periode berikutnya.  Dragon Ball menawarkan cerita yang menarik, fantastis, dan melekat kuat dan terus diingat. Dragon Ball adalah cerita yang diawali pertemuan Goku dengan Bulma. Goku memiliki bola bintang empat yang merupakan peninggalan dari sang kakek. Dari pertemuan tak terduga tersebut, cerita berkembang luas. Musuh-musuh dihadapi oleh Goku dan Burma. Mulai dari Pilaf hingga Red Ribbon di awal cerita, musuh-musuh Goku dan teman-teman makin menarik diikuti seiring cerita berjalan.  Kebangkitan Pikkoro, lalu disusul kenyataan bahwa Goku ternyata manusia luar angkasa yang berasal dari Planet Saiya, ditambah kedatangan Radit yang merupakan kakak kandung Goku, membuat Dragon Ball makin susah untuk ditinggalkan.  Banyak momen-momen indah yang punya kesan mendalam yang tetap terus diingat meski lembar-lembar komik Dragon Ball tersebut tak lagi pernah dibuka.  Goku yang rela mati bersama Radit demi menyelamatkan bumi. Pikkoro yang merupakan musuh besar namun kemudian malah menghabiskan waktu melatih Son Gohan. Bezita, sang pangeran Saiya, yang memohon jelang ajalnya dan meminta Goku mengalahkan Freeza demi harga diri Bangsa Saiya.', '2024-04-25', '3'),
(42, '2024-04-05 21:20:08', 1, 3, 'Gina S Noer Bawa Isu Viral Soal Pernikahan dalam Dua Hati Biru', 'Gina S Noer mengakui sejumlah isu keluarga yang ramai dibahas oleh masyarakat Indonesia beberapa waktu terakhir turut menjadi inspirasi untuk Dua Hati Biru. Berbeda dengan Dua Garis Biru, Dua Hati Biru akan fokus pada kisah kelanjutan Dara juga Bima yang bersama-sama mengasuh anak mereka, Adam.  \"Nah ini adalah kisah keluarga yang walaupun mereka tahu mereka enggak sempurna, mereka sangat sangat berjuang untuk menyatukan hubungan mereka, untuk mengeratkan diri, untuk menjaga hubungan mereka,\" kata Gina di Jakarta, Kamis (4/4).  \"Jadi dengan semangat itu, apalagi saya rasa kita sekarang ada di negara yang sering banget disebut fatherless nation, kayak di mana bapak yang belum tentu dibiasakan hadir, kadang-kadang mau hadir juga enggak mengerti bagaimana caranya,\" kata kreator saga tersebut.  Baca artikel CNN Indonesia \"Gina S Noer Bawa Isu Viral Soal Pernikahan dalam Dua Hati Biru\" selengkapnya di sini: https://www.cnnindonesia.com/hiburan/20240405202712-220-1083610/gina-s-noer-bawa-isu-viral-soal-pernikahan-dalam-dua-hati-biru.', '2024-04-27', '1'),
(44, '2024-04-08 10:30:08', 1, 2, 'ekonomi', 'ekonomi', '2024-04-08', '1'),
(45, '2024-04-08 10:31:19', 1, 6, 'Tugas 6', 'ok siap', '2024-04-09', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoriberita`
--

CREATE TABLE `kategoriberita` (
  `idkategori` int(11) NOT NULL,
  `nama` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoriberita`
--

INSERT INTO `kategoriberita` (`idkategori`, `nama`, `keterangan`) VALUES
(1, 'Politik', 'Berita tentang kebijakan pemerintah, pemilihan umum, dan isu-isu politik lainnya'),
(2, 'Ekonomi', 'Berita tentang kondisi ekonomi, pasar saham, dan isu-isu ekonomi lainnya'),
(3, 'Hiburan', 'Berita tentang dunia hiburan seperti film, musik, selebriti, dan lainnya'),
(4, 'Olahraga', 'Berita tentang pertandingan olahraga, profil atlet, dan isu-isu olahraga lainnya'),
(5, 'Teknologi', 'Berita tentang perkembangan teknologi terbaru, review produk, dan isu-isu teknologi lainnya'),
(6, 'Kesehatan', 'Berita tentang tips kesehatan, penelitian medis terbaru, dan isu-isu kesehatan lainnya'),
(7, 'Pendidikan', 'Berita tentang sistem pendidikan, beasiswa, dan isu-isu pendidikan lainnya'),
(8, 'Sains', 'Berita tentang penemuan dan penelitian sains terbaru'),
(9, 'Internasional', 'Berita tentang peristiwa dan isu-isu yang terjadi di luar negeri'),
(10, 'Kemahasiswaan', 'Berita tentang kegiatan kemahasiswaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar1`
--

CREATE TABLE `komentar1` (
  `idkomentar1` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `idberita` int(11) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `komentar1`
--

INSERT INTO `komentar1` (`idkomentar1`, `tanggal`, `idberita`, `isi`) VALUES
(5, '2024-03-07 01:32:55', 2, 'selamat datang'),
(7, '2024-03-09 03:23:46', 1, 'hallo'),
(11, '2024-03-13 08:30:51', 1, 'hebat'),
(13, '2024-03-13 08:53:40', 4, 'asik'),
(15, '2024-03-13 09:17:32', 5, 'mantap'),
(17, '2024-03-13 13:00:22', 5, 'mantap'),
(21, '2024-03-29 06:33:09', 2, 'ok siap'),
(32, '2024-03-29 08:08:56', 4, 'komentar'),
(33, '2024-04-01 13:46:53', 4, 'ini sumber duit ikn'),
(34, '2024-04-01 13:48:06', 3, 'mantap solidaritas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar2`
--

CREATE TABLE `komentar2` (
  `idkomentar2` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idkomentar1` int(11) NOT NULL,
  `idberita` int(11) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `komentar2`
--

INSERT INTO `komentar2` (`idkomentar2`, `tanggal`, `idkomentar1`, `idberita`, `isi`) VALUES
(12, '2024-03-13 10:07:43', 7, 1, 'balasan komentar hallo jokowi'),
(13, '2024-03-13 10:10:29', 11, 1, 'balasan komentar hebat jokowi'),
(16, '2024-03-13 12:53:47', 11, 1, 'ada juga hebat'),
(17, '2024-03-13 12:55:23', 7, 1, 'asik'),
(18, '2024-03-13 12:58:33', 15, 5, 'mantap juga'),
(19, '2024-03-13 13:00:32', 17, 5, 'mantap juga 2'),
(20, '2024-03-13 13:47:10', 13, 4, 'qw'),
(21, '2024-03-13 13:54:00', 13, 4, 'balas asik 2'),
(22, '2024-03-13 14:12:44', 7, 1, 'balas hallo'),
(23, '2024-03-13 14:13:33', 5, 2, 'mantap'),
(24, '2024-03-14 05:32:44', 11, 1, 'wer'),
(25, '2024-03-20 06:45:57', 5, 2, 'qwer'),
(30, '2024-03-29 06:28:38', 5, 2, 'balasakn komentar'),
(31, '2024-03-29 08:07:38', 11, 1, 'balasakn komentar jokowi'),
(32, '2024-03-29 08:09:08', 32, 4, 'balasan'),
(34, '2024-04-01 13:47:27', 33, 0, 'wow besar banget duitnya'),
(42, '2024-04-01 14:09:35', 33, 4, 'ini sumber duit ikn 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal`
--

CREATE TABLE `portal` (
  `idportal` int(11) NOT NULL,
  `nama` text NOT NULL,
  `telepon` text NOT NULL,
  `email` text NOT NULL,
  `penanggungjawab` text NOT NULL,
  `alamat` text NOT NULL,
  `petalokasi` text NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `portal`
--

INSERT INTO `portal` (`idportal`, `nama`, `telepon`, `email`, `penanggungjawab`, `alamat`, `petalokasi`, `status`) VALUES
(1, 'Kornelis Andrian Kabo', '0823238782', 'nhellys@gmail.com', 'yosafat funome', 'alak', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3927.216770432682!2d123.62013377333965!3d-10.163027609689982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c56834e0db12415%3A0x4adc2c26430f6087!2sSTIKOM%20Uyelindo%20Kupang!5e0!3m2!1sid!2sid!4v1709789572962!5m2!1sid!2sid\" width=\"100%\" height=\"200\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil`
--

CREATE TABLE `profil` (
  `idprofil` int(11) NOT NULL,
  `isiprofil` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profil`
--

INSERT INTO `profil` (`idprofil`, `isiprofil`) VALUES
(1, '\nSelamat Datang\n\"Buana Uyelindo\" adalah portal berita online yang membawa Anda menjelajahi dunia. Kami menyediakan berita terkini dan terpercaya dari berbagai bidang, termasuk politik, ekonomi, teknologi, olahraga, dan budaya. Dengan nama \"Buana\", yang berarti \"dunia\" dalam Bahasa Indonesia, kami berkomitmen untuk memberikan perspektif global pada setiap berita yang kami sajikan. \"Uyelindo\" adalah identitas kami, sebuah nama yang mencerminkan dedikasi kami untuk integritas dan kebenaran dalam jurnalisme. Bergabunglah dengan kami di \"Buana Uyelindo\" untuk menjelajahi dunia melalui berita.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `superadmin`
--

CREATE TABLE `superadmin` (
  `idsuperadmin` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `superadmin`
--

INSERT INTO `superadmin` (`idsuperadmin`, `nama`, `email`, `password`) VALUES
(1, 'Kornelis', 'andyapc09@gmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`idberita`);

--
-- Indeks untuk tabel `kategoriberita`
--
ALTER TABLE `kategoriberita`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indeks untuk tabel `komentar1`
--
ALTER TABLE `komentar1`
  ADD PRIMARY KEY (`idkomentar1`);

--
-- Indeks untuk tabel `komentar2`
--
ALTER TABLE `komentar2`
  ADD PRIMARY KEY (`idkomentar2`);

--
-- Indeks untuk tabel `portal`
--
ALTER TABLE `portal`
  ADD PRIMARY KEY (`idportal`);

--
-- Indeks untuk tabel `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`idprofil`);

--
-- Indeks untuk tabel `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`idsuperadmin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `idberita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `kategoriberita`
--
ALTER TABLE `kategoriberita`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `komentar1`
--
ALTER TABLE `komentar1`
  MODIFY `idkomentar1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `komentar2`
--
ALTER TABLE `komentar2`
  MODIFY `idkomentar2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
