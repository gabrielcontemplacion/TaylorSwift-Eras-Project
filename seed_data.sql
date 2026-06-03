-- ============================================================
--  taylors_db  —  Full seed data
--  Run this in phpMyAdmin → SQL tab to populate all tables
-- ============================================================

USE taylors_db;

-- ── Personal Info ────────────────────────────────────────────
INSERT INTO personal_info (category, title, description, image, created_at, updated_at) VALUES
('Childhood',      'Childhood',     'Taylor Swift was born on December 13, 1989, in West Reading, Pennsylvania. She grew up in Wyomissing, PA, and began performing in musical theater at age 9. Her passion for country music led her family to move to Nashville, Tennessee when she was 14 to pursue a music career.',                                              'img/taylor4.jpg',  NOW(), NOW()),
('Education',      'Education',     'Taylor graduated from Hendersonville High School one year early — at age 16 — to focus on her rapidly growing music career. Despite leaving traditional school early, she has consistently emphasized the importance of education and literacy, donating millions to schools and libraries across the U.S.',              'img/taylor5.jpg',  NOW(), NOW()),
('Career',         'Career',        'From Nashville to global superstardom, Taylor redefined the music industry. She signed with Big Machine Records at 14, released her self-titled debut at 16, and has since released 11 studio albums spanning country, pop, folk, and alternative genres. She is the first artist to win the Grammy Album of the Year four times.',  'img/taylor6.jpg',  NOW(), NOW()),
('Acting',         'Acting',        'Taylor has appeared in several films and TV projects including Valentine\'s Day (2010), The Giver (2014), and Cats (2019). She also starred as Bombalurina in Cats and voiced a character in The Lorax. Her acting roles, while secondary to her music career, have shown her versatility as a performer.',                    'img/taylor7.webp', NOW(), NOW()),
('Relationships',  'Relationships', 'Taylor\'s personal life has been widely covered by the media. She has been in several high-profile relationships over the years. As of 2025, she is in a relationship with NFL superstar Travis Kelce, tight end for the Kansas City Chiefs, whom she began dating in 2023.',                                                   'img/taylor8.jpg',  NOW(), NOW()),
('Facts',          'Fun Facts',     'Taylor Swift is the first artist to win Album of the Year four times at the Grammy Awards. She has broken numerous Spotify and Apple Music streaming records, and her Eras Tour became the highest-grossing concert tour in history, surpassing $1 billion in revenue. She was also named TIME Magazine\'s Person of the Year 2023.', 'img/taylor9.webp', NOW(), NOW());


-- ── Albums ──────────────────────────────────────────────────
INSERT INTO albums (title, release_year, description, cover_image, created_at, updated_at) VALUES
('Taylor Swift', 2006, '2006 Era. Taylor\'s self-titled debut album launched her country music career. A blend of teenage heartbreak and small-town storytelling.',                                                              'img/taylorswift2006.jpg', NOW(), NOW()),
('Fearless',     2008, '2008 Era. Her sophomore album blended country and pop, earning her the Grammy for Album of the Year and launching her into superstardom.',                                                               'img/fearless.jpg',        NOW(), NOW()),
('Speak Now',    2010, '2010 Era. Entirely self-written, this album showcased Taylor\'s songwriting maturity with dramatic ballads and bold storytelling.',                                                                      'img/speaknow.jpg',        NOW(), NOW()),
('Red',          2012, '2012 Era. A genre-blending masterpiece mixing country, pop, rock, and dubstep. Widely regarded as one of her most emotionally raw albums.',                                                             'img/red.jpg',             NOW(), NOW()),
('1989',         2014, '2014 Era. Taylor\'s official pop crossover. A synth-pop record inspired by the 1980s that became one of the best-selling albums of the decade.',                                                       'img/1989.jpg',            NOW(), NOW()),
('Reputation',   2017, '2017 Era. A dark, hip-hop-influenced record exploring themes of media scrutiny, betrayal, and new love. Her most theatrical era.',                                                                      'img/reputation.jpg',      NOW(), NOW()),
('Lover',        2019, '2019 Era. A bright, colorful pop record celebrating love and identity. Features some of her most upbeat and optimistic songwriting.',                                                                   'img/lover.jpg',           NOW(), NOW()),
('Folklore',     2020, '2020 Era. An indie-folk surprise album recorded during the pandemic. Universally acclaimed as one of the greatest albums of the 2020s.',                                                               'img/folklore.jpg',        NOW(), NOW()),
('Evermore',     2020, '2020 Era. A sister album to Folklore, released just months later. Continues the indie-folk aesthetic with even more introspective storytelling.',                                                       'img/evermore.jpg',        NOW(), NOW()),
('Midnights',    2022, '2022 Era. A synth-pop record about sleepless nights and self-reflection. Broke multiple streaming records on release night.',                                                                           'img/midnights.jpg',       NOW(), NOW()),
('TTPD',         2024, '2024 Era. The Tortured Poets Department — a double album exploring themes of heartbreak, obsession, and artistic identity. Her longest album to date.',                                                 'img/ttpd.jpg',            NOW(), NOW()),
('Showgirl',     2025, '2025 Era. Taylor\'s most theatrical record yet, drawing inspiration from old Hollywood, cabaret, and dramatic pop. A bold reinvention.',                                                               'img/showgirl.webp',       NOW(), NOW());


