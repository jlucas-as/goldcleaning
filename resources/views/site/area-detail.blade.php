@extends('site')
@section('main')
<section class="section areas-hero">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">House cleaning in {{ $city }}, GA</span>
            <h1>House Cleaning Services in {{ $city }}, GA</h1>
            <p class="lead">{{ $area['note'] }} Gold Cleaning helps homeowners, renters, apartment residents, condo owners, short-term rental hosts, and move-in/move-out clients request practical cleaning service without a complicated booking process.</p>
            <div class="hero-actions">
                <a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a>
                <a class="btn" data-phone-tel href="tel:+14709829820">Call Now</a>
                <a class="btn" href="sms:+14709829820">Text Us</a>
            </div>
        </div>
        <div class="card quote-card"><div class="pad"><div style="font-weight:900;font-size:22px">Request a quote in {{ $city }}</div><p class="sub" style="margin-top:6px">Share ZIP code, service type, home size, and timing so we can confirm availability.</p>@include('site.partials.quote-form', ['id' => $slug, 'city' => $city])</div></div>
    </div>
</section>

<section class="section">
    <div class="grid grid-2">
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Clients we help in {{ $city }}</h2><div class="check-grid"><span>Homeowners who need routine or detailed cleaning</span><span>Renters preparing for guests, inspections, or move-outs</span><span>Apartment and condo residents with access or parking notes</span><span>Short-term rental hosts between guest stays</span><span>Move-in and move-out clients working against deadlines</span></div></div></div>
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Cleaning services available in {{ $city }}</h2><div class="check-grid">@foreach ($services as $serviceSlug => $service)<span><a href="{{ route('site.service', ['slug' => $serviceSlug]) }}">{{ $service['name'] }}</a></span>@endforeach</div></div></div>
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">Why local homeowners choose Gold Cleaning</h2><p class="sub">Clear communication, flexible quote options, and service that focuses on the rooms and details that matter in your home.</p></div>
    <div class="grid grid-3">
        <div class="step"><span>01</span><h3>Quote by real details</h3><p>Home size, ZIP code, service type, timing, pets, and access all help shape a fair estimate.</p></div>
        <div class="step"><span>02</span><h3>Easy contact options</h3><p>Call, text, WhatsApp, email, or use the quote form depending on what is easiest for you.</p></div>
        <div class="step"><span>03</span><h3>Local route awareness</h3><p>Nearby city pages and ZIP code notes help confirm availability around metro Atlanta traffic and routes.</p></div>
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">Nearby service areas</h2></div>
    <div class="city-chips link-chips">
        @foreach ($area['nearby'] as $nearby)
            @php $nearbySlug = strtolower(str_replace(' ', '-', $nearby)).'-ga'; @endphp
            @if (isset($areas[$nearbySlug]))
                <a href="{{ route('site.service-area', ['slug' => $nearbySlug]) }}">{{ $nearby }}</a>
            @else
                <span>{{ $nearby }}</span>
            @endif
        @endforeach
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">{{ $city }} cleaning FAQ</h2></div>
    <div class="faq-list">
        @foreach ([["Do you offer house cleaning in {$city}, GA?", "Yes. Gold Cleaning serves {$city} by route availability for standard, deep, recurring, move-in/move-out, apartment, condo, and Airbnb cleaning."], ["Can I get a same-week quote in {$city}?", 'Send your ZIP code, service type, and preferred timing by WhatsApp, text, or the quote form so we can confirm availability.'], ["Do you clean apartments and condos in {$city}?", 'Yes. Share building access, parking, elevator details, bedrooms, bathrooms, and any pet or roommate notes.'], ["What services are popular in {$city}?", 'Common requests include standard cleaning, deep cleaning, recurring maintenance, move-out cleaning, and short-term rental turnover support.']] as $item)
            <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div><h2 class="h2">Request a quote in {{ $city }}</h2><p class="sub">Send your ZIP code, bedrooms, bathrooms, service type, and preferred timing. Photos are helpful when you want a more detailed estimate.</p></div>
        <a class="btn primary" href="{{ route('site.quote') }}">Request a Cleaning Quote</a>
    </div>
</section>
@endsection
