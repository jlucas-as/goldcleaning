@extends('site')
@section('main')
<section class="section services-hero">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">Residential cleaning services in Marietta, GA</span>
            <h1>Cleaning options built around your home, schedule, and priorities.</h1>
            <p class="lead">Gold Cleaning serves Marietta and nearby Atlanta suburbs with flexible cleaning for houses, apartments, move-outs, and short-term rentals. Choose a one-time service or request recurring visits.</p>
            <div class="hero-actions">
                <a class="btn primary" href="{{ route('site.quote') }}">Request a Quote</a>
                <a class="btn" data-phone-tel href="tel:+14709829820">Call Now</a>
            </div>
        </div>
        <div class="card">
            <div class="pad service-summary">
                <h2>What affects your quote?</h2>
                <p class="sub">Every home is different. The most accurate estimate comes from a few practical details.</p>
                <ul>
                    <li>Home size, bedrooms, and bathrooms</li>
                    <li>Current condition and last deep clean</li>
                    <li>Pets, clutter level, and special priorities</li>
                    <li>One-time, recurring, move-out, or turnover service</li>
                    <li>ZIP code, parking, access, and scheduling window</li>
                </ul>
                <a class="btn primary" href="{{ route('site.quote') }}">Send Details</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <h2 class="h2">Services</h2>
        <p class="sub">Start with the service that best matches your situation. You can add notes for rooms, surfaces, pets, access instructions, or anything that needs extra attention.</p>
    </div>
    <div class="grid grid-3">
        @foreach ($services as $slug => $service)
            <article class="card service-card">
                <div class="pad item">
                    <h3>{{ $service['name'] }}</h3>
                    <p>{{ $service['intro'] }}</p>
                    <a class="badge" href="{{ route('site.service', ['slug' => $slug]) }}">Learn more</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="grid grid-2">
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Common focus areas</h2><div class="check-grid"><span>Kitchen counters and exterior appliances</span><span>Sinks, fixtures, mirrors, and bathroom surfaces</span><span>Toilets, tubs, showers, and tile touchpoints</span><span>Dusting reachable surfaces and furniture</span><span>Vacuuming and mopping accessible floors</span><span>Baseboards and detail work for deep cleans</span></div></div></div>
        <div class="card"><div class="pad checklist-panel"><h2 class="h2">Optional add-ons</h2><div class="check-grid"><span>Inside oven</span><span>Inside refrigerator</span><span>Interior windows</span><span>Cabinet interior wipe-down</span><span>Laundry or linen change</span><span>Extra pet hair attention</span></div></div></div>
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div><h2 class="h2">Not sure which service you need?</h2><p class="sub">Send a few details and photos if helpful. We will guide you toward the right option based on your home, timing, and goals.</p></div>
        <a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a>
    </div>
</section>
@endsection
