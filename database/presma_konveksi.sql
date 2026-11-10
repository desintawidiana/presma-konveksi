-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 29, 2026 at 09:19 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presma_konveksi`
--

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `catat_perubahan` (IN `p_tabel` VARCHAR(50), IN `p_id` BIGINT, IN `p_kolom` VARCHAR(50), IN `p_lama` TEXT, IN `p_baru` TEXT)   BEGIN
  INSERT INTO riwayat_perubahan(nama_tabel, id_data, kolom, nilai_lama, nilai_baru, diubah_oleh)
  VALUES (p_tabel, p_id, p_kolom, p_lama, p_baru, @id_pengguna);
END$$

CREATE PROCEDURE `cek_order_belum_diinvoice` (IN `p_pesanan` BIGINT)   BEGIN
  IF EXISTS (SELECT 1 FROM invoice WHERE pesanan_id = p_pesanan) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Harga dan rincian ukuran dikunci setelah invoice dibuat. Batalkan invoice lebih dulu bila perlu koreksi';
  END IF;
END$$

CREATE PROCEDURE `cek_pembelian_terbuka` (IN `p_pembelian` BIGINT)   BEGIN
  IF (SELECT status FROM pembelian WHERE id = p_pembelian) <> 'DIAJUKAN' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Item pembelian hanya bisa diubah saat status DIAJUKAN';
  END IF;
END$$

CREATE PROCEDURE `ubah_tahap_produksi` (IN `p_pesanan` BIGINT, IN `p_tahap` VARCHAR(40), IN `p_catatan` TEXT, IN `p_user` BIGINT)   BEGIN
  DECLARE v_user_lama BIGINT;
  DECLARE v_catatan_lama TEXT;
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    SET @id_pengguna = v_user_lama;
    SET @catatan = v_catatan_lama;
    RESIGNAL;
  END;
  SET v_user_lama = @id_pengguna;
  SET v_catatan_lama = @catatan;
  SET @id_pengguna = p_user;
  SET @catatan = p_catatan;
  UPDATE pesanan SET tahap_saat_ini = p_tahap WHERE id = p_pesanan;
  SET @id_pengguna = v_user_lama;
  SET @catatan = v_catatan_lama;
END$$

--
-- Functions
--
CREATE FUNCTION `normalisasi_hp` (`p` VARCHAR(40)) RETURNS VARCHAR(40) CHARSET utf8mb4 DETERMINISTIC BEGIN
  DECLARE d VARCHAR(40);
  SET d = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(p, ''), ' ', ''), '-', ''), '+', ''), '(', ''), ')', ''), '.', '');
  IF d LIKE '0%' THEN
    RETURN CONCAT('62', SUBSTRING(d, 2));
  ELSEIF d LIKE '8%' THEN
    RETURN CONCAT('62', d);
  END IF;
  RETURN d;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` bigint NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_bahan` varchar(50) DEFAULT NULL,
  `warna` varchar(50) NOT NULL DEFAULT '',
  `satuan` varchar(20) NOT NULL DEFAULT 'meter',
  `stok_minimum` decimal(12,2) NOT NULL DEFAULT '0.00',
  `supplier_id` bigint DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_desain`
--

