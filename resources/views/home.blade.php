<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Khaja — Digital menus for restaurants in Nepal</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --ink: #1f2421;
        --paper: #faf6ed;
        --paper-dim: #f2ecdd;
        --marigold: #e8a33d;
        --cardamom: #3b5249;
        --clay: #a13d2b;
        --muted: #6b6a63;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0; background: var(--paper); color: var(--ink);
        font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, .display { font-family: 'Fraunces', serif; }
    .mono { font-family: 'JetBrains Mono', monospace; }
    a { text-decoration: none; color: inherit; }
    .wrap { max-width: 1080px; margin: 0 auto; padding: 0 24px; }

    /* Nav */
    nav.top {
        display: flex; align-items: center; justify-content: space-between;
        padding: 22px 24px;
    }
    .wordmark { font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.35rem; letter-spacing: -0.01em; }
    .wordmark span { color: var(--marigold); }
    .nav-links { display: flex; align-items: center; gap: 10px; }
    .btn {
        display: inline-block; padding: 9px 18px; border-radius: 8px; font-weight: 600; font-size: 0.88rem;
    }
    .btn-ghost { border: 1.5px solid rgba(31,36,33,0.18); color: var(--ink); }
    .btn-solid { background: var(--ink); color: var(--paper) !important; }
    .btn-solid:hover { background: var(--cardamom); }

    /* Hero */
    .hero {
        padding: 40px 24px 70px;
    }
    .hero-grid {
        display: grid; grid-template-columns: 1fr; gap: 40px; align-items: center;
    }
    @media (min-width: 900px) {
        .hero-grid { grid-template-columns: 1.05fr 0.95fr; gap: 30px; }
    }
    .eyebrow {
        display: inline-block; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.04em;
        text-transform: uppercase; color: var(--cardamom); background: rgba(59,82,73,0.09);
        padding: 5px 12px; border-radius: 20px; margin-bottom: 18px;
    }
    .hero h1 {
        font-size: clamp(1.9rem, 4.5vw, 2.7rem); font-weight: 600; line-height: 1.18;
        margin: 0 0 16px; letter-spacing: -0.01em;
    }
    .hero p.lede { font-size: 1.03rem; color: #46453f; line-height: 1.6; max-width: 480px; margin: 0 0 26px; }
    .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .hero-actions .btn-solid { padding: 12px 22px; }
    .hero-actions .btn-ghost { padding: 12px 22px; }
    .fine-print { font-size: 0.82rem; color: var(--muted); margin-top: 14px; }

    /* Phone mockup — the signature element */
    .phone-stage { display: flex; justify-content: center; }
    .phone {
        position: relative; width: 260px; background: #fff; border-radius: 30px;
        box-shadow: 0 30px 60px -20px rgba(31,36,33,0.35), 0 0 0 8px #14181a;
        transform: rotate(-4deg); overflow: hidden;
    }
    .phone::after {
        /* peeling laminate corner */
        content: ''; position: absolute; top: 0; right: 0; width: 34px; height: 34px;
        background: linear-gradient(135deg, transparent 50%, rgba(0,0,0,0.06) 51%, rgba(0,0,0,0.12) 100%);
        border-bottom-left-radius: 10px;
        box-shadow: -2px 2px 6px rgba(0,0,0,0.08);
    }
    .phone-cover { height: 78px; background: linear-gradient(120deg, #d8c9a3, #b9a679); position: relative; }
    .phone-logo {
        position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%);
        width: 42px; height: 42px; border-radius: 50%; background: var(--cardamom); color: #fff;
        display: flex; align-items: center; justify-content: center; font-family: 'Fraunces', serif;
        font-weight: 700; font-size: 0.95rem; border: 3px solid #fff;
    }
    .phone-body { padding: 30px 14px 16px; }
    .phone-name { text-align: center; font-family: 'Fraunces', serif; font-weight: 600; font-size: 0.95rem; margin-bottom: 10px; }
    .phone-search {
        background: var(--paper-dim); border-radius: 20px; padding: 7px 12px; font-size: 0.72rem;
        color: var(--muted); margin-bottom: 4px; display: flex; justify-content: space-between;
    }
    .phone-search .typo { text-decoration: line-through; color: #b5aa8f; }
    .phone-suggestion {
        font-size: 0.68rem; color: var(--cardamom); background: #eef2ee; border-radius: 10px;
        padding: 6px 10px; margin: 6px 0 14px; display: flex; justify-content: space-between;
    }
    .phone-pills { display: flex; gap: 6px; margin-bottom: 12px; }
    .phone-pill { font-size: 0.62rem; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.12); color: var(--muted); }
    .phone-pill.active { background: var(--ink); color: #fff; border-color: var(--ink); }
    .phone-row { display: flex; gap: 8px; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0ece0; }
    .phone-row .thumb { width: 34px; height: 34px; border-radius: 8px; background: #e4d8b8; flex-shrink: 0; }
    .phone-row .info { flex-grow: 1; }
    .phone-row .info .name { font-size: 0.74rem; font-weight: 600; }
    .phone-row .info .tag { font-size: 0.6rem; color: var(--clay); }
    .phone-row .price { font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; font-weight: 600; }

    /* Feature strip — grounded, not icon-tile generic */
    .strip { padding: 10px 24px 60px; }
    .strip-head { text-align: center; margin-bottom: 34px; }
    .strip-head .eyebrow { background: rgba(232,163,61,0.15); color: #93641c; }
    .strip-head h2 { font-size: 1.7rem; font-weight: 600; margin: 10px 0 8px; }
    .strip-head p { color: var(--muted); font-size: 0.95rem; }
    .strip-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
    @media (min-width: 700px) { .strip-grid { grid-template-columns: 1fr 1fr; } }
    .strip-card {
        background: #fff; border-radius: 14px; padding: 22px; border: 1px solid rgba(31,36,33,0.07);
    }
    .strip-card .label { font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: var(--marigold); font-weight: 600; letter-spacing: 0.03em; }
    .strip-card h3 { font-size: 1.05rem; font-weight: 600; margin: 8px 0 6px; }
    .strip-card p { font-size: 0.88rem; color: var(--muted); margin: 0; line-height: 1.55; }

    /* How it works — legitimate sequence, numbers earn their place */
    .steps { background: var(--ink); color: var(--paper); padding: 56px 24px; }
    .steps h2 { text-align: center; font-size: 1.6rem; font-weight: 600; margin-bottom: 36px; }
    .steps-grid { display: grid; grid-template-columns: 1fr; gap: 26px; max-width: 780px; margin: 0 auto; }
    @media (min-width: 700px) { .steps-grid { grid-template-columns: repeat(3, 1fr); } }
    .step { text-align: center; }
    .step .num { font-family: 'Fraunces', serif; font-size: 2.1rem; color: var(--marigold); font-weight: 600; line-height: 1; margin-bottom: 8px; }
    .step h4 { font-size: 0.98rem; font-weight: 600; margin: 0 0 6px; }
    .step p { font-size: 0.85rem; color: #cbcdc4; margin: 0; }

    /* Pricing */
    .pricing { padding: 60px 24px; }
    .pricing-head { text-align: center; margin-bottom: 30px; }
    .pricing-head h2 { font-size: 1.7rem; font-weight: 600; margin: 0 0 8px; }
    .pricing-head p { color: var(--muted); font-size: 0.95rem; }
    .price-grid { display: grid; grid-template-columns: 1fr; gap: 18px; max-width: 640px; margin: 0 auto; }
    @media (min-width: 640px) { .price-grid { grid-template-columns: 1fr 1fr; } }
    .price-card {
        border: 1.5px solid rgba(31,36,33,0.12); border-radius: 16px; padding: 26px; background: #fff;
        position: relative;
    }
    .price-card.yearly { border-color: var(--marigold); }
    .price-card .badge {
        position: absolute; top: -11px; right: 20px; background: var(--marigold); color: #fff;
        font-size: 0.66rem; font-weight: 700; padding: 3px 10px; border-radius: 10px;
    }
    .price-card h4 { font-size: 0.95rem; font-weight: 600; color: var(--muted); margin: 0 0 6px; text-transform: uppercase; letter-spacing: 0.03em; }
    .price-card .amount { font-family: 'JetBrains Mono', monospace; font-size: 1.9rem; font-weight: 600; margin-bottom: 4px; }
    .price-card .amount span { font-size: 0.8rem; color: var(--muted); font-weight: 500; }
    .price-card ul { list-style: none; padding: 0; margin: 16px 0 20px; font-size: 0.84rem; color: #46453f; }
    .price-card li { padding: 4px 0; }
    .price-card a.btn { width: 100%; text-align: center; }

    /* Trial band */
    .trial-band {
        margin: 0 24px 60px; background: var(--cardamom); color: #fff; border-radius: 18px;
        padding: 32px 26px; text-align: center;
    }
    .trial-band h3 { font-size: 1.25rem; margin: 0 0 8px; font-weight: 600; }
    .trial-band p { font-size: 0.9rem; color: #dfe6e0; margin: 0 0 18px; }
    .trial-band .btn-solid { background: var(--marigold); }
    .trial-band .btn-solid:hover { background: #d4922f; }

    footer { padding: 26px 24px 34px; text-align: center; color: var(--muted); font-size: 0.8rem; }

    @media (prefers-reduced-motion: reduce) {
        * { transition: none !important; }
    }
</style>
</head>
<body>

<nav class="top wrap">
    <div class="wordmark">Khaja<span>.</span></div>
    <div class="nav-links">
        <a href="{{ route('login') }}" class="btn btn-ghost">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-solid">Start free trial</a>
    </div>
</nav>

<section class="hero wrap">
    <div class="hero-grid">
        <div>
            <span class="eyebrow">For restaurants &amp; cafés in Nepal</span>
            <h1>Your laminated menu<br>just got an upgrade.</h1>
            <p class="lede">Put a QR code on the table. Update prices from your phone. Let the menu quietly figure out what's popular, help people find what they typo, and suggest what goes well together.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-solid">Start free trial</a>
                <a href="#pricing" class="btn btn-ghost">See pricing</a>
            </div>
            <p class="fine-print">3 months free. No card needed.</p>
        </div>
        <div class="phone-stage">
            <div class="phone">
                <div class="phone-cover"><div class="phone-logo">MH</div></div>
                <div class="phone-body">
                    <div class="phone-name">Momo House</div>
                    <div class="phone-search"><span><span class="typo">chiken</span> sekuwa</span><span>🔍</span></div>
                    <div class="phone-suggestion"><span>Showing results for "Chicken Sekuwa"</span><span>✓</span></div>
                    <div class="phone-pills">
                        <div class="phone-pill active">Popular</div>
                        <div class="phone-pill">Momo</div>
                        <div class="phone-pill">Drinks</div>
                    </div>
                    <div class="phone-row">
                        <div class="thumb"></div>
                        <div class="info"><div class="name">Chicken Sekuwa</div><div class="tag">🔥 trending tonight</div></div>
                        <div class="price mono">450</div>
                    </div>
                    <div class="phone-row">
                        <div class="thumb"></div>
                        <div class="info"><div class="name">Buff Momo (10pc)</div><div class="tag">often ordered with drinks</div></div>
                        <div class="price mono">280</div>
                    </div>
                    <div class="phone-row" style="border-bottom:none;">
                        <div class="thumb"></div>
                        <div class="info"><div class="name">Masala Chiya</div></div>
                        <div class="price mono">60</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="strip wrap">
    <div class="strip-head">
        <span class="eyebrow">What's actually different</span>
        <h2>It's not just a PDF with a QR code on it</h2>
        <p>Three small things run quietly behind every menu.</p>
    </div>
    <div class="strip-grid">
        <div class="strip-card">
            <div class="label">POPULAR TONIGHT</div>
            <h3>It notices what's selling</h3>
            <p>The menu tracks what people actually tap and quietly moves your best sellers to the top — weighted toward tonight, not last month.</p>
        </div>
        <div class="strip-card">
            <div class="label">EVEN WITH TYPOS</div>
            <h3>Search that forgives mistakes</h3>
            <p>Someone types "chiken" on a phone keyboard at a table — they still land on your chicken sekuwa, not a blank results page.</p>
        </div>
        <div class="strip-card">
            <div class="label">GOES WELL TOGETHER</div>
            <h3>Suggestions from real behavior</h3>
            <p>Order momo, and the menu remembers what other tables usually add next — no manual "recommended pairing" lists to maintain.</p>
        </div>
        <div class="strip-card">
            <div class="label">ONE QR CODE</div>
            <h3>Print it once, not every time</h3>
            <p>Change a price at 6pm for happy hour — it's live immediately. Nobody's reading a laminated card from three months ago.</p>
        </div>
    </div>
</section>

<section class="steps">
    <div class="wrap">
        <h2>Getting set up takes about twenty minutes</h2>
        <div class="steps-grid">
            <div class="step">
                <div class="num">1</div>
                <h4>Build your menu</h4>
                <p>Add categories, dishes, photos, and prices.</p>
            </div>
            <div class="step">
                <div class="num">2</div>
                <h4>Get your QR code</h4>
                <p>Print it, stick it on the table. Done.</p>
            </div>
            <div class="step">
                <div class="num">3</div>
                <h4>Let it run</h4>
                <p>Prices update instantly. The menu learns as people browse.</p>
            </div>
        </div>
    </div>
</section>

<section class="pricing wrap" id="pricing">
    <div class="pricing-head">
        <h2>Straightforward pricing</h2>
        <p>Pay with eSewa. Cancel anytime.</p>
    </div>
    <div class="price-grid">
        @foreach($plans as $key => $plan)
        <div class="price-card {{ $key === 'yearly' ? 'yearly' : '' }}">
            @if($key === 'yearly')<span class="badge">2 months free</span>@endif
            <h4>{{ $plan['label'] }}</h4>
            <div class="amount">Rs {{ number_format($plan['amount']) }} <span>/ {{ $key === 'yearly' ? 'year' : 'month' }}</span></div>
            <ul>
                <li>Unlimited menu items</li>
                <li>QR code generator</li>
                <li>Smart search &amp; suggestions</li>
                <li>Views &amp; trend dashboard</li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-solid">Get started</a>
        </div>
        @endforeach
    </div>
</section>

<div class="trial-band wrap">
    <h3>Try the whole thing free for 3 months</h3>
    <p>No card needed up front. Claim it anytime after you sign up.</p>
    <a href="{{ route('register') }}" class="btn btn-solid">Create your account</a>
</div>

<footer>
    Built for restaurants in Nepal. &copy; {{ date('Y') }} Khaja.
</footer>

</body>
</html>