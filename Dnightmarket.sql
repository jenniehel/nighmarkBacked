-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:8889
-- 產生時間： 2024 年 01 月 25 日 10:37
-- 伺服器版本： 5.7.39
-- PHP 版本： 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `nightmarket`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ad_auto_close`
--

CREATE TABLE `ad_auto_close` (
  `record_id` int(30) NOT NULL,
  `ad_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `ad_auto_close`
--

INSERT INTO `ad_auto_close` (`record_id`, `ad_id`) VALUES
(3, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `ad_price`
--

CREATE TABLE `ad_price` (
  `ad_id` int(30) NOT NULL,
  `ad_price` int(30) NOT NULL,
  `deadline` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `ad_price`
--

INSERT INTO `ad_price` (`ad_id`, `ad_price`, `deadline`) VALUES
(1, 1500, 14),
(2, 1000, 7),
(3, 500, 14);

-- --------------------------------------------------------

--
-- 資料表結構 `ad_record`
--

CREATE TABLE `ad_record` (
  `record_id` int(30) NOT NULL,
  `ad_id` int(30) NOT NULL,
  `merchant_Id` int(30) NOT NULL,
  `ad_image` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `clicks` int(255) DEFAULT NULL,
  `state` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `ad_record`
--

INSERT INTO `ad_record` (`record_id`, `ad_id`, `merchant_Id`, `ad_image`, `start_date`, `clicks`, `state`) VALUES
(1, 1, 20, '輪播廣告圖_01.png', '2023-06-14', 141, '下架'),
(2, 2, 19, '漂浮廣告_01.png', '2023-02-19', 288, '下架'),
(3, 2, 27, '漂浮廣告_02.png', '2024-02-05', 158, '上架');

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(30) NOT NULL,
  `custom_id` int(30) NOT NULL,
  `merchant_id` int(30) NOT NULL,
  `service_rating` int(30) NOT NULL,
  `product_ratings` int(30) NOT NULL,
  `content` varchar(300) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `comment`
--

INSERT INTO `comment` (`comment_id`, `custom_id`, `merchant_id`, `service_rating`, `product_ratings`, `content`, `date`) VALUES
(1, 1, 3, 5, 4, '從這家還是在傳統士林夜市裡時就吃到現在，味道不變，只是價格漲了很多，外送的價格也比店內用餐高了些，但是炸天婦羅配小醃小黃瓜片還是一樣好吃，一樣是用新鮮魚漿下去現炸，和市面上的天婦羅口感完全不同，當然如果是在店內用餐，會更好吃，微脆的表皮咬下有魚漿的香味，加上微甜的小黃瓜片，真的很搭配，他家的蚵仔煎，邊邊煎的有些酥脆，煎蛋青菜加上滿滿的蚵仔，再淋上略帶點沙茶味的甜辣醬，一下子就吃光了，至於炒米粉，就比較普通，古早傳統的米粉淋碎滷肉，自己加點辣椒醬，拌一下也很不錯吃，現在點外送平台，滿額還送一杯冰的冬瓜茶。', '2023-03-13'),
(2, 6, 9, 5, 5, '整體氣氛真的很不錯\r\n熱鬧的夜市感\r\n店內明亮 服務人員也滿親切的！\r\n之後會想內用感受一下氣氛♥️', '2023-08-29'),
(3, 17, 17, 4, 4, '用餐時間一到店內高朋滿座\r\n甜不辣蠻不錯的但底下滿滿的一層油\r\n臭豆腐上桌溫度稍嫌不夠只有溫溫的\r\n吃起來蠻普通的沒有特別感受\r\n蚵仔煎很脆很香只是醬料有點吃不懂\r\n還點了一個里肌湯挺不錯喝的\r\n但碗裡滿滿的渣渣不知道為什麼？？？\r\n總而言之蠻適合觀光客來嚐鮮多樣台灣小吃\r\n但價格上稍微偏高也沒有想像中好吃', '2024-01-17'),
(4, 8, 4, 4, 4, '剛到士林夜市就看到很多人在排隊，想說晚點再過來吃～沒想到繞完一圈回來就有位置了！吃了綜合煎90$蝦仁只有四個，所以比較推薦蚵仔煎或是蝦仁煎喔～不錯吃。', '2023-12-20'),
(5, 26, 3, 5, 4, 'IG:doryieat\r\n▪️臭豆腐(小)$35\r\n帶有中藥味的臭豆腐，吃起來很入味\r\n但不是酥脆的，吃起來濕濕軟軟的\r\n▪️生炒花枝羹$100\r\n非常的濃稠，像玉米濃湯\r\n南部口味偏甜\r\n花枝給的很大塊\r\n▪️雞蛋蝦仁煎$80\r\n這個勾芡反而比較少，吃起來就像蝦仁煎蛋', '2023-09-26'),
(6, 11, 3, 2, 3, '炒空心菜，好吃！\r\n生炒花枝羹， 好吃！\r\n麻油豬肚，可以！\r\n蚵仔煎……蚵仔可以，煎不行，蛋過熟，醬不搭。完全不愛！', '2023-12-30'),
(11, 3, 9, 4, 5, '很久沒有吃到雞吃飯入口時，雞汁香氣衝出於口中，飯粒軟卻不爛。這次點的煙燻雞肉，口感紮實，適合喜歡有咬勁的雞肉。溏心蛋細密入味。湯品用傳統陶器承裝，保溫效果很好。\r\n店家貼心地準備籃子裝雞骨頭，不會弄得到處都是，是很少見的細節。能夠看見店家的用心，推推～', '2023-05-25'),
(12, 1, 7, 2, 4, '第一次來吃這間 感覺不錯吃\r\n實際上吃了米心沒有熟的飯 反應了2次被店員白眼了感覺真差\r\n真的是一顆星都不想給 …', '2023-10-19'),
(13, 21, 8, 4, 2, '外帶這樣賣255有沒有搞錯 我到山上抓一隻雞都沒這麼扯= =我還再三確認好幾次到底有沒有漏掉 結果還真的只有六塊肉 太猛了 真的花錢買經驗', '2023-02-12'),
(14, 22, 7, 4, 4, '雞油飯很香，鹹中帶甜，飯粒Q彈。\r\n煙燻雞腿香氣十足，有肉汁、不柴、嫩，是好吃的土雞腿。我選的是泰式醬料，夠辣、夠酸、夠泰，讓土雞腿吃起來完全不會膩，但是，還蠻辣的，不吃辣的朋友不要點。\r\n溏心蛋，中規中矩，優點是能沾醬，更添風味。\r\n湯，蠻驚豔的，好喝，感覺是食材好，才煮出這種味道，可惜忘記拍照了。\r\n缺點，漬物的量也太少了點...\r\n整體來說，很讚，會再訪。', '2020-10-19'),
(15, 1, 27, 2, 1, '吃飯的過程腳下出現一直超大蟑螂，真噁心，最後那大蟑螂泡到花瓶裏面睡覺。\r\n金燻定食 300元就被這大蟑螂搞得心情不好。', '2023-02-27'),
(16, 8, 30, 4, 3, '因為凌晨真的找不到東西所以大家都來了\r\n早上三點半一樣超級多人\r\n店家快忙不過來沒時間理客人\r\n點餐要先去桌子拿紙自己寫之後會有人來收\r\n餐都是一個菜色全部桌同時發下去\r\n所以如果工作人員經過是在發你有點的\r\n舉手大叫就對了\r\n晚上在這裡是吃個氛圍 味道就普普通通啦', '2021-02-21'),
(17, 25, 14, 5, 3, '炒蛤蜊都是殻\r\n菜都普普\r\n但點菜方式很特別，寫好數量店家會一次炒\r\n店家沒有先來後到的問題，先喊先贏，攻略是盡量坐在炒爐旁邊的位置，喊菜時要大聲，手要舉直，好似舉手跟老師說你要上廁所那樣洪亮！端菜的很猛，都一次端9盤，很有趣的體驗～', '2021-04-30'),
(20, 9, 29, 4, 3, '隱藏在工業區的泰國料理\r\n用餐時間就只能登記在門口等待\r\n建議提早打電話留位子才不會這麼累\r\n吃服務態度那套的客人不要太玻璃心\r\n請迴避 姐姐們都不會太客氣的應答\r\n店員雖然多 因為客人太多都很忙\r\n但是只是口氣上的問題 其實都還是很好的對話\r\n\r\n炒粿條鹹香軟Q稍油了一點\r\n打拋雞肉吃起來很像涼拌雞絲拌飯\r\n月亮蝦餅厚實有咬勁\r\n酸辣湯蝦子花枝給的很多\r\n價錢也不貴，都是百元價錢', '2021-12-21'),
(21, 18, 10, 5, 4, '炒飯、乾炒粄條、泰式炒河粉、蝦醬空心菜味道不錯，但豬肉片、雞胸都蠻乾的。\r\n小孩抱怨為何上次內用炒飯有附小黃瓜，外帶卻沒有？\r\n有次打電話要去訂幾天以後的位置，接電話的婦人講台語，說中午忙碌，要下午再打來，直接去餐廳了，她又說現在忙，晚點再打電話來，可是她在櫃檯看起來真的不忙（也沒人在結帳），她可能怕老闆生意太好了，幫老闆過濾掉一些客人！', '2023-07-01'),
(22, 20, 15, 5, 5, '餐點味道都還滿泰的，蝦餅厚實好吃！椒麻雞我個人沒有很喜歡。生蝦有辣但是辣得很讚！涼拌海鮮也是。泰奶也很好喝！價格都還算親民，推薦！可以先電話預訂', '2020-04-11'),
(23, 21, 16, 5, 4, '五星 味道非常的泰\r\n\r\n點了七道菜跟泰式奶茶，除了月亮蝦餅本人不是泰國菜，所以是真的不好吃之外，其他菜的口味都很棒，酸辣重口味，同行友人是泰國旅遊的狂熱者，說很不錯，冬陰功好喝，檸檬魚很便宜，但略有點土味，會擔心的可以避開，放開來吃到超飽還是很便宜，推推', '2021-02-25');

-- --------------------------------------------------------

--
-- 資料表結構 `comment_image`
--

CREATE TABLE `comment_image` (
  `image_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment_id` int(30) NOT NULL,
  `image_src` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `comment_image`
--

INSERT INTO `comment_image` (`image_id`, `name`, `comment_id`, `image_src`) VALUES
(1, '評論照01.png', 5, ''),
(2, '評論照02.png', 5, ''),
(3, '評論照03.png', 5, ''),
(4, '評論照04.png\r\n', 2, ''),
(5, '評論照05.png', 2, ''),
(6, '評論照06.png', 2, ''),
(7, '評論照07.png', 2, ''),
(8, '評論照08.png', 20, '');

-- --------------------------------------------------------

--
-- 資料表結構 `good`
--

CREATE TABLE `good` (
  `good_id` int(30) NOT NULL,
  `custom_Id` int(30) NOT NULL,
  `comment_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `good`
--

INSERT INTO `good` (`good_id`, `custom_Id`, `comment_id`) VALUES
(1, 1, 11),
(2, 20, 17),
(3, 1, 12),
(4, 29, 12),
(5, 29, 5),
(6, 29, 13),
(7, 22, 13);

-- --------------------------------------------------------

--
-- 資料表結構 `sub_comment`
--

CREATE TABLE `sub_comment` (
  `sub_id` int(30) NOT NULL,
  `merchant_id` int(30) NOT NULL,
  `comment_id` int(30) NOT NULL,
  `content` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `sub_comment`
--

INSERT INTO `sub_comment` (`sub_id`, `merchant_id`, `comment_id`, `content`, `date`) VALUES
(1, 7, 14, '謝謝您喜歡春秋的服務，期待您的再度光臨^^', '2020-11-15'),
(2, 27, 15, '不好意思照成妳的不愉快\r\n當日已告知店員並加強人員服務訓練\r\n萬分真誠的向妳道歉', '2023-02-28'),
(3, 20, 2, '謝謝您的蒞臨與喜愛，全體同仁十分榮幸能為您創造如此愉悅的體驗，並竭誠期待很快能再為您服務～', '2023-08-29');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ad_auto_close`
--
ALTER TABLE `ad_auto_close`
  ADD KEY `record_id` (`record_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- 資料表索引 `ad_price`
--
ALTER TABLE `ad_price`
  ADD PRIMARY KEY (`ad_id`) USING BTREE;

--
-- 資料表索引 `ad_record`
--
ALTER TABLE `ad_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- 資料表索引 `comment_image`
--
ALTER TABLE `comment_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- 資料表索引 `good`
--
ALTER TABLE `good`
  ADD PRIMARY KEY (`good_id`);

--
-- 資料表索引 `sub_comment`
--
ALTER TABLE `sub_comment`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ad_record`
--
ALTER TABLE `ad_record`
  MODIFY `record_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `comment_image`
--
ALTER TABLE `comment_image`
  MODIFY `image_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `good`
--
ALTER TABLE `good`
  MODIFY `good_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sub_comment`
--
ALTER TABLE `sub_comment`
  MODIFY `sub_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `ad_auto_close`
--
ALTER TABLE `ad_auto_close`
  ADD CONSTRAINT `ad_auto_close_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `ad_record` (`record_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ad_auto_close_ibfk_2` FOREIGN KEY (`ad_id`) REFERENCES `ad_price` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `ad_record`
--
ALTER TABLE `ad_record`
  ADD CONSTRAINT `ad_record_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ad_price` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `comment_image`
--
ALTER TABLE `comment_image`
  ADD CONSTRAINT `comment_image_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `sub_comment`
--
ALTER TABLE `sub_comment`
  ADD CONSTRAINT `sub_comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
