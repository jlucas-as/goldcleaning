<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}" />
    <meta name="robots" content="{{ $meta['robots'] ?? 'index,follow' }}" />
    <link rel="canonical" href="{{ $meta['canonical'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $meta['title'] }}" />
    <meta property="og:description" content="{{ $meta['description'] }}" />
    <meta property="og:url" content="{{ $meta['canonical'] }}" />
    <meta property="og:image" content="{{ $meta['image'] }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $meta['title'] }}" />
    <meta name="twitter:description" content="{{ $meta['description'] }}" />
    <meta name="twitter:image" content="{{ $meta['image'] }}" />
    <link rel="icon" type="image/png" href="{{ url('public/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('public/css/styles.css') }}?v=21" />
    @if (!empty($settings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings['google_analytics_id'] }}');
        </script>
    @endif
    
    @if (!empty($settings['google_ads_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_ads_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings['google_ads_id'] }}');
        </script>
    @endif

    @foreach (($meta['schema'] ?? []) as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endforeach
</head>

<body>
    <header class="nav">
        <div class="nav-inner">
            <a class="brand" href="{{ route('site.home') }}" aria-label="Gold Cleaning home">
                <img src="{{ url('public/img/logo.png') }}" alt="Gold Cleaning logo" class="logo-img" width="220" height="52">
            </a>

            <nav class="menu" data-menu aria-label="Main navigation">
                <a href="{{ route('site.home') }}">Home</a>
                <a href="{{ route('site.services') }}">Services</a>
                <a href="{{ route('site.service-areas') }}">Service Areas</a>
                <a href="{{ route('site.quote') }}">Quote</a>
                <a href="{{ route('site.how-it-works') }}">How It Works</a>
                <a href="{{ route('site.home') }}#reviews">Reviews</a>
                <a href="{{ route('site.faq') }}">FAQ</a>
                <a href="{{ route('site.contact') }}">Contact</a>
            </nav>

            <div class="actions">
                <a class="btn" data-phone-tel href="tel:{{ $settings['phone_tel'] }}">Call</a>
                <a class="btn primary" data-wa-quote href="#" target="_blank" rel="noreferrer">Get a Quote</a>
                <button class="btn burger" type="button" data-burger aria-label="Open menu">Menu</button>
            </div>
        </div>
    </header>

    <main class="container">
        @if (!empty($breadcrumbs))
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('site.home') }}">Home</a>
                @foreach ($breadcrumbs as $crumb)
                    <span>/</span>
                    <a href="{{ url($crumb[1]) }}">{{ $crumb[0] }}</a>
                @endforeach
            </nav>
        @endif

        @yield('main')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div style="font-weight:900;font-size:16px" data-brand>Gold Cleaning</div>
                    <p style="margin:10px 0 0;max-width:60ch">
                        {{ $settings['footer_description'] ?? 'Professional residential cleaning in Marietta, GA and nearby Atlanta suburbs. Call, text, or WhatsApp for a quote.' }}
                    </p>
                </div>

                <div>
                    <div style="font-weight:900;margin-bottom:8px">Quick Links</div>
                    <div style="display:grid;gap:6px">
                        <a href="{{ route('site.services') }}">Services</a>
                        <a href="{{ route('site.service-areas') }}">Service Areas</a>
                        <a href="{{ route('site.quote') }}">Quote</a>
                        <a href="{{ route('site.how-it-works') }}">How It Works</a>
                        <a href="{{ route('site.home') }}#reviews">Google Reviews</a>
                        <a href="{{ route('site.faq') }}">FAQ</a>
                        <a href="{{ route('site.privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ route('site.terms') }}">Terms</a>
                    </div>
                </div>

                <div>
                    <div style="font-weight:900;margin-bottom:8px">Contact</div>
                    <div style="display:grid;gap:6px">
                        <a data-phone-tel href="tel:{{ $settings['phone_tel'] }}"><span data-phone-display>{{ $settings['phone_display'] }}</span></a>
                        <a data-email-link href="mailto:{{ $settings['email'] }}"><span data-email>{{ $settings['email'] }}</span></a>
                        <a href="sms:{{ $settings['phone_digits'] }}">Text Us</a>
                        <a data-wa-quote href="#" target="_blank" rel="noreferrer">WhatsApp Quote</a>
                    </div>
                </div>
            </div>

            <hr class="hr" />
            <div style="text-align:center;opacity:.8">
                &copy; <span id="y"></span> <span data-brand>Gold Cleaning</span>. All rights reserved.
            </div>
        </div>
        <script>
            document.getElementById("y").textContent = new Date().getFullYear();
        </script>
    </footer>

    <script>
        window.GOLD_CLEANING_BRAND = {!! json_encode([
            'name' => $settings['brand'],
            'city' => $settings['city'],
            'serviceRadius' => $settings['service_radius'],
            'phoneDisplay' => $settings['phone_display'],
            'phoneTel' => $settings['phone_tel'],
            'phoneDigits' => $settings['phone_digits'],
            'whatsappDigits' => $settings['whatsapp_digits'],
            'email' => $settings['email'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ url('public/js/app.js') }}?v=22"></script>
</body>

</html>
