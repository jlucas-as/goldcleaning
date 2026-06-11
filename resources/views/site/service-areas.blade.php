@extends('site')
@section('main')
<section class="section areas-hero">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">Based in Marietta, GA</span>
            <h1>Cleaning service across Marietta, Cobb County, and nearby Atlanta suburbs.</h1>
            <p class="lead">Gold Cleaning serves homes, apartments, condos, and short-term rentals across the north metro Atlanta area. If your city is not listed, send your ZIP code and we will confirm availability quickly.</p>
            <div class="hero-actions">
                <a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a>
                <a class="btn" data-phone-tel href="tel:+16783303174">Call Now</a>
            </div>
            <div class="area-highlights"><span>Cobb County core coverage</span><span>North metro Atlanta routes</span><span>Quote by city or ZIP code</span></div>
        </div>
        <div class="card">
            <div class="pad">
                <div style="font-weight:900;font-size:22px">Check Your Area</div>
                <p class="sub" style="margin-top:6px">Send your city or ZIP code and we will confirm coverage, scheduling, and quote options.</p>
                @include('site.partials.quote-form', ['id' => 'areas'])
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <h2 class="h2">Priority service areas</h2>
        <p class="sub">Each city page includes local cleaning options, nearby areas, FAQs, and quote links.</p>
    </div>
    <div class="area-grid">
        @foreach ($areas as $slug => $area)
            <article class="card area-card @if ($slug === 'marietta-ga') featured @endif">
                <div class="pad item">
                    <h3>{{ $area['city'] }}, GA</h3>
                    <p>{{ $area['note'] }}</p>
                    <div class="city-chips">
                        @foreach ($area['nearby'] as $nearby)
                            <span>{{ $nearby }}</span>
                        @endforeach
                    </div>
                    <a class="badge" href="{{ route('site.service-area', ['slug' => $slug]) }}">View {{ $area['city'] }}</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div><h2 class="h2">Not listed?</h2><p class="sub">We serve a wide area around Marietta. Send your city or ZIP code and we will confirm coverage, availability, and the best service option for your home.</p></div>
        <a class="btn primary" data-wa-quote href="#" target="_blank" rel="noreferrer">Ask on WhatsApp</a>
    </div>
</section>
@endsection