-- ── Songs ────────────────────────────────────────────────────
-- (album_id matches insertion order above: Taylor Swift=1, Fearless=2, etc.)

-- Taylor Swift (album_id=1)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(1,'Tim McGraw','lEehaxN0TXw',NOW(),NOW()),
(1,'Teardrops On My Guitar','lEehaxN0TXw',NOW(),NOW()),
(1,'Our Song','4v1Eez7ECU4',NOW(),NOW()),
(1,'Picture to Burn','15a_L2ybl2Y',NOW(),NOW()),
(1,'Should\'ve Said No','dUisZV--Nbs',NOW(),NOW()),
(1,'Mary\'s Song','VfVuptgjeU',NOW(),NOW()),
(1,'Cold as You','SoXPvCcFibo',NOW(),NOW()),
(1,'The Outside','L4hOi4KvRY0',NOW(),NOW()),
(1,'Stay Beautiful','6BOPfGQLUH8',NOW(),NOW()),
(1,'Tied Together with a Smile','aCVHGH5sO0c',NOW(),NOW());

-- Fearless (album_id=2)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(2,'Love Story','8xg3vE8Ie_E',NOW(),NOW()),
(2,'You Belong With Me','VuNIsY6JdUw',NOW(),NOW()),
(2,'Fifteen','Pb-K2tXWK4w',NOW(),NOW()),
(2,'White Horse','D1Xr-JFLxik',NOW(),NOW()),
(2,'Fearless','eVNNfmr_vWI',NOW(),NOW()),
(2,'Breathe','eVNNfmr_vWI',NOW(),NOW()),
(2,'The Best Day','eVNNfmr_vWI',NOW(),NOW()),
(2,'You\'re Not Sorry','eVNNfmr_vWI',NOW(),NOW()),
(2,'Tell Me Why','eVNNfmr_vWI',NOW(),NOW()),
(2,'Mr. Perfectly Fine','eVNNfmr_vWI',NOW(),NOW());

-- Speak Now (album_id=3)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(3,'Mine','XPBwXKgDTdE',NOW(),NOW()),
(3,'Back To December','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Mean','oOEhHDx6xOQ',NOW(),NOW()),
(3,'The Story Of Us','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Sparks Fly','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Enchanted','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Better Than Revenge','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Dear John','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Ours','oOEhHDx6xOQ',NOW(),NOW()),
(3,'Long Live','oOEhHDx6xOQ',NOW(),NOW());

-- Red (album_id=4)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(4,'All Too Well','rX9GLnJ06F4',NOW(),NOW()),
(4,'22','AgFeZr5ptV8',NOW(),NOW()),
(4,'I Knew You Were Trouble','vNoKguSdy4Y',NOW(),NOW()),
(4,'Red','Zlot0i3Zykw',NOW(),NOW()),
(4,'Begin Again','bVcxtHhyfZQ',NOW(),NOW()),
(4,'Everything Has Changed','SWQwtE9N5aU',NOW(),NOW()),
(4,'State of Grace','gr4cqcqnAN0',NOW(),NOW()),
(4,'Holy Ground','NA90OVe2ixo',NOW(),NOW()),
(4,'Treacherous','OE2RVmaioAo',NOW(),NOW()),
(4,'Nothing New','EsiqARpjOBQ',NOW(),NOW());

-- 1989 (album_id=5)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(5,'Shake It Off','nfWlot6h_JM',NOW(),NOW()),
(5,'Blank Space','e-ORhEE9VVg',NOW(),NOW()),
(5,'Style','-CmadmM5cOk',NOW(),NOW()),
(5,'Bad Blood','QcIy9NiNbmo',NOW(),NOW()),
(5,'Wildest Dreams','IdneKLhsWOQ',NOW(),NOW()),
(5,'Out Of The Woods','JLf9q36UsBk',NOW(),NOW()),
(5,'Clean','AppsjTInqiw',NOW(),NOW()),
(5,'New Romantics','wyK7YuwUWsU',NOW(),NOW()),
(5,'This Love','mvxQYPR4lmU',NOW(),NOW()),
(5,'Is It Over Now?','vNoKguSdy4Y',NOW(),NOW());

