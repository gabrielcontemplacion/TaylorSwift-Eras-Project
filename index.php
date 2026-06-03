<?php
session_start();
// Prevent browser from caching this page
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}
$db = new mysqli('localhost', 'root', '', 'taylors_db');
if ($db->connect_error) die('DB error: ' . $db->connect_error);

// ── Fetch all data ────────────────────────────────────────────────────────────

// Personal Info
$personal_rows = [];
$r = $db->query("SELECT * FROM personal_info ORDER BY info_id ASC");
if ($r) while ($row = $r->fetch_assoc()) $personal_rows[] = $row;

// Albums
$albums = [];
$r = $db->query("SELECT * FROM albums ORDER BY release_year ASC");
if ($r) while ($row = $r->fetch_assoc()) $albums[] = $row;

// Songs grouped by album_id
$songs_by_album = [];
$r = $db->query("SELECT * FROM songs ORDER BY song_id ASC");
if ($r) while ($row = $r->fetch_assoc()) $songs_by_album[$row['album_id']][] = $row;

// Tours
$tours = [];
$r = $db->query("SELECT * FROM tours ORDER BY tour_id ASC");
if ($r) while ($row = $r->fetch_assoc()) $tours[] = $row;

// Awards
$awards = [];
$r = $db->query("SELECT * FROM awards ORDER BY award_id ASC");
if ($r) while ($row = $r->fetch_assoc()) $awards[] = $row;

$db->close();

// ── Build personal JS array ───────────────────────────────────────────────
$personal_js = [];
foreach ($personal_rows as $pi) {
    $personal_js[] = [
        'title' => $pi['title'],
        'desc'  => $pi['description'],
        'img'   => $pi['image'],
        'cat'   => $pi['category'],
    ];
}

// ── Build album JS data for section 4 ─────────────────────────────────────
$album_js = [];
foreach ($albums as $album) {
    $aid   = $album['album_id'];
    $songs = $songs_by_album[$aid] ?? [];
    $song_arr = [];
    foreach ($songs as $s) {
        $song_arr[] = ['name' => $s['title'], 'thumb' => $s['youtube_id']];
    }
    $album_js[$album['title']] = [
        'desc'  => $album['description'],
        'img'   => $album['cover_image'],
        'songs' => $song_arr,
    ];
}