CREATE TABLE `file_desain` (
  `id` bigint NOT NULL,
  `pesanan_id` bigint NOT NULL,
  `nama_file` varchar(200) NOT NULL,
  `lokasi_file` varchar(500) NOT NULL,
  `diunggah_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` bigint NOT NULL,
  `pesanan_id` bigint NOT NULL,
  `nomor_invoice` varchar(30) NOT NULL DEFAULT '',
  `deskripsi_produk` varchar(255) NOT NULL DEFAULT '',
  `tanggal_invoice` date NOT NULL DEFAULT (curdate()),
  `dibuat_oleh` bigint DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `invoice`
--
DELIMITER $$
CREATE TRIGGER `invoice_sebelum_delete` BEFORE DELETE ON `invoice` FOR EACH ROW BEGIN
  IF EXISTS (SELECT 1 FROM pembayaran WHERE pesanan_id = OLD.pesanan_id)
     OR EXISTS (SELECT 1 FROM work_order WHERE pesanan_id = OLD.pesanan_id) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invoice tidak dapat dibatalkan karena sudah ada pembayaran atau Work Order';
  END IF;
  CALL catat_perubahan('invoice', OLD.pesanan_id, 'invoice.DIBATALKAN', OLD.nomor_invoice, NULL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `invoice_sebelum_insert` BEFORE INSERT ON `invoice` FOR EACH ROW BEGIN
  DECLARE v_status VARCHAR(20);
  DECLARE v_kode VARCHAR(30);
  DECLARE v_harga DECIMAL(14,2);
  DECLARE v_deskripsi VARCHAR(255);
  DECLARE v_jumlah INT;

  SELECT p.status_order, CONCAT(p.id, '_', p.hp_4_digit), p.harga_satuan,
         UPPER(CONCAT(p.jenis_produk, COALESCE(CONCAT(' - ', s.bahan), '')))
    INTO v_status, v_kode, v_harga, v_deskripsi
    FROM pesanan p LEFT JOIN spesifikasi_pesanan s ON s.pesanan_id = p.id
   WHERE p.id = NEW.pesanan_id;
  SELECT COALESCE(SUM(jumlah), 0) INTO v_jumlah FROM ukuran_pesanan WHERE pesanan_id = NEW.pesanan_id;

  IF v_status <> 'DIKONFIRMASI' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invoice hanya bisa dibuat untuk order yang sudah DIKONFIRMASI';
  END IF;
  IF v_harga IS NULL OR v_jumlah <= 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Lengkapi harga satuan dan rincian ukuran/jumlah sebelum membuat invoice';
  END IF;
  SET NEW.nomor_invoice = v_kode;
  SET NEW.deskripsi_produk = v_deskripsi;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_bahan`
--

CREATE TABLE `kebutuhan_bahan` (
  `id` bigint NOT NULL,
  `work_order_id` bigint NOT NULL,
  `bahan_id` bigint NOT NULL,
  `jumlah_dibutuhkan` decimal(12,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` bigint NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_whatsapp` varchar(20) NOT NULL,
  `hp_4_digit` char(4) GENERATED ALWAYS AS (right(`no_whatsapp`,4)) STORED,
  `instansi` varchar(200) DEFAULT NULL,
  `sumber_informasi` enum('REKOMENDASI_TEMAN','INSTAGRAM','TIKTOK','IKLAN','FACEBOOK','LAINNYA') DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `no_whatsapp`, `instansi`, `sumber_informasi`, `dibuat_pada`) VALUES
(1, 'Pelanggan Uji', '6281234567890', 'Uji Sistem Presma', 'INSTAGRAM', '2026-10-27 14:28:31');

--
-- Triggers `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `pelanggan_sebelum_insert` BEFORE INSERT ON `pelanggan` FOR EACH ROW BEGIN
  SET NEW.no_whatsapp = normalisasi_hp(NEW.no_whatsapp);
  IF NEW.no_whatsapp NOT REGEXP '^62[0-9]{8,13}$' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nomor WhatsApp tidak valid (contoh: 085732240729)';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pelanggan_sebelum_update` BEFORE UPDATE ON `pelanggan` FOR EACH ROW BEGIN
  SET NEW.no_whatsapp = normalisasi_hp(NEW.no_whatsapp);
  IF NEW.no_whatsapp NOT REGEXP '^62[0-9]{8,13}$' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nomor WhatsApp tidak valid (contoh: 085732240729)';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint NOT NULL,
  `pesanan_id` bigint NOT NULL,
  `invoice_id` bigint DEFAULT NULL,
  `jenis` enum('DP','PELUNASAN') NOT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `tanggal_bayar` date NOT NULL DEFAULT (curdate()),
  `metode` enum('TRANSFER','TUNAI','QRIS','LAINNYA') NOT NULL DEFAULT 'TRANSFER',
  `keterangan` varchar(255) DEFAULT NULL,
  `dicatat_oleh` bigint DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Triggers `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `pembayaran_sebelum_delete` BEFORE DELETE ON `pembayaran` FOR EACH ROW BEGIN
  DECLARE v_lock BIGINT;
  SELECT id INTO v_lock FROM pesanan WHERE id = OLD.pesanan_id FOR UPDATE;
  CALL catat_perubahan('pembayaran', OLD.pesanan_id, CONCAT('pembayaran_', OLD.id, '.DIHAPUS'),
                       CONCAT(OLD.jenis, ' ', OLD.jumlah), NULL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembayaran_sebelum_insert` BEFORE INSERT ON `pembayaran` FOR EACH ROW BEGIN
  DECLARE v_lock BIGINT;
  DECLARE v_status VARCHAR(20);
  DECLARE v_invoice BIGINT;
  DECLARE v_total DECIMAL(14,2);
  DECLARE v_bayar DECIMAL(14,2);

  -- kunci baris order: pembayaran untuk order yang sama diproses BERURUTAN
  SELECT id, status_order INTO v_lock, v_status FROM pesanan WHERE id = NEW.pesanan_id FOR UPDATE;
  SELECT id INTO v_invoice FROM invoice WHERE pesanan_id = NEW.pesanan_id;
  IF v_invoice IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pembayaran hanya bisa dicatat setelah invoice dibuat';
  END IF;
  IF v_status = 'BATAL' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Order BATAL tidak dapat menerima pembayaran baru';
  END IF;
  SET NEW.invoice_id = v_invoice;

  -- pembacaan TERKUNCI (LOCK IN SHARE MODE = data terbaru yang sudah di-commit, bukan snapshot lama).
  -- Catatan teknis: FOR UPDATE pada tabel yang sedang diubah pemicu dilarang (error 1442), karena itu dipakai SHARE MODE.
  SELECT COALESCE(SUM(jumlah), 0) INTO v_bayar FROM pembayaran WHERE pesanan_id = NEW.pesanan_id LOCK IN SHARE MODE;
  SELECT total_pembayaran INTO v_total FROM v_pembayaran_order WHERE pesanan_id = NEW.pesanan_id;
  IF v_bayar + NEW.jumlah > v_total THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pembayaran melebihi total tagihan order';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembayaran_sebelum_update` BEFORE UPDATE ON `pembayaran` FOR EACH ROW BEGIN
  DECLARE v_lock BIGINT;
  DECLARE v_total DECIMAL(14,2);
  DECLARE v_lain DECIMAL(14,2);

  SELECT id INTO v_lock FROM pesanan WHERE id = OLD.pesanan_id FOR UPDATE;
  SET NEW.pesanan_id = OLD.pesanan_id;
  SET NEW.invoice_id = OLD.invoice_id;

  SELECT total_pembayaran INTO v_total FROM v_pembayaran_order WHERE pesanan_id = OLD.pesanan_id;
  SELECT COALESCE(SUM(jumlah), 0) INTO v_lain FROM pembayaran WHERE pesanan_id = OLD.pesanan_id AND id <> OLD.id LOCK IN SHARE MODE;
  IF v_lain + NEW.jumlah > v_total THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Koreksi pembayaran melebihi total tagihan order';
  END IF;

  IF NOT (NEW.jumlah        <=> OLD.jumlah)        THEN CALL catat_perubahan('pembayaran', OLD.pesanan_id, CONCAT('pembayaran_', OLD.id, '.jumlah'),        OLD.jumlah,        NEW.jumlah);        END IF;
  IF NOT (NEW.jenis         <=> OLD.jenis)         THEN CALL catat_perubahan('pembayaran', OLD.pesanan_id, CONCAT('pembayaran_', OLD.id, '.jenis'),         OLD.jenis,         NEW.jenis);         END IF;
  IF NOT (NEW.tanggal_bayar <=> OLD.tanggal_bayar) THEN CALL catat_perubahan('pembayaran', OLD.pesanan_id, CONCAT('pembayaran_', OLD.id, '.tanggal_bayar'), OLD.tanggal_bayar, NEW.tanggal_bayar); END IF;
  IF NOT (NEW.metode        <=> OLD.metode)        THEN CALL catat_perubahan('pembayaran', OLD.pesanan_id, CONCAT('pembayaran_', OLD.id, '.metode'),        OLD.metode,        NEW.metode);        END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` bigint NOT NULL,
  `supplier_id` bigint DEFAULT NULL,
  `pesanan_id` bigint DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT (curdate()),
  `status` enum('DIAJUKAN','DISETUJUI','DITOLAK','DITERIMA') NOT NULL DEFAULT 'DIAJUKAN',
  `tanggal_diterima` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `diajukan_oleh` bigint DEFAULT NULL,
  `disetujui_oleh` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `pembelian`
--
DELIMITER $$
CREATE TRIGGER `pembelian_sebelum_update` BEFORE UPDATE ON `pembelian` FOR EACH ROW BEGIN
  IF NEW.status <> OLD.status THEN
    IF NOT ((OLD.status = 'DIAJUKAN' AND NEW.status IN ('DISETUJUI', 'DITOLAK'))
         OR (OLD.status = 'DISETUJUI' AND NEW.status IN ('DITERIMA', 'DITOLAK'))) THEN
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Alur status pembelian: DIAJUKAN > DISETUJUI > DITERIMA (atau DITOLAK). DITERIMA dan DITOLAK bersifat final';
    END IF;
    IF NEW.status = 'DISETUJUI' THEN
      SET NEW.disetujui_oleh = COALESCE(NEW.disetujui_oleh, @id_pengguna);
    ELSEIF NEW.status = 'DITERIMA' THEN
      IF NOT EXISTS (SELECT 1 FROM pembelian_item WHERE pembelian_id = OLD.id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pembelian belum memiliki item bahan';
      END IF;
      SET NEW.tanggal_diterima = CURDATE();
      -- jumlah_diterima yang tidak diisi dianggap diterima penuh sesuai pesanan
      UPDATE pembelian_item SET jumlah_diterima = COALESCE(jumlah_diterima, jumlah) WHERE pembelian_id = OLD.id;
      -- stok masuk TEPAT SATU KALI per item (dijaga juga oleh UNIQUE transaksi_bahan.pembelian_item_id)
      INSERT INTO transaksi_bahan(bahan_id, jenis, jumlah, pembelian_item_id, keterangan, dicatat_oleh)
      SELECT bahan_id, 'MASUK', jumlah_diterima, id, CONCAT('Pembelian #', OLD.id), @id_pengguna
        FROM pembelian_item WHERE pembelian_id = OLD.id AND jumlah_diterima > 0;
    END IF;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_item`
--

CREATE TABLE `pembelian_item` (
  `id` bigint NOT NULL,
  `pembelian_id` bigint NOT NULL,
  `bahan_id` bigint NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `jumlah_diterima` decimal(12,2) DEFAULT NULL,
  `harga_satuan` decimal(14,2) NOT NULL
) ;

--
-- Triggers `pembelian_item`
--
DELIMITER $$
CREATE TRIGGER `pembelian_item_sebelum_delete` BEFORE DELETE ON `pembelian_item` FOR EACH ROW BEGIN
  CALL cek_pembelian_terbuka(OLD.pembelian_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembelian_item_sebelum_insert` BEFORE INSERT ON `pembelian_item` FOR EACH ROW BEGIN
  CALL cek_pembelian_terbuka(NEW.pembelian_id);
  SET NEW.jumlah_diterima = NULL;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembelian_item_sebelum_update` BEFORE UPDATE ON `pembelian_item` FOR EACH ROW BEGIN
  DECLARE v_status VARCHAR(20);
  SELECT status INTO v_status FROM pembelian WHERE id = OLD.pembelian_id;
  IF v_status <> 'DIAJUKAN' AND (NOT (NEW.pembelian_id <=> OLD.pembelian_id) OR NOT (NEW.bahan_id <=> OLD.bahan_id)
                                 OR NOT (NEW.jumlah <=> OLD.jumlah) OR NOT (NEW.harga_satuan <=> OLD.harga_satuan)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Item pembelian hanya bisa diubah saat status DIAJUKAN';
  END IF;
  IF NOT (NEW.jumlah_diterima <=> OLD.jumlah_diterima) AND v_status <> 'DISETUJUI' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah diterima hanya bisa diisi saat pembelian berstatus DISETUJUI';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_lain`
--

CREATE TABLE `pengeluaran_lain` (
  `id` bigint NOT NULL,
  `tanggal` date NOT NULL DEFAULT (curdate()),
  `kategori` enum('PRODUKSI','VENDOR','OPERASIONAL','GAJI','LAINNYA') NOT NULL,
  `jumlah` decimal(14,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `pesanan_id` bigint DEFAULT NULL,
  `dicatat_oleh` bigint DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `kata_sandi_hash` varchar(255) NOT NULL,
  `peran` set('OWNER','CS','PRODUKSI') NOT NULL DEFAULT 'CS',
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `kata_sandi_hash`, `peran`, `aktif`, `dibuat_pada`) VALUES
(1, 'Owner Presma', 'owner@presmakonveksi.com', '$2y$12$8OKhBoTJUpXvUMXP2lo4O.cBbiTDtbbgXpVprZVGHXN70UUYdr7pa', 'OWNER', 1, '2026-10-21 04:29:47'),
(2, 'Customer Service Presma', 'cs.order@presmakonveksi.com', '$2y$12$avD7VtshdydgKlJxwzmNd.WhQljTpLqQb2ytQwmTBg00rxJAMZKgC', 'CS', 1, '2026-10-21 04:30:13'),
(3, 'Produksi Presma', 'produksi.spv@presmakonveksi.com', '$2y$12$DBMn/P.2GgO7Py.5llrKdOLRbBH/wFvttLDCtPcnqYrkXXUQQKhRu', 'PRODUKSI', 1, '2026-10-21 04:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint NOT NULL,
  `pelanggan_id` bigint NOT NULL,
  `hp_4_digit` char(4) NOT NULL DEFAULT '',
  `kode_tracking` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `instansi` varchar(200) DEFAULT NULL,
  `jenis_produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `harga_satuan` decimal(14,2) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status_order` enum('BARU','DIKONFIRMASI','BATAL') NOT NULL DEFAULT 'BARU',
  `tahap_saat_ini` varchar(40) NOT NULL DEFAULT 'Order Diterima',
  `dibuat_dari` enum('FORM_CUSTOMER','CS') NOT NULL DEFAULT 'FORM_CUSTOMER',
  `selesai_pada` datetime DEFAULT NULL,
  `catatan_internal` text,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `pelanggan_id`, `hp_4_digit`, `kode_tracking`, `instansi`, `jenis_produk`, `keterangan`, `harga_satuan`, `deadline`, `status_order`, `tahap_saat_ini`, `dibuat_dari`, `selesai_pada`, `catatan_internal`, `dibuat_pada`, `diubah_pada`) VALUES
(1, 1, '7890', '36f338d555df799c444336f509e5b636', 'Uji Sistem Presma', 'Vest', 'Pesanan uji API', '130000.00', '2026-11-15', 'BARU', 'Order Diterima', 'FORM_CUSTOMER', NULL, NULL, '2026-10-27 07:57:49', '2026-10-27 07:57:49');

--
-- Triggers `pesanan`
--
DELIMITER $$
CREATE TRIGGER `pesanan_sebelum_insert` BEFORE INSERT ON `pesanan` FOR EACH ROW BEGIN
  -- 4 digit akhir HP disalin agar KODE ORDER tetap walau HP pelanggan nanti dikoreksi
  SET NEW.hp_4_digit = (SELECT hp_4_digit FROM pelanggan WHERE id = NEW.pelanggan_id);
  IF NEW.instansi IS NULL THEN
    SET NEW.instansi = (SELECT instansi FROM pelanggan WHERE id = NEW.pelanggan_id);
  END IF;
  -- Kode tracking ACAK (32 karakter). Idealnya diisi Laravel dengan Str::random(32) (CSPRNG);
  -- ini hanya cadangan bila order dibuat lewat SQL langsung.
  IF NEW.kode_tracking IS NULL OR NEW.kode_tracking = '' THEN
    SET NEW.kode_tracking = LOWER(SUBSTRING(SHA2(CONCAT(UUID(), RAND(), NOW(6), CONNECTION_ID(), NEW.pelanggan_id), 256), 1, 32));
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pesanan_sebelum_update` BEFORE UPDATE ON `pesanan` FOR EACH ROW BEGIN
  DECLARE v_urut_lama TINYINT;
  DECLARE v_urut_baru TINYINT;
  DECLARE v_qc VARCHAR(10);

  -- kode order & kode tracking tidak boleh berubah
  SET NEW.hp_4_digit = OLD.hp_4_digit;
  SET NEW.kode_tracking = OLD.kode_tracking;

  -- POLA 3: harga dikunci setelah invoice
  IF NOT (NEW.harga_satuan <=> OLD.harga_satuan) THEN
    CALL cek_order_belum_diinvoice(OLD.id);
  END IF;

  -- POLA 6: jejak perubahan data penting
  IF NOT (NEW.jenis_produk <=> OLD.jenis_produk) THEN CALL catat_perubahan('pesanan', OLD.id, 'jenis_produk', OLD.jenis_produk, NEW.jenis_produk); END IF;
  IF NOT (NEW.keterangan   <=> OLD.keterangan)   THEN CALL catat_perubahan('pesanan', OLD.id, 'keterangan',   OLD.keterangan,   NEW.keterangan);   END IF;
  IF NOT (NEW.harga_satuan <=> OLD.harga_satuan) THEN CALL catat_perubahan('pesanan', OLD.id, 'harga_satuan', OLD.harga_satuan, NEW.harga_satuan); END IF;
  IF NOT (NEW.deadline     <=> OLD.deadline)     THEN CALL catat_perubahan('pesanan', OLD.id, 'deadline',     OLD.deadline,     NEW.deadline);     END IF;
  IF NOT (NEW.status_order <=> OLD.status_order) THEN CALL catat_perubahan('pesanan', OLD.id, 'status_order', OLD.status_order, NEW.status_order); END IF;
  IF NOT (NEW.instansi     <=> OLD.instansi)     THEN CALL catat_perubahan('pesanan', OLD.id, 'instansi',     OLD.instansi,     NEW.instansi);     END IF;

  -- POLA 2: aturan perubahan tahap produksi
  IF NEW.tahap_saat_ini <> OLD.tahap_saat_ini THEN
    IF NEW.status_order = 'BATAL' THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Order berstatus BATAL tidak dapat diproses produksi';
    END IF;
    IF NOT EXISTS (SELECT 1 FROM work_order WHERE pesanan_id = OLD.id AND status_wo = 'DITERUSKAN') THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tahap produksi hanya bisa diubah setelah Work Order diteruskan ke Tim Produksi';
    END IF;
    -- Packing/Selesai hanya boleh setelah QC TERAKHIR berhasil (LOLOS)
    IF NEW.tahap_saat_ini IN ('Packing', 'Selesai') THEN
      SELECT q.hasil INTO v_qc FROM qc q JOIN work_order w ON w.id = q.work_order_id
       WHERE w.pesanan_id = OLD.id ORDER BY q.id DESC LIMIT 1;
      IF v_qc IS NULL OR v_qc <> 'LOLOS' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Packing/Selesai hanya bisa setelah hasil QC terakhir LOLOS';
      END IF;
    END IF;
    SELECT urutan INTO v_urut_lama FROM tahap_produksi WHERE nama = OLD.tahap_saat_ini;
    SELECT urutan INTO v_urut_baru FROM tahap_produksi WHERE nama = NEW.tahap_saat_ini;
    IF v_urut_baru IS NULL THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tahap produksi tidak dikenal (lihat tabel tahap_produksi)';
    END IF;
    INSERT INTO riwayat_tahap(pesanan_id, tahap_sebelumnya, tahap_baru, mundur, catatan, diubah_oleh)
    VALUES (OLD.id, OLD.tahap_saat_ini, NEW.tahap_saat_ini, v_urut_baru < v_urut_lama, @catatan, @id_pengguna);
    IF NEW.tahap_saat_ini = 'Selesai' THEN
      SET NEW.selesai_pada = NOW();
    ELSE
      SET NEW.selesai_pada = NULL;
    END IF;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `qc`
--

CREATE TABLE `qc` (
  `id` bigint NOT NULL,
  `work_order_id` bigint NOT NULL,
  `hasil` enum('LOLOS','REVISI') NOT NULL,
  `catatan` text,
  `kembali_ke_tahap` varchar(40) DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dicatat_oleh` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `qc`
--
DELIMITER $$
CREATE TRIGGER `qc_setelah_insert` AFTER INSERT ON `qc` FOR EACH ROW BEGIN
  DECLARE v_pesanan BIGINT;
  DECLARE v_tahap VARCHAR(40);
  DECLARE v_urut_kembali TINYINT;
  DECLARE v_urut_qc TINYINT;
  DECLARE v_user_lama BIGINT;
  DECLARE v_catatan_lama TEXT;
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    SET @id_pengguna = v_user_lama;
    SET @catatan = v_catatan_lama;
    RESIGNAL;
  END;
  SET v_user_lama = @id_pengguna;
  SET v_catatan_lama = @catatan;

  SELECT p.id, p.tahap_saat_ini INTO v_pesanan, v_tahap
    FROM work_order w JOIN pesanan p ON p.id = w.pesanan_id WHERE w.id = NEW.work_order_id;
  IF v_tahap <> 'QC' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'QC hanya bisa dicatat saat order berada di tahap QC';
  END IF;
  IF NEW.hasil = 'REVISI' THEN
    IF NEW.kembali_ke_tahap IS NULL THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Revisi QC wajib menentukan tahap tujuan';
    END IF;
    SELECT urutan INTO v_urut_kembali FROM tahap_produksi WHERE nama = NEW.kembali_ke_tahap;
    SELECT urutan INTO v_urut_qc FROM tahap_produksi WHERE nama = 'QC';
    IF v_urut_kembali >= v_urut_qc THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Revisi QC harus kembali ke tahap SEBELUM QC';
    END IF;
  END IF;

  SET @id_pengguna = COALESCE(NEW.dicatat_oleh, @id_pengguna);
  SET @catatan = CONCAT('QC ', NEW.hasil, IF(NEW.catatan IS NULL, '', CONCAT(': ', NEW.catatan)));
  IF NEW.hasil = 'LOLOS' THEN
    UPDATE pesanan SET tahap_saat_ini = 'Packing' WHERE id = v_pesanan;
  ELSE
    UPDATE pesanan SET tahap_saat_ini = NEW.kembali_ke_tahap WHERE id = v_pesanan;
  END IF;
  SET @id_pengguna = v_user_lama;
  SET @catatan = v_catatan_lama;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_perubahan`
--

CREATE TABLE `riwayat_perubahan` (
  `id` bigint NOT NULL,
  `nama_tabel` varchar(50) NOT NULL,
  `id_data` bigint NOT NULL,
  `kolom` varchar(50) NOT NULL,
  `nilai_lama` text,
  `nilai_baru` text,
  `diubah_oleh` bigint DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_tahap`
--

CREATE TABLE `riwayat_tahap` (
  `id` bigint NOT NULL,
  `pesanan_id` bigint NOT NULL,
  `tahap_sebelumnya` varchar(40) NOT NULL,
  `tahap_baru` varchar(40) NOT NULL,
  `mundur` tinyint(1) NOT NULL DEFAULT '0',
  `catatan` text,
  `diubah_oleh` bigint DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spesifikasi_pesanan`
--

CREATE TABLE `spesifikasi_pesanan` (
  `pesanan_id` bigint NOT NULL,
  `model_cuttingan` varchar(200) DEFAULT NULL,
  `lengan` enum('PANJANG','PENDEK') DEFAULT NULL,
  `status_desain` enum('SUDAH_ADA_FILE','DIBUATKAN_TIM') NOT NULL,
  `catatan_desain` text,
  `bahan` varchar(150) DEFAULT NULL,
  `warna` varchar(100) DEFAULT NULL,
  `pakai_lanyard` tinyint(1) NOT NULL DEFAULT '0',
  `pakai_id_card` tinyint(1) NOT NULL DEFAULT '0',
  `model_saku` text,
  `pakai_sablon` tinyint(1) NOT NULL DEFAULT '0',
  `pakai_bordir` tinyint(1) NOT NULL DEFAULT '0',
  `ket_bordir_sablon` text,
  `tambahan` text,
  `variasi_lain` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `spesifikasi_pesanan`
--

INSERT INTO `spesifikasi_pesanan` (`pesanan_id`, `model_cuttingan`, `lengan`, `status_desain`, `catatan_desain`, `bahan`, `warna`, `pakai_lanyard`, `pakai_id_card`, `model_saku`, `pakai_sablon`, `pakai_bordir`, `ket_bordir_sablon`, `tambahan`, `variasi_lain`) VALUES
(1, 'Regular', 'PENDEK', 'SUDAH_ADA_FILE', NULL, 'American Drill', 'Hitam', 0, 0, NULL, 0, 1, 'Logo dada kiri', NULL, NULL);

--
-- Triggers `spesifikasi_pesanan`
--
DELIMITER $$
CREATE TRIGGER `spesifikasi_sebelum_update` BEFORE UPDATE ON `spesifikasi_pesanan` FOR EACH ROW BEGIN
  IF NOT (NEW.model_cuttingan   <=> OLD.model_cuttingan)   THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'model_cuttingan',   OLD.model_cuttingan,   NEW.model_cuttingan);   END IF;
  IF NOT (NEW.lengan            <=> OLD.lengan)            THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'lengan',            OLD.lengan,            NEW.lengan);            END IF;
  IF NOT (NEW.status_desain     <=> OLD.status_desain)     THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'status_desain',     OLD.status_desain,     NEW.status_desain);     END IF;
  IF NOT (NEW.bahan             <=> OLD.bahan)             THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'bahan',             OLD.bahan,             NEW.bahan);             END IF;
  IF NOT (NEW.warna             <=> OLD.warna)             THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'warna',             OLD.warna,             NEW.warna);             END IF;
  IF NOT (NEW.pakai_lanyard     <=> OLD.pakai_lanyard)     THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'pakai_lanyard',     OLD.pakai_lanyard,     NEW.pakai_lanyard);     END IF;
  IF NOT (NEW.pakai_id_card     <=> OLD.pakai_id_card)     THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'pakai_id_card',     OLD.pakai_id_card,     NEW.pakai_id_card);     END IF;
  IF NOT (NEW.model_saku        <=> OLD.model_saku)        THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'model_saku',        OLD.model_saku,        NEW.model_saku);        END IF;
  IF NOT (NEW.pakai_sablon      <=> OLD.pakai_sablon)      THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'pakai_sablon',      OLD.pakai_sablon,      NEW.pakai_sablon);      END IF;
  IF NOT (NEW.pakai_bordir      <=> OLD.pakai_bordir)      THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'pakai_bordir',      OLD.pakai_bordir,      NEW.pakai_bordir);      END IF;
  IF NOT (NEW.ket_bordir_sablon <=> OLD.ket_bordir_sablon) THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'ket_bordir_sablon', OLD.ket_bordir_sablon, NEW.ket_bordir_sablon); END IF;
  IF NOT (NEW.tambahan          <=> OLD.tambahan)          THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'tambahan',          OLD.tambahan,          NEW.tambahan);          END IF;
  IF NOT (NEW.variasi_lain      <=> OLD.variasi_lain)      THEN CALL catat_perubahan('spesifikasi_pesanan', OLD.pesanan_id, 'variasi_lain',      OLD.variasi_lain,      NEW.variasi_lain);      END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id` bigint NOT NULL,
  `bahan_id` bigint NOT NULL,
  `tanggal` date NOT NULL DEFAULT (curdate()),
  `stok_sistem` decimal(12,2) DEFAULT NULL,
  `stok_fisik` decimal(12,2) NOT NULL,
  `selisih` decimal(12,2) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `dicatat_oleh` bigint DEFAULT NULL
) ;

--
-- Triggers `stok_opname`
--
DELIMITER $$
CREATE TRIGGER `opname_sebelum_delete` BEFORE DELETE ON `stok_opname` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock opname tidak boleh dihapus';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `opname_sebelum_insert` BEFORE INSERT ON `stok_opname` FOR EACH ROW BEGIN
  DECLARE v_lock BIGINT;
  DECLARE v_sistem DECIMAL(12,2);
  SELECT id INTO v_lock FROM bahan_baku WHERE id = NEW.bahan_id FOR UPDATE;
  SELECT COALESCE(SUM(jumlah), 0) INTO v_sistem FROM transaksi_bahan WHERE bahan_id = NEW.bahan_id LOCK IN SHARE MODE;
  SET NEW.stok_sistem = v_sistem;
  SET NEW.selisih = NEW.stok_fisik - v_sistem;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `opname_sebelum_update` BEFORE UPDATE ON `stok_opname` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock opname tidak boleh diubah. Lakukan stock opname baru';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `opname_setelah_insert` AFTER INSERT ON `stok_opname` FOR EACH ROW BEGIN
  IF NEW.selisih <> 0 THEN
    INSERT INTO transaksi_bahan(bahan_id, jenis, jumlah, stok_opname_id, keterangan, dicatat_oleh)
    VALUES (NEW.bahan_id, 'OPNAME', NEW.selisih, NEW.id, CONCAT('Stock opname ', NEW.tanggal), NEW.dicatat_oleh);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` bigint NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahap_produksi`
--

CREATE TABLE `tahap_produksi` (
  `nama` varchar(40) NOT NULL,
  `urutan` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tahap_produksi`
--

INSERT INTO `tahap_produksi` (`nama`, `urutan`) VALUES
('Order Diterima', 1),
('Persiapan/Pembelian Bahan', 2),
('Cutting', 3),
('Jahit/Bordir/Sablon', 4),
('Finishing', 5),
('QC', 6),
('Packing', 7),
('Selesai', 8);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_bahan`
--

CREATE TABLE `transaksi_bahan` (
  `id` bigint NOT NULL,
  `bahan_id` bigint NOT NULL,
  `jenis` enum('MASUK','KELUAR','PEMAKAIAN_WO','OPNAME','PENYESUAIAN') NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `work_order_id` bigint DEFAULT NULL,
  `pembelian_item_id` bigint DEFAULT NULL,
  `stok_opname_id` bigint DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `dicatat_oleh` bigint DEFAULT NULL
) ;

--
-- Triggers `transaksi_bahan`
--
DELIMITER $$
CREATE TRIGGER `transaksi_sebelum_delete` BEFORE DELETE ON `transaksi_bahan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transaksi stok tidak boleh dihapus. Buat transaksi koreksi (PENYESUAIAN)';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi_sebelum_insert` BEFORE INSERT ON `transaksi_bahan` FOR EACH ROW BEGIN
  DECLARE v_lock BIGINT;
  DECLARE v_stok DECIMAL(12,2);
  DECLARE v_pesan VARCHAR(200);

  SELECT id INTO v_lock FROM bahan_baku WHERE id = NEW.bahan_id FOR UPDATE;

  IF NEW.jenis = 'PEMAKAIAN_WO' AND NEW.work_order_id IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pemakaian bahan harus mengacu ke Work Order';
  END IF;
  IF NEW.jenis = 'OPNAME' AND NEW.stok_opname_id IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transaksi OPNAME harus mengacu ke data stok opname';
  END IF;
  IF NEW.jenis IN ('MASUK', 'KELUAR', 'PENYESUAIAN') AND NEW.pembelian_item_id IS NULL
     AND COALESCE(TRIM(NEW.keterangan), '') = '' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Isi keterangan sumber atau alasan transaksi stok';
  END IF;

  SELECT COALESCE(SUM(jumlah), 0) INTO v_stok FROM transaksi_bahan WHERE bahan_id = NEW.bahan_id LOCK IN SHARE MODE;
  IF v_stok + NEW.jumlah < 0 THEN
    SET v_pesan = CONCAT('Stok tidak mencukupi (tersedia ', v_stok, ', diminta ', ABS(NEW.jumlah), ')');
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_pesan;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi_sebelum_update` BEFORE UPDATE ON `transaksi_bahan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Transaksi stok tidak boleh diubah. Buat transaksi koreksi (PENYESUAIAN)';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ukuran_pesanan`
--

CREATE TABLE `ukuran_pesanan` (
  `pesanan_id` bigint NOT NULL,
  `ukuran` enum('XS','S','M','L','XL','2XL','3XL','4XL','5XL','6XL','TANPA_UKURAN') NOT NULL,
  `jumlah` int NOT NULL
) ;

--
-- Dumping data for table `ukuran_pesanan`
--

INSERT INTO `ukuran_pesanan` (`pesanan_id`, `ukuran`, `jumlah`) VALUES
(1, 'M', 10),
(1, 'L', 8);

--
-- Triggers `ukuran_pesanan`
--
DELIMITER $$
CREATE TRIGGER `ukuran_sebelum_delete` BEFORE DELETE ON `ukuran_pesanan` FOR EACH ROW BEGIN
  CALL cek_order_belum_diinvoice(OLD.pesanan_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ukuran_sebelum_insert` BEFORE INSERT ON `ukuran_pesanan` FOR EACH ROW BEGIN
  CALL cek_order_belum_diinvoice(NEW.pesanan_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ukuran_sebelum_update` BEFORE UPDATE ON `ukuran_pesanan` FOR EACH ROW BEGIN
  IF NOT (NEW.jumlah <=> OLD.jumlah) OR NEW.ukuran <> OLD.ukuran OR NEW.pesanan_id <> OLD.pesanan_id THEN
    CALL cek_order_belum_diinvoice(OLD.pesanan_id);
    IF NEW.pesanan_id <> OLD.pesanan_id THEN
      CALL cek_order_belum_diinvoice(NEW.pesanan_id);
    END IF;
  END IF;
  IF NOT (NEW.jumlah <=> OLD.jumlah) THEN
    CALL catat_perubahan('ukuran_pesanan', OLD.pesanan_id, CONCAT('ukuran_', OLD.ukuran), OLD.jumlah, NEW.jumlah);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_antrian_produksi`
-- (See below for the actual view)
--
CREATE TABLE `v_antrian_produksi` (
`bahan` varchar(150)
,`catatan_produksi` text
,`customer` varchar(150)
,`deadline` date
,`jumlah` decimal(32,0)
,`kode_order` varchar(25)
,`pesanan_id` bigint
,`produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`tahap_saat_ini` varchar(40)
,`work_order_id` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_arus_kas_bulanan`
-- (See below for the actual view)
--
CREATE TABLE `v_arus_kas_bulanan` (
`arus_kas` decimal(65,2)
,`bulan` varchar(7)
,`uang_keluar` decimal(65,2)
,`uang_masuk` decimal(36,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_invoice`
-- (See below for the actual view)
--
CREATE TABLE `v_invoice` (
`balance_due` decimal(47,2)
,`customer` varchar(150)
,`dp` decimal(36,2)
,`harga_satuan` decimal(14,2)
,`instansi` varchar(200)
,`jumlah` decimal(32,0)
,`kode_order` varchar(25)
,`nomor_invoice` varchar(30)
,`produk` varchar(255)
,`status_pembayaran` varchar(13)
,`tanggal_invoice` date
,`total` decimal(46,2)
,`total_dibayar` decimal(36,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kebutuhan_bahan`
-- (See below for the actual view)
--
CREATE TABLE `v_kebutuhan_bahan` (
`bahan` varchar(100)
,`bahan_id` bigint
,`dibutuhkan` decimal(12,2)
,`kode_order` varchar(25)
,`kurang_wo_ini` decimal(36,2)
,`nomor_wo` varchar(40)
,`satuan` varchar(20)
,`sisa_kebutuhan` decimal(35,2)
,`stok_tersedia` decimal(34,2)
,`sudah_dipakai` decimal(34,2)
,`warna` varchar(50)
,`work_order_id` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kekurangan_bahan`
-- (See below for the actual view)
--
CREATE TABLE `v_kekurangan_bahan` (
`bahan` varchar(100)
,`bahan_id` bigint
,`kekurangan` decimal(58,2)
,`satuan` varchar(20)
,`stok_tersedia` decimal(34,2)
,`total_sisa_kebutuhan` decimal(57,2)
,`warna` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_laporan_bulanan`
-- (See below for the actual view)
--
CREATE TABLE `v_laporan_bulanan` (
`bulan` varchar(7)
,`cash_flow` decimal(65,2)
,`pemasukan` decimal(65,2)
,`pengeluaran` decimal(65,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_laporan_pemasukan`
-- (See below for the actual view)
--
CREATE TABLE `v_laporan_pemasukan` (
`customer` varchar(150)
,`instansi` varchar(200)
,`jenis_produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`jumlah` decimal(32,0)
,`keterangan` varchar(82)
,`kode_order` varchar(25)
,`nomor_invoice` varchar(30)
,`pesanan_id` bigint
,`status_pembayaran` varchar(13)
,`status_produksi` varchar(40)
,`tanggal_selesai` datetime
,`tanggal_transaksi` date
,`total_dp` decimal(36,2)
,`total_pelunasan` decimal(36,2)
,`total_pembayaran` decimal(46,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_notifikasi`
-- (See below for the actual view)
--
CREATE TABLE `v_notifikasi` (
`jenis` varchar(18)
,`pesan` varchar(222)
,`pesanan_id` bigint
,`untuk_peran` varchar(17)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_order`
-- (See below for the actual view)
--
CREATE TABLE `v_order` (
`2xl` decimal(32,0)
,`3xl` decimal(32,0)
,`4xl` decimal(32,0)
,`5xl` decimal(32,0)
,`6xl` decimal(32,0)
,`bahan` varchar(150)
,`bordir` varchar(5)
,`customer` varchar(150)
,`deadline` date
,`dibuat_dari` enum('FORM_CUSTOMER','CS')
,`dibuat_pada` datetime
,`dp` decimal(36,2)
,`harga_satuan` decimal(14,2)
,`id_card` varchar(5)
,`instansi` varchar(200)
,`jenis_order` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`jumlah` decimal(32,0)
,`kekurangan` decimal(47,2)
,`keterangan` varchar(255)
,`kode_order` varchar(25)
,`kode_tracking` char(32)
,`l` decimal(32,0)
,`lanyard` varchar(5)
,`lengan_panjang` int
,`lengan_pendek` int
,`m` decimal(32,0)
,`no` bigint
,`no_whatsapp` varchar(20)
,`nomor_invoice` varchar(30)
,`pelanggan_id` bigint
,`pelunasan` decimal(36,2)
,`s` decimal(32,0)
,`sablon` varchar(5)
,`status_order` enum('BARU','DIKONFIRMASI','BATAL')
,`status_pembayaran` varchar(13)
,`status_pengerjaan` varchar(40)
,`sumber` enum('REKOMENDASI_TEMAN','INSTAGRAM','TIKTOK','IKLAN','FACEBOOK','LAINNYA')
,`tahap_saat_ini` varchar(40)
,`tanggal_selesai` datetime
,`tanpa_ukuran` decimal(32,0)
,`total_dibayar` decimal(36,2)
,`total_pembayaran` decimal(46,2)
,`urutan_tahap` tinyint
,`xl` decimal(32,0)
,`xs` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pembayaran_order`
-- (See below for the actual view)
--
CREATE TABLE `v_pembayaran_order` (
`dp` decimal(36,2)
,`harga_satuan` decimal(14,2)
,`jumlah` decimal(32,0)
,`kekurangan` decimal(47,2)
,`pelunasan` decimal(36,2)
,`pesanan_id` bigint
,`status_pembayaran` varchar(13)
,`total_dibayar` decimal(36,2)
,`total_pembayaran` decimal(46,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pembelian`
-- (See below for the actual view)
--
CREATE TABLE `v_pembelian` (
`id` bigint
,`pesanan_id` bigint
,`status` enum('DIAJUKAN','DISETUJUI','DITOLAK','DITERIMA')
,`supplier` varchar(150)
,`tanggal` date
,`tanggal_diterima` date
,`total_pembelian` decimal(47,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pengeluaran`
-- (See below for the actual view)
--
CREATE TABLE `v_pengeluaran` (
`jenis_transaksi` varchar(15)
,`jumlah` decimal(47,2)
,`keterangan` varchar(255)
,`kode_order` varchar(25)
,`nomor_invoice` varchar(30)
,`referensi` varchar(33)
,`tanggal` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ringkasan_keuangan`
-- (See below for the actual view)
--
CREATE TABLE `v_ringkasan_keuangan` (
`cash_flow` decimal(65,2)
,`pembayaran_order_batal` decimal(36,2)
,`pembayaran_order_berjalan` decimal(65,2)
,`saldo_kas_aktual` decimal(65,2)
,`total_dp` decimal(58,2)
,`total_pelunasan` decimal(58,2)
,`total_pemasukan` decimal(65,2)
,`total_pengeluaran` decimal(65,2)
,`total_uang_diterima` decimal(36,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stok_bahan`
-- (See below for the actual view)
--
CREATE TABLE `v_stok_bahan` (
`id` bigint
,`jenis_bahan` varchar(50)
,`menipis` int
,`nama` varchar(100)
,`satuan` varchar(20)
,`stok_minimum` decimal(12,2)
,`stok_tersedia` decimal(34,2)
,`supplier` varchar(150)
,`warna` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tracking`
-- (See below for the actual view)
--
CREATE TABLE `v_tracking` (
`bahan` varchar(150)
,`bordir` varchar(5)
,`customer` varchar(150)
,`deadline` date
,`id_card` varchar(5)
,`instansi` varchar(200)
,`jenis_produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`jumlah` decimal(32,0)
,`kode_order` varchar(25)
,`kode_tracking` char(32)
,`lanyard` varchar(5)
,`lengan` enum('PANJANG','PENDEK')
,`model_cuttingan` varchar(200)
,`model_saku` text
,`progres_persen` decimal(8,0)
,`sablon` varchar(5)
,`status_pembayaran` varchar(13)
,`tahap_saat_ini` varchar(40)
,`tambahan` text
,`variasi_lain` text
,`warna` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tracking_riwayat`
-- (See below for the actual view)
--
CREATE TABLE `v_tracking_riwayat` (
`kode_tracking` char(32)
,`tahap_baru` varchar(40)
,`waktu` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tracking_ukuran`
-- (See below for the actual view)
--
CREATE TABLE `v_tracking_ukuran` (
`jumlah` int
,`kode_tracking` char(32)
,`ukuran` enum('XS','S','M','L','XL','2XL','3XL','4XL','5XL','6XL','TANPA_UKURAN')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_transaksi_keuangan`
-- (See below for the actual view)
--
CREATE TABLE `v_transaksi_keuangan` (
`customer` varchar(150)
,`jenis_transaksi` varchar(15)
,`keterangan` varchar(255)
,`kode_order` varchar(25)
,`nomor_invoice` varchar(30)
,`pemasukan` decimal(46,2)
,`pengeluaran` decimal(47,2)
,`referensi` varchar(33)
,`status_pembayaran` varchar(13)
,`tanggal` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_transaksi_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `v_transaksi_pembayaran` (
`customer` varchar(150)
,`instansi` varchar(200)
,`jenis_produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`jenis_transaksi` enum('DP','PELUNASAN')
,`jumlah` decimal(14,2)
,`keterangan` varchar(255)
,`kode_order` varchar(25)
,`metode` enum('TRANSFER','TUNAI','QRIS','LAINNYA')
,`nomor_invoice` varchar(30)
,`pembayaran_id` bigint
,`status_pembayaran` varchar(13)
,`tanggal` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_work_order`
-- (See below for the actual view)
--
CREATE TABLE `v_work_order` (
`bahan` varchar(150)
,`bordir` varchar(5)
,`catatan_desain` text
,`catatan_produksi` text
,`customer` varchar(150)
,`deadline` date
,`file_desain` text
,`id_card` varchar(5)
,`instansi` varchar(200)
,`jenis_produk` enum('Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya')
,`jumlah` decimal(32,0)
,`ket_bordir_sablon` text
,`kode_order` varchar(25)
,`lanyard` varchar(5)
,`lengan` enum('PANJANG','PENDEK')
,`model_cuttingan` varchar(200)
,`model_saku` text
,`nomor_wo` varchar(40)
,`rincian_ukuran` text
,`sablon` varchar(5)
,`status_desain` enum('SUDAH_ADA_FILE','DIBUATKAN_TIM')
,`status_wo` enum('DIBUAT','DITERUSKAN')
,`tahap_saat_ini` varchar(40)
,`tambahan` text
,`tanggal_wo` date
,`variasi_lain` text
,`warna` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `work_order`
--

CREATE TABLE `work_order` (
  `id` bigint NOT NULL,
  `pesanan_id` bigint NOT NULL,
  `nomor_wo` varchar(40) GENERATED ALWAYS AS (concat(_utf8mb4'WO-',`pesanan_id`)) STORED,
  `tanggal_wo` date NOT NULL DEFAULT (curdate()),
  `catatan_produksi` text,
  `status_wo` enum('DIBUAT','DITERUSKAN') NOT NULL DEFAULT 'DIBUAT',
  `dibuat_oleh` bigint DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `work_order`
--
DELIMITER $$
CREATE TRIGGER `wo_sebelum_insert` BEFORE INSERT ON `work_order` FOR EACH ROW BEGIN
  IF NOT EXISTS (SELECT 1 FROM invoice WHERE pesanan_id = NEW.pesanan_id) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Work Order hanya bisa dibuat setelah invoice dibuat';
  END IF;
  IF NOT EXISTS (SELECT 1 FROM pembayaran WHERE pesanan_id = NEW.pesanan_id) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Work Order hanya bisa dibuat setelah DP tercatat';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `v_antrian_produksi`
--
DROP TABLE IF EXISTS `v_antrian_produksi`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_antrian_produksi`  AS SELECT `w`.`id` AS `work_order_id`, `o`.`no` AS `pesanan_id`, `o`.`kode_order` AS `kode_order`, `o`.`customer` AS `customer`, `o`.`jenis_order` AS `produk`, `o`.`jumlah` AS `jumlah`, `o`.`deadline` AS `deadline`, `o`.`bahan` AS `bahan`, `o`.`tahap_saat_ini` AS `tahap_saat_ini`, `w`.`catatan_produksi` AS `catatan_produksi` FROM (`work_order` `w` join `v_order` `o` on((`o`.`no` = `w`.`pesanan_id`))) WHERE ((`w`.`status_wo` = 'DITERUSKAN') AND (`o`.`tahap_saat_ini` <> 'Selesai')) ORDER BY (`o`.`deadline` is null) ASC, `o`.`deadline` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_arus_kas_bulanan`
--
DROP TABLE IF EXISTS `v_arus_kas_bulanan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_arus_kas_bulanan`  AS SELECT `x`.`bulan` AS `bulan`, sum(`x`.`masuk`) AS `uang_masuk`, sum(`x`.`keluar`) AS `uang_keluar`, (sum(`x`.`masuk`) - sum(`x`.`keluar`)) AS `arus_kas` FROM (select date_format(`pembayaran`.`tanggal_bayar`,'%Y-%m') AS `bulan`,`pembayaran`.`jumlah` AS `masuk`,0 AS `keluar` from `pembayaran` union all select date_format(`v_pengeluaran`.`tanggal`,'%Y-%m') AS `DATE_FORMAT(tanggal, '%Y-%m')`,0 AS `0`,`v_pengeluaran`.`jumlah` AS `jumlah` from `v_pengeluaran`) AS `x` GROUP BY `x`.`bulan` ORDER BY `x`.`bulan` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_invoice`
--
DROP TABLE IF EXISTS `v_invoice`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_invoice`  AS SELECT `i`.`nomor_invoice` AS `nomor_invoice`, `o`.`kode_order` AS `kode_order`, `i`.`tanggal_invoice` AS `tanggal_invoice`, `o`.`customer` AS `customer`, `o`.`instansi` AS `instansi`, `i`.`deskripsi_produk` AS `produk`, `o`.`jumlah` AS `jumlah`, `o`.`harga_satuan` AS `harga_satuan`, `o`.`total_pembayaran` AS `total`, `o`.`dp` AS `dp`, `o`.`total_dibayar` AS `total_dibayar`, `o`.`kekurangan` AS `balance_due`, `o`.`status_pembayaran` AS `status_pembayaran` FROM (`invoice` `i` join `v_order` `o` on((`o`.`no` = `i`.`pesanan_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_kebutuhan_bahan`
--
DROP TABLE IF EXISTS `v_kebutuhan_bahan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_kebutuhan_bahan`  AS SELECT `w`.`id` AS `work_order_id`, `w`.`nomor_wo` AS `nomor_wo`, `o`.`kode_order` AS `kode_order`, `b`.`id` AS `bahan_id`, `b`.`nama` AS `bahan`, `b`.`warna` AS `warna`, `b`.`satuan` AS `satuan`, `kb`.`jumlah_dibutuhkan` AS `dibutuhkan`, coalesce(`pk`.`dipakai`,0) AS `sudah_dipakai`, greatest((`kb`.`jumlah_dibutuhkan` - coalesce(`pk`.`dipakai`,0)),0) AS `sisa_kebutuhan`, coalesce(`st`.`stok`,0) AS `stok_tersedia`, greatest(((`kb`.`jumlah_dibutuhkan` - coalesce(`pk`.`dipakai`,0)) - coalesce(`st`.`stok`,0)),0) AS `kurang_wo_ini` FROM (((((`kebutuhan_bahan` `kb` join `work_order` `w` on((`w`.`id` = `kb`.`work_order_id`))) join `v_order` `o` on((`o`.`no` = `w`.`pesanan_id`))) join `bahan_baku` `b` on((`b`.`id` = `kb`.`bahan_id`))) left join (select `transaksi_bahan`.`work_order_id` AS `work_order_id`,`transaksi_bahan`.`bahan_id` AS `bahan_id`,-(sum(`transaksi_bahan`.`jumlah`)) AS `dipakai` from `transaksi_bahan` where (`transaksi_bahan`.`jenis` = 'PEMAKAIAN_WO') group by `transaksi_bahan`.`work_order_id`,`transaksi_bahan`.`bahan_id`) `pk` on(((`pk`.`work_order_id` = `kb`.`work_order_id`) and (`pk`.`bahan_id` = `kb`.`bahan_id`)))) left join (select `transaksi_bahan`.`bahan_id` AS `bahan_id`,sum(`transaksi_bahan`.`jumlah`) AS `stok` from `transaksi_bahan` group by `transaksi_bahan`.`bahan_id`) `st` on((`st`.`bahan_id` = `kb`.`bahan_id`))) WHERE ((`o`.`status_order` <> 'BATAL') AND (`o`.`tahap_saat_ini` <> 'Selesai'))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_kekurangan_bahan`
--
DROP TABLE IF EXISTS `v_kekurangan_bahan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_kekurangan_bahan`  AS SELECT `x`.`bahan_id` AS `bahan_id`, `b`.`nama` AS `bahan`, `b`.`warna` AS `warna`, `b`.`satuan` AS `satuan`, `x`.`total_sisa_kebutuhan` AS `total_sisa_kebutuhan`, coalesce(`st`.`stok`,0) AS `stok_tersedia`, greatest((`x`.`total_sisa_kebutuhan` - coalesce(`st`.`stok`,0)),0) AS `kekurangan` FROM (((select `v`.`bahan_id` AS `bahan_id`,sum(`v`.`sisa_kebutuhan`) AS `total_sisa_kebutuhan` from `v_kebutuhan_bahan` `v` group by `v`.`bahan_id`) `x` join `bahan_baku` `b` on((`b`.`id` = `x`.`bahan_id`))) left join (select `transaksi_bahan`.`bahan_id` AS `bahan_id`,sum(`transaksi_bahan`.`jumlah`) AS `stok` from `transaksi_bahan` group by `transaksi_bahan`.`bahan_id`) `st` on((`st`.`bahan_id` = `x`.`bahan_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_laporan_bulanan`
--
DROP TABLE IF EXISTS `v_laporan_bulanan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_laporan_bulanan`  AS SELECT date_format(`v_transaksi_keuangan`.`tanggal`,'%Y-%m') AS `bulan`, sum(`v_transaksi_keuangan`.`pemasukan`) AS `pemasukan`, sum(`v_transaksi_keuangan`.`pengeluaran`) AS `pengeluaran`, (sum(`v_transaksi_keuangan`.`pemasukan`) - sum(`v_transaksi_keuangan`.`pengeluaran`)) AS `cash_flow` FROM `v_transaksi_keuangan` GROUP BY date_format(`v_transaksi_keuangan`.`tanggal`,'%Y-%m') ORDER BY `bulan` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_laporan_pemasukan`
--
DROP TABLE IF EXISTS `v_laporan_pemasukan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_laporan_pemasukan`  AS SELECT greatest(`b`.`terakhir`,cast(`o`.`tanggal_selesai` as date)) AS `tanggal_transaksi`, `o`.`no` AS `pesanan_id`, `o`.`kode_order` AS `kode_order`, `o`.`nomor_invoice` AS `nomor_invoice`, `o`.`customer` AS `customer`, `o`.`instansi` AS `instansi`, `o`.`jenis_order` AS `jenis_produk`, `o`.`jumlah` AS `jumlah`, `o`.`total_pembayaran` AS `total_pembayaran`, `o`.`dp` AS `total_dp`, `o`.`pelunasan` AS `total_pelunasan`, `o`.`status_pembayaran` AS `status_pembayaran`, `o`.`tahap_saat_ini` AS `status_produksi`, `o`.`tanggal_selesai` AS `tanggal_selesai`, concat('Pemasukan pesanan lunas dan selesai: ',`o`.`jenis_order`,' x',`o`.`jumlah`) AS `keterangan` FROM (`v_order` `o` join (select `pembayaran`.`pesanan_id` AS `pesanan_id`,max(`pembayaran`.`tanggal_bayar`) AS `terakhir` from `pembayaran` group by `pembayaran`.`pesanan_id`) `b` on((`b`.`pesanan_id` = `o`.`no`))) WHERE ((`o`.`status_order` <> 'BATAL') AND (`o`.`status_pembayaran` = 'LUNAS') AND (`o`.`tahap_saat_ini` = 'Selesai'))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_notifikasi`
--
DROP TABLE IF EXISTS `v_notifikasi`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_notifikasi`  AS SELECT 'ORDER_BARU' AS `jenis`, 'CS' AS `untuk_peran`, concat('Form Order baru dari ',`o`.`customer`,' (',`o`.`kode_order`,')') AS `pesan`, `o`.`no` AS `pesanan_id` FROM `v_order` AS `o` WHERE (`o`.`status_order` = 'BARU') union all select 'PERLU_DILENGKAPI' AS `PERLU_DILENGKAPI`,'CS' AS `CS`,concat('Order ',`o`.`kode_order`,' belum lengkap (harga/deadline)') AS `Name_exp_7`,`o`.`no` AS `no` from `v_order` `o` where ((`o`.`status_order` in ('BARU','DIKONFIRMASI')) and ((`o`.`harga_satuan` is null) or (`o`.`deadline` is null))) union all select 'DEADLINE_DEKAT' AS `DEADLINE_DEKAT`,'CS,PRODUKSI,OWNER' AS `CS,PRODUKSI,OWNER`,concat('Order ',`o`.`kode_order`,' deadline ',`o`.`deadline`) AS `CONCAT('Order ', o.kode_order, ' deadline ', o.deadline)`,`o`.`no` AS `no` from `v_order` `o` where ((`o`.`status_order` <> 'BATAL') and (`o`.`tahap_saat_ini` <> 'Selesai') and (`o`.`deadline` <= (curdate() + interval 3 day))) union all select 'PEMBAYARAN' AS `PEMBAYARAN`,'CS' AS `CS`,concat('Order ',`o`.`kode_order`,' sudah ',`o`.`tahap_saat_ini`,' tetapi belum lunas') AS `Name_exp_15`,`o`.`no` AS `no` from `v_order` `o` where ((`o`.`status_order` = 'DIKONFIRMASI') and (`o`.`status_pembayaran` <> 'LUNAS') and (`o`.`tahap_saat_ini` in ('Packing','Selesai'))) union all select 'REVISI_QC' AS `REVISI_QC`,'PRODUKSI' AS `PRODUKSI`,concat('Order ',`o`.`kode_order`,' perlu revisi sesuai catatan QC') AS `Name_exp_19`,`o`.`no` AS `no` from ((`qc` `q` join `work_order` `w` on((`w`.`id` = `q`.`work_order_id`))) join `v_order` `o` on((`o`.`no` = `w`.`pesanan_id`))) where ((`q`.`hasil` = 'REVISI') and (`q`.`id` = (select max(`q2`.`id`) from `qc` `q2` where (`q2`.`work_order_id` = `q`.`work_order_id`))) and (`o`.`urutan_tahap` < (select `tahap_produksi`.`urutan` from `tahap_produksi` where (`tahap_produksi`.`nama` = 'QC')))) union all select 'ORDER_SELESAI' AS `ORDER_SELESAI`,'CS,OWNER' AS `CS,OWNER`,concat('Order ',`o`.`kode_order`,' sudah selesai') AS `CONCAT('Order ', o.kode_order, ' sudah selesai')`,`o`.`no` AS `no` from `v_order` `o` where ((`o`.`tahap_saat_ini` = 'Selesai') and exists(select 1 from `riwayat_tahap` `r` where ((`r`.`pesanan_id` = `o`.`no`) and (`r`.`tahap_baru` = 'Selesai') and (`r`.`waktu` >= (now() - interval 7 day))))) union all select 'STOK_MENIPIS' AS `STOK_MENIPIS`,'PRODUKSI,OWNER' AS `PRODUKSI,OWNER`,concat('Stok ',`v`.`nama`,' ',`v`.`warna`,' tinggal ',`v`.`stok_tersedia`,' ',`v`.`satuan`) AS `Name_exp_27`,`v`.`id` AS `id` from `v_stok_bahan` `v` where (`v`.`menipis` = 1) union all select 'PEMBELIAN_MENUNGGU' AS `PEMBELIAN_MENUNGGU`,'OWNER' AS `OWNER`,concat('Pengajuan pembelian #',`p`.`id`,' menunggu persetujuan') AS `CONCAT('Pengajuan pembelian #', p.id, ' menunggu persetujuan')`,`p`.`id` AS `id` from `pembelian` `p` where (`p`.`status` = 'DIAJUKAN')  ;

-- --------------------------------------------------------

--
-- Structure for view `v_order`
--
DROP TABLE IF EXISTS `v_order`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_order`  AS SELECT `p`.`id` AS `no`, concat(`p`.`id`,'_',`p`.`hp_4_digit`) AS `kode_order`, `p`.`jenis_produk` AS `jenis_order`, `c`.`nama` AS `customer`, `c`.`no_whatsapp` AS `no_whatsapp`, coalesce(`p`.`instansi`,`c`.`instansi`) AS `instansi`, `c`.`sumber_informasi` AS `sumber`, `p`.`keterangan` AS `keterangan`, `k`.`jumlah` AS `jumlah`, `uk`.`xs` AS `xs`, `uk`.`s` AS `s`, `uk`.`m` AS `m`, `uk`.`l` AS `l`, `uk`.`xl` AS `xl`, `uk`.`2xl` AS `2xl`, `uk`.`3xl` AS `3xl`, `uk`.`4xl` AS `4xl`, `uk`.`5xl` AS `5xl`, `uk`.`6xl` AS `6xl`, `uk`.`tanpa_ukuran` AS `tanpa_ukuran`, (`s`.`lengan` = 'PANJANG') AS `lengan_panjang`, (`s`.`lengan` = 'PENDEK') AS `lengan_pendek`, `p`.`harga_satuan` AS `harga_satuan`, `k`.`total_pembayaran` AS `total_pembayaran`, `k`.`dp` AS `dp`, `k`.`pelunasan` AS `pelunasan`, `k`.`total_dibayar` AS `total_dibayar`, `k`.`kekurangan` AS `kekurangan`, `k`.`status_pembayaran` AS `status_pembayaran`, `p`.`tahap_saat_ini` AS `status_pengerjaan`, `p`.`tahap_saat_ini` AS `tahap_saat_ini`, `tp`.`urutan` AS `urutan_tahap`, if((`s`.`pakai_lanyard` = 1),'Ya','Tidak') AS `lanyard`, if((`s`.`pakai_id_card` = 1),'Ya','Tidak') AS `id_card`, `s`.`bahan` AS `bahan`, if((`s`.`pakai_sablon` = 1),'Ya','Tidak') AS `sablon`, if((`s`.`pakai_bordir` = 1),'Ya','Tidak') AS `bordir`, `p`.`deadline` AS `deadline`, `p`.`status_order` AS `status_order`, `p`.`dibuat_dari` AS `dibuat_dari`, `p`.`dibuat_pada` AS `dibuat_pada`, `p`.`pelanggan_id` AS `pelanggan_id`, `i`.`nomor_invoice` AS `nomor_invoice`, `p`.`selesai_pada` AS `tanggal_selesai`, `p`.`kode_tracking` AS `kode_tracking` FROM ((((((`pesanan` `p` join `pelanggan` `c` on((`c`.`id` = `p`.`pelanggan_id`))) join `v_pembayaran_order` `k` on((`k`.`pesanan_id` = `p`.`id`))) join `tahap_produksi` `tp` on((`tp`.`nama` = `p`.`tahap_saat_ini`))) left join `spesifikasi_pesanan` `s` on((`s`.`pesanan_id` = `p`.`id`))) left join `invoice` `i` on((`i`.`pesanan_id` = `p`.`id`))) left join (select `ukuran_pesanan`.`pesanan_id` AS `pesanan_id`,sum((case when (`ukuran_pesanan`.`ukuran` = 'XS') then `ukuran_pesanan`.`jumlah` end)) AS `xs`,sum((case when (`ukuran_pesanan`.`ukuran` = 'S') then `ukuran_pesanan`.`jumlah` end)) AS `s`,sum((case when (`ukuran_pesanan`.`ukuran` = 'M') then `ukuran_pesanan`.`jumlah` end)) AS `m`,sum((case when (`ukuran_pesanan`.`ukuran` = 'L') then `ukuran_pesanan`.`jumlah` end)) AS `l`,sum((case when (`ukuran_pesanan`.`ukuran` = 'XL') then `ukuran_pesanan`.`jumlah` end)) AS `xl`,sum((case when (`ukuran_pesanan`.`ukuran` = '2XL') then `ukuran_pesanan`.`jumlah` end)) AS `2xl`,sum((case when (`ukuran_pesanan`.`ukuran` = '3XL') then `ukuran_pesanan`.`jumlah` end)) AS `3xl`,sum((case when (`ukuran_pesanan`.`ukuran` = '4XL') then `ukuran_pesanan`.`jumlah` end)) AS `4xl`,sum((case when (`ukuran_pesanan`.`ukuran` = '5XL') then `ukuran_pesanan`.`jumlah` end)) AS `5xl`,sum((case when (`ukuran_pesanan`.`ukuran` = '6XL') then `ukuran_pesanan`.`jumlah` end)) AS `6xl`,sum((case when (`ukuran_pesanan`.`ukuran` = 'TANPA_UKURAN') then `ukuran_pesanan`.`jumlah` end)) AS `tanpa_ukuran` from `ukuran_pesanan` group by `ukuran_pesanan`.`pesanan_id`) `uk` on((`uk`.`pesanan_id` = `p`.`id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_pembayaran_order`
--
DROP TABLE IF EXISTS `v_pembayaran_order`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_pembayaran_order`  AS SELECT `x`.`pesanan_id` AS `pesanan_id`, `x`.`jumlah` AS `jumlah`, `x`.`harga_satuan` AS `harga_satuan`, `x`.`total_pembayaran` AS `total_pembayaran`, `x`.`dp` AS `dp`, `x`.`pelunasan` AS `pelunasan`, `x`.`total_dibayar` AS `total_dibayar`, (`x`.`total_pembayaran` - `x`.`total_dibayar`) AS `kekurangan`, (case when (`x`.`total_dibayar` <= 0) then 'BELUM DIBAYAR' when ((`x`.`total_pembayaran` > 0) and (`x`.`total_dibayar` >= `x`.`total_pembayaran`)) then 'LUNAS' else 'DP' end) AS `status_pembayaran` FROM (select `p`.`id` AS `pesanan_id`,coalesce(`u`.`jumlah`,0) AS `jumlah`,`p`.`harga_satuan` AS `harga_satuan`,(coalesce(`u`.`jumlah`,0) * coalesce(`p`.`harga_satuan`,0)) AS `total_pembayaran`,coalesce(`b`.`dp`,0) AS `dp`,coalesce(`b`.`pelunasan`,0) AS `pelunasan`,coalesce(`b`.`dibayar`,0) AS `total_dibayar` from ((`pesanan` `p` left join (select `ukuran_pesanan`.`pesanan_id` AS `pesanan_id`,sum(`ukuran_pesanan`.`jumlah`) AS `jumlah` from `ukuran_pesanan` group by `ukuran_pesanan`.`pesanan_id`) `u` on((`u`.`pesanan_id` = `p`.`id`))) left join (select `pembayaran`.`pesanan_id` AS `pesanan_id`,sum(`pembayaran`.`jumlah`) AS `dibayar`,sum((case when (`pembayaran`.`jenis` = 'DP') then `pembayaran`.`jumlah` else 0 end)) AS `dp`,sum((case when (`pembayaran`.`jenis` = 'PELUNASAN') then `pembayaran`.`jumlah` else 0 end)) AS `pelunasan` from `pembayaran` group by `pembayaran`.`pesanan_id`) `b` on((`b`.`pesanan_id` = `p`.`id`)))) AS `x`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_pembelian`
--
DROP TABLE IF EXISTS `v_pembelian`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_pembelian`  AS SELECT `p`.`id` AS `id`, `p`.`tanggal` AS `tanggal`, `sp`.`nama` AS `supplier`, `p`.`pesanan_id` AS `pesanan_id`, `p`.`status` AS `status`, round(coalesce(`i`.`total`,0),2) AS `total_pembelian`, `p`.`tanggal_diterima` AS `tanggal_diterima` FROM ((`pembelian` `p` left join `supplier` `sp` on((`sp`.`id` = `p`.`supplier_id`))) left join (select `pembelian_item`.`pembelian_id` AS `pembelian_id`,sum((coalesce(`pembelian_item`.`jumlah_diterima`,`pembelian_item`.`jumlah`) * `pembelian_item`.`harga_satuan`)) AS `total` from `pembelian_item` group by `pembelian_item`.`pembelian_id`) `i` on((`i`.`pembelian_id` = `p`.`id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_pengeluaran`
--
DROP TABLE IF EXISTS `v_pengeluaran`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_pengeluaran`  AS SELECT `x`.`tanggal` AS `tanggal`, `x`.`jenis_transaksi` AS `jenis_transaksi`, `x`.`jumlah` AS `jumlah`, `x`.`keterangan` AS `keterangan`, `x`.`referensi` AS `referensi`, (case when (`p`.`id` is null) then NULL else concat(`p`.`id`,'_',`p`.`hp_4_digit`) end) AS `kode_order`, `i`.`nomor_invoice` AS `nomor_invoice` FROM (((select `v`.`tanggal_diterima` AS `tanggal`,'PEMBELIAN_BAHAN' AS `jenis_transaksi`,`v`.`total_pembelian` AS `jumlah`,concat('Pembelian bahan',coalesce(concat(' - ',`v`.`supplier`),'')) AS `keterangan`,concat('Pembelian #',`v`.`id`) AS `referensi`,`v`.`pesanan_id` AS `pesanan_id` from `v_pembelian` `v` where (`v`.`status` = 'DITERIMA') union all select `pl`.`tanggal` AS `tanggal`,cast(`pl`.`kategori` as char charset utf8mb4) AS `CAST(pl.kategori AS CHAR)`,`pl`.`jumlah` AS `jumlah`,coalesce(`pl`.`keterangan`,'Pengeluaran') AS `COALESCE(pl.keterangan, 'Pengeluaran')`,concat('Pengeluaran #',`pl`.`id`) AS `CONCAT('Pengeluaran #', pl.id)`,`pl`.`pesanan_id` AS `pesanan_id` from `pengeluaran_lain` `pl`) `x` left join `pesanan` `p` on((`p`.`id` = `x`.`pesanan_id`))) left join `invoice` `i` on((`i`.`pesanan_id` = `x`.`pesanan_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_ringkasan_keuangan`
--
DROP TABLE IF EXISTS `v_ringkasan_keuangan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_ringkasan_keuangan`  AS SELECT `m`.`total_pemasukan` AS `total_pemasukan`, `m`.`total_dp` AS `total_dp`, `m`.`total_pelunasan` AS `total_pelunasan`, `e`.`total_pengeluaran` AS `total_pengeluaran`, (`m`.`total_pemasukan` - `e`.`total_pengeluaran`) AS `cash_flow`, `u`.`diterima` AS `total_uang_diterima`, ((`u`.`diterima` - `u`.`batal`) - `m`.`total_pemasukan`) AS `pembayaran_order_berjalan`, `u`.`batal` AS `pembayaran_order_batal`, (`u`.`diterima` - `e`.`total_pengeluaran`) AS `saldo_kas_aktual` FROM (((select coalesce(sum(`v_laporan_pemasukan`.`total_pembayaran`),0) AS `total_pemasukan`,coalesce(sum(`v_laporan_pemasukan`.`total_dp`),0) AS `total_dp`,coalesce(sum(`v_laporan_pemasukan`.`total_pelunasan`),0) AS `total_pelunasan` from `v_laporan_pemasukan`) `m` join (select coalesce(sum(`v_pengeluaran`.`jumlah`),0) AS `total_pengeluaran` from `v_pengeluaran`) `e`) join (select coalesce(sum(`pb`.`jumlah`),0) AS `diterima`,coalesce(sum((case when (`p`.`status_order` = 'BATAL') then `pb`.`jumlah` else 0 end)),0) AS `batal` from (`pembayaran` `pb` join `pesanan` `p` on((`p`.`id` = `pb`.`pesanan_id`)))) `u`)  ;

-- --------------------------------------------------------

--
-- Structure for view `v_stok_bahan`
--
DROP TABLE IF EXISTS `v_stok_bahan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_stok_bahan`  AS SELECT `b`.`id` AS `id`, `b`.`nama` AS `nama`, `b`.`jenis_bahan` AS `jenis_bahan`, `b`.`warna` AS `warna`, `b`.`satuan` AS `satuan`, coalesce(`t`.`stok`,0) AS `stok_tersedia`, `b`.`stok_minimum` AS `stok_minimum`, (coalesce(`t`.`stok`,0) <= `b`.`stok_minimum`) AS `menipis`, `sp`.`nama` AS `supplier` FROM ((`bahan_baku` `b` left join (select `transaksi_bahan`.`bahan_id` AS `bahan_id`,sum(`transaksi_bahan`.`jumlah`) AS `stok` from `transaksi_bahan` group by `transaksi_bahan`.`bahan_id`) `t` on((`t`.`bahan_id` = `b`.`id`))) left join `supplier` `sp` on((`sp`.`id` = `b`.`supplier_id`))) WHERE (`b`.`aktif` = 1)  ;

-- --------------------------------------------------------

--
-- Structure for view `v_tracking`
--
DROP TABLE IF EXISTS `v_tracking`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_tracking`  AS SELECT `o`.`kode_tracking` AS `kode_tracking`, `o`.`kode_order` AS `kode_order`, `o`.`customer` AS `customer`, `o`.`instansi` AS `instansi`, `o`.`jenis_order` AS `jenis_produk`, `o`.`jumlah` AS `jumlah`, `s`.`model_cuttingan` AS `model_cuttingan`, `s`.`bahan` AS `bahan`, `s`.`warna` AS `warna`, `s`.`lengan` AS `lengan`, `o`.`lanyard` AS `lanyard`, `o`.`id_card` AS `id_card`, `o`.`sablon` AS `sablon`, `o`.`bordir` AS `bordir`, `s`.`model_saku` AS `model_saku`, `s`.`tambahan` AS `tambahan`, `s`.`variasi_lain` AS `variasi_lain`, `o`.`deadline` AS `deadline`, `o`.`status_pembayaran` AS `status_pembayaran`, `o`.`tahap_saat_ini` AS `tahap_saat_ini`, round(((100 * (`o`.`urutan_tahap` - 1)) / (select (max(`tahap_produksi`.`urutan`) - min(`tahap_produksi`.`urutan`)) from `tahap_produksi`)),0) AS `progres_persen` FROM (`v_order` `o` left join `spesifikasi_pesanan` `s` on((`s`.`pesanan_id` = `o`.`no`))) WHERE (`o`.`status_order` <> 'BATAL')  ;

-- --------------------------------------------------------

--
-- Structure for view `v_tracking_riwayat`
--
DROP TABLE IF EXISTS `v_tracking_riwayat`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_tracking_riwayat`  AS SELECT `p`.`kode_tracking` AS `kode_tracking`, 'Order Diterima' AS `tahap_baru`, `p`.`dibuat_pada` AS `waktu` FROM `pesanan` AS `p` WHERE (`p`.`status_order` <> 'BATAL') union all select `p`.`kode_tracking` AS `kode_tracking`,`r`.`tahap_baru` AS `tahap_baru`,`r`.`waktu` AS `waktu` from (`riwayat_tahap` `r` join `pesanan` `p` on((`p`.`id` = `r`.`pesanan_id`))) where (`p`.`status_order` <> 'BATAL')  ;

-- --------------------------------------------------------

--
-- Structure for view `v_tracking_ukuran`
--
DROP TABLE IF EXISTS `v_tracking_ukuran`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_tracking_ukuran`  AS SELECT `p`.`kode_tracking` AS `kode_tracking`, `u`.`ukuran` AS `ukuran`, `u`.`jumlah` AS `jumlah` FROM (`ukuran_pesanan` `u` join `pesanan` `p` on((`p`.`id` = `u`.`pesanan_id`))) WHERE (`p`.`status_order` <> 'BATAL')  ;

-- --------------------------------------------------------

--
-- Structure for view `v_transaksi_keuangan`
--
DROP TABLE IF EXISTS `v_transaksi_keuangan`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_transaksi_keuangan`  AS SELECT `v_laporan_pemasukan`.`tanggal_transaksi` AS `tanggal`, 'PEMASUKAN_ORDER' AS `jenis_transaksi`, `v_laporan_pemasukan`.`kode_order` AS `kode_order`, `v_laporan_pemasukan`.`nomor_invoice` AS `nomor_invoice`, `v_laporan_pemasukan`.`customer` AS `customer`, concat('Order ',`v_laporan_pemasukan`.`kode_order`) AS `referensi`, `v_laporan_pemasukan`.`keterangan` AS `keterangan`, `v_laporan_pemasukan`.`total_pembayaran` AS `pemasukan`, 0 AS `pengeluaran`, `v_laporan_pemasukan`.`status_pembayaran` AS `status_pembayaran` FROM `v_laporan_pemasukan` union all select `v_pengeluaran`.`tanggal` AS `tanggal`,`v_pengeluaran`.`jenis_transaksi` AS `jenis_transaksi`,`v_pengeluaran`.`kode_order` AS `kode_order`,`v_pengeluaran`.`nomor_invoice` AS `nomor_invoice`,NULL AS `NULL`,`v_pengeluaran`.`referensi` AS `referensi`,`v_pengeluaran`.`keterangan` AS `keterangan`,0 AS `0`,`v_pengeluaran`.`jumlah` AS `jumlah`,NULL AS `NULL` from `v_pengeluaran`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_transaksi_pembayaran`
--
DROP TABLE IF EXISTS `v_transaksi_pembayaran`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_transaksi_pembayaran`  AS SELECT `pb`.`id` AS `pembayaran_id`, `pb`.`tanggal_bayar` AS `tanggal`, `o`.`kode_order` AS `kode_order`, `i`.`nomor_invoice` AS `nomor_invoice`, `o`.`customer` AS `customer`, `o`.`instansi` AS `instansi`, `o`.`jenis_order` AS `jenis_produk`, `pb`.`jenis` AS `jenis_transaksi`, `pb`.`jumlah` AS `jumlah`, `pb`.`metode` AS `metode`, `o`.`status_pembayaran` AS `status_pembayaran`, `pb`.`keterangan` AS `keterangan` FROM ((`pembayaran` `pb` join `v_order` `o` on((`o`.`no` = `pb`.`pesanan_id`))) join `invoice` `i` on((`i`.`id` = `pb`.`invoice_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_work_order`
--
DROP TABLE IF EXISTS `v_work_order`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_work_order`  AS SELECT `w`.`nomor_wo` AS `nomor_wo`, `w`.`tanggal_wo` AS `tanggal_wo`, `w`.`status_wo` AS `status_wo`, `o`.`kode_order` AS `kode_order`, `o`.`customer` AS `customer`, `o`.`instansi` AS `instansi`, `o`.`jenis_order` AS `jenis_produk`, `o`.`jumlah` AS `jumlah`, (select group_concat(concat(`u`.`ukuran`,': ',`u`.`jumlah`) order by `u`.`ukuran` ASC separator ', ') from `ukuran_pesanan` `u` where (`u`.`pesanan_id` = `o`.`no`)) AS `rincian_ukuran`, `s`.`model_cuttingan` AS `model_cuttingan`, `s`.`bahan` AS `bahan`, `s`.`warna` AS `warna`, `s`.`status_desain` AS `status_desain`, `s`.`catatan_desain` AS `catatan_desain`, (select group_concat(`f`.`lokasi_file` separator ', ') from `file_desain` `f` where (`f`.`pesanan_id` = `o`.`no`)) AS `file_desain`, `s`.`lengan` AS `lengan`, `o`.`lanyard` AS `lanyard`, `o`.`id_card` AS `id_card`, `o`.`sablon` AS `sablon`, `o`.`bordir` AS `bordir`, `s`.`ket_bordir_sablon` AS `ket_bordir_sablon`, `s`.`model_saku` AS `model_saku`, `s`.`tambahan` AS `tambahan`, `s`.`variasi_lain` AS `variasi_lain`, `o`.`deadline` AS `deadline`, `w`.`catatan_produksi` AS `catatan_produksi`, `o`.`tahap_saat_ini` AS `tahap_saat_ini` FROM ((`work_order` `w` join `v_order` `o` on((`o`.`no` = `w`.`pesanan_id`))) left join `spesifikasi_pesanan` `s` on((`s`.`pesanan_id` = `w`.`pesanan_id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bahan_unik` (`nama`,`warna`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `file_desain`
--
ALTER TABLE `file_desain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesanan_id` (`pesanan_id`),
  ADD UNIQUE KEY `nomor_invoice` (`nomor_invoice`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `kebutuhan_bahan`
--
ALTER TABLE `kebutuhan_bahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kebutuhan_unik` (`work_order_id`,`bahan_id`),
  ADD KEY `bahan_id` (`bahan_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_whatsapp` (`no_whatsapp`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_pesanan_idx` (`pesanan_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `diajukan_oleh` (`diajukan_oleh`),
  ADD KEY `disetujui_oleh` (`disetujui_oleh`);

--
-- Indexes for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelian_id` (`pembelian_id`),
  ADD KEY `bahan_id` (`bahan_id`);

--
-- Indexes for table `pengeluaran_lain`
--
ALTER TABLE `pengeluaran_lain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_tracking` (`kode_tracking`),
  ADD KEY `pesanan_status_idx` (`status_order`,`tahap_saat_ini`),
  ADD KEY `pesanan_deadline_idx` (`deadline`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `fk_pesanan_tahap` (`tahap_saat_ini`);

--
-- Indexes for table `qc`
--
ALTER TABLE `qc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_id` (`work_order_id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`),
  ADD KEY `fk_qc_tahap` (`kembali_ke_tahap`);

--
-- Indexes for table `riwayat_perubahan`
--
ALTER TABLE `riwayat_perubahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_perubahan_idx` (`nama_tabel`,`id_data`),
  ADD KEY `diubah_oleh` (`diubah_oleh`);

--
-- Indexes for table `riwayat_tahap`
--
ALTER TABLE `riwayat_tahap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_tahap_idx` (`pesanan_id`,`waktu`),
  ADD KEY `diubah_oleh` (`diubah_oleh`);

--
-- Indexes for table `spesifikasi_pesanan`
--
ALTER TABLE `spesifikasi_pesanan`
  ADD PRIMARY KEY (`pesanan_id`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahap_produksi`
--
ALTER TABLE `tahap_produksi`
  ADD PRIMARY KEY (`nama`),
  ADD UNIQUE KEY `urutan` (`urutan`);

--
-- Indexes for table `transaksi_bahan`
--
ALTER TABLE `transaksi_bahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembelian_item_id` (`pembelian_item_id`),
  ADD UNIQUE KEY `stok_opname_id` (`stok_opname_id`),
  ADD KEY `transaksi_bahan_idx` (`bahan_id`),
  ADD KEY `work_order_id` (`work_order_id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indexes for table `ukuran_pesanan`
--
ALTER TABLE `ukuran_pesanan`
  ADD PRIMARY KEY (`pesanan_id`,`ukuran`);

--
-- Indexes for table `work_order`
--
ALTER TABLE `work_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_desain`
--
ALTER TABLE `file_desain`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kebutuhan_bahan`
--
ALTER TABLE `kebutuhan_bahan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengeluaran_lain`
--
ALTER TABLE `pengeluaran_lain`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qc`
--
ALTER TABLE `qc`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_perubahan`
--
ALTER TABLE `riwayat_perubahan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_tahap`
--
ALTER TABLE `riwayat_tahap`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_bahan`
--
ALTER TABLE `transaksi_bahan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_order`
--
ALTER TABLE `work_order`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD CONSTRAINT `bahan_baku_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `file_desain`
--
ALTER TABLE `file_desain`
  ADD CONSTRAINT `file_desain_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `kebutuhan_bahan`
--
ALTER TABLE `kebutuhan_bahan`
  ADD CONSTRAINT `kebutuhan_bahan_ibfk_1` FOREIGN KEY (`work_order_id`) REFERENCES `work_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kebutuhan_bahan_ibfk_2` FOREIGN KEY (`bahan_id`) REFERENCES `bahan_baku` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`diajukan_oleh`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `pembelian_ibfk_4` FOREIGN KEY (`disetujui_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `pembelian_item`
--
ALTER TABLE `pembelian_item`
  ADD CONSTRAINT `pembelian_item_ibfk_1` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_item_ibfk_2` FOREIGN KEY (`bahan_id`) REFERENCES `bahan_baku` (`id`);

--
-- Constraints for table `pengeluaran_lain`
--
ALTER TABLE `pengeluaran_lain`
  ADD CONSTRAINT `pengeluaran_lain_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pengeluaran_lain_ibfk_2` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_tahap` FOREIGN KEY (`tahap_saat_ini`) REFERENCES `tahap_produksi` (`nama`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `qc`
--
ALTER TABLE `qc`
  ADD CONSTRAINT `fk_qc_tahap` FOREIGN KEY (`kembali_ke_tahap`) REFERENCES `tahap_produksi` (`nama`),
  ADD CONSTRAINT `qc_ibfk_1` FOREIGN KEY (`work_order_id`) REFERENCES `work_order` (`id`),
  ADD CONSTRAINT `qc_ibfk_2` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `riwayat_perubahan`
--
ALTER TABLE `riwayat_perubahan`
  ADD CONSTRAINT `riwayat_perubahan_ibfk_1` FOREIGN KEY (`diubah_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `riwayat_tahap`
--
ALTER TABLE `riwayat_tahap`
  ADD CONSTRAINT `riwayat_tahap_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `riwayat_tahap_ibfk_2` FOREIGN KEY (`diubah_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `spesifikasi_pesanan`
--
ALTER TABLE `spesifikasi_pesanan`
  ADD CONSTRAINT `spesifikasi_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD CONSTRAINT `stok_opname_ibfk_1` FOREIGN KEY (`bahan_id`) REFERENCES `bahan_baku` (`id`),
  ADD CONSTRAINT `stok_opname_ibfk_2` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `transaksi_bahan`
--
ALTER TABLE `transaksi_bahan`
  ADD CONSTRAINT `fk_transaksi_opname` FOREIGN KEY (`stok_opname_id`) REFERENCES `stok_opname` (`id`),
  ADD CONSTRAINT `fk_transaksi_pembelian_item` FOREIGN KEY (`pembelian_item_id`) REFERENCES `pembelian_item` (`id`),
  ADD CONSTRAINT `transaksi_bahan_ibfk_1` FOREIGN KEY (`bahan_id`) REFERENCES `bahan_baku` (`id`),
  ADD CONSTRAINT `transaksi_bahan_ibfk_2` FOREIGN KEY (`work_order_id`) REFERENCES `work_order` (`id`),
  ADD CONSTRAINT `transaksi_bahan_ibfk_3` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Constraints for table `ukuran_pesanan`
--
ALTER TABLE `ukuran_pesanan`
  ADD CONSTRAINT `ukuran_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_order`
--
ALTER TABLE `work_order`
  ADD CONSTRAINT `work_order_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `work_order_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