-- Reputation (album_id=6)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(6,'LWYMMD','3tmd-ClpJxA',NOW(),NOW()),
(6,'Delicate','tCXGJQYZ9JA',NOW(),NOW()),
(6,'...Ready For It?','wIft-t-MQuE',NOW(),NOW()),
(6,'End Game','dfnCAmr569k',NOW(),NOW()),
(6,'Gorgeous','tCXGJQYZ9JA',NOW(),NOW()),
(6,'Getaway Car','tCXGJQYZ9JA',NOW(),NOW()),
(6,'Call It What You Want','tCXGJQYZ9JA',NOW(),NOW()),
(6,'Don\'t Blame Me','tCXGJQYZ9JA',NOW(),NOW()),
(6,'I Did Something Bad','tCXGJQYZ9JA',NOW(),NOW()),
(6,'New Year\'s Day','KkvTYrFIxNM',NOW(),NOW());

-- Lover (album_id=7)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(7,'Cruel Summer','ic8j13piAhQ',NOW(),NOW()),
(7,'Lover','-BjZmE2gtdo',NOW(),NOW()),
(7,'The Man','AqAJLh9wuZ0',NOW(),NOW()),
(7,'You Need To Calm Down','1wgr1Bjxs7E',NOW(),NOW()),
(7,'ME!','FuXNumBwDOM',NOW(),NOW()),
(7,'The Archer','3sAdg1N-byw',NOW(),NOW()),
(7,'Paper Rings','a3FVEgsi5ag',NOW(),NOW()),
(7,'Cornelia Street','bqJ9I-3MG1g',NOW(),NOW()),
(7,'Death By A Thousand','KNp1yY9s5dc',NOW(),NOW()),
(7,'Miss Americana','2B9fBFtBXhU',NOW(),NOW());

-- Folklore (album_id=8)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(8,'cardigan','M_lVZIpgnjU',NOW(),NOW()),
(8,'the 1','_yHn-954iVQ',NOW(),NOW()),
(8,'exile','Nm08yUg38tE',NOW(),NOW()),
(8,'august','92jy750yv00',NOW(),NOW()),
(8,'betty','gtzCuhDTRzk',NOW(),NOW()),
(8,'mirrorball','UupJ9yX3_Bg',NOW(),NOW()),
(8,'seven','llshN1pcGoY',NOW(),NOW()),
(8,'invisible string','CQ_dWZG5RJU',NOW(),NOW()),
(8,'my tears ricochet','CsiVvkzCdSI',NOW(),NOW()),
(8,'epiphany','M_lVZIpgnjU',NOW(),NOW());

-- Evermore (album_id=9)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(9,'willow','RsEZmictANA',NOW(),NOW()),
(9,'champagne problems','wMpqCRF7TKg',NOW(),NOW()),
(9,'gold rush','RsEZmictANA',NOW(),NOW()),
(9,'no body, no crime','RsEZmictANA',NOW(),NOW()),
(9,'tolerate it','RsEZmictANA',NOW(),NOW()),
(9,'ivy','RsEZmictANA',NOW(),NOW()),
(9,'cowboy like me','RsEZmictANA',NOW(),NOW()),
(9,'long story short','RsEZmictANA',NOW(),NOW()),
(9,'marjorie','RsEZmictANA',NOW(),NOW()),
(9,'evermore','RsEZmictANA',NOW(),NOW());

-- Midnights (album_id=10)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(10,'Anti-Hero','gGwN25z7FrE',NOW(),NOW()),
(10,'Bejeweled','ywUqTGWU7ec',NOW(),NOW()),
(10,'Karma','pzVYSfzNQ5Y',NOW(),NOW()),
(10,'Lavender Haze','GwNPBeWpI-0',NOW(),NOW()),
(10,'Maroon','IHMySdortig',NOW(),NOW()),
(10,'Snow On The Beach','_p0jeMjTccw',NOW(),NOW()),
(10,'You\'re On Your Own, Kid','fKgoo_KT6aM',NOW(),NOW()),
(10,'Midnight Rain','EL72UcDZLSk',NOW(),NOW()),
(10,'Vigilante Shit','mnCmHleqQGk',NOW(),NOW()),
(10,'Mastermind','teos2yMvkEA',NOW(),NOW());

