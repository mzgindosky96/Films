<?php
// No need to require config here since frontend uses APIs
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3032189625676969" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Badini-Movies | Watch Free Movies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        }
        body {
            background: #0c0b14;
            color: #f0eef7;
            line-height: 1.5;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .badini-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #2f2b45;
            padding-bottom: 1rem;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        .logo-icon {
            font-size: 2.5rem;
            color: #e4b363;
        }
        .badini-title {
            font-size: 2.2rem;
            font-weight: 700;
        }
        .badini-title span {
            color: #e4b363;
            font-weight: 300;
        }
        .lang-tag {
            background: #2f2b45;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .lang-tag:hover {
            background: #e4b363;
            color: #12101c;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.8rem;
            border-left: 5px solid #e4b363;
            padding-left: 1rem;
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid #4b446b;
            color: #dbd4f5;
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-secondary:hover, .btn-secondary.active {
            border-color: #e4b363;
            color: #e4b363;
        }
        .btn-secondary.active {
            background: #e4b363;
            color: #12101c;
        }
        .search-container {
            margin-bottom: 1.2rem;
            position: relative;
            max-width: 500px;
        }
        .search-wrapper {
            display: flex;
            align-items: center;
            background: #1a1728;
            border: 2px solid #332e48;
            border-radius: 60px;
            padding: 0.3rem 0.3rem 0.3rem 1.5rem;
        }
        .search-wrapper:focus-within {
            border-color: #e4b363;
        }
        .search-icon {
            color: #a29cc0;
            font-size: 1.2rem;
            margin-right: 0.8rem;
        }
        #searchInput {
            background: transparent;
            border: none;
            padding: 0.9rem 0;
            font-size: 1rem;
            color: #f0eef7;
            width: 100%;
            outline: none;
        }
        #searchInput::placeholder {
            color: #5e577a;
        }
        .clear-search {
            background: none;
            border: none;
            color: #a29cc0;
            cursor: pointer;
            padding: 0 1rem;
            font-size: 1.3rem;
            display: none;
        }
        .search-stats {
            margin-top: 0.6rem;
            font-size: 0.85rem;
            color: #a29cc0;
            padding-left: 0.5rem;
        }
        .film-marquee {
            background: linear-gradient(95deg, #181526 0%, #201d30 100%);
            border-radius: 60px;
            border: 1px solid rgba(228, 179, 99, 0.25);
            margin-bottom: 2rem;
            padding: 0.4rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .marquee-icon {
            background: #2f2b45;
            border-radius: 40px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: #e4b363;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .marquee-scroll-container {
            flex: 1;
            overflow: hidden;
        }
        .marquee-track {
            display: inline-flex;
            white-space: nowrap;
            animation: scrollMarquee 200s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        .marquee-item {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            margin-right: 2rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        @keyframes scrollMarquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .filter-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        .movie-card {
            background: #1a1728;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #332e48;
            transition: 0.3s;
            cursor: pointer;
        }
        .movie-card:hover {
            transform: translateY(-5px);
            border-color: #e4b363;
            box-shadow: 0 10px 30px rgba(228, 179, 99, 0.15);
        }
        .video-thumbnail {
            width: 100%;
            height: 180px;
            background: #0c0b14;
            position: relative;
            overflow: hidden;
        }
        .video-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
        }
        .movie-card:hover .play-overlay {
            opacity: 1;
        }
        .play-overlay i {
            font-size: 3rem;
            color: #e4b363;
        }
        .movie-details {
            padding: 1.5rem;
        }
        .movie-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .movie-year {
            background: #2f2b45;
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.8rem;
        }
        .movie-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.8rem 0;
            color: #a29cc0;
            font-size: 0.9rem;
            flex-wrap: wrap;
        }
        .lang-badge {
            background: #e4b363;
            color: #12101c;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .lang-badge.ar { background: #1e9c8d; color: white; }
        .lang-badge.both { background: #9b87e0; color: white; }
        .watch-counter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #2f2b45 0%, #3a3552 100%);
            padding: 0.2rem 0.7rem;
            border-radius: 30px;
            font-size: 0.8rem;
        }
        .loading, .no-results {
            text-align: center;
            padding: 3rem;
            background: #1a1728;
            border-radius: 32px;
            margin: 2rem 0;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.7rem;
            margin: 2rem 0;
        }
        .pagination-btn {
            background: #1a1728;
            border: 1px solid #4b446b;
            color: #dbd4f5;
            padding: 0.6rem 1.2rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .pagination-btn.active-page {
            background: #e4b363;
            color: #12101c;
            border-color: #e4b363;
        }
        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        .page-info {
            background: #2f2b45;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.85rem;
            color: #e4b363;
        }
        .movie-detail-page {
            display: none;
            flex-direction: column;
            gap: 2rem;
            margin: 2rem 0;
            animation: fadeIn 0.4s ease;
        }
        .movie-detail-page.active { display: flex; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .movie-detail-header {
            display: flex;
            gap: 2.5rem;
            background: #1a1728;
            border-radius: 32px;
            padding: 2rem;
            border: 1px solid #332e48;
            flex-wrap: wrap;
        }
        .movie-detail-poster {
            flex: 0 0 280px;
            border-radius: 20px;
            overflow: hidden;
        }
        .movie-detail-poster img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .movie-detail-info {
            flex: 1;
            min-width: 250px;
        }
        .movie-detail-info h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .title-ar {
            font-size: 1.4rem;
            color: #b9b3d6;
            margin-bottom: 0.8rem;
            direction: rtl;
        }
        .detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem 1.5rem;
            margin: 0.8rem 0;
            color: #a29cc0;
        }
        .detail-meta i { color: #e4b363; width: 20px; }
        .detail-view-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(228, 179, 99, 0.15);
            padding: 0.3rem 1rem;
            border-radius: 30px;
        }
        .movie-description {
            background: rgba(255, 255, 255, 0.03);
            padding: 1.2rem 1.5rem;
            border-radius: 20px;
            border-left: 4px solid #e4b363;
            margin: 1rem 0;
            line-height: 1.6;
        }
        .detail-server-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            padding: 1rem 1.5rem;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 50px;
            margin: 1rem 0;
        }
        .detail-server-btn {
            background: #1a1728;
            border: 1px solid #4b446b;
            color: #dbd4f5;
            padding: 0.5rem 1.4rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .detail-server-btn.active-server {
            background: #e4b363;
            color: #12101c;
            border-color: #e4b363;
        }
        .detail-video-container {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }
        .detail-video-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .back-to-home-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #2f2b45;
            color: #e4b363;
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            border: 1px solid #e4b363;
            font-weight: 600;
            cursor: pointer;
            width: fit-content;
        }
        .footer {
            margin-top: 2rem;
            padding: 3rem 0 2rem;
            background: linear-gradient(145deg, #12101f 0%, #0a0912 100%);
            border-radius: 48px 48px 24px 24px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }
        .footer-card {
            background: rgba(26, 23, 40, 0.6);
            border-radius: 32px;
            padding: 1.8rem;
            border: 1px solid rgba(228, 179, 99, 0.2);
        }
        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-top: 1rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .contact-item a {
            color: #dbd4f5;
            text-decoration: none;
        }
        .social-links {
            display: flex;
            gap: 1.2rem;
            margin-top: 1.5rem;
        }
        .social-links a {
            background: #2f2b45;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e4b363;
            transition: all 0.3s;
        }
        .sitemap-btn {
            background: #2a2540;
            border: 1px solid #e4b363;
            color: #e4b363;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            cursor: pointer;
            margin-top: 1rem;
        }
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .movies-grid { grid-template-columns: 1fr; }
            .movie-detail-header { flex-direction: column; align-items: center; }
            .movie-detail-poster { flex: 0 0 auto; max-width: 250px; }
            .movie-detail-poster img { height: 300px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="badini-header">
            <div class="logo-area" id="homeLogo">
                <i class="fas fa-film logo-icon"></i>
                <div class="badini-title">Badini<span>Movies</span></div>
            </div>
            <div class="lang-tag" onclick="toggleLanguage()">
                <i class="fas fa-globe"></i>
                <span id="langDisplay">EN | عربي</span>
            </div>
        </div>

        <div class="section-title">
            <i class="fas fa-film"></i> <span id="libraryTitle">Movie Library</span>
        </div>

        <div class="search-container">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search by film name... / ابحث باسم الفيلم...">
                <button class="clear-search" id="clearSearchBtn"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="search-stats" id="searchStats"></div>
        </div>

        <div class="film-marquee">
            <div class="marquee-icon"><i class="fas fa-ticket-alt"></i><span>NOW SHOWING</span></div>
            <div class="marquee-scroll-container">
                <div class="marquee-track" id="marqueeTrack"></div>
            </div>
        </div>

        <div class="filter-container">
            <button class="btn-secondary filter-btn active" data-filter="all">All / الكل</button>
            <button class="btn-secondary filter-btn" data-filter="en">English</button>
            <button class="btn-secondary filter-btn" data-filter="ar">العربية</button>
        </div>

        <div id="homeView">
            <div class="movies-grid" id="moviesGrid"><div class="loading"><i class="fas fa-spinner fa-spin"></i> Loading movies...</div></div>
            <div id="paginationWrapper" class="pagination-container"></div>
        </div>

        <div id="movieDetailView" class="movie-detail-page">
            <button class="back-to-home-btn" id="backToHomeBtn">
                <i class="fas fa-arrow-left"></i> Back to Library
            </button>
            <div class="movie-detail-header">
                <div class="movie-detail-poster">
                    <img id="detailPoster" src="" alt="Poster">
                </div>
                <div class="movie-detail-info">
                    <h1 id="detailTitleEn">Title</h1>
                    <div class="title-ar" id="detailTitleAr">العنوان</div>
                    <div class="detail-meta">
                        <span><i class="fas fa-calendar-alt"></i> <span id="detailYear">2025</span></span>
                        <span><i class="fas fa-language"></i> <span id="detailLang">EN/AR</span></span>
                        <span class="detail-view-count"><i class="fas fa-eye"></i> <span id="detailViews">0</span> views</span>
                    </div>
                    <div class="movie-description" id="detailDescription">
                        <span id="detailDescText">Loading...</span>
                    </div>
                    <div class="detail-server-buttons" id="detailServerButtons"></div>
                </div>
            </div>
            <div class="detail-video-container" id="detailVideoContainer">
                <iframe id="detailEmbedIframe" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container" style="padding: 0 1rem;">
            <div class="footer-grid">
                <div class="footer-card">
                    <i class="fas fa-info-circle" style="font-size: 2rem; color: #e4b363; margin-bottom: 1rem; display: inline-block;"></i>
                    <h3 id="footerAboutTitle">About Us</h3>
                    <p id="footerAboutText">BadiniMovies - Watch free movies in high quality with multiple servers.</p>
                </div>
                <div class="footer-card">
                    <i class="fas fa-envelope" style="font-size: 2rem; color: #e4b363; margin-bottom: 1rem; display: inline-block;"></i>
                    <h3 id="footerContactTitle">Contact Us</h3>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:mzgindosky@icloud.com">support@badinimovies.com</a>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-card">
                    <i class="fas fa-shield-alt" style="font-size: 2rem; color: #e4b363; margin-bottom: 1rem; display: inline-block;"></i>
                    <h3 id="footerPrivacyTitle">Privacy Policy</h3>
                    <p id="footerPrivacyText">We use cookies and ads to improve your experience.</p>
                    <button id="generateSitemapBtn" class="sitemap-btn"><i class="fas fa-sitemap"></i> Download sitemap.xml</button>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const API_BASE = '/api/';
        let currentLanguage = 'en';
        let currentFilter = 'all';
        let currentSearchQuery = '';
        let currentPage = 1;
        let totalPages = 1;
        let totalMovies = 0;
        let currentView = 'home';
        let currentMovieSlug = null;

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m]));
        }

        function getTitle(movie) {
            return currentLanguage === 'ar' ? movie.title_ar : movie.title_en;
        }

        function getDescription(movie) {
            if (currentLanguage === 'ar') {
                return movie.description_ar || movie.description_en || 'لا يوجد وصف متاح';
            }
            return movie.description_en || movie.description_ar || 'No description available';
        }

        async function fetchMovies() {
            document.getElementById('moviesGrid').innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Loading movies...</div>';
            
            const url = `${API_BASE}get_movies.php?page=${currentPage}&limit=20&filter=${currentFilter}&search=${encodeURIComponent(currentSearchQuery)}`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.success) {
                    totalPages = data.totalPages;
                    totalMovies = data.total;
                    renderMoviesGrid(data.movies);
                    renderPagination();
                    updateSearchStats();
                } else {
                    document.getElementById('moviesGrid').innerHTML = '<div class="no-results">Error loading movies</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('moviesGrid').innerHTML = '<div class="no-results">Failed to load movies</div>';
            }
        }

        function renderMoviesGrid(movies) {
            const grid = document.getElementById('moviesGrid');
            if (movies.length === 0) {
                grid.innerHTML = `<div class="no-results"><i class="fas fa-film-slash"></i><h3>${currentLanguage === 'en' ? 'No movies found' : 'لا توجد أفلام'}</h3></div>`;
                return;
            }
            
            grid.innerHTML = movies.map(movie => {
                const displayTitle = getTitle(movie);
                const langClass = movie.lang === 'ar' ? 'ar' : (movie.lang === 'both' ? 'both' : 'en');
                return `<div class="movie-card" onclick="openMovieDetail('${movie.slug}')">
                    <div class="video-thumbnail">
                        <img src="${escapeHtml(movie.poster_url)}" alt="${escapeHtml(displayTitle)}" onerror="this.src='https://via.placeholder.com/300x180?text=No+Poster'">
                        <div class="play-overlay"><i class="fas fa-play-circle"></i></div>
                    </div>
                    <div class="movie-details">
                        <div class="movie-title">
                            <span>${escapeHtml(displayTitle)}</span>
                            <span class="movie-year">${movie.year}</span>
                        </div>
                        <div class="movie-meta">
                            <span class="lang-badge ${langClass}">${movie.lang === 'en' ? 'EN' : movie.lang === 'ar' ? 'AR' : 'EN/AR'}</span>
                            <span class="watch-counter"><i class="fas fa-eye"></i> ${(movie.views || 0).toLocaleString()}</span>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        function renderPagination() {
            const wrapper = document.getElementById('paginationWrapper');
            if (totalPages <= 1) {
                wrapper.innerHTML = '';
                return;
            }
            
            let html = '';
            html += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" onclick="changePage(${currentPage - 1})"><i class="fas fa-chevron-left"></i> ${currentLanguage === 'en' ? 'Prev' : 'السابق'}</button>`;
            
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
            
            for (let i = startPage; i <= endPage; i++) {
                html += `<button class="pagination-btn ${i === currentPage ? 'active-page' : ''}" onclick="changePage(${i})">${i}</button>`;
            }
            
            html += `<button class="pagination-btn ${currentPage === totalPages ? 'disabled' : ''}" onclick="changePage(${currentPage + 1})">${currentLanguage === 'en' ? 'Next' : 'التالي'} <i class="fas fa-chevron-right"></i></button>`;
            html += `<span class="page-info"><i class="fas fa-film"></i> ${(currentPage-1)*20+1}-${Math.min(currentPage*20, totalMovies)} / ${totalMovies}</span>`;
            
            wrapper.innerHTML = html;
        }

        function changePage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            if (currentView === 'home') {
                fetchMovies();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function updateSearchStats() {
            const stats = document.getElementById('searchStats');
            if (currentSearchQuery.trim() !== '') {
                stats.innerHTML = currentLanguage === 'en' 
                    ? `Found ${totalMovies} movie(s) matching "${escapeHtml(currentSearchQuery)}"`
                    : `تم العثور على ${totalMovies} فيلماً تطابق "${escapeHtml(currentSearchQuery)}"`;
            } else {
                stats.innerHTML = '';
            }
        }

        async function openMovieDetail(slug) {
            currentMovieSlug = slug;
            currentView = 'detail';
            
            document.getElementById('homeView').style.display = 'none';
            document.getElementById('movieDetailView').classList.add('active');
            
            try {
                const response = await fetch(`${API_BASE}get_movie.php?slug=${slug}`);
                const data = await response.json();
                
                if (data.success && data.movie) {
                    const movie = data.movie;
                    document.getElementById('detailPoster').src = movie.poster_url;
                    document.getElementById('detailTitleEn').textContent = movie.title_en;
                    document.getElementById('detailTitleAr').textContent = movie.title_ar;
                    document.getElementById('detailYear').textContent = movie.year;
                    document.getElementById('detailLang').textContent = movie.lang === 'en' ? 'English' : (movie.lang === 'ar' ? 'العربية' : 'EN/AR');
                    document.getElementById('detailViews').textContent = (movie.views || 0).toLocaleString();
                    document.getElementById('detailDescText').textContent = getDescription(movie);
                    
                    const serverContainer = document.getElementById('detailServerButtons');
                    serverContainer.innerHTML = '';
                    if (movie.servers && movie.servers.length > 0) {
                        movie.servers.forEach((server, idx) => {
                            const btn = document.createElement('button');
                            btn.className = 'detail-server-btn' + (idx === 0 ? ' active-server' : '');
                            btn.innerHTML = `<i class="fas ${server.icon || 'fa-play-circle'}"></i> ${server.label}`;
                            btn.onclick = () => {
                                document.querySelectorAll('.detail-server-btn').forEach(b => b.classList.remove('active-server'));
                                btn.classList.add('active-server');
                                document.getElementById('detailEmbedIframe').src = server.url;
                            };
                            serverContainer.appendChild(btn);
                        });
                        document.getElementById('detailEmbedIframe').src = movie.servers[0].url;
                    } else {
                        serverContainer.innerHTML = '<span style="color:#a29cc0;">No video sources available</span>';
                    }
                    
                    const url = new URL(window.location);
                    url.searchParams.set('movie', slug);
                    window.history.pushState({ slug: slug }, '', url);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function closeMovieDetail() {
            currentView = 'home';
            currentMovieSlug = null;
            document.getElementById('movieDetailView').classList.remove('active');
            document.getElementById('homeView').style.display = 'block';
            document.getElementById('detailEmbedIframe').src = '';
            
            const url = new URL(window.location);
            url.searchParams.delete('movie');
            window.history.pushState({}, '', url);
        }

        async function buildMarquee() {
            try {
                const response = await fetch(`${API_BASE}get_movies.php?page=1&limit=100&filter=all&search=`);
                const data = await response.json();
                if (data.success && data.movies) {
                    const track = document.getElementById('marqueeTrack');
                    let html = '';
                    data.movies.forEach(m => {
                        html += `<div class="marquee-item"><i class="fas fa-play-circle"></i><span>${escapeHtml(m.title_en)} / ${escapeHtml(m.title_ar)}</span><i class="fas fa-star"></i></div>`;
                    });
                    track.innerHTML = html + html;
                }
            } catch (e) {}
        }

        async function generateSitemap() {
            try {
                const response = await fetch(`${API_BASE}get_movies.php?page=1&limit=1000&filter=all&search=`);
                const data = await response.json();
                if (data.success && data.movies) {
                    const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '/');
                    const today = new Date().toISOString().split('T')[0];
                    let urls = `<url><loc>${baseUrl}</loc><lastmod>${today}</lastmod><priority>1.0</priority></url>`;
                    data.movies.forEach(movie => {
                        urls += `<url><loc>${baseUrl}?movie=${movie.slug}</loc><lastmod>${today}</lastmod><priority>0.8</priority></url>`;
                    });
                    const sitemapXml = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">${urls}\n</urlset>`;
                    const blob = new Blob([sitemapXml], { type: 'application/xml' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'sitemap.xml';
                    link.click();
                    URL.revokeObjectURL(link.href);
                }
            } catch (e) {
                alert('Error generating sitemap');
            }
        }

        function toggleLanguage() {
            currentLanguage = currentLanguage === 'en' ? 'ar' : 'en';
            document.getElementById('langDisplay').textContent = currentLanguage === 'en' ? 'EN | عربي' : 'عربي | EN';
            document.getElementById('libraryTitle').innerHTML = currentLanguage === 'en' ? 'Movie Library / مكتبة الأفلام' : 'مكتبة الأفلام / Movie Library';
            document.getElementById('backToHomeBtn').innerHTML = `<i class="fas fa-arrow-left"></i> ${currentLanguage === 'en' ? 'Back to Library' : 'العودة إلى المكتبة'}`;
            
            if (currentView === 'home') {
                fetchMovies();
            } else if (currentView === 'detail' && currentMovieSlug) {
                openMovieDetail(currentMovieSlug);
            }
        }

        function init() {
            const params = new URLSearchParams(window.location.search);
            const slug = params.get('movie');
            if (slug) {
                openMovieDetail(slug);
            } else {
                fetchMovies();
            }
            buildMarquee();
            
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            searchInput.addEventListener('input', function() {
                currentSearchQuery = this.value;
                clearBtn.style.display = currentSearchQuery.length ? 'block' : 'none';
                currentPage = 1;
                if (currentView === 'home') fetchMovies();
            });
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                currentSearchQuery = '';
                this.style.display = 'none';
                currentPage = 1;
                if (currentView === 'home') fetchMovies();
                searchInput.focus();
            });
            
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.dataset.filter;
                    currentPage = 1;
                    if (currentView === 'home') fetchMovies();
                });
            });
            
            document.getElementById('backToHomeBtn').addEventListener('click', closeMovieDetail);
            document.getElementById('homeLogo').addEventListener('click', function() {
                if (currentView === 'detail') {
                    closeMovieDetail();
                } else if (window.location.search) {
                    window.history.pushState({}, '', window.location.pathname);
                    fetchMovies();
                }
            });
            document.getElementById('generateSitemapBtn').addEventListener('click', generateSitemap);
            
            window.addEventListener('popstate', function(event) {
                const params = new URLSearchParams(window.location.search);
                const slug = params.get('movie');
                if (slug) {
                    openMovieDetail(slug);
                } else if (currentView === 'detail') {
                    closeMovieDetail();
                } else {
                    fetchMovies();
                }
            });
        }
        
        window.toggleLanguage = toggleLanguage;
        window.openMovieDetail = openMovieDetail;
        window.changePage = changePage;
        
        init();
    </script>
</body>
</html>
