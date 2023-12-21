-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 21, 2023 lúc 05:10 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbannoithat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `maAdmin` int(11) NOT NULL,
  `tenAdmin` varchar(35) NOT NULL,
  `passWord` varchar(15) NOT NULL,
  `hinh` varchar(20) DEFAULT 'default.png',
  `sdt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`maAdmin`, `tenAdmin`, `passWord`, `hinh`, `sdt`) VALUES
(1, 'Hoàng Gia Bảo', 'Bao123456', 'default.png', '0859003536');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `maKhachHang` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hang`
--

CREATE TABLE `hang` (
  `maHang` int(11) NOT NULL,
  `tenHang` varchar(100) NOT NULL,
  `moTa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hang`
--

INSERT INTO `hang` (`maHang`, `tenHang`, `moTa`) VALUES
(1, 'Hãng làm đồ gỗ', 'làm đồ gỗ'),
(2, 'Hãng làm đồ sứ', 'làm đồ sứ'),
(3, 'Hãng làm đồ thủy tinh', 'làm đồ thủy tinh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `maKhachHang` int(11) NOT NULL,
  `tenKhachHang` varchar(35) NOT NULL,
  `passWord` varchar(15) NOT NULL,
  `hinh` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`maKhachHang`, `tenKhachHang`, `passWord`, `hinh`) VALUES
(1, 'Lê Minh trung', 'Trung123', NULL),
(2, 'Hà Thị Diễm My', 'My12345', NULL),
(3, 'Đặng Ngọc Trâm', 'Tram1234', NULL),
(4, 'Hoàng Thái Bảo', 'Bao123456', NULL),
(5, 'Hoàng Thùy Linh', 'Linh1234', NULL),
(6, 'Nguyễn Thanh Tâm', 'Tam12345', NULL),
(7, 'Lê Thanh Thúy', 'Thuy123', NULL),
(8, 'Nguyễn Hà Văn Tuấn Thanh', 'Thanh123', '8.png'),
(9, 'Hoàng Thiên Tân', 'Tan12345', NULL),
(10, 'Hà Thanh Văn', 'Van12345', '10.png'),
(11, 'Hoàng Thiên Vũ', 'Vu123456', '11.png'),
(12, 'hoang', 'duckien28', '12.png'),
(13, 'Thanh Trần', 'Tran12345', '13.png'),
(14, 'Hoang Van Tuan', 'Tuan12345', '14.png'),
(15, 'Le Van Thanh', 'Thanh123', '15.png'),
(16, 'Tung Le', '21032001', '16.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang_sdt`
--

CREATE TABLE `khachhang_sdt` (
  `sdt` varchar(10) NOT NULL,
  `maKhachHang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang_sdt`
--

INSERT INTO `khachhang_sdt` (`sdt`, `maKhachHang`) VALUES
('0135789276', 4),
('0248795639', 5),
('0328918705', 3),
('0723456715', 1),
('0857832567', 11),
('0858002127', 10),
('0858004547', 10),
('0859002124', 15),
('0859002125', 16),
('0859002425', 14),
('0859237198', 8),
('0859238888', 8),
('0867233679', 13),
('0912736448', 2),
('0918236785', 7),
('0918723456', 13),
('0943526485', 9),
('0972146783', 6),
('0985345677', 4),
('1234567890', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `maLoai` int(11) NOT NULL,
  `tenLoai` varchar(100) NOT NULL,
  `moTa` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`maLoai`, `tenLoai`, `moTa`) VALUES
(1, 'Bàn', 0),
(2, 'Ghế', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `maSanPham` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `gia` int(11) NOT NULL,
  `giaMoi` int(11) NOT NULL DEFAULT 0,
  `moTa` text NOT NULL,
  `maLoai` int(11) NOT NULL,
  `maHang` int(11) NOT NULL,
  `hinh` varchar(50) NOT NULL,
  `ngayTao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`maSanPham`, `tenSanPham`, `gia`, `giaMoi`, `moTa`, `maLoai`, `maHang`, `hinh`, `ngayTao`) VALUES
(3, 'bàn lớn', 150000, 0, '', 1, 1, '1.png', '2023-12-19 18:55:24'),
(14, 'ghe ghe', 120000, 0, '', 2, 1, '589450.png', '2023-12-21 10:41:02'),
(17, 'hang go_ban', 1230000, 1200000, '', 1, 2, '816061.png', '2023-12-21 11:35:14'),
(18, 'hang thuy tinh_ban', 1400000, 0, '', 1, 3, '154124.png', '2023-12-21 11:35:39'),
(19, 'hang go_ghe', 123, 0, '', 2, 1, '429928.png', '2023-12-21 11:36:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`maAdmin`);

--
-- Chỉ mục cho bảng `hang`
--
ALTER TABLE `hang`
  ADD PRIMARY KEY (`maHang`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`maKhachHang`);

--
-- Chỉ mục cho bảng `khachhang_sdt`
--
ALTER TABLE `khachhang_sdt`
  ADD PRIMARY KEY (`sdt`,`maKhachHang`),
  ADD UNIQUE KEY `sdt` (`sdt`),
  ADD KEY `maKhachHang` (`maKhachHang`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`maLoai`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`maSanPham`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `maAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `hang`
--
ALTER TABLE `hang`
  MODIFY `maHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `maKhachHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `maLoai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `maSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `khachhang_sdt`
--
ALTER TABLE `khachhang_sdt`
  ADD CONSTRAINT `khachhang_sdt_ibfk_1` FOREIGN KEY (`maKhachHang`) REFERENCES `khachhang` (`maKhachHang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