-- TTPD (album_id=11)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(11,'Fortnight','q3zqJs7JUCQ',NOW(),NOW()),
(11,'I Can Do It With a Broken Heart','i8_w_m6HLJ0',NOW(),NOW()),
(11,'Down Bad','EVbtjaWXQVg',NOW(),NOW()),
(11,'But Daddy I Love Him','U2W173hRfyA',NOW(),NOW()),
(11,'Florida!!!','uEssK8o3jKg',NOW(),NOW()),
(11,'Guilty as Sin?','OOYlWF6V8t8',NOW(),NOW()),
(11,'Who\'s Afraid of Little Old Me?','vOZFiX6hDXQ',NOW(),NOW()),
(11,'So Long, London','CCUr2pNJft4',NOW(),NOW()),
(11,'The Alchemy','iMMUAd66vxo',NOW(),NOW()),
(11,'The Manuscript','iY6Qhlua8Zw',NOW(),NOW());

-- Showgirl (album_id=12)
INSERT INTO songs (album_id, title, youtube_id, created_at, updated_at) VALUES
(12,'The Fate of Ophelia','ko70cExuzZM',NOW(),NOW()),
(12,'The Life of a Showgirl','slUhVTAznMo',NOW(),NOW()),
(12,'Elizabeth Taylor','slUhVTAznMo',NOW(),NOW()),
(12,'Father Figure','b3hW8c9mmLQ',NOW(),NOW()),
(12,'Cancelled!','F-5XoUZ42Tc',NOW(),NOW()),
(12,'Eldest Daughter','rhzMYDvgG2U',NOW(),NOW()),
(12,'Ruin The Friendship','f5ZAXAxHqog',NOW(),NOW()),
(12,'Honey','9Sx8MWI8qTU',NOW(),NOW()),
(12,'Wi$h Li$t','mC54kTYa9oI',NOW(),NOW()),
(12,'The Manuscript','iY6Qhlua8Zw',NOW(),NOW());


-- ── Tours ────────────────────────────────────────────────────
INSERT INTO tours (tour_name, description, image, total_sales, attendance, songs_count, created_at, updated_at) VALUES
('Fearless Tour',    'The fairytale-themed tour that captured hearts worldwide. Taylor\'s first major headlining tour, performed across North America and international markets.',                     'img/Fearless1.webp',   63700000.00,  1100000, 15, NOW(), NOW()),
('Speak Now Tour',   'An enchanting, self-produced theatrical production. Every song was written solely by Taylor, showcasing her as one of music\'s premier songwriters.',                         'img/speaknow1.webp',  123700000.00,  1600000, 17, NOW(), NOW()),
('The Red Tour',     'The bold transition to pop. Featuring elaborate set pieces and costume changes, this tour marked Taylor\'s evolution from country to mainstream pop.',                         'img/red1.jpg',        150200000.00,  1700000, 18, NOW(), NOW()),
('1989 World Tour',  'The ultimate pop rebirth. Named after her landmark pop album, this stadium tour cemented Taylor as one of the world\'s biggest pop stars.',                                  'img/19892.jpg',       250700000.00,  2200000, 18, NOW(), NOW()),
('Reputation Tour',  'A massive stadium spectacle featuring elaborate snake imagery, pyrotechnics, and a bold visual identity exploring themes of media and persona.',                              'img/reputation1.jpg', 345700000.00,  2800000, 19, NOW(), NOW()),
('The Eras Tour',    'The biggest concert tour in history. A nearly 4-hour journey through all of Taylor\'s musical eras, breaking records for attendance and revenue worldwide.', 'img/erastour1.jpg',  1000000000.00, 4300000, 44, NOW(), NOW());


-- ── Awards ───────────────────────────────────────────────────
INSERT INTO awards (award_name, description, image, created_at, updated_at) VALUES
('GRAMMYS',   '14-time Grammy winner and the first artist to win Album of the Year four times (Fearless, 1989, Folklore, Midnights). Also holds the record for most AOTY wins in history.', 'img/grammys.jpg',    NOW(), NOW()),
('AMA',       '40 trophies total at the American Music Awards — the most of any artist in history. She also holds the record for most Artist of the Year wins.',                              'img/ama.webp',       NOW(), NOW()),
('BILLBOARD',  '39 total Billboard Music Award wins with chart dominance spanning multiple genres. Multiple entries on the Hot 100 simultaneously, a feat few artists have achieved.',         'img/billboards.webp',NOW(), NOW()),
('VMAs',      '23 MTV Video Music Award Moonperson trophies including multiple Video of the Year wins. One of the most decorated artists in VMA history.',                                    'img/vma.webp',       NOW(), NOW());


-- ── Default admin user ───────────────────────────────────────
-- Password is stored as plain text to match your current schema.
-- Change 'admin123' to your preferred password before running.
INSERT INTO users (username, password, role, created_at, updated_at)
VALUES ('admin', 'admin123', 'admin', NOW(), NOW());
