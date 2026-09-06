<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

    <title>{{ $restaurant->name }} - Menu</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #14213d;
            --gold: #c8a951;
            --muted: #8a8a8a;
            --light: #f7f7f7;
            --border: #eeeeee;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f4f4f4;
            margin: 0;
            padding-bottom: 110px;
        }

        .wrap {
            max-width: 560px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
        }

        /* =========================================================
           COVER
        ========================================================= */

        .cover-wrap {
            position: relative;
        }

        .cover-img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
            background: #ddd;
        }

        .lang-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(255, 255, 255, .95);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: .76rem;
            font-weight: 600;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .12);
        }

        .logo-circle {
            position: absolute;
            bottom: -36px;
            left: 50%;
            transform: translateX(-50%);
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: var(--accent);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* =========================================================
           RESTAURANT INFO
        ========================================================= */

        .info-card {
            text-align: center;
            padding: 50px 20px 18px;
        }

        .info-card h2 {
            font-weight: 700;
            margin: 0 0 6px;
            color: #171717;
            font-size: 1.45rem;
        }

        .info-card .meta {
            font-size: .78rem;
            color: var(--muted);
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .info-card .meta span {
            margin: 0 4px;
        }

        .social-row {
            display: flex;
            justify-content: center;
            gap: 7px;
        }

        .social-row a {
            display: inline-flex;
            width: 31px;
            height: 31px;
            border-radius: 50%;
            border: 1px solid #ddd;
            align-items: center;
            justify-content: center;
            color: #555;
            text-decoration: none;
            font-size: .72rem;
            font-weight: 600;
            transition: .2s;
        }

        .social-row a:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .hours-text {
            font-size: .76rem;
            color: var(--muted);
            margin: 8px 0 0;
        }

        /* =========================================================
           CATEGORY NAV
        ========================================================= */

        .category-nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(10px);
            white-space: nowrap;
            overflow-x: auto;
            padding: 11px 16px;
            border-top: 1px solid #f5f5f5;
            border-bottom: 1px solid var(--border);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .category-nav::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            display: inline-block;
            padding: 7px 17px;
            margin-right: 7px;
            border-radius: 22px;
            border: 1px solid #ddd;
            background: #fff;
            color: #555;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            transition: .2s;
        }

        .category-pill.active,
        .category-pill:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* =========================================================
           ORDER HINT
        ========================================================= */

        .order-hint {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff9ed;
            border: 1px solid #f0dfb8;
            border-radius: 13px;
            padding: 11px 13px;
            margin: 15px 16px 12px;
        }

        .order-hint-icon {
            font-size: 1.15rem;
            line-height: 1;
        }

        .order-hint strong {
            font-size: .78rem;
            color: #222;
            display: block;
            margin-bottom: 2px;
        }

        .order-hint p {
            font-size: .7rem;
            color: var(--muted);
            margin: 0;
            line-height: 1.4;
        }

        .order-hint-close {
            margin-left: auto;
            background: none;
            border: none;
            color: #bbb;
            font-size: 1.1rem;
            padding: 0 4px;
        }

        /* =========================================================
           SEARCH
        ========================================================= */

        .search-wrap {
            padding: 5px 16px 0;
        }

        .search-wrap .input-group {
            border-radius: 30px;
            overflow: hidden;
            background: #f3f3f3;
            border: 1px solid #eee;
        }

        .search-wrap input {
            border: none;
            background: transparent;
            padding: 11px 17px;
            font-size: .82rem;
        }

        .search-wrap input:focus {
            outline: none;
            box-shadow: none;
            background: transparent;
        }

        .search-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
            color: #fff;
            font-size: .8rem;
        }

        /* =========================================================
           SECTION
        ========================================================= */

        .section-title {
            font-weight: 700;
            font-size: 1rem;
            margin: 23px 16px 9px;
            color: #181818;
            scroll-margin-top: 65px;
        }

        /* =========================================================
           TRENDING
        ========================================================= */

        .trending-strip {
            display: flex;
            overflow-x: auto;
            padding: 4px 16px 13px;
            gap: 10px;
            scrollbar-width: none;
        }

        .trending-strip::-webkit-scrollbar {
            display: none;
        }

        .trending-card {
            flex: 0 0 145px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 9px rgba(0, 0, 0, .08);
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            border: 1px solid #f0f0f0;
        }

        .trending-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 16px rgba(0, 0, 0, .12);
        }

        .trending-card:active {
            transform: scale(.98);
        }

        .trending-card img {
            width: 100%;
            height: 92px;
            object-fit: cover;
        }

        .trending-placeholder {
            height: 92px;
            background: #f0f0f0;
        }

        .trending-card .tc-body {
            padding: 9px;
        }

        .trending-card h6 {
            font-size: .78rem;
            font-weight: 600;
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .trending-price {
            font-weight: 700;
            color: var(--accent);
            font-size: .8rem;
        }

        .trending-time {
            font-size: .65rem;
            color: var(--muted);
            margin-top: 3px;
        }

        /* =========================================================
           MENU ITEM
        ========================================================= */

        .menu-item-wrapper {
            scroll-margin-top: 70px;
        }

        .item-row {
            display: flex;
            align-items: flex-start;
            padding: 13px 16px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
            transition: background .2s;
            scroll-margin-top: 70px;
        }

        .item-row:hover {
            background: #fafafa;
        }

        .item-row.active-item {
            background: #fbfbfb;
        }

        .item-row img,
        .item-image-placeholder {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .item-image-placeholder {
            background: #f0f0f0;
        }

        .item-info {
            padding-left: 12px;
            flex-grow: 1;
            min-width: 0;
        }

        .item-name-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }

        .item-info h6 {
            font-weight: 600;
            margin: 1px 0 4px;
            color: #171717;
            font-size: .88rem;
            line-height: 1.3;
        }

        .item-description {
            font-size: .7rem;
            color: var(--muted);
            margin: 0 0 7px;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-price {
            font-weight: 700;
            color: var(--accent);
            font-size: .86rem;
        }

        .old-price {
            text-decoration: line-through;
            color: #bbb;
            font-size: .68rem;
            margin-left: 5px;
        }

        .badge-tag {
            background: #f3efe4;
            color: #a78938;
            font-weight: 500;
            margin-right: 3px;
            margin-bottom: 5px;
            font-size: .59rem;
            padding: 3px 6px;
            border-radius: 5px;
        }

        .preparation-time {
            font-size: .66rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* =========================================================
           QUANTITY
        ========================================================= */

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
        }

        .quantity-control button {
            width: 29px;
            height: 29px;
            border: 1px solid #ddd;
            background: #fff;
            color: #333;
            border-radius: 50%;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: .18s;
        }

        .quantity-control button:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .quantity-control .quantity {
            min-width: 20px;
            text-align: center;
            font-weight: 600;
            font-size: .78rem;
        }

        /* =========================================================
           DETAIL PANEL
        ========================================================= */

        .detail-panel {
            display: none;
            margin: 0 12px 10px;
            padding: 16px;
            background: linear-gradient(145deg, #fffdf8, #f8f5ed);
            border: 1px solid #eee6d5;
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .05);
            animation: detailOpen .25s ease;
        }

        .detail-panel.show {
            display: block;
        }

        @keyframes detailOpen {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detail-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 13px;
            border-bottom: 1px solid #e9e1d0;
        }

        .detail-title {
            font-size: .88rem;
            font-weight: 700;
            color: #222;
            margin: 0;
        }

        .detail-subtitle {
            font-size: .67rem;
            color: var(--muted);
            margin: 3px 0 0;
        }

        .detail-quantity {
            margin-top: 0;
            background: #fff;
            padding: 4px 7px;
            border-radius: 30px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .07);
            flex-shrink: 0;
        }

        .detail-quantity button {
            width: 28px;
            height: 28px;
        }

        .detail-content {
            padding-top: 14px;
        }

        .detail-section-label {
            font-size: .72rem;
            font-weight: 700;
            color: #555;
            margin: 0 0 9px;
        }

        .rec-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .rec-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 11px;
            padding: 9px;
            cursor: pointer;
            transition: .2s;
        }

        .rec-card:hover {
            border-color: #ddd2b8;
            transform: translateY(-1px);
        }

        .rec-card strong {
            display: block;
            font-size: .7rem;
            font-weight: 600;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rec-card .rec-price {
            font-size: .7rem;
            color: var(--accent);
            font-weight: 700;
        }

        .rec-card .rec-time {
            font-size: .6rem;
            color: var(--muted);
            display: block;
            margin-top: 2px;
        }

        .no-recommendations {
            color: var(--muted);
            font-size: .7rem;
            margin: 0;
        }

        /* =========================================================
           ORDER SUMMARY
        ========================================================= */

        .order-summary {
            position: fixed;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            width: min(528px, calc(100% - 28px));
            background: var(--accent);
            color: #fff;
            border-radius: 16px;
            padding: 11px 12px 11px 16px;
            display: none;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 7px 25px rgba(0, 0, 0, .25);
            opacity: 0;
            transition: opacity .2s, transform .2s;
        }

        .order-summary.visible {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .order-summary strong {
            display: block;
            font-size: .8rem;
        }

        .order-summary small {
            opacity: .75;
            font-size: .7rem;
        }

        .order-summary button {
            border: none;
            background: #fff;
            color: var(--accent);
            padding: 8px 16px;
            border-radius: 22px;
            font-size: .75rem;
            font-weight: 700;
            cursor: pointer;
        }

        /* =========================================================
           ORDER MODAL
        ========================================================= */

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 15px 17px;
        }

        .modal-title {
            font-size: .95rem;
            font-weight: 700;
        }

        .modal-body {
            padding: 15px 17px 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px solid #eee;
        }

        .order-item-name {
            font-size: .8rem;
            font-weight: 600;
        }

        .order-item-price {
            font-size: .68rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .order-item-total {
            font-size: .78rem;
            font-weight: 700;
            color: var(--accent);
            white-space: nowrap;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            margin-top: 16px;
            font-size: .9rem;
        }

        .confirm-order-btn {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 11px 22px;
            width: 100%;
            font-weight: 600;
            font-size: .82rem;
            margin-top: 15px;
        }

        .confirm-order-btn:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        /* =========================================================
           SEARCH RESULTS
        ========================================================= */

        #searchResults {
            background: #fff;
            border-radius: 12px;
        }

        .search-result {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .search-result:last-child {
            border-bottom: none;
        }

        .search-result:hover {
            background: #fafafa;
        }

        .search-result img,
        .search-result-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
            flex-shrink: 0;
        }

        .search-result-info {
            min-width: 0;
        }

        .search-result-info strong {
            display: block;
            font-size: .76rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-info span {
            font-size: .68rem;
            color: var(--accent);
            font-weight: 600;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            font-size: .65rem;
            margin: 25px 0 20px;
            color: #aaa;
        }
        /* =========================================================
   TOAST NOTIFICATION
========================================================= */

.toast-notify {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px);
    background: var(--accent);
    color: #fff;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: .82rem;
    font-weight: 600;
    box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
    z-index: 200;
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0;
    transition: opacity .25s, transform .25s;
    max-width: min(400px, calc(100% - 32px));
}

.toast-notify.visible {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.toast-notify.error {
    background: #b3261e;
}

.toast-icon {
    font-size: 1rem;
    line-height: 1;
    flex-shrink: 0;
}
    </style>
</head>

<body>

    <div class="wrap">

        {{-- =========================================================
        COVER
        ========================================================== --}}

        <div class="cover-wrap">

            @if($restaurant->cover_image)

                <img src="{{ asset('storage/' . $restaurant->cover_image) }}" class="cover-img"
                    alt="{{ $restaurant->name }}">

            @else

                <div class="cover-img"></div>

            @endif

            <span class="lang-badge">
                English ▾
            </span>

            <div class="logo-circle">

                @if($restaurant->logo)

                    <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}">

                @else

                    {{ substr($restaurant->name, 0, 1) }}

                @endif

            </div>

        </div>


        {{-- =========================================================
        RESTAURANT INFO
        ========================================================== --}}

        <div class="info-card">

            <h2>
                {{ $restaurant->name }}
            </h2>

            <div class="meta">

                @if($restaurant->address)

                    <span>
                        📍 {{ $restaurant->address }}
                    </span>

                @endif

                @if($restaurant->phone)

                    <span>
                        📞 {{ $restaurant->phone }}
                    </span>

                @endif

            </div>

            @if(
    $restaurant->facebook_url ||
    $restaurant->instagram_url ||
    $restaurant->tripadvisor_url
)

                <div class="social-row">

                    @if($restaurant->instagram_url)

                        <a href="{{ $restaurant->instagram_url }}" target="_blank">
                            IG
                        </a>

                    @endif

                    @if($restaurant->facebook_url)

                        <a href="{{ $restaurant->facebook_url }}" target="_blank">
                            FB
                        </a>

                    @endif

                    @if($restaurant->tripadvisor_url)

                        <a href="{{ $restaurant->tripadvisor_url }}" target="_blank">
                            TA
                        </a>

                    @endif

                </div>

            @endif

            @if($restaurant->opening_hours)

                <p class="hours-text">
                    🕒 {{ $restaurant->opening_hours }}
                </p>

            @endif

            @if($restaurant->wifi_password)

                <p class="hours-text">
                    📶 WiFi: {{ $restaurant->wifi_password }}
                </p>

            @endif

        </div>


        {{-- =========================================================
        CATEGORY NAV
        ========================================================== --}}

        @if($categories->count())

            <div class="category-nav">

                @foreach($categories as $cat)

                    <a href="#cat-{{ $cat->_id }}" class="category-pill">

                        {{ $cat->name }}

                    </a>

                @endforeach

            </div>

        @endif


        {{-- =========================================================
        ORDER HINT
        ========================================================== --}}

        <div class="order-hint" id="orderHint">

            <span class="order-hint-icon">
                🍽️
            </span>

            <div>

                <strong>
                    Build your order
                </strong>

                <p>
                    Tap + to add dishes, then review your order below.
                </p>

            </div>

            <button type="button" class="order-hint-close"
                onclick="document.getElementById('orderHint').style.display='none'">

                &times;

            </button>

        </div>


        {{-- =========================================================
        SEARCH
        ========================================================== --}}

        <div class="search-wrap">

            <div class="input-group">

                <input type="text" id="menuSearch" class="form-control" placeholder="Search dishes...">

                <div class="search-btn">
                    🔍
                </div>

            </div>

            <div id="searchResults"></div>

        </div>


        {{-- =========================================================
        TRENDING
        ========================================================== --}}

        @if($trendingItems->count())

            <h4 class="section-title">
                🔥 Popular Now
            </h4>

            <div class="trending-strip">

                @foreach($trendingItems as $item)

                    <div class="trending-card" onclick="openMenuItem('{{ $item->_id }}')">

                        @if($item->photo)

                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}">

                        @else

                            <div class="trending-placeholder"></div>

                        @endif

                        <div class="tc-body">

                            <h6>
                                {{ $item->name }}
                            </h6>

                            <span class="trending-price">
                                Rs. {{ $item->price }}
                            </span>

                            @if($item->preparation_time)

                                <div class="trending-time">
                                    ⏱ {{ $item->preparation_time }} min
                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif


        {{-- =========================================================
        MENU
        ========================================================== --}}

        @foreach($categories as $cat)

            @php
    $catItems = $items[(string) $cat->_id] ?? collect();
            @endphp

            @if($catItems->count())

                <h4 class="section-title" id="cat-{{ $cat->_id }}">

                    {{ $cat->name }}

                </h4>


                @foreach($catItems as $item)

                    {{-- =================================================
                    ITEM WRAPPER
                    ================================================== --}}

                    <div class="menu-item-wrapper" id="item-wrapper-{{ $item->_id }}">

                        {{-- ITEM ROW --}}

                        <div class="item-row" id="item-{{ $item->_id }}" onclick="openMenuItem('{{ $item->_id }}')">

                            @if($item->photo)

                                <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}">

                            @else

                                <div class="item-image-placeholder"></div>

                            @endif


                            <div class="item-info">

                                <div class="item-name-row">

                                    <h6>
                                        {{ $item->name }}
                                    </h6>

                                </div>


                                @if($item->description)

                                    <p class="item-description">
                                        {{ $item->description }}
                                    </p>

                                @endif


                                @if(!empty($item->tags))

                                    <div>

                                        @foreach($item->tags as $tag)

                                            <span class="badge badge-tag">
                                                {{ $tag }}
                                            </span>

                                        @endforeach

                                    </div>

                                @endif


                                <div>

                                    <span class="item-price">
                                        Rs. {{ $item->price }}
                                    </span>

                                    @if($item->old_price)

                                        <span class="old-price">
                                            Rs. {{ $item->old_price }}
                                        </span>

                                    @endif

                                </div>


                                @if($item->preparation_time)

                                    <div class="preparation-time">
                                        ⏱ Preparation: {{ $item->preparation_time }} min
                                    </div>

                                @endif


                                {{-- MAIN QUANTITY --}}

                                <div class="quantity-control" onclick="event.stopPropagation()">

                                    <button type="button" class="qty-btn" data-item-id="{{ $item->_id }}" data-change="-1"
                                        data-price="{{ $item->price }}" data-name="{{ $item->name }}">

                                        −

                                    </button>


                                    <span class="quantity qty-display" data-item-id="{{ $item->_id }}">

                                        0

                                    </span>


                                    <button type="button" class="qty-btn" data-item-id="{{ $item->_id }}" data-change="1"
                                        data-price="{{ $item->price }}" data-name="{{ $item->name }}">

                                        +

                                    </button>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                        DETAILS
                        ================================================== --}}

                        <div id="detail-{{ $item->_id }}" class="detail-panel">

                            <div class="detail-header">

                                <div>

                                    <p class="detail-title">
                                        {{ $item->name }}
                                    </p>

                                    <p class="detail-subtitle">
                                        Adjust quantity or explore similar dishes
                                    </p>

                                </div>


                                {{-- DETAIL QUANTITY --}}

                                <div class="quantity-control detail-quantity" onclick="event.stopPropagation()">

                                    <button type="button" class="qty-btn" data-item-id="{{ $item->_id }}" data-change="-1"
                                        data-price="{{ $item->price }}" data-name="{{ $item->name }}">

                                        −

                                    </button>


                                    <span class="quantity qty-display" data-item-id="{{ $item->_id }}">

                                        0

                                    </span>


                                    <button type="button" class="qty-btn" data-item-id="{{ $item->_id }}" data-change="1"
                                        data-price="{{ $item->price }}" data-name="{{ $item->name }}">

                                        +

                                    </button>

                                </div>

                            </div>


                            <div class="detail-content">

                                <p class="detail-section-label">
                                    You might also like
                                </p>

                                <div id="recs-{{ $item->_id }}" class="rec-grid">

                                    <p class="no-recommendations">
                                        Loading suggestions...
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            @endif

        @endforeach


        {{-- =========================================================
        ORDER SUMMARY
        ========================================================== --}}

        <div class="order-summary" id="orderSummary">

            <div>

                <strong id="orderCount">
                    0 items
                </strong>

                <small id="orderTotal">
                    Rs. 0.00
                </small>

            </div>

            <button type="button" onclick="openOrderModal()">

                View Order

            </button>

        </div>


        {{-- =========================================================
        ORDER MODAL
        ========================================================== --}}

        <div class="modal fade" id="orderModal" tabindex="-1">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Your Order
                        </h5>

                        <button type="button" class="close" data-dismiss="modal">

                            <span>
                                &times;
                            </span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div id="orderItemsList"></div>


                        <div class="order-total">

                            <span>
                                Total
                            </span>

                            <span id="modalOrderTotal">
                                Rs. 0.00
                            </span>

                        </div>


                        <button class="confirm-order-btn" onclick="submitOrder()">

                            Confirm Order

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
        FOOTER
        ========================================================== --}}

        <p class="text-center footer">
            Powered by Menu SaaS
        </p>

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>


    <script>

        /* ============================================================
           ORDER STATE
        ============================================================ */

        const orderItems = {};

        let openItemId = null;


        /* ============================================================
           QUANTITY BUTTON DELEGATION
           Reads values from data-* attributes instead of interpolating
           item name/price directly into an inline onclick call. This
           avoids breaking the JS (and every handler on the page) when
           a dish name or price contains a quote character.
        ============================================================ */

        document.addEventListener('click', function (event) {

            const btn = event.target.closest('.qty-btn');

            if (!btn) {
                return;
            }

            changeQuantity(
                btn.dataset.itemId,
                Number(btn.dataset.change),
                btn.dataset.price,
                btn.dataset.name
            );

        }, true);


        /* ============================================================
           TABLE
        ============================================================ */

        function getTableFromUrl() {

            const params = new URLSearchParams(
                window.location.search
            );

            return params.get('table') || '';

        }


        /* ============================================================
           CHANGE QUANTITY
           ONE SOURCE OF TRUTH
        ============================================================ */

        function changeQuantity(itemId, change, price, name) {

            if (!orderItems[itemId]) {

                orderItems[itemId] = {
                    id: itemId,
                    name: name,
                    price: Number(price),
                    quantity: 0
                };

            }


            let quantity =
                orderItems[itemId].quantity + change;


            if (quantity < 0) {
                quantity = 0;
            }


            orderItems[itemId].quantity = quantity;


            if (quantity === 0) {

                delete orderItems[itemId];

            }


            /*
            IMPORTANT:
    
            We DO NOT update a single element by ID.
    
            We update ALL quantity displays belonging
            to this item.
    
            Therefore:
    
            Main +  -> Detail updates
            Detail + -> Main updates
            */

            updateQuantityDisplays(
                itemId,
                quantity
            );


            updateOrderSummary();

        }


        /* ============================================================
           UPDATE EVERY QUANTITY DISPLAY
        ============================================================ */

        function updateQuantityDisplays(itemId, quantity) {

            const displays =
                document.querySelectorAll(
                    `.qty-display[data-item-id="${itemId}"]`
                );


            displays.forEach(display => {

                display.textContent = quantity;

            });

        }


        /* ============================================================
           ORDER SUMMARY
        ============================================================ */

        function updateOrderSummary() {

            let totalQuantity = 0;
            let totalPrice = 0;


            Object.values(orderItems).forEach(item => {

                totalQuantity += item.quantity;

                totalPrice +=
                    item.quantity * item.price;

            });


            const summary =
                document.getElementById('orderSummary');


            if (totalQuantity === 0) {

                summary.classList.remove('visible');

                setTimeout(() => {

                    if (totalQuantity === 0) {
                        summary.style.display = 'none';
                    }

                }, 200);

                return;

            }


            summary.style.display = 'flex';


            requestAnimationFrame(() => {

                summary.classList.add('visible');

            });


            document.getElementById('orderCount').textContent =
                `${totalQuantity} ${totalQuantity === 1 ? 'item' : 'items'}`;


            document.getElementById('orderTotal').textContent =
                `Rs. ${totalPrice.toFixed(2)}`;

        }


        /* ============================================================
           OPEN ORDER MODAL
        ============================================================ */

        function openOrderModal() {

            const list =
                document.getElementById('orderItemsList');


            list.innerHTML = '';


            let total = 0;


            const items =
                Object.values(orderItems);


            if (items.length === 0) {

                list.innerHTML = `
                <p class="text-muted text-center small">
                    Your order is empty.
                </p>
            `;

            }


            items.forEach(item => {

                const itemTotal =
                    item.quantity * item.price;


                total += itemTotal;


                list.innerHTML += `

                <div class="order-item">

                    <div>

                        <div class="order-item-name">
                            ${escapeHtml(item.name)}
                        </div>

                        <div class="order-item-price">
                            Rs. ${item.price.toFixed(2)}
                            × ${item.quantity}
                        </div>

                    </div>

                    <div class="order-item-total">
                        Rs. ${itemTotal.toFixed(2)}
                    </div>

                </div>

            `;

            });


            document.getElementById(
                'modalOrderTotal'
            ).textContent =
                `Rs. ${total.toFixed(2)}`;


            $('#orderModal').modal('show');

        }

    /* ============================================================
       TOAST NOTIFICATION
       Replaces alert() for order feedback.
    ============================================================ */

    function showToast(message, type = 'success') {

        const toast =
            document.createElement('div');

        toast.className =
            `toast-notify ${type === 'error' ? 'error' : ''}`;

        toast.innerHTML = `
        <span class="toast-icon">${type === 'error' ? '⚠️' : '✅'}</span>
        <span>${escapeHtml(message)}</span>
    `;

        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.add('visible');
        });

        setTimeout(() => {

            toast.classList.remove('visible');

            setTimeout(() => {
                toast.remove();
            }, 250);

        }, 2800);

    }
        /* ============================================================
           ESCAPE HTML
        ============================================================ */

        function escapeHtml(text) {

            const div =
                document.createElement('div');

            div.textContent = text;

            return div.innerHTML;

        }


        /* ============================================================
       SUBMIT ORDER
       No single "place whole order" endpoint exists — each cart
       item is sent individually to the notify-waiter endpoint.
    ============================================================ */

            function submitOrder() {

                const items =
                    Object.values(orderItems);


                if (items.length === 0) {

                    showToast('Please select at least one item.', 'error');

                    return;

                }


                const table =
                    getTableFromUrl();


                if (!table) {

                    showToast('Table number is missing.', 'error');

                    return;

                }


                const confirmButton =
                    document.querySelector(
                        '.confirm-order-btn'
                    );


                if (confirmButton.disabled) {
                    return;
                }


                confirmButton.disabled = true;

                confirmButton.textContent =
                    'Placing Order...';


                const requests = items.map(item =>

                    fetch(
                        `/menu/{{ $restaurant->slug }}/item/${item.id}/notify`,
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}',

                                'Accept':
                                    'application/json'

                            },

                            body: JSON.stringify({

                                table: table,

                                quantity: item.quantity

                            })

                        }
                    )

                        .then(async response => {

                            const data =
                                await response.json();


                            if (!response.ok) {

                                throw new Error(
                                    data.message ||
                                    `Failed to notify for ${item.name}.`
                                );

                            }


                            return data;

                        })

                );


                Promise.all(requests)

                    .then(() => {

                        $('#orderModal').modal('hide');


                        showToast('Order placed successfully!', 'success');


                        Object.keys(orderItems)
                            .forEach(itemId => {

                                updateQuantityDisplays(
                                    itemId,
                                    0
                                );

                            });


                        Object.keys(orderItems)
                            .forEach(itemId => {

                                delete orderItems[itemId];

                            });


                        updateOrderSummary();

                    })

                    .catch(error => {

                        console.error(error);


                        showToast(error.message || 'Something went wrong while placing your order.', 'error');

                    })

                    .finally(() => {

                        confirmButton.disabled = false;

                        confirmButton.textContent =
                            'Confirm Order';

                    });

            }


        /* ============================================================
           OPEN MENU ITEM
        ============================================================ */

        function openMenuItem(itemId) {

            const wrapper =
                document.getElementById(
                    `item-wrapper-${itemId}`
                );


            const panel =
                document.getElementById(
                    `detail-${itemId}`
                );


            if (!wrapper || !panel) {

                console.warn(
                    'Menu item not found:',
                    itemId
                );

                return;

            }


            /*
            If clicking the same item again,
            close it.
            */

            if (openItemId === itemId) {

                panel.classList.remove('show');

                wrapper
                    .querySelector('.item-row')
                    ?.classList.remove('active-item');

                openItemId = null;

                return;

            }


            /*
            Close previous item.
            */

            if (openItemId) {

                const previousPanel =
                    document.getElementById(
                        `detail-${openItemId}`
                    );


                const previousWrapper =
                    document.getElementById(
                        `item-wrapper-${openItemId}`
                    );


                if (previousPanel) {

                    previousPanel.classList.remove(
                        'show'
                    );

                }


                if (previousWrapper) {

                    previousWrapper
                        .querySelector('.item-row')
                        ?.classList.remove(
                            'active-item'
                        );

                }

            }


            /*
            Open new item.
            */

            panel.classList.add('show');


            wrapper
                .querySelector('.item-row')
                ?.classList.add('active-item');


            openItemId = itemId;


            /*
            IMPORTANT:
    
            Wait for the panel to render,
            then smoothly move the ITEM itself
            to the top.
    
            scroll-margin-top prevents the
            sticky category bar from covering it.
            */

            setTimeout(() => {

                wrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            }, 30);


            /*
            Load recommendations.
            */

            loadRecommendations(itemId);

        }


        /* ============================================================
           RECOMMENDATIONS
        ============================================================ */

        function loadRecommendations(itemId) {

            const recBox =
                document.getElementById(
                    `recs-${itemId}`
                );


            if (!recBox) {
                return;
            }


            if (recBox.dataset.loaded === 'true') {
                return;
            }


            fetch(
                `/menu/{{ $restaurant->slug }}/item/${itemId}/recommendations`
            )

                .then(response => {

                    if (!response.ok) {
                        throw new Error(
                            'Failed to load recommendations'
                        );
                    }

                    return response.json();

                })

                .then(data => {

                    if (!data || data.length === 0) {

                        recBox.innerHTML = `
                    <p class="no-recommendations">
                        No suggestions yet.
                    </p>
                `;

                        recBox.dataset.loaded = 'true';

                        return;

                    }


                    recBox.innerHTML =
                        data.map(item => `

                    <div
                        class="rec-card"
                        onclick="event.stopPropagation(); openMenuItem('${item.id}')">

                        <strong>
                            ${escapeHtml(item.name)}
                        </strong>

                        <span class="rec-price">
                            Rs. ${Number(item.price).toFixed(2)}
                        </span>

                        ${item.preparation_time
                                ? `
                                    <span class="rec-time">
                                        ⏱ ${item.preparation_time} min
                                    </span>
                                  `
                                : ''
                            }

                    </div>

                `).join('');


                    recBox.dataset.loaded = 'true';

                })

                .catch(error => {

                    console.error(
                        'Recommendation error:',
                        error
                    );


                    recBox.innerHTML = `
                <p class="no-recommendations">
                    Unable to load suggestions.
                </p>
            `;

                });

        }


        /* ============================================================
           CATEGORY NAVIGATION
        ============================================================ */

        const navLinks =
            document.querySelectorAll(
                '.category-pill'
            );


        navLinks.forEach(link => {

            link.addEventListener(
                'click',
                function () {

                    navLinks.forEach(l => {

                        l.classList.remove(
                            'active'
                        );

                    });


                    this.classList.add(
                        'active'
                    );

                }
            );

        });


        /* ============================================================
           SEARCH
        ============================================================ */

        let searchTimeout;


        const searchInput =
            document.getElementById(
                'menuSearch'
            );


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function () {

                    clearTimeout(
                        searchTimeout
                    );


                    const query =
                        this.value.trim();


                    const resultsBox =
                        document.getElementById(
                            'searchResults'
                        );


                    if (query.length < 2) {

                        resultsBox.innerHTML = '';

                        return;

                    }


                    searchTimeout =
                        setTimeout(() => {

                            fetch(
                                `/menu/{{ $restaurant->slug }}/search?q=${encodeURIComponent(query)}`
                            )

                                .then(response => {

                                    if (!response.ok) {

                                        throw new Error(
                                            'Search failed'
                                        );

                                    }

                                    return response.json();

                                })

                                .then(data => {

                                    if (
                                        !data ||
                                        data.length === 0
                                    ) {

                                        resultsBox.innerHTML = `
                                    <p class="text-muted small px-2 py-2 mb-0">
                                        No matches found.
                                    </p>
                                `;

                                        return;

                                    }


                                    resultsBox.innerHTML =
                                        data.map(item => `

                                    <div
                                        class="search-result"
                                        onclick="openMenuItem('${item.id}')">

                                        ${item.photo
                                                ? `
                                                    <img
                                                        src="${escapeHtml(item.photo)}"
                                                        alt="${escapeHtml(item.name)}">
                                                  `
                                                : `
                                                    <div class="search-result-placeholder"></div>
                                                  `
                                            }

                                        <div class="search-result-info">

                                            <strong>
                                                ${escapeHtml(item.name)}
                                            </strong>

                                            <span>
                                                Rs. ${Number(item.price).toFixed(2)}
                                            </span>

                                        </div>

                                    </div>

                                `).join('');

                                })

                                .catch(error => {

                                    console.error(
                                        'Search error:',
                                        error
                                    );

                                });

                        }, 300);

                }
            );

        }


        /* ============================================================
           CLOSE SEARCH WHEN CLICKING OUTSIDE
        ============================================================ */

        document.addEventListener(
            'click',
            function (event) {

                const searchWrap =
                    document.querySelector(
                        '.search-wrap'
                    );


                if (
                    searchWrap &&
                    !searchWrap.contains(event.target)
                ) {

                    const results =
                        document.getElementById(
                            'searchResults'
                        );


                    if (results) {
                        results.innerHTML = '';
                    }

                }

            }
        );

    </script>

</body>

</html>