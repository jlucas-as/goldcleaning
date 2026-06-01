@extends('site')
@section('main')
<section class="section services-hero">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">Gold Cleaning service in Marietta, GA</span>
            <h1>{{ $service['name'] }} Services in Marietta, GA</h1>
            <p class="lead">{{ $service['intro'] }}</p>
            <div class="hero-actions">
                <a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a>
                <a class="btn" data-phone-tel href="tel:+14709829820">Call Now</a>
                <a class="btn" href="sms:+14709829820">Text Us</a>
            </div>
        </div>
        <div class="card quote-card"><div class="pad"><div style="font-weight:900;font-size:22px">Request {{ $service['name'] }}</div><p class="sub" style="margin-top:6px">Tell us about the home, timing, ZIP code, and priorities.</p>@include('site.partials.quote-form', ['id' => $slug, 'selectedService' => $service['name'], 'city' => 'Marietta'])</div></div>
    </div>
</section>

<section class="section">
    <div class="grid grid-2">
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Who this service is for</h2><div class="check-grid">@foreach ($service['for'] as $item)<span>{{ $item }}</span>@endforeach</div></div></div>
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">What's commonly included</h2><div class="check-grid">@foreach ($service['included'] as $item)<span>{{ $item }}</span>@endforeach</div></div></div>
    </div>
</section>

<section class="section">
    <div class="grid grid-2">
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">What can affect the quote</h2><div class="check-grid">@foreach ($service['quote'] as $item)<span>{{ $item }}</span>@endforeach</div></div></div>
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Popular add-ons</h2><div class="check-grid">@foreach ($service['addons'] as $item)<span>{{ $item }}</span>@endforeach</div></div></div>
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">Service areas</h2><p class="sub">{{ $service['name'] }} is available in Marietta and many nearby metro Atlanta communities by route availability.</p></div>
    <div class="city-chips link-chips">
        @foreach (array_slice($areas, 0, 12) as $areaSlug => $area)
            <a href="{{ route('site.service-area', ['slug' => $areaSlug]) }}">{{ $area['city'] }}</a>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">{{ $service['name'] }} FAQ</h2></div>
    <div class="faq-list">
        @foreach ([["How do I request {$service['name']}?", 'Use the quote form, call, text, or WhatsApp Gold Cleaning with your ZIP code, home size, service type, and preferred timing.'], ["Is {$service['name']} available outside Marietta?", 'Yes. Availability depends on route and schedule, but Gold Cleaning serves many nearby Cobb County and metro Atlanta cities.'], ['Do I need to be home during the cleaning?', 'Many clients provide access instructions. Share parking, pets, entry details, and any priorities before the appointment.'], ['Can I add special requests?', 'Yes. Include inside appliances, interior windows, linens, pet hair, or priority rooms in your quote request.'], ['What affects the final quote?', 'Home size, condition, service type, add-ons, access, timing, and frequency can all affect the estimate.']] as $item)
            <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div><h2 class="h2">Compare nearby services</h2><p class="sub">Many clients combine a first deep clean with recurring service or request add-ons for a move-in, move-out, or turnover.</p></div>
        <a class="btn primary" href="{{ route('site.services') }}">View All Services</a>
    </div>
</section>
@endsection
