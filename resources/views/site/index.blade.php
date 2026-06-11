@extends('site')
@section('main')
<section class="hero-banner">
    <img src="{{ url('public/img/hero-team.png') }}" alt="Gold Cleaning residential cleaning team in Marietta, Georgia" width="1120" height="520" />
</section>

<section class="hero-content section" id="quote">
    <div class="grid grid-2 hero-bottom-grid">
        <div class="hero-copy-block">
            <span class="pill">Locally focused cleaning for Marietta, GA homes</span>
            <h1>Reliable house cleaning for busy homes in Marietta, GA.</h1>
            <p class="lead">
                Gold Cleaning helps homeowners, renters, apartment residents, and short-term rental hosts keep their spaces guest-ready, family-ready, and easier to live in. Request a one-time clean or set up recurring service around your routine.
            </p>
            <div class="hero-actions">
                <a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a>
                <a class="btn" data-phone-tel href="tel:+16783303174">Call Now</a>
            </div>
            <div class="service-areas-mini">
                <span class="areas-label">Serving Marietta and nearby communities:</span>
                <div class="areas-list">
                    @foreach (array_slice($areas, 0, 12) as $slug => $area)
                        <a class="badge" href="{{ route('site.service-area', ['slug' => $slug]) }}">{{ $area['city'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="contact-shortcuts">
                <a class="contact-chip" href="tel:+16783303174">Call</a>
                <a class="contact-chip" href="sms:+16783303174">Text Us</a>
                <a class="contact-chip" data-wa-quote href="#" target="_blank" rel="noreferrer">WhatsApp</a>
                <a class="contact-chip" href="mailto:hello@goldcleaning.com">Email</a>
            </div>
        </div>

        <div class="card quote-card">
            <div class="pad">
                <div style="font-weight:900;font-size:22px">Request a Cleaning Quote</div>
                <p class="sub" style="margin-top:6px">Share the basics and we will follow up with availability and a clear estimate.</p>
                @include('site.partials.quote-form', ['id' => 'home'])
            </div>
        </div>
    </div>
</section>

<section class="section" id="services">
    <div class="section-heading">
        <h2 class="h2">Cleaning services for real life in metro Atlanta</h2>
        <p class="sub">Choose the service that fits your home, timing, and priorities. Each quote is based on home size, condition, access, ZIP code, and requested add-ons.</p>
    </div>
    <div class="grid grid-3">
        @foreach ($services as $slug => $service)
            <article class="card service-card">
                <div class="pad item">
                    <h3>{{ $service['name'] }}</h3>
                    <p>{{ $service['intro'] }}</p>
                    <a class="badge" href="{{ route('site.service', ['slug' => $slug]) }}">View service</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section" id="process">
    <div class="section-heading">
        <h2 class="h2">How the quote works</h2>
        <p class="sub">A clear process keeps the first visit simple and helps us match the right cleaning option to your home.</p>
    </div>
    <div class="grid grid-3">
        <div class="step"><span>01</span><h3>Send the basics</h3><p>Share your ZIP code, bedrooms, bathrooms, service type, preferred contact method, and priority areas.</p></div>
        <div class="step"><span>02</span><h3>Confirm availability</h3><p>We follow up with scheduling options, estimate details, and any questions needed for an accurate quote.</p></div>
        <div class="step"><span>03</span><h3>Walk through priorities</h3><p>Before the clean, we align on access, supplies, pets, parking, and the rooms that matter most.</p></div>
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div>
            <h2 class="h2">Built for Marietta schedules</h2>
            <p class="sub">From East Cobb family homes to apartments near Marietta Square and short-term rentals across the north metro area, our goal is simple: make the home feel clean without making booking complicated.</p>
        </div>
        <a class="btn primary" href="{{ route('site.service-areas') }}">View Service Areas</a>
    </div>
</section>

<section class="section" id="reviews">
    <div class="google-reviews-panel">
        <div class="google-reviews-copy">
            <span class="pill">Google Reviews</span>
            <h2 class="h2">Customer feedback on Google</h2>
            <p class="sub">
                Our Google Business Profile is new and does not have public reviews yet. Visit the official profile
                to leave the first review or check for the latest customer feedback.
            </p>
        </div>
        <div class="google-reviews-actions">
            <div class="google-rating">
                <strong>New profile</strong>
                <span>Reviews will appear on Google as customers share their experience.</span>
            </div>
            <a class="btn primary" href="https://share.google/PYUQBJCVwr6IlvqTv" target="_blank" rel="noopener noreferrer">
                View Gold Cleaning on Google
            </a>
        </div>
    </div>
</section>

<section class="section" id="faq">
    <div class="section-heading"><h2 class="h2">Common questions</h2></div>
    <div class="faq-list">
        @foreach ([['Do you serve areas outside Marietta?', 'Yes. Gold Cleaning serves Marietta and nearby communities including Smyrna, Kennesaw, Acworth, Woodstock, Roswell, Sandy Springs, East Cobb, Vinings, and more.'], ['Can I request a one-time clean?', 'Yes. You can request standard cleaning, deep cleaning, move-in/move-out cleaning, or Airbnb turnover without committing to recurring service.'], ['How do I get pricing?', 'Send the quote form with your home size, ZIP code, service type, and notes. We will follow up with an estimate based on the details you provide.'], ['Can I text instead of calling?', 'Yes. You can request your quote by WhatsApp or text message, and choose your preferred contact method in the form.']] as $item)
            <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
        @endforeach
    </div>
</section>

<section class="section" style="text-align:center">
    <h2 class="h2">Ready for a cleaner, calmer home?</h2>
    <p class="sub">Get a fast quote and availability for Marietta, GA and nearby areas.</p>
    <div class="center-actions">
        <a class="btn primary" href="{{ route('site.quote') }}">Request a Cleaning Quote</a>
        <a class="btn" data-phone-tel href="tel:+16783303174">Call Gold Cleaning</a>
    </div>
</section>
@endsection
