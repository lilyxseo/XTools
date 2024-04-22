-- Backup database pada 2024-04-23 03:45:13

CREATE TABLE `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `registrar` varchar(255) NOT NULL,
  `name_servers` text NOT NULL,
  `search_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `owner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO domains VALUES
('41', 'bydrz.com', '2023-09-08', '2024-09-08', 'COSMOTOWN, INC.', 'Name Server 1: lennon.ns.cloudflare.com<br>Name Server 2: sara.ns.cloudflare.com<br>', '2023-11-17 05:30:00', 'bydrz'),
('42', 'lily.com', '1996-12-11', '2025-12-10', 'Network Solutions, LLC', 'Name Server 1: NS3.WORLDNIC.COM<br>Name Server 2: NS4.WORLDNIC.COM<br>', '2023-11-17 05:46:00', 'bydrz'),
('43', 'alhikamsurabaya.sch.id', '2022-01-05', '2024-01-04', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('44', 'bintangislam-cpy.sch.id', '2022-01-19', '2024-01-18', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('45', 'dwpkedungrejo.sch.id', '2020-11-12', '2024-11-11', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('46', 'ihyaulumiddin.sch.id', '2022-03-07', '2024-03-07', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('47', 'insankamilsidoarjo.sch.id', '2012-10-04', '2024-10-03', 'Digital Registra', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('48', 'kbramathlabulhuda.sch.id', '2022-12-20', '2023-12-19', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('49', 'kbramujahidin.sch.id', '2023-05-23', '2024-05-22', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('50', 'kbtklabum.sch.id', '2020-04-17', '2024-04-16', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('51', 'mtsnupakis.sch.id', '2020-07-27', '2024-07-26', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('52', 'paudlabumblitar.sch.id', '2021-07-01', '2024-06-30', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('53', 'pelangiceria.sch.id', '2018-03-13', '2024-03-12', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('54', 'pgtktpaislamarrasyid.sch.id', '2020-07-17', '2024-07-16', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('55', 'ponpesalkhairattanjungselor.sch.id', '2018-03-28', '2024-03-28', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('56', 'radcalmuhajirin.sch.id', '2023-04-04', '2024-04-03', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('57', 'rarobithoh.sch.id', '2022-01-24', '2024-01-23', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('58', 'sd-mujahidin.sch.id', '2022-12-30', '2024-12-29', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('59', 'sdiarroudlohmiru.sch.id', '2020-02-28', '2024-02-27', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('60', 'sdlabum.sch.id', '2017-12-01', '2023-11-30', 'Digital Registra', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('61', 'sdlabumblitar.sch.id', '2021-08-12', '2024-08-12', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('62', 'sdmujahidin2surabaya.sch.id', '2023-06-05', '2024-06-04', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('63', 'sekolahdaarunnahlcilegon.sch.id', '2020-11-05', '2024-11-05', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('64', 'smaalfalah-ketintang.sch.id', '2021-03-16', '2024-03-15', 'Digital Registra', 'Name Server 1: ns1.niagahoster.com<br>Name Server 2: ns2.niagahoster.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('65', 'smabudimurni2jakarta.sch.id', '2023-02-08', '2024-02-07', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('66', 'smamujahidin-sby.sch.id', '2023-07-11', '2024-07-10', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('67', 'smatulusbhakti.sch.id', '2023-02-22', '2024-02-21', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('68', 'smk-islambatu.sch.id', '2022-10-24', '2024-10-24', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('69', 'smpbhayangkari1sby.sch.id', '2023-08-02', '2024-08-01', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('70', 'smpbudimurni2.sch.id', '2023-01-30', '2024-01-29', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:07:00', 'bydrz'),
('71', 'smptagsby.sch.id', '2023-05-11', '2024-05-10', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 15:09:00', 'bydrz'),
('72', 'sadang-jatirogo.desa.id', '2017-09-26', '2024-09-25', 'Kementerian Komunikasi dan Informatika', 'Name Server 1: cl1.hosterbyte.net<br>Name Server 2: cl2.hosterbyte.net<br>', '2023-11-17 15:09:00', 'bydrz'),
('74', 'hosterbyte.net', '2017-12-05', '2023-12-05', 'CV. Jogjacamp', 'Name Server 1: pam.ns.cloudflare.com<br>Name Server 2: rocky.ns.cloudflare.com<br>', '2023-11-18 04:31:00', '123');

CREATE TABLE `login_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cookie_value` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO login_cookies VALUES
('20', '1', 'b8bca98cd748a56134c8fd54ca3ed010', '2023-11-16 08:16:44'),
('21', '1', 'e97cefa104241425601cb2808e158ccb', '2023-11-16 14:59:12'),
('22', '1', '0ba2063a7a611d05ab70aca0c924c602', '2023-11-16 14:59:39'),
('23', '1', '078ecdf9cf252165cc50f0e83554b26b', '2023-11-16 15:06:59'),
('24', '1', 'c96ba343e3b1784e95562699bcbdf022', '2023-11-17 02:39:08'),
('25', '1', '07228d6851835f124533655695f41309', '2023-11-17 02:44:58'),
('26', '1', 'e70c0db3146c96831c796b664fe4216e', '2023-11-17 15:03:06'),
('27', '1', 'f5aef8ab64a38ca9eae1ffb20a1a505d', '2023-11-18 04:23:00'),
('28', '7', '5a90daeaeefd5bd262fdc2ed67f5fe88', '2023-11-18 04:24:12'),
('29', '1', 'ba602669d5278353488dce22af0d6c00', '2023-11-18 04:32:46'),
('30', '1', 'f18a98594aae4ab41c4f998ef67c2174', '2023-11-19 09:02:14'),
('31', '1', '8195b286de1717a2239462d59a3b6c00', '2023-11-19 09:31:31'),
('32', '1', '44e8e5476446ed892a8ca50cadaf2841', '2023-12-05 01:24:07'),
('33', '1', '5942f79f99656b60fecc5356f11f7367', '2024-01-11 06:59:44'),
('34', '1', 'ea4c83eaa203a721dba13c7ba16c4eea', '2024-04-02 08:54:06'),
('35', '1', 'd00d9a2e83ef71ab25db0af8a90a5d26', '2024-04-02 15:21:17'),
('36', '1', 'c0b0cc01c8984dc04f2c8e03ac56d2bb', '2024-04-02 19:16:41'),
('37', '1', 'f9ad919cac113e129175da6789782e24', '2024-04-02 19:38:12'),
('38', '1', 'da8a2eda2717bf2e87abc966d38b06dc', '2024-04-02 19:38:29'),
('39', '1', '86c7afbefa7cb1b63c4307817cda0e1e', '2024-04-02 19:44:12'),
('40', '8', '5dd772f859925b2c9717bb3e672ab86a', '2024-04-02 19:56:12'),
('41', '1', '53ebdc5c7dbde78bfb6ecd53fa4939c8', '2024-04-02 19:57:03'),
('42', '1', '576e068555b40b6180d10f2a4cf84518', '2024-04-02 20:35:29'),
('43', '1', '94dec7b2eefe588bfbc483a3f6a23e29', '2024-04-03 08:39:30'),
('44', '1', 'a886b146384dc3f58593fb30dd935815', '2024-04-03 10:27:56'),
('45', '1', '92555c0393ab2962ad575614c5e63a13', '2024-04-03 10:28:20'),
('46', '1', '62716785c71af986c44d2386a747050e', '2024-04-03 10:29:10'),
('47', '9', '8d1099b9cdf424041b53809c4971e03c', '2024-04-03 10:31:39'),
('48', '9', '720e78a8c5ede2cfafd846c547abb4f4', '2024-04-03 10:32:34'),
('49', '1', '52027403628b3d9d7ed49d0eac255c00', '2024-04-03 10:33:57'),
('50', '1', '360044220a250ce58c7560b54fa7f953', '2024-04-03 10:35:33'),
('51', '1', '012390cb42778e9ec1c4c101153c7039', '2024-04-03 10:37:31'),
('52', '1', '85e8abe013c0f09535c5e454e2ee2cbd', '2024-04-03 17:59:08'),
('53', '1', '82fd0968129d5e52108ace0c18125da1', '2024-04-03 19:43:47'),
('54', '1', 'ae9067e6e05799551d41cca48d2c54e2', '2024-04-03 19:44:45'),
('55', '1', '878e31cb4c15a038691310c125c0adc9', '2024-04-03 19:45:56'),
('56', '1', '1e3aea925940f2488e4b709f0683af9d', '2024-04-03 19:48:32'),
('57', '1', '4b67e05c91829ca2e692c84f77c84a4f', '2024-04-03 19:51:53'),
('58', '1', '77b5cdb35e4b2bb6f613c983fb85a0b3', '2024-04-03 19:59:53'),
('59', '1', '90a4cc46fcfa55aca09ced297bdfdb51', '2024-04-03 20:03:27'),
('60', '1', 'f2b8811306f6460b8b0f074a948b7725', '2024-04-03 20:04:13'),
('61', '1', 'f80b4d2a375d175d336e87b68050173a', '2024-04-04 09:03:53'),
('62', '1', '844860af4ac35122da11bf392a069a64', '2024-04-05 09:02:06'),
('63', '1', 'c492649dffb5e6b54aa0716b0896f463', '2024-04-06 07:28:48'),
('64', '1', '4e827a78b57bfd2b2b6aa1be01d208c7', '2024-04-06 17:15:54'),
('65', '1', 'ab189ae599c1c785aa00269d948ddd8a', '2024-04-07 08:01:33'),
('66', '1', 'a84c09cc37f710db775b0800545e863a', '2024-04-07 16:58:42'),
('67', '1', '89122a1a7741a3e8dde534098fb07718', '2024-04-08 19:57:58'),
('68', '1', 'a310fcd793cee6ef8cba6ab951026156', '2024-04-08 19:58:27'),
('69', '1', '741827e57ac680c20ed44ad2d4e98b7c', '2024-04-10 17:30:56'),
('70', '1', '7c37c3b5ac4c57f4b18113a50e0c7da7', '2024-04-14 16:44:06'),
('71', '1', '788517d864c60a5e0ac5f947c72f9a15', '2024-04-14 17:35:40'),
('72', '1', 'ee5979fd4f3c48ae74b0dfe0c01e11ee', '2024-04-20 23:10:04'),
('73', '1', 'eaba33f33192da4a0520c9dfbf7b498c', '2024-04-21 10:04:31'),
('74', '1', 'ab465ae55f879fbe41b9fca63d6b2251', '2024-04-21 15:16:05'),
('75', '1', '2c6cd96936dd747aca57eed174af74bf', '2024-04-21 15:22:08'),
('76', '1', '215d6e63d7cf5a610d99e788199652ca', '2024-04-21 19:51:20'),
('77', '1', '609163eb4faf9f4e9bc913ed5cc3b217', '2024-04-21 23:27:28'),
('78', '1', 'ba9600d577769f5ed9897a9a15a10ed0', '2024-04-23 01:23:32');

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(255) NOT NULL DEFAULT '#',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO menu VALUES
('1', 'Dashboard', 'bi bi-grid-fill', 'dashboard', '[\"Administrator\", \"Member\"]', '0', 'Home'),
('2', 'Tools', 'bi bi-tools', '#', '[\"Administrator\", \"Member\"]', '0', 'Menu'),
('3', 'NS Checker', '', 'ns', '[\"Administrator\", \"Member\"]', '2', ''),
('7', 'Settings', 'bi bi-gear-fill', '#', '[\"Administrator\"]', '0', 'Admin'),
('8', 'General', '', 'general', '[\"Administrator\"]', '7', ''),
('10', 'Template', '', 'template', '[\"Administrator\"]', '7', ''),
('12', 'Notepad Online', '', 'notepad', '[\"Administrator\", \"Member\"]', '2', ''),
('13', 'Blank Page', 'bi bi-file', 'blank', '[\"Administrator\"]', '0', 'Other'),
('14', 'Manage Menu', '', 'manage', '[\"Administrator\"]', '7', ''),
('16', 'Demo Site', 'bi bi-grid-fill', 'demo/', '[\"Administrator\"]', '0', 'Other'),
('18', 'Bcrypt Generator', '', 'bcrypt', '[\"Administrator\", \"Member\"]', '2', ''),
('63', 'Export database', '', 'export', '[\"Administrator\"]', '7', ''),
('65', 'Cloud File', '', 'cloud', '[\"Administrator\",\"Member\"]', '2', ''),
('66', 'Finance', 'bi bi-currency-dollar', '#', '[\"Administrator\"]', '0', 'Admin'),
('67', 'Crypto', '', 'crypto', '[\"Administrator\"]', '66', ''),
('68', 'Slot', '', 'slot', '[\"Administrator\"]', '66', '');

CREATE TABLE `notepad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `owner` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO notepad VALUES
('8', 'FB Baru', 'id 61553711932072', '2023-11-14 07:36:24', 'bydrz'),
('12', 'sc deface', '&lt;html&gt;&lt;head&gt;&lt;title&gt;Hacked by Anon7&lt;/title&gt;&lt;meta charset=&quot;UTF-8&quot;&gt;&lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;&lt;meta name=&quot;viewport&quot; content=&quot;width=device-width,initial-scale=1&quot;&gt;&lt;meta name=&quot;title&quot; content=&quot;Hacked by Anon7&quot;&gt;&lt;meta name=&quot;description&quot; content=&quot;wh00pz ! your security get down&quot;&gt;&lt;meta name=&quot;keywords&quot; content=&quot;hacked,deface,wordpress,website,whitehat,blackhat,defacer,hack,mirror&quot;&gt;&lt;meta name=&quot;robots&quot; content=&quot;index, follow&quot;&gt;&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;meta name=&quot;language&quot; content=&quot;English&quot;&gt;&lt;meta name=&quot;revisit-after&quot; content=&quot;60 days&quot;&gt;&lt;meta name=&quot;author&quot; content=&quot;Anon7&quot;&gt;&lt;meta property=&quot;og:image&quot; content=&quot;https://i.imgur.com/6RSyvoJ.jpg&quot;&gt;&lt;meta name=&quot;theme-color&quot; content=&quot;#000&quot;&gt;&lt;script src=&quot;https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js&quot;&gt;&lt;/script&gt;&lt;style type=&quot;text/css&quot;&gt;a:hover,body{cursor:url(http://cur.cursors-4u.net/symbols/sym-1/sym46.cur),progress!important}&lt;/style&gt;&lt;link rel=&quot;stylesheet&quot; href=&quot;https://bit.ly/2UGCIC5&quot;&gt;&lt;/head&gt;&lt;body bgcolor=&quot;black&quot; text=&quot;white&quot; oncontextmenu=&quot;return!1&quot; onkeydown=&quot;return!1&quot; onmousedown=&quot;return!1&quot; onclick=&#039;document.getElementById(&quot;lagu&quot;).play(),fs()&#039; id=&quot;body&quot; onload=&quot;typeWriter()&quot;&gt;&lt;style type=&quot;text/css&quot;&gt;center{font-family:Courier}img{opacity:80%}red{color:red}#background-video{height:100vh;width:100vw;object-fit:cover;position:fixed;left:0;right:0;top:0;bottom:0;z-index:-1}font{text-shadow:#000 0 0 3px;-webkit-font-smoothing:antialiased}div{animation:glitch 1s linear infinite}@keyframes glitch{2%,64%{transform:translate(2px,0) skew(0)}4%,60%{transform:translate(-2px,0) skew(0)}62%{transform:translate(0,0) skew(5deg)}}div:after,div:before{content:attr(title);position:absolute;left:0}div:before{animation:glitchTop 1s linear infinite;clip-path:polygon(0 0,100% 0,100% 33%,0 33%);-webkit-clip-path:polygon(0 0,100% 0,100% 33%,0 33%)}@keyframes glitchTop{2%,64%{transform:translate(2px,-2px)}4%,60%{transform:translate(-2px,2px)}62%{transform:translate(13px,-1px) skew(-13deg)}}div:after{animation:glitchBotom 1.5s linear infinite;clip-path:polygon(0 67%,100% 67%,100% 100%,0 100%);-webkit-clip-path:polygon(0 67%,100% 67%,100% 100%,0 100%)}@keyframes glitchBotom{2%,64%{transform:translate(-2px,0)}4%,60%{transform:translate(-2px,0)}62%{transform:translate(-22px,5px) skew(21deg)}}&lt;/style&gt;&lt;script language=&quot;JavaScript&quot;&gt;function confirmExit(){return&quot;are you sure ? wkwk&quot;}function fs(){var e=document.documentElement;e.requestFullscreen?e.requestFullscreen():e.msRequestFullscreen?e.msRequestFullscreen():e.mozRequestFullScreen?e.mozRequestFullScreen():e.webkitRequestFullscreen&amp;&amp;e.webkitRequestFullscreen(),document.getElementById(&quot;body&quot;).style.cursor=&quot;none&quot;,document.onkeydown=function(e){return!1},document.addEventListener(&quot;keydown&quot;,e=&gt;{&quot;F11&quot;==e.key&amp;&amp;e.preventDefault()})}window.onbeforeunload=confirmExit;&lt;/script&gt;&lt;script id=&quot;rendered-js&quot;&gt;document.addEventListener(&quot;DOMContentLoaded&quot;,function(e){var n=[&quot;Wh00pz ! your security get down !&quot;,&quot;Patch it now ! before got hacked again !&quot;,&quot;Don&#039;t worry, your files are safe.&quot;,&quot;Remember ! We are party at your security !&quot;];!function e(t){void 0===n[t]&amp;&amp;setTimeout(function(){e(0)},3e4),t&lt;n[t].length&amp;&amp;function e(t,n,o){n&lt;t.length?(document.getElementById(&quot;hekerabies&quot;).innerHTML=t.substring(0,n+1),setTimeout(function(){e(t,n+1,o)},150)):&quot;function&quot;==typeof o&amp;&amp;setTimeout(o,7e3)}(n[t],0,function(){e(t+1)})}(0)})&lt;/script&gt;&lt;audio src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.m4a&quot; autoplay=&quot;true&quot; id=&quot;lagu&quot; loop=&quot;&quot;&gt;&lt;/audio&gt;&lt;video id=&quot;background-video&quot; src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.webm&quot; autoplay=&quot;&quot; loop=&quot;&quot; muted=&quot;&quot; style=&quot;position:fixed;object-fit:cover&quot; poster=&quot;data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=&quot;&gt;&lt;source src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.webm&quot; type=&quot;video/webm&quot;&gt;&lt;/video&gt;&lt;table width=&quot;100%&quot; height=&quot;80%&quot;&gt;&lt;td&gt;&lt;center&gt;&lt;small&gt;AnonSec Team&lt;/small&gt;&lt;br&gt;&lt;img src=&quot;https://i.imgur.com/OjF1rUq.png&quot; width=&quot;220&quot; height=&quot;220&quot; loading=&quot;lazy&quot; onerror=&#039;this.style.display=&quot;none&quot;&#039;&gt;&lt;br&gt;Hacked by&lt;red&gt;&lt;i&gt; Anon7&lt;/i&gt;&lt;/red&gt;&lt;br&gt;&lt;font size=&quot;2&quot; id=&quot;hekerabies&quot;&gt;&lt;/font&gt;&lt;br&gt;&lt;br&gt;&lt;small&gt;&lt;font size=&quot;1&quot; color=&quot;gray&quot;&gt;anonganteng@protonmail.com&lt;/a&gt;&lt;/font&gt;&lt;/small&gt;&lt;div class=&quot;footer-greetings&quot;&gt;&lt;marquee&gt;&lt;font size=&quot;2&quot;&gt;&lt;b&gt;Greetz&lt;/b&gt;: Type-0 - ./meicookies - MR.HAGAN_404CR4ZY - PohonSagu - FarisGanss - KosameAmegai - K4TSUY4-GH05T - He4l3rz - Unknown1337 - Mr.Grim - Rian Haxor - ChokkaXploiter - MungielL - Nzxsx7 - ./G1L4N6_ST86 - kuroaMEpiKAcyu - UnknownSec - Temp3 - xRyukZ - Mr.Crifty - ./Tikus_HaXoR - RavaFake - Cubjrnet7 - Calutax07 - Mr. Spongebob&lt;/font&gt;&lt;/marquee&gt;&lt;/div&gt;&lt;/td&gt;&lt;/table&gt;&lt;script data-cfasync=&quot;false&quot; src=&quot;/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js&quot;&gt;&lt;/script&gt;', '2023-11-16 15:23:22', 'bydrz'),
('13', 'referensi', 'https://themesdesign.in/neloz/\r\nhttp://demo.tempload.com/turing/\r\nhttps://nerox.vercel.app/\r\nhttps://learning.atheros.ai/\r\n\r\nhttps://elfsight.com/slider-widget/html/', '2024-04-21 19:05:00', 'bydrz'),
('48', 'list desa.id', 'bancar.desa.id\r\nbangunrejo-soko.desa.id\r\nbanjar-widang.desa.id\r\nbanjaragung-rengel.desa.id\r\nbanjarworo-bangilan.desa.id\r\nbanyubang-grabagan.desa.id\r\nbelikanget-tambakboyo.desa.id\r\nbogorejo-bancar.desa.id\r\nbogorejo-merakurak.desa.id\r\nboto-semanding.desa.id\r\nbrangkal-parengan.desa.id\r\nbringin-montong.desa.id\r\nbulumeduro-bancar.desa.id\r\nbulurejo-rengel.desa.id\r\nbunut-widang.desa.id\r\ncampurejo-rengel.desa.id\r\ncangkring-plumpang.desa.id\r\ncekalang-soko.desa.id\r\ncendoro-palang.desa.id\r\ncepokorejo-palang.desa.id\r\ncingklung-bancar.desa.id\r\ncokrowati-tambakboyo.desa.id\r\ncompreng-widang.desa.id\r\ndagangan-parengan.desa.id\r\ndasin-tambakboyo.desa.id\r\ngadon-tambakboyo.desa.id\r\ngaji-kerek.desa.id\r\ngemulung-kerek.desa.id\r\nglagahsari-soko.desa.id\r\nglondonggede-tambakboyo.desa.id\r\ngrabagan.desa.id\r\ngununganyar-soko.desa.id\r\nhargoretno-kerek.desa.id\r\njamprong.desa.id\r\njarorejo-kerek.desa.id\r\njati-soko.desa.id\r\njatiklabang-jatirogo.desa.id\r\njatimulyo-plumpang.desa.id\r\njatisari-bancar.desa.id\r\njatisari-senori.desa.id\r\njegulo-soko.desa.id\r\njenggolo-jenu.desa.id\r\njenu.desa.id\r\njetak-montong.desa.id\r\njlodro.desa.id\r\njombok-jatirogo.desa.id\r\nkablukan-bangilan.desa.id\r\nkaligede-senori.desa.id\r\nkanorejo-rengel.desa.id\r\nkapu-merakurak.desa.id\r\nkarangagung-palang.desa.id\r\nkarangasem-jenu.desa.id\r\nkaranglo-kerek.desa.id\r\nkarangrejo-bancar.desa.id\r\nkasiman-kerek.desa.id\r\nkaterban-senori.desa.id\r\nkayen-bancar.desa.id\r\nkebomlati-plumpang.desa.id\r\nkebonharjo-jatirogo.desa.id\r\nkedungharjo-bangilan.desa.id\r\nkedungharjo-widang.desa.id\r\nkedungmulyo-bangilan.desa.id\r\nkedungrejo-kerek.desa.id\r\nkedungrojo-plumpang.desa.id\r\nkembangbilo.desa.id\r\nkembangbilosatudata.desa.id\r\nkemlaten-parengan.desa.id\r\nkenanti-tambakboyo.desa.id\r\nkendalrejo-soko.desa.id\r\nkenongosari-soko.desa.id\r\nkepohagung-plumpang.desa.id\r\nketambul-palang.desa.id\r\nklakeh-bangilan.desa.id\r\nklotok-plumpang.desa.id\r\nkowang-semanding.desa.id\r\nkradenan-palang.desa.id\r\nkumpulrejo-parengan.desa.id\r\nlajolor-singgahan.desa.id\r\nlatsari-bancar.desa.id\r\nleran-senori.desa.id\r\nlerankulon-palang.desa.id\r\nleranwetan-palang.desa.id\r\nmaibit-rengel.desa.id\r\nmanjung-montong.desa.id\r\nmargorejo-kerek.desa.id\r\nmargorejo-parengan.desa.id\r\nmargosuko-bancar.desa.id\r\nmedalem-senori.desa.id\r\nmenilo-soko.desa.id\r\nmentoro-soko.desa.id\r\nmergoasri-parengan.desa.id\r\nmerkawang-tambakboyo.desa.id\r\nmliwang-kerek.desa.id\r\nmojoagung-soko.desa.id\r\nmojomalang-parengan.desa.id\r\nmrutuk-widang.desa.id\r\nngadipuro-widang.desa.id\r\nngadirejo-rengel.desa.id\r\nngarum-grabagan.desa.id\r\nngawun-parengan.desa.id\r\nngepon-jatirogo.desa.id\r\nngimbang-palang.desa.id\r\nngino-semanding.desa.id\r\nngrejeng-grabagan.desa.id\r\npabeyan-tambakboyo.desa.id\r\npacing-parengan.desa.id\r\npadasan.desa.id\r\npakel-montong.desa.id\r\npakis-grabagan.desa.id\r\nparangbatu-parengan.desa.id\r\npekuwon-rengel.desa.id\r\npenambangan-semanding.desa.id\r\npenidon-plumpang.desa.id\r\npilkades.sugiharjo.desa.id\r\nplandirejo-plumpang.desa.id\r\npliwetan-palang.desa.id\r\nplumpang.desa.id\r\npongpongan-merakurak.desa.id\r\nprambontergayang-soko.desa.id\r\nprambonwetan-rengel.desa.id\r\nprunggahanwetan-semanding.desa.id\r\npucangan-palang.desa.id\r\npugoh-bancar.desa.id\r\npunggulrejo-rengel.desa.id\r\npurworejo-jenu.desa.id\r\nrayung-senori.desa.id\r\nremen-jenu.desa.id\r\nsadang-jatirogo.desa.id\r\nsambonggede-merakurak.desa.id\r\nsambongrejo-semanding.desa.id\r\nsandingrowo-soko.desa.id\r\nsaringembat-singgahan.desa.id\r\nsawahan-rengel.desa.id\r\nsekardadi-jenu.desa.id\r\nsemanding.desa.id\r\nsembung-parengan.desa.id\r\nsembungrejo-merakurak.desa.id\r\nsembungrejo-plumpang.desa.id\r\nsendangharjo-parengan.desa.id\r\nsendangrejo-parengan.desa.id\r\nsenori-merakurak.desa.id\r\nsiding-bancar.desa.id\r\nsidodadi-bangilan.desa.id\r\nsidohasri.desa.id\r\nsidomukti.desa.id\r\nsidomulyo-bancar.desa.id\r\nsidomulyo-jatirogo.desa.id\r\nsidonganti-kerek.desa.id\r\nsidorejo-kenduruan.desa.id\r\nsidotentrem-bangilan.desa.id\r\nsimo-soko.desa.id\r\nsobontoro-tambakboyo.desa.id\r\nsocorejo-jenu.desa.id\r\nsokogrenjeng.desa.id\r\nsokogunung.desa.id\r\nsokosari-soko.desa.id\r\nsotang-tambakboyo.desa.id\r\nsuciharjo-parengan.desa.id\r\nsugihan-merakurak.desa.id\r\nsugiharjo.desa.id\r\nsugihwaras-jenu.desa.id\r\nsugihwaras-parengan.desa.id\r\nsukoharjo-bancar.desa.id\r\nsukolilo-bancar.desa.id\r\nsukorejo-parengan.desa.id\r\nsumber-merakurak.desa.id\r\nsumberagung-plumpang.desa.id\r\nsumberarum-kerek.desa.id\r\nsumberejo-rengel.desa.id\r\nsumberjo-merakurak.desa.id\r\nsumurcinde-soko.desa.id\r\nsumurgung-palang.desa.id\r\nsumurgung.desa.id\r\nsumurjalak-plumpang.desa.id\r\nsuwalan-jenu.desa.id\r\ntambakboyo-tuban.desa.id\r\ntasikharjo-jenu.desa.id\r\ntawaran.desa.id\r\ntegalagung-semanding.desa.id\r\ntegalsari-widang.desa.id\r\ntemaji-jenu.desa.id\r\ntemayang-kerek.desa.id\r\ntenggerkulon-bancar.desa.id\r\ntenggerwetan-kerek.desa.id\r\ntergambang-bancar.desa.id\r\ntlogoagung-bancar.desa.id\r\ntluwe-soko.desa.id\r\ntobo-merakurak.desa.id\r\ntrantang-kerek.desa.id\r\ntrutup-plumpang.desa.id\r\ntuwirikulon-merakurak.desa.id\r\nwadung-jenu.desa.id\r\nwadung-soko.desa.id\r\nwanglukulon-senori.desa.id\r\nwukirharjo-parengan.desa.id', '2023-11-17 21:57:00', 'bydrz'),
('50', 'list sch.id', 'alhikamsurabaya.sch.id\r\nbintangislam-cpy.sch.id\r\ndwpkedungrejo.sch.id\r\nihyaulumiddin.sch.id\r\ninsankamilsidoarjo.sch.id\r\nkbramathlabulhuda.sch.id\r\nkbramujahidin.sch.id\r\nkbtklabum.sch.id\r\nkbtkmujahidin103sby.sch.id\r\nmtsnupakis.sch.id\r\npaudlabumblitar.sch.id\r\npelangiceria.sch.id\r\npgtktpaislamarrasyid.sch.id\r\nponpesalkhairattanjungselor.sch.id\r\nradcalmuhajirin.sch.id\r\nrarobithoh.sch.id\r\nsd-mujahidin.sch.id\r\nsdiarroudlohmiru.sch.id\r\nsdlabum.sch.id\r\nsdlabumblitar.sch.id\r\nsdmujahidin2surabaya.sch.id\r\nsekolahdaarunnahlcilegon.sch.id\r\nsmaalfalah-ketintang.sch.id\r\nsmabudimurni2jakarta.sch.id\r\nsmaitpsurabaya.sch.id\r\nsmamujahidin-sby.sch.id\r\nsmatulusbhakti.sch.id\r\nsmk-islambatu.sch.id\r\nsmpbhayangkari1sby.sch.id\r\nsmpbudimurni2.sch.id\r\nsmpkpetramlg.sch.id\r\nsmptagsby.sch.id\r\nweb.sdlabum.sch.id\r\nyayasanrobithohsekesalam.sch.id', '2023-11-17 22:04:00', 'bydrz'),
('52', 'hc', 'GET wss://sg4.ssh30.top/ HTTP/1.1[crlf]Host: bughost.com[crlf]Upgrade: websocket[crlf][crlf]\r\n\r\nGET / HTTP/1.1[crlf]Host: sg4.ssh30.top[crlf]Upgrade: websocket[crlf][crlf]', '2024-04-09 02:58:00', 'bydrz'),
('53', 'ssh vip', 'Account has been successfully created!\r\nHostname :\r\nsg8vip30.sshnet.vip\r\nHostname (Cloudflare) :\r\nsg8vip30.cdnws.us\r\nUsername :\r\nsshstores-bydrzsg8vip\r\nPassword :\r\n12345678\r\nPort SSH :\r\n997,1997,22\r\nPort Dropbear :\r\n442,143\r\nPort SSH TLS/SSL :\r\n445\r\nPort Squid Proxy :\r\n3128,8080\r\nPort Websocket :\r\n8880\r\nPort Websocket (SSL) :\r\n2087\r\nPort UDPGW :\r\n7313,7300,7390,7385,7376\r\nCreated :\r\n11 April 2024\r\nExpired :\r\n11 May 2024\r\nif internet unavailable, set manual Remote DNS to 8.8.8.8 or 1.1.1.1\r\n\r\nIf Netflix not work maybe netflix block our dns resolver from your country try another server.\r\n\r\n\r\nGET / HTTP/1.1[crlf]Host: sg8vip30.sshnet.vip[crlf]Upgrade: websocket[crlf][crlf]\r\n\r\nGET wss://sg8vip30.sshnet.vip/ HTTP/1.1[crlf]Host: bughost.com[crlf]Upgrade: websocket[crlf][crlf]\r\n', '2024-04-11 00:31:00', 'bydrz'),
('54', 'List Project', 'copy secreto\r\nhttps://secreto.site/id/1491023\r\n\r\nfinance menu\r\ncrypto\r\nslot', '2024-04-14 23:44:00', 'bydrz'),
('55', 'cmd send file', 'scp elementor.zip root@8.215.6.187:/root', '2024-04-21 10:00:00', 'bydrz'),
('56', 'alibaba', '8.215.6.187\r\nId: root\r\nPw: @Narto210424\r\n\r\nLogin alibaba \r\nId: nartonina@darentcar.com\r\nPw: @Narto210424\r\n\r\nOTP\r\nhttps://totp.danhersam.com/#/4UYOVMFPIPSSMS6RLAEJARS3XAKMNYOGJND4EMOP6XMKNSJJKAPUFGB4L3EGL3IN', '2024-04-21 15:09:00', 'bydrz'),
('57', 'git access token', 'glpat-xC3M5o86Cf3fZE3wbFfv\r\n\r\n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', '2024-04-21 22:33:00', 'bydrz'),
('58', 'projek crypto', 'https://user-images.githubusercontent.com/18032062/133916353-a3f7c5e9-ac4d-47cd-a817-0dc7458a1f31.png', '2024-04-21 23:16:00', 'bydrz');

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) NOT NULL,
  `site_description` text DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO settings VALUES
