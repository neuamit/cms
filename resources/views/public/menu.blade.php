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
        :root { --accent: #14213d; --gold: #c8a951; --muted: #8a8a8a; }
        * { font-family: 'Poppins', sans-serif; }
        body { background: #fafafa; margin: 0; padding-bottom: 40px; }
        .wrap { max-width: 560px; margin: 0 auto; background: #fff; min-height: 100vh; }

        /* Cover banner */
        .cover-wrap { position: relative; }
        .cover-img { width: 100%; height: 180px; object-fit: cover; display: block; background: #ddd; }
        .lang-badge {
            position: absolute; top: 14px; right: 14px; background: #fff;
            border-radius: 20px; padding: 5px 14px; font-size: 0.8rem; font-weight: 500;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        }
        .logo-circle {
            position: absolute; bottom: -34px; left: 50%; transform: translateX(-50%);
            width: 72px; height: 72px; border-radius: 50%; background: #fff;
            border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .logo-circle img { width: 100%; height: 100%; object-fit: cover; }

        /* Info card */
        .info-card { text-align: center; padding: 46px 20px 14px; }
        .info-card h2 { font-weight: 700; margin: 0 0 6px; color: #1a1a1a; font-size: 1.4rem; }
        .info-card .meta { font-size: 0.82rem; color: var(--muted); margin-bottom: 8px; }
        .info-card .meta span { margin: 0 6px; }
        .social-row a {
            display: inline-flex; width: 30px; height: 30px; border-radius: 50%;
            border: 1px solid #ddd; align-items: center; justify-content: center;
            margin: 0 4px; color: #555; text-decoration: none; font-size: 0.85rem;
        }
        .hours-text { font-size: 0.78rem; color: var(--muted); margin-top: 8px; }

        /* Category pills */
        .category-nav {
            position: sticky; top: 0; z-index: 50; background: #fff;
            white-space: nowrap; overflow-x: auto; padding: 12px 16px;
            border-bottom: 1px solid #eee; -ms-overflow-style: none; scrollbar-width: none;
        }
        .category-nav::-webkit-scrollbar { display: none; }
        .category-pill {
            display: inline-block; padding: 7px 18px; margin-right: 8px;
            border-radius: 20px; border: 1.5px solid var(--accent); color: var(--accent);
            font-size: 0.82rem; font-weight: 600; cursor: pointer; text-decoration: none;
        }
        .category-pill.active, .category-pill:hover { background: var(--accent); color: #fff; }

        /* Search */
        .search-wrap { padding: 14px 16px 0; }
        .search-wrap .input-group { border-radius: 30px; overflow: hidden; background: #f2f2f2; }
        .search-wrap input {
            border: none; background: transparent; padding: 12px 18px; font-size: 0.9rem;
        }
        .search-wrap input:focus { outline: none; box-shadow: none; }
        .search-btn {
            width: 34px; height: 34px; border-radius: 50%; background: var(--accent);
            display: flex; align-items: center; justify-content: center; margin: 3px; color: #fff;
        }

        .section-title { font-weight: 700; font-size: 1.05rem; margin: 22px 16px 10px; color: #1a1a1a; }

        /* Item rows */
        .item-row { display: flex; padding: 12px 16px; border-bottom: 1px solid #f2f2f2; cursor: pointer; }
        .item-row img { width: 76px; height: 76px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
        .item-row .item-info { padding-left: 12px; flex-grow: 1; min-width: 0; }
        .item-row .item-info h6 { font-weight: 600; margin: 0 0 3px; color: #1a1a1a; font-size: 0.92rem; }
        .item-row .item-info p {
            font-size: 0.78rem; color: var(--muted); margin: 0 0 6px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .item-price { font-weight: 700; color: var(--accent); font-size: 0.95rem; }
        .old-price { text-decoration: line-through; color: #bbb; font-size: 0.75rem; margin-left: 6px; }
        .badge-tag { background: #f0ede3; color: var(--gold); font-weight: 500; margin-right: 4px; font-size: 0.68rem; }

        /* Trending strip */
        .trending-strip { display: flex; overflow-x: auto; padding: 4px 16px 12px; gap: 10px; }
        .trending-strip::-webkit-scrollbar { display: none; }
        .trending-card {
            flex: 0 0 138px; background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 1px 5px rgba(0,0,0,0.08); cursor: pointer;
        }
        .trending-card img { width: 100%; height: 88px; object-fit: cover; }
        .trending-card .tc-body { padding: 8px; }
        .trending-card h6 { font-size: 0.8rem; font-weight: 600; margin: 0 0 3px; }

        /* Inline detail panel */
        .detail-panel {
            background: #faf8f2; margin: 0 16px 8px; padding: 12px 14px;
            border-radius: 10px; border: 1px dashed #e6dcc0;
        }
        .detail-panel h6 { font-size: 0.85rem; font-weight: 600; color: #1a1a1a; }
        .rec-card {
            background: #fff; border-radius: 10px; padding: 8px; font-size: 0.8rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06); cursor: pointer;
        }
        .rec-card strong { display: block; font-size: 0.82rem; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="cover-wrap">
        @if($restaurant->cover_image)
            <img src="{{ asset('storage/' . $restaurant->cover_image) }}" class="cover-img">
        @else
            <div class="cover-img"></div>
        @endif
        <span class="lang-badge">English ▾</span>
        <div class="logo-circle">
            @if($restaurant->logo)
                <img src="{{ asset('storage/' . $restaurant->logo) }}">
            @else
                <strong>{{ substr($restaurant->name, 0, 1) }}</strong>
            @endif
        </div>
    </div>

    <div class="info-card">
        <h2>{{ $restaurant->name }}</h2>
        <div class="meta">
            @if($restaurant->address)<span>📍 {{ $restaurant->address }}</span>@endif
            @if($restaurant->phone)<span>📞 {{ $restaurant->phone }}</span>@endif
        </div>
        @if($restaurant->facebook_url || $restaurant->instagram_url || $restaurant->tripadvisor_url)
        <div class="social-row">
            @if($restaurant->instagram_url)<a href="{{ $restaurant->instagram_url }}" target="_blank">IG</a>@endif
            @if($restaurant->facebook_url)<a href="{{ $restaurant->facebook_url }}" target="_blank">FB</a>@endif
            @if($restaurant->tripadvisor_url)<a href="{{ $restaurant->tripadvisor_url }}" target="_blank">TA</a>@endif
        </div>
        @endif
        @if($restaurant->opening_hours)
            <p class="hours-text">{{ $restaurant->opening_hours }}</p>
        @endif
        @if($restaurant->wifi_password)
            <p class="hours-text">📶 WiFi: {{ $restaurant->wifi_password }}</p>
        @endif
    </div>

    @if($categories->count())
    <div class="category-nav">
        @foreach($categories as $cat)
            <a href="#cat-{{ $cat->_id }}" class="category-pill">{{ $cat->name }}</a>
        @endforeach
    </div>
    @endif

    <div class="search-wrap">
        <div class="input-group">
            <input type="text" id="menuSearch" class="form-control" placeholder="Search dishes...">
            <div class="search-btn">🔍</div>
        </div>
        <div id="searchResults" class="mt-2"></div>
    </div>

    @if($trendingItems->count())
    <h4 class="section-title">🔥 Popular Now</h4>
    <div class="trending-strip">
        @foreach($trendingItems as $item)
        <div class="trending-card" onclick="toggleItem('{{ $item->_id }}', '{{ $restaurant->slug }}')">
            @if($item->photo)
                <img src="{{ asset('storage/' . $item->photo) }}">
            @endif
            <div class="tc-body">
                <h6>{{ $item->name }}</h6>
                <span class="item-price">Rs. {{ $item->price }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @foreach($trendingItems as $item)
        <div id="detail-{{ $item->_id }}" class="detail-panel" style="display:none;">
            <h6>You might also like</h6>
            <div id="recs-{{ $item->_id }}" class="row"></div>
        </div>
    @endforeach
    @endif

    @foreach($categories as $cat)
        @php $catItems = $items[(string) $cat->_id] ?? collect(); @endphp
        @if($catItems->count())
        <h4 class="section-title" id="cat-{{ $cat->_id }}">{{ $cat->name }}</h4>
        @foreach($catItems as $item)
            <div class="item-row" onclick="toggleItem('{{ $item->_id }}', '{{ $restaurant->slug }}')">
                @if($item->photo)
                    <img src="{{ asset('storage/' . $item->photo) }}">
                @else
                    <div style="width:76px;height:76px;background:#f0f0f0;border-radius:10px;flex-shrink:0;"></div>
                @endif
                <div class="item-info">
                    <h6>{{ $item->name }}</h6>
                    <p>{{ $item->description }}</p>
                    @if(!empty($item->tags))
                        @foreach($item->tags as $tag)
                            <span class="badge badge-tag">{{ $tag }}</span>
                        @endforeach
                    @endif
                    <div>
                        <span class="item-price">Rs. {{ $item->price }}</span>
                        @if($item->old_price)<span class="old-price">Rs. {{ $item->old_price }}</span>@endif
                    </div>
                </div>
            </div>
            <div id="detail-{{ $item->_id }}" class="detail-panel" style="display:none;">
                <h6>You might also like</h6>
                <div id="recs-{{ $item->_id }}" class="row"></div>
            </div>
        @endforeach
        @endif
    @endforeach

    <p class="text-center text-muted" style="font-size:0.7rem;margin-top:20px;">Powered by Menu SaaS</p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
const navLinks = document.querySelectorAll('.category-pill');
navLinks.forEach(link => {
    link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});

let searchTimeout;
const searchInput = document.getElementById('menuSearch');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        const resultsBox = document.getElementById('searchResults');

        if (query.length < 2) { resultsBox.innerHTML = ''; return; }

        searchTimeout = setTimeout(() => {
            fetch(`/menu/{{ $restaurant->slug }}/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        resultsBox.innerHTML = '<p class="text-muted small px-2">No matches found.</p>';
                        return;
                    }
                    resultsBox.innerHTML = data.map(item => `
                        <div class="item-row" style="border:none;" onclick="toggleItem('${item.id}', '{{ $restaurant->slug }}')">
                            ${item.photo ? `<img src="${item.photo}">` : ''}
                            <div class="item-info">
                                <h6>${item.name}</h6>
                                <span class="item-price">Rs. ${item.price}</span>
                            </div>
                        </div>
                    `).join('');
                });
        }, 300);
    });
}

let openItemId = null;

function toggleItem(itemId, slug) {
    const panel = document.getElementById(`detail-${itemId}`);
    if (!panel) return;

    if (openItemId === itemId) {
        panel.style.display = 'none';
        openItemId = null;
        return;
    }
    if (openItemId) {
        const prevPanel = document.getElementById(`detail-${openItemId}`);
        if (prevPanel) prevPanel.style.display = 'none';
    }

    panel.style.display = 'block';
    openItemId = itemId;
    panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    fetch(`/menu/${slug}/item/${itemId}/view`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    const recBox = document.getElementById(`recs-${itemId}`);
    if (recBox.dataset.loaded) return;

    fetch(`/menu/${slug}/item/${itemId}/recommendations`)
        .then(res => res.json())
        .then(data => {
            recBox.innerHTML = data.length === 0
                ? '<p class="text-muted small">No suggestions yet.</p>'
                : data.map(r => `
                    <div class="col-6 mb-2">
                        <div class="rec-card" onclick="event.stopPropagation(); toggleItem('${r.id}', '${slug}')">
                            <strong>${r.name}</strong>
                            <span class="item-price">Rs. ${r.price}</span>
                        </div>
                    </div>
                `).join('');
            recBox.dataset.loaded = 'true';
        });
}
</script>
</body>
</html>