// ── Build tour JS data ────────────────────────────────────────────────────
$tour_js = [];
foreach ($tours as $t) {
    $tour_js[] = [
        'title'      => $t['tour_name'],
        'desc'       => $t['description'],
        'img'        => $t['image'],
        'sales'      => $t['total_sales'],
        'attendance' => $t['attendance'],
        'songs'      => $t['songs_count'],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taylor Swift | The Eras Project</title>
    <link rel="stylesheet" href="taylor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="admin_login.php" style="text-decoration:none;"><div class="logo">Dashboard</div></a>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#personal">Personal Info</a></li>
                    <li><a href="#album">Album</a></li>
                    <li><a href="#tours">Tours</a></li>
                    <li><a href="#awards-final-check">Collection Awards</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#socials">Social Media</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ══════════════════════════ HERO ══════════════════════════ -->
    <section id="home" class="hero-section">
        <div class="hero-wrapper">
            <div class="image-grid">
                <div class="left-stack">
                    <div class="photo-box small"><img src="img/taylor1.jpg" alt="Taylor Swift 1"></div>
                    <div class="photo-box small"><img src="img/taylor2.jpg" alt="Taylor Swift 2"></div>
                </div>
                <div class="photo-box large"><img src="img/taylor3.jpg" alt="Taylor Swift 3"></div>
            </div>
            <div class="hero-text">
                <span class="tagline">A Story in Every Era</span>
                <h1>Taylor Swift</h1>
                <p>Step into the golden age of storytelling. From the teardrops on her guitar to the midnights that defined a generation, explore the eras that made Taylor Swift a global icon</p>
                <div class="visual-lines">
                    <div class="line l1"></div>
                    <div class="line l2"></div>
                    <div class="line l3"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ PERSONAL INFO ══════════════════════════ -->
    <section id="personal" class="personal-section">
        <div class="container">
            <h2 class="section-title">Personal Info</h2>
            <div class="personal-grid-large">
                <?php if ($personal_rows): ?>
                    <?php foreach ($personal_rows as $idx => $info): ?>
                        <div class="large-box" onclick="updateDetail(<?php echo $idx; ?>)">
                            <div class="box-content"><h3><?php echo htmlspecialchars($info['category']); ?></h3></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color:#888;grid-column:1/-1;text-align:center;">No personal info found in database.</p>
                <?php endif; ?>
            </div>
            <div id="personal-detail" class="detail-display-large">
                <div class="detail-flex">
                    <div class="detail-img-side"><img id="detail-img" src="img/taylor3.jpg"></div>
                    <div class="detail-info-side">
                        <h3 id="detail-title">Select a Box</h3>
                        <div class="line-accent"></div>
                        <p id="detail-desc"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ ALBUMS SLIDER ══════════════════════════ -->
    <section id="album" class="section-3">
        <div class="container">
            <h2 class="section-title">The Eras Gallery</h2>
            <div class="slider-container" style="position:relative;">
                <button class="nav-btn prev" onclick="scrollSlider(-1)">&#10094;</button>
                <button class="nav-btn next" onclick="scrollSlider(1)">&#10095;</button>
                <div class="eras-slider" id="erasSlider">
                    <?php if ($albums): ?>
                        <?php foreach ($albums as $idx => $album): ?>
                            <div class="era-card" onclick="updateSection4(<?php echo $idx; ?>)">
                                <img src="<?php echo htmlspecialchars($album['cover_image']); ?>" alt="<?php echo htmlspecialchars($album['title']); ?>">
                                <div class="era-info">
                                    <h3><?php echo htmlspecialchars($album['title']); ?></h3>
                                    <span><?php echo htmlspecialchars($album['release_year']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color:#888;padding:20px;">No albums found in database.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ ALBUM DETAIL ══════════════════════════ -->
    <section id="album-details">
        <div style="max-width:1200px;margin:0 auto;">
            <div style="display:flex;align-items:center;gap:50px;margin-bottom:50px;">
                <div style="flex:0 0 350px;">
                    <div style="background:white;padding:15px;border:1px solid #ddd;">
                        <img id="current-album-img" src="img/WHITE.jpg" style="width:320px;height:320px;object-fit:cover;">
                    </div>
                </div>
                <div style="flex:1;">
                    <h2 id="current-album-name" style="font-size:3.5rem;margin:0;">SELECT AN ALBUM</h2>
                    <div style="width:60px;height:5px;background:#b22222;margin:20px 0;"></div>
                    <p id="current-album-desc" style="font-size:1.2rem;"></p>
                </div>
            </div>
            <h3>Top Tracks</h3>
            <div id="song-grid" style="display:flex;gap:20px;overflow-x:auto;padding-bottom:20px;"></div>
        </div>
    </section>

    <!-- ══════════════════════════ TOURS SLIDER ══════════════════════════ -->
    <section id="tours">
        <h2 style="text-align:center;font-size:3rem;margin-top:40px;margin-bottom:20px;">The Tour Collection</h2>
        <div class="slider-container" style="position:relative;max-width:1200px;margin:0 auto;">
            <button class="nav-btn prev" onclick="scrollTours(-1)" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);z-index:10;background:white;border-radius:50%;width:50px;height:50px;border:1px solid #ddd;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">&#10094;</button>
            <button class="nav-btn next" onclick="scrollTours(1)"  style="position:absolute;right:10px;top:50%;transform:translateY(-50%);z-index:10;background:white;border-radius:50%;width:50px;height:50px;border:1px solid #ddd;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">&#10095;</button>
            <div class="tours-slider" id="toursSlider" style="display:flex;gap:20px;overflow-x:auto;scroll-behavior:smooth;scrollbar-width:none;padding:20px 70px;">
                <?php if ($tours): ?>
                    <?php foreach ($tours as $i => $tour): ?>
                        <div class="tour-item <?php echo $i === 0 ? 'active' : ''; ?>" onclick="updateTourLayout6(<?php echo $i; ?>)">
                            <img src="<?php echo htmlspecialchars($tour['image']); ?>" alt="<?php echo htmlspecialchars($tour['tour_name']); ?>">
                            <div class="tour-overlay"><h3><?php echo htmlspecialchars($tour['tour_name']); ?></h3></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color:#888;padding:20px;">No tours found in database.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ TOUR DETAIL ══════════════════════════ -->
    <section id="section-6" style="padding:50px 0;">
        <div class="tour-main-display" id="tour-display-box">
            <div class="tour-visual"><img id="main-tour-img" src="img/WHITE.jpg"></div>
            <div class="tour-info-box">
                <h2 id="main-tour-title">CHOOSE A TOUR</h2>
                <div class="tour-accent-line"></div>
                <p id="main-tour-desc"></p>
                <div class="tour-stats-grid">
                    <div class="stat-item"><span class="stat-label">💰 Total Sales</span><span id="stat-sales" class="stat-value"></span></div>
                    <div class="stat-item"><span class="stat-label">👥 Attendance</span><span id="stat-attendance" class="stat-value"></span></div>
                    <div class="stat-item"><span class="stat-label">🎤 Songs</span><span id="stat-songs" class="stat-value"></span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ AWARDS ══════════════════════════ -->
    <section id="awards-final-check" style="width:100%;padding:80px 0;display:flex;flex-direction:column;align-items:center;font-family:'Montserrat',sans-serif;">
        <h2 style="font-family:'Playfair Display',serif;font-size:3rem;margin-bottom:50px;color:#1a1a1a;">Awards & Achievements</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr;width:90%;max-width:1100px;gap:30px;">
            <?php if ($awards): ?>
                <?php foreach ($awards as $i => $award): ?>
                    <?php if ($i % 2 === 0): // image left, text right ?>
                        <div style="aspect-ratio:16/9;overflow:hidden;border-radius:20px;background:rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:center;">
                            <img src="<?php echo htmlspecialchars($award['image']); ?>"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        </div>
                        <div style="aspect-ratio:16/9;border-radius:20px;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:20px;text-align:center;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);">
                            <h3 style="margin:0;font-size:1.8rem;font-weight:800;letter-spacing:2px;"><?php echo htmlspecialchars($award['award_name']); ?></h3>
                            <p style="margin:10px 0 0;font-size:1rem;"><?php echo htmlspecialchars($award['description']); ?></p>
                        </div>
                    <?php else: // text left, image right ?>
                        <div style="aspect-ratio:16/9;border-radius:20px;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:20px;text-align:center;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);">
                            <h3 style="margin:0;font-size:1.8rem;font-weight:800;letter-spacing:2px;"><?php echo htmlspecialchars($award['award_name']); ?></h3>
                            <p style="margin:10px 0 0;font-size:1rem;"><?php echo htmlspecialchars($award['description']); ?></p>
                        </div>
                        <div style="aspect-ratio:16/9;overflow:hidden;border-radius:20px;background:rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:center;">
                            <img src="<?php echo htmlspecialchars($award['image']); ?>"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#888;grid-column:1/-1;text-align:center;">No awards found in database.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ══════════════════════════ ABOUT ══════════════════════════ -->
    <section id="about" class="about-container">
        <h2 class="about-title">The Creators</h2>
        <div class="about-grid">
            <div class="about-card">
                <div class="profile-circle"><img src="img/creator.jpg" alt="Lead Developer"></div>
                <h3 class="member-name">Rojan Gabriel G. Contemplacion</h3>
                <p class="member-role">Lead Developer</p>
                <div class="accent-line red"></div>
            </div>
            <div class="about-card">
                <div class="profile-circle"><img src="img/creator.jpg" alt="Designer"></div>
                <h3 class="member-name">Rojan Gabriel G. Contemplacion</h3>
                <p class="member-role">UI/UX Designer</p>
                <div class="accent-line purple"></div>
            </div>
            <div class="about-card">
                <div class="profile-circle"><img src="img/creator.jpg" alt="Researcher"></div>
                <h3 class="member-name">Rojan Gabriel G. Contemplacion</h3>
                <p class="member-role">Researcher</p>
                <div class="accent-line red"></div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════ FOOTER / SOCIALS ══════════════════════════ -->
    <footer id="socials" class="social-footer">
        <div class="social-content">
            <h2 class="social-title">Connect with Taylor</h2>
            <div class="social-icons">
                <a href="https://www.instagram.com/taylorswift" target="_blank" class="glass-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/taylorswift13"     target="_blank" class="glass-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.tiktok.com/@taylorswift"   target="_blank" class="glass-icon" title="TikTok"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.youtube.com/taylorswift"   target="_blank" class="glass-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="copyright">© 2026 The Eras Tour Fan Project | Group Taylor</p>
        </div>
    </footer>

    <!-- ══════════════════════════ JAVASCRIPT ══════════════════════════ -->
    <script>
        // ── Personal Info ──────────────────────────────────────────────────
        const personalData = <?php echo json_encode(array_values($personal_js), JSON_UNESCAPED_UNICODE); ?>;

        function updateDetail(index) {
            const d = personalData[index];
            if (!d) return;
            document.getElementById('detail-title').innerText = d.title;
            document.getElementById('detail-desc').innerText  = d.desc;
            document.getElementById('detail-img').src         = d.img;
            document.getElementById('personal-detail').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // ── Album Slider ───────────────────────────────────────────────────
        function scrollSlider(dir) {
            document.getElementById('erasSlider').scrollBy({ left: 450 * dir, behavior: 'smooth' });
        }

        // ── Tours Slider ───────────────────────────────────────────────────
        function scrollTours(dir) {
            document.getElementById('toursSlider').scrollBy({ left: 450 * dir, behavior: 'smooth' });
        }

        // ── Album data from PHP ────────────────────────────────────────────
        const albumList = <?php echo json_encode(array_values($album_js), JSON_UNESCAPED_UNICODE); ?>;
        const albumNames = <?php echo json_encode(array_keys($album_js), JSON_UNESCAPED_UNICODE); ?>;

        function updateSection4(index) {
            const data = albumList[index];
            const albumName = albumNames[index];
            if (!data) return;
            document.getElementById('current-album-name').innerText = albumName;
            document.getElementById('current-album-desc').innerText = data.desc;
            document.getElementById('current-album-img').src        = data.img;
            const grid = document.getElementById('song-grid');
            grid.innerHTML = '';
            data.songs.forEach(song => {
                const div = document.createElement('div');
                div.style.cssText = 'flex:0 0 200px;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);padding:15px;border-radius:15px;text-align:center;cursor:pointer;';
                div.onclick = () => window.open(`https://www.youtube.com/watch?v=${song.thumb}`, '_blank');
                div.innerHTML = `<img src="https://img.youtube.com/vi/${song.thumb}/mqdefault.jpg" style="width:100%;border-radius:10px;"><p>${song.name}</p>`;
                grid.appendChild(div);
            });
            document.getElementById('album-details').scrollIntoView({ behavior: 'smooth' });
        }

        // ── Tour data from PHP ─────────────────────────────────────────────
        const tourData = <?php echo json_encode($tour_js, JSON_UNESCAPED_UNICODE); ?>;

        function updateTourLayout6(index) {
            const data = tourData[index];
            if (!data) return;
            document.getElementById('main-tour-title').innerText    = data.title;
            document.getElementById('main-tour-desc').innerText     = data.desc;
            document.getElementById('main-tour-img').src            = data.img;
            document.getElementById('stat-sales').innerText         = data.sales;
            document.getElementById('stat-attendance').innerText    = data.attendance;
            document.getElementById('stat-songs').innerText         = data.songs;
            document.querySelectorAll('.tour-item').forEach((el, i) =>
                el.classList.toggle('active', i === index)
            );
            document.getElementById('section-6').scrollIntoView({ behavior: 'smooth' });
        }
    </script>

    <script>
        // Check session every 5 seconds — redirect to login if logged out
        setInterval(function() {
            fetch('check_session.php')
                .then(res => res.json())
                .then(data => {
                    if (!data.logged_in) {
                        window.location.href = 'admin_login.php';
                    }
                })
                .catch(() => {});
        }, 5000);
    </script>
</body>
</html>