('1', 'XTools', 'Berisi alat yang di gunakan untuk deface dan mencari kelemahan suatu website, namun tidak hanya alat untuk deface saja, disini juga menyediakan programmer dan lookup tools.', 'logo.svg', 'favicon.svg');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` datetime DEFAULT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'Member',
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES
('1', 'Abi Baydarus', 'bydrz', '$2y$10$ojkNRkC/w6mlpe90P4cr/.DC9s8UJTDCgsAOgegEtfnQt2/R1uM0a', '2023-11-05 23:48:50', 'Administrator', '1712221089.png'),
('4', 'LilyXploit', 'lily', '$2y$10$EnE3pMRW2isvpJh.tEhPOecTse6AZl4uy.RYFWi/KebDyJoW1/udS', '2023-11-07 22:28:15', 'Member', '3.jpg'),
('5', 'Lily Allen', 'allen', '$2y$10$SZ9qQG.aJbej/kRjDSASB.fS5YkMTfgty1XCR.7PRpZj2.8ry9TJ.', '2023-11-14 18:38:07', 'Member', '5.jpg'),
('7', '123', '123', '$2y$10$5ASZ9Rpa3jIqoCR90fKBCu.a8vHJy.6SY9p99xS7lgyAhOXhjShRC', '2023-11-18 11:23:00', 'Member', '3.jpg'),
('8', 'Maulana Ibrohim ', 'imzy', '$2y$10$r.2pwK.P13MVHwzh.wpVFe63ityciIF9Cdk99tjVQUek7e9l48jKq', '2024-04-03 02:56:00', 'Member', '4.jpg'),
('9', 'ee', 'ee', '$2y$10$gCNGRoc51jx..K0vICTXvuShy48UY4aQ.GIIFGfforsD20sFrJHK2', '2024-04-03 17:31:00', 'Member', '8.jpg');

