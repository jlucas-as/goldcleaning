@extends('site')
@section('main')
<section class="section">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">{{ $page['hero_pill'] ?? 'Contact Gold Cleaning' }}</span>
            <h1>{{ $page['hero_h1'] ?? 'Contact Gold Cleaning in Marietta, GA.' }}</h1>
            <p class="lead">{{ $page['hero_lead'] ?? 'Call, text, WhatsApp, or email Gold Cleaning for residential house cleaning quotes in Marietta, Cobb County, and nearby metro Atlanta cities.' }}</p>
            <div class="contact-shortcuts">
                <a class="contact-chip" data-phone-tel href="tel:{{ $settings['phone_tel'] }}">Call {{ $settings['phone_display'] }}</a>
                <a class="contact-chip" href="sms:{{ $settings['phone_digits'] }}">Text Us</a>
                <a class="contact-chip" data-wa-quote href="#" target="_blank" rel="noreferrer">WhatsApp Quote</a>
                <a class="contact-chip" data-email-link href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a>
            </div>
        </div>
        <div class="card quote-card"><div class="pad"><div style="font-weight:900;font-size:22px">Send cleaning details</div>@include('site.partials.quote-form', ['id' => 'contact'])</div></div>
    </div>
</section>

<section class="section">
    <div class="local-panel">
        <div><h2 class="h2">Need the fastest answer?</h2><p class="sub">Include your city, ZIP code, service type, bedrooms, bathrooms, and preferred timing in your first message.</p></div>
        <a class="btn primary" data-wa-quote href="#" target="_blank" rel="noreferrer">Message on WhatsApp</a>
    </div>
</section>
@endsection
