-- Backup database pada 2024-04-04 15:26:28

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
('41', 'bydrz.com', '2023-09-08', '2024-09-08', 'COSMOTOWN, INC.', 'Name Server 1: lennon.ns.cloudflare.com<br>Name Server 2: sara.ns.cloudflare.com<br>', '2023-11-17 12:30:00', 'bydrz'),
('42', 'lily.com', '1996-12-11', '2025-12-10', 'Network Solutions, LLC', 'Name Server 1: NS3.WORLDNIC.COM<br>Name Server 2: NS4.WORLDNIC.COM<br>', '2023-11-17 12:46:00', 'bydrz'),
('43', 'alhikamsurabaya.sch.id', '2022-01-05', '2024-01-04', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('44', 'bintangislam-cpy.sch.id', '2022-01-19', '2024-01-18', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('45', 'dwpkedungrejo.sch.id', '2020-11-12', '2024-11-11', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('46', 'ihyaulumiddin.sch.id', '2022-03-07', '2024-03-07', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('47', 'insankamilsidoarjo.sch.id', '2012-10-04', '2024-10-03', 'Digital Registra', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('48', 'kbramathlabulhuda.sch.id', '2022-12-20', '2023-12-19', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('49', 'kbramujahidin.sch.id', '2023-05-23', '2024-05-22', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('50', 'kbtklabum.sch.id', '2020-04-17', '2024-04-16', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('51', 'mtsnupakis.sch.id', '2020-07-27', '2024-07-26', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('52', 'paudlabumblitar.sch.id', '2021-07-01', '2024-06-30', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('53', 'pelangiceria.sch.id', '2018-03-13', '2024-03-12', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('54', 'pgtktpaislamarrasyid.sch.id', '2020-07-17', '2024-07-16', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('55', 'ponpesalkhairattanjungselor.sch.id', '2018-03-28', '2024-03-28', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('56', 'radcalmuhajirin.sch.id', '2023-04-04', '2024-04-03', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('57', 'rarobithoh.sch.id', '2022-01-24', '2024-01-23', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('58', 'sd-mujahidin.sch.id', '2022-12-30', '2024-12-29', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('59', 'sdiarroudlohmiru.sch.id', '2020-02-28', '2024-02-27', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('60', 'sdlabum.sch.id', '2017-12-01', '2023-11-30', 'Digital Registra', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('61', 'sdlabumblitar.sch.id', '2021-08-12', '2024-08-12', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('62', 'sdmujahidin2surabaya.sch.id', '2023-06-05', '2024-06-04', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('63', 'sekolahdaarunnahlcilegon.sch.id', '2020-11-05', '2024-11-05', 'PT Registrasi Nama Domain', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('64', 'smaalfalah-ketintang.sch.id', '2021-03-16', '2024-03-15', 'Digital Registra', 'Name Server 1: ns1.niagahoster.com<br>Name Server 2: ns2.niagahoster.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('65', 'smabudimurni2jakarta.sch.id', '2023-02-08', '2024-02-07', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('66', 'smamujahidin-sby.sch.id', '2023-07-11', '2024-07-10', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('67', 'smatulusbhakti.sch.id', '2023-02-22', '2024-02-21', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('68', 'smk-islambatu.sch.id', '2022-10-24', '2024-10-24', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('69', 'smpbhayangkari1sby.sch.id', '2023-08-02', '2024-08-01', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('70', 'smpbudimurni2.sch.id', '2023-01-30', '2024-01-29', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:07:00', 'bydrz'),
('71', 'smptagsby.sch.id', '2023-05-11', '2024-05-10', 'ResellerCamp', 'Name Server 1: adam.ns.cloudflare.com<br>Name Server 2: aria.ns.cloudflare.com<br>', '2023-11-17 22:09:00', 'bydrz'),
('72', 'sadang-jatirogo.desa.id', '2017-09-26', '2024-09-25', 'Kementerian Komunikasi dan Informatika', 'Name Server 1: cl1.hosterbyte.net<br>Name Server 2: cl2.hosterbyte.net<br>', '2023-11-17 22:09:00', 'bydrz'),
('74', 'hosterbyte.net', '2017-12-05', '2023-12-05', 'CV. Jogjacamp', 'Name Server 1: pam.ns.cloudflare.com<br>Name Server 2: rocky.ns.cloudflare.com<br>', '2023-11-18 11:31:00', '123');

CREATE TABLE `login_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cookie_value` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `login_cookies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO login_cookies VALUES
('37', '1', 'bdf52b5f64d04e62f183fb4bc19b2844', '2024-04-04 01:38:23');

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(255) NOT NULL DEFAULT '#',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '["Administrator", "Member"]',
  `parent_id` int(11) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO menu VALUES
('1', 'Dashboard', 'bi bi-grid-fill', 'dashboard', '[\"Administrator\", \"Member\"]', '', 'Home'),
('2', 'Tools', 'bi bi-tools', '#', '[\"Administrator\", \"Member\"]', '', 'Menu'),
('3', 'NS Checker', '', 'ns', '[\"Administrator\", \"Member\"]', '2', ''),
('7', 'Settings', 'bi bi-gear-fill', '#', '[\"Administrator\"]', '', 'Admin'),
('8', 'General', '', 'general', '[\"Administrator\"]', '7', ''),
('10', 'Template', '', 'template', '[\"Administrator\"]', '7', ''),
('12', 'Notepad Online', '', 'notepad', '[\"Administrator\", \"Member\"]', '2', ''),
('13', 'Blank Page', 'bi bi-file', 'blank', '[\"Administrator\"]', '', 'Other'),
('14', 'Manage Menu', '', 'manage', '[\"Administrator\"]', '7', ''),
('16', 'Demo Site', 'bi bi-grid-fill', 'demo/', '[\"Administrator\"]', '', 'Other'),
('18', 'Bcrypt Generator', '', 'bcrypt', '[\"Administrator\", \"Member\"]', '2', ''),
('19', 'URL Cleaner', '', 'cleaner', '[\"Administrator\", \"Member\"]', '2', ''),
('63', 'Export database', '', 'export', '[\"Administrator\"]', '7', ''),
('67', 'Cloud File', '', 'cloud', '[\"Administrator\",\"Member\"]', '2', '');

CREATE TABLE `notepad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `owner` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO notepad VALUES
('8', 'FB Baru', 'id 61553711932072', '2023-11-14 07:36:24', 'bydrz'),
('12', 'sc deface', '&lt;html&gt;&lt;head&gt;&lt;title&gt;Hacked by Anon7&lt;/title&gt;&lt;meta charset=&quot;UTF-8&quot;&gt;&lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;&lt;meta name=&quot;viewport&quot; content=&quot;width=device-width,initial-scale=1&quot;&gt;&lt;meta name=&quot;title&quot; content=&quot;Hacked by Anon7&quot;&gt;&lt;meta name=&quot;description&quot; content=&quot;wh00pz ! your security get down&quot;&gt;&lt;meta name=&quot;keywords&quot; content=&quot;hacked,deface,wordpress,website,whitehat,blackhat,defacer,hack,mirror&quot;&gt;&lt;meta name=&quot;robots&quot; content=&quot;index, follow&quot;&gt;&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;meta name=&quot;language&quot; content=&quot;English&quot;&gt;&lt;meta name=&quot;revisit-after&quot; content=&quot;60 days&quot;&gt;&lt;meta name=&quot;author&quot; content=&quot;Anon7&quot;&gt;&lt;meta property=&quot;og:image&quot; content=&quot;https://i.imgur.com/6RSyvoJ.jpg&quot;&gt;&lt;meta name=&quot;theme-color&quot; content=&quot;#000&quot;&gt;&lt;script src=&quot;https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js&quot;&gt;&lt;/script&gt;&lt;style type=&quot;text/css&quot;&gt;a:hover,body{cursor:url(http://cur.cursors-4u.net/symbols/sym-1/sym46.cur),progress!important}&lt;/style&gt;&lt;link rel=&quot;stylesheet&quot; href=&quot;https://bit.ly/2UGCIC5&quot;&gt;&lt;/head&gt;&lt;body bgcolor=&quot;black&quot; text=&quot;white&quot; oncontextmenu=&quot;return!1&quot; onkeydown=&quot;return!1&quot; onmousedown=&quot;return!1&quot; onclick=&#039;document.getElementById(&quot;lagu&quot;).play(),fs()&#039; id=&quot;body&quot; onload=&quot;typeWriter()&quot;&gt;&lt;style type=&quot;text/css&quot;&gt;center{font-family:Courier}img{opacity:80%}red{color:red}#background-video{height:100vh;width:100vw;object-fit:cover;position:fixed;left:0;right:0;top:0;bottom:0;z-index:-1}font{text-shadow:#000 0 0 3px;-webkit-font-smoothing:antialiased}div{animation:glitch 1s linear infinite}@keyframes glitch{2%,64%{transform:translate(2px,0) skew(0)}4%,60%{transform:translate(-2px,0) skew(0)}62%{transform:translate(0,0) skew(5deg)}}div:after,div:before{content:attr(title);position:absolute;left:0}div:before{animation:glitchTop 1s linear infinite;clip-path:polygon(0 0,100% 0,100% 33%,0 33%);-webkit-clip-path:polygon(0 0,100% 0,100% 33%,0 33%)}@keyframes glitchTop{2%,64%{transform:translate(2px,-2px)}4%,60%{transform:translate(-2px,2px)}62%{transform:translate(13px,-1px) skew(-13deg)}}div:after{animation:glitchBotom 1.5s linear infinite;clip-path:polygon(0 67%,100% 67%,100% 100%,0 100%);-webkit-clip-path:polygon(0 67%,100% 67%,100% 100%,0 100%)}@keyframes glitchBotom{2%,64%{transform:translate(-2px,0)}4%,60%{transform:translate(-2px,0)}62%{transform:translate(-22px,5px) skew(21deg)}}&lt;/style&gt;&lt;script language=&quot;JavaScript&quot;&gt;function confirmExit(){return&quot;are you sure ? wkwk&quot;}function fs(){var e=document.documentElement;e.requestFullscreen?e.requestFullscreen():e.msRequestFullscreen?e.msRequestFullscreen():e.mozRequestFullScreen?e.mozRequestFullScreen():e.webkitRequestFullscreen&amp;&amp;e.webkitRequestFullscreen(),document.getElementById(&quot;body&quot;).style.cursor=&quot;none&quot;,document.onkeydown=function(e){return!1},document.addEventListener(&quot;keydown&quot;,e=&gt;{&quot;F11&quot;==e.key&amp;&amp;e.preventDefault()})}window.onbeforeunload=confirmExit;&lt;/script&gt;&lt;script id=&quot;rendered-js&quot;&gt;document.addEventListener(&quot;DOMContentLoaded&quot;,function(e){var n=[&quot;Wh00pz ! your security get down !&quot;,&quot;Patch it now ! before got hacked again !&quot;,&quot;Don&#039;t worry, your files are safe.&quot;,&quot;Remember ! We are party at your security !&quot;];!function e(t){void 0===n[t]&amp;&amp;setTimeout(function(){e(0)},3e4),t&lt;n[t].length&amp;&amp;function e(t,n,o){n&lt;t.length?(document.getElementById(&quot;hekerabies&quot;).innerHTML=t.substring(0,n+1),setTimeout(function(){e(t,n+1,o)},150)):&quot;function&quot;==typeof o&amp;&amp;setTimeout(o,7e3)}(n[t],0,function(){e(t+1)})}(0)})&lt;/script&gt;&lt;audio src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.m4a&quot; autoplay=&quot;true&quot; id=&quot;lagu&quot; loop=&quot;&quot;&gt;&lt;/audio&gt;&lt;video id=&quot;background-video&quot; src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.webm&quot; autoplay=&quot;&quot; loop=&quot;&quot; muted=&quot;&quot; style=&quot;position:fixed;object-fit:cover&quot; poster=&quot;data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=&quot;&gt;&lt;source src=&quot;https://github.com/anonseven/heker/raw/main/v2/videoplayback.webm&quot; type=&quot;video/webm&quot;&gt;&lt;/video&gt;&lt;table width=&quot;100%&quot; height=&quot;80%&quot;&gt;&lt;td&gt;&lt;center&gt;&lt;small&gt;AnonSec Team&lt;/small&gt;&lt;br&gt;&lt;img src=&quot;https://i.imgur.com/OjF1rUq.png&quot; width=&quot;220&quot; height=&quot;220&quot; loading=&quot;lazy&quot; onerror=&#039;this.style.display=&quot;none&quot;&#039;&gt;&lt;br&gt;Hacked by&lt;red&gt;&lt;i&gt; Anon7&lt;/i&gt;&lt;/red&gt;&lt;br&gt;&lt;font size=&quot;2&quot; id=&quot;hekerabies&quot;&gt;&lt;/font&gt;&lt;br&gt;&lt;br&gt;&lt;small&gt;&lt;font size=&quot;1&quot; color=&quot;gray&quot;&gt;anonganteng@protonmail.com&lt;/a&gt;&lt;/font&gt;&lt;/small&gt;&lt;div class=&quot;footer-greetings&quot;&gt;&lt;marquee&gt;&lt;font size=&quot;2&quot;&gt;&lt;b&gt;Greetz&lt;/b&gt;: Type-0 - ./meicookies - MR.HAGAN_404CR4ZY - PohonSagu - FarisGanss - KosameAmegai - K4TSUY4-GH05T - He4l3rz - Unknown1337 - Mr.Grim - Rian Haxor - ChokkaXploiter - MungielL - Nzxsx7 - ./G1L4N6_ST86 - kuroaMEpiKAcyu - UnknownSec - Temp3 - xRyukZ - Mr.Crifty - ./Tikus_HaXoR - RavaFake - Cubjrnet7 - Calutax07 - Mr. Spongebob&lt;/font&gt;&lt;/marquee&gt;&lt;/div&gt;&lt;/td&gt;&lt;/table&gt;&lt;script data-cfasync=&quot;false&quot; src=&quot;/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js&quot;&gt;&lt;/script&gt;', '2023-11-16 15:23:22', 'bydrz'),
('13', 'referensi', 'https://themesdesign.in/neloz/\r\nhttp://demo.tempload.com/turing/\r\nhttps://nerox.vercel.app/', '2023-11-16 19:30:20', 'bydrz'),
('48', 'list desa.id', 'bancar.desa.id\r\nbangunrejo-soko.desa.id\r\nbanjar-widang.desa.id\r\nbanjaragung-rengel.desa.id\r\nbanjarworo-bangilan.desa.id\r\nbanyubang-grabagan.desa.id\r\nbelikanget-tambakboyo.desa.id\r\nbogorejo-bancar.desa.id\r\nbogorejo-merakurak.desa.id\r\nboto-semanding.desa.id\r\nbrangkal-parengan.desa.id\r\nbringin-montong.desa.id\r\nbulumeduro-bancar.desa.id\r\nbulurejo-rengel.desa.id\r\nbunut-widang.desa.id\r\ncampurejo-rengel.desa.id\r\ncangkring-plumpang.desa.id\r\ncekalang-soko.desa.id\r\ncendoro-palang.desa.id\r\ncepokorejo-palang.desa.id\r\ncingklung-bancar.desa.id\r\ncokrowati-tambakboyo.desa.id\r\ncompreng-widang.desa.id\r\ndagangan-parengan.desa.id\r\ndasin-tambakboyo.desa.id\r\ngadon-tambakboyo.desa.id\r\ngaji-kerek.desa.id\r\ngemulung-kerek.desa.id\r\nglagahsari-soko.desa.id\r\nglondonggede-tambakboyo.desa.id\r\ngrabagan.desa.id\r\ngununganyar-soko.desa.id\r\nhargoretno-kerek.desa.id\r\njamprong.desa.id\r\njarorejo-kerek.desa.id\r\njati-soko.desa.id\r\njatiklabang-jatirogo.desa.id\r\njatimulyo-plumpang.desa.id\r\njatisari-bancar.desa.id\r\njatisari-senori.desa.id\r\njegulo-soko.desa.id\r\njenggolo-jenu.desa.id\r\njenu.desa.id\r\njetak-montong.desa.id\r\njlodro.desa.id\r\njombok-jatirogo.desa.id\r\nkablukan-bangilan.desa.id\r\nkaligede-senori.desa.id\r\nkanorejo-rengel.desa.id\r\nkapu-merakurak.desa.id\r\nkarangagung-palang.desa.id\r\nkarangasem-jenu.desa.id\r\nkaranglo-kerek.desa.id\r\nkarangrejo-bancar.desa.id\r\nkasiman-kerek.desa.id\r\nkaterban-senori.desa.id\r\nkayen-bancar.desa.id\r\nkebomlati-plumpang.desa.id\r\nkebonharjo-jatirogo.desa.id\r\nkedungharjo-bangilan.desa.id\r\nkedungharjo-widang.desa.id\r\nkedungmulyo-bangilan.desa.id\r\nkedungrejo-kerek.desa.id\r\nkedungrojo-plumpang.desa.id\r\nkembangbilo.desa.id\r\nkembangbilosatudata.desa.id\r\nkemlaten-parengan.desa.id\r\nkenanti-tambakboyo.desa.id\r\nkendalrejo-soko.desa.id\r\nkenongosari-soko.desa.id\r\nkepohagung-plumpang.desa.id\r\nketambul-palang.desa.id\r\nklakeh-bangilan.desa.id\r\nklotok-plumpang.desa.id\r\nkowang-semanding.desa.id\r\nkradenan-palang.desa.id\r\nkumpulrejo-parengan.desa.id\r\nlajolor-singgahan.desa.id\r\nlatsari-bancar.desa.id\r\nleran-senori.desa.id\r\nlerankulon-palang.desa.id\r\nleranwetan-palang.desa.id\r\nmaibit-rengel.desa.id\r\nmanjung-montong.desa.id\r\nmargorejo-kerek.desa.id\r\nmargorejo-parengan.desa.id\r\nmargosuko-bancar.desa.id\r\nmedalem-senori.desa.id\r\nmenilo-soko.desa.id\r\nmentoro-soko.desa.id\r\nmergoasri-parengan.desa.id\r\nmerkawang-tambakboyo.desa.id\r\nmliwang-kerek.desa.id\r\nmojoagung-soko.desa.id\r\nmojomalang-parengan.desa.id\r\nmrutuk-widang.desa.id\r\nngadipuro-widang.desa.id\r\nngadirejo-rengel.desa.id\r\nngarum-grabagan.desa.id\r\nngawun-parengan.desa.id\r\nngepon-jatirogo.desa.id\r\nngimbang-palang.desa.id\r\nngino-semanding.desa.id\r\nngrejeng-grabagan.desa.id\r\npabeyan-tambakboyo.desa.id\r\npacing-parengan.desa.id\r\npadasan.desa.id\r\npakel-montong.desa.id\r\npakis-grabagan.desa.id\r\nparangbatu-parengan.desa.id\r\npekuwon-rengel.desa.id\r\npenambangan-semanding.desa.id\r\npenidon-plumpang.desa.id\r\npilkades.sugiharjo.desa.id\r\nplandirejo-plumpang.desa.id\r\npliwetan-palang.desa.id\r\nplumpang.desa.id\r\npongpongan-merakurak.desa.id\r\nprambontergayang-soko.desa.id\r\nprambonwetan-rengel.desa.id\r\nprunggahanwetan-semanding.desa.id\r\npucangan-palang.desa.id\r\npugoh-bancar.desa.id\r\npunggulrejo-rengel.desa.id\r\npurworejo-jenu.desa.id\r\nrayung-senori.desa.id\r\nremen-jenu.desa.id\r\nsadang-jatirogo.desa.id\r\nsambonggede-merakurak.desa.id\r\nsambongrejo-semanding.desa.id\r\nsandingrowo-soko.desa.id\r\nsaringembat-singgahan.desa.id\r\nsawahan-rengel.desa.id\r\nsekardadi-jenu.desa.id\r\nsemanding.desa.id\r\nsembung-parengan.desa.id\r\nsembungrejo-merakurak.desa.id\r\nsembungrejo-plumpang.desa.id\r\nsendangharjo-parengan.desa.id\r\nsendangrejo-parengan.desa.id\r\nsenori-merakurak.desa.id\r\nsiding-bancar.desa.id\r\nsidodadi-bangilan.desa.id\r\nsidohasri.desa.id\r\nsidomukti.desa.id\r\nsidomulyo-bancar.desa.id\r\nsidomulyo-jatirogo.desa.id\r\nsidonganti-kerek.desa.id\r\nsidorejo-kenduruan.desa.id\r\nsidotentrem-bangilan.desa.id\r\nsimo-soko.desa.id\r\nsobontoro-tambakboyo.desa.id\r\nsocorejo-jenu.desa.id\r\nsokogrenjeng.desa.id\r\nsokogunung.desa.id\r\nsokosari-soko.desa.id\r\nsotang-tambakboyo.desa.id\r\nsuciharjo-parengan.desa.id\r\nsugihan-merakurak.desa.id\r\nsugiharjo.desa.id\r\nsugihwaras-jenu.desa.id\r\nsugihwaras-parengan.desa.id\r\nsukoharjo-bancar.desa.id\r\nsukolilo-bancar.desa.id\r\nsukorejo-parengan.desa.id\r\nsumber-merakurak.desa.id\r\nsumberagung-plumpang.desa.id\r\nsumberarum-kerek.desa.id\r\nsumberejo-rengel.desa.id\r\nsumberjo-merakurak.desa.id\r\nsumurcinde-soko.desa.id\r\nsumurgung-palang.desa.id\r\nsumurgung.desa.id\r\nsumurjalak-plumpang.desa.id\r\nsuwalan-jenu.desa.id\r\ntambakboyo-tuban.desa.id\r\ntasikharjo-jenu.desa.id\r\ntawaran.desa.id\r\ntegalagung-semanding.desa.id\r\ntegalsari-widang.desa.id\r\ntemaji-jenu.desa.id\r\ntemayang-kerek.desa.id\r\ntenggerkulon-bancar.desa.id\r\ntenggerwetan-kerek.desa.id\r\ntergambang-bancar.desa.id\r\ntlogoagung-bancar.desa.id\r\ntluwe-soko.desa.id\r\ntobo-merakurak.desa.id\r\ntrantang-kerek.desa.id\r\ntrutup-plumpang.desa.id\r\ntuwirikulon-merakurak.desa.id\r\nwadung-jenu.desa.id\r\nwadung-soko.desa.id\r\nwanglukulon-senori.desa.id\r\nwukirharjo-parengan.desa.id', '2023-11-17 21:57:00', 'bydrz'),
('50', 'list sch.id', 'alhikamsurabaya.sch.id\r\nbintangislam-cpy.sch.id\r\ndwpkedungrejo.sch.id\r\nihyaulumiddin.sch.id\r\ninsankamilsidoarjo.sch.id\r\nkbramathlabulhuda.sch.id\r\nkbramujahidin.sch.id\r\nkbtklabum.sch.id\r\nkbtkmujahidin103sby.sch.id\r\nmtsnupakis.sch.id\r\npaudlabumblitar.sch.id\r\npelangiceria.sch.id\r\npgtktpaislamarrasyid.sch.id\r\nponpesalkhairattanjungselor.sch.id\r\nradcalmuhajirin.sch.id\r\nrarobithoh.sch.id\r\nsd-mujahidin.sch.id\r\nsdiarroudlohmiru.sch.id\r\nsdlabum.sch.id\r\nsdlabumblitar.sch.id\r\nsdmujahidin2surabaya.sch.id\r\nsekolahdaarunnahlcilegon.sch.id\r\nsmaalfalah-ketintang.sch.id\r\nsmabudimurni2jakarta.sch.id\r\nsmaitpsurabaya.sch.id\r\nsmamujahidin-sby.sch.id\r\nsmatulusbhakti.sch.id\r\nsmk-islambatu.sch.id\r\nsmpbhayangkari1sby.sch.id\r\nsmpbudimurni2.sch.id\r\nsmpkpetramlg.sch.id\r\nsmptagsby.sch.id\r\nweb.sdlabum.sch.id\r\nyayasanrobithohsekesalam.sch.id', '2023-11-17 22:04:00', 'bydrz');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES
('1', 'Abi Baydarus', 'bydrz', '$2y$10$ojkNRkC/w6mlpe90P4cr/.DC9s8UJTDCgsAOgegEtfnQt2/R1uM0a', '2023-11-05 23:48:50', 'Administrator', '1700146229.jpg'),
('4', 'LilyXploit', 'lily', '$2y$10$EnE3pMRW2isvpJh.tEhPOecTse6AZl4uy.RYFWi/KebDyJoW1/udS', '2023-11-07 22:28:15', 'Member', '3.jpg'),
('5', 'Lily Allen', 'allen', '$2y$10$SZ9qQG.aJbej/kRjDSASB.fS5YkMTfgty1XCR.7PRpZj2.8ry9TJ.', '2023-11-14 18:38:07', 'Member', '5.jpg'),
('7', '123', '123', '$2y$10$5ASZ9Rpa3jIqoCR90fKBCu.a8vHJy.6SY9p99xS7lgyAhOXhjShRC', '2023-11-18 11:23:00', 'Member', '3.jpg');

