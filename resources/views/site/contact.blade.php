@extends('site')
@section('main')
<section class="section">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">Contact Gold Cleaning</span>
            <h1>Contact Gold Cleaning in Marietta, GA.</h1>
            <p class="lead">Call, text, WhatsApp, or email Gold Cleaning for residential house cleaning quotes in Marietta, Cobb County, and nearby metro Atlanta cities.</p>
            <div class="contact-shortcuts">
                <a class="contact-chip" href="tel:+16783303174">Call (678) 330-3174</a>
                <a class="contact-chip" href="sms:+16783303174">Text Us</a>
                <a class="contact-chip" data-wa-quote href="#" target="_blank" rel="noreferrer">WhatsApp Quote</a>
                <a class="contact-chip" href="mailto:hello@goldcleaning.com">hello@goldcleaning.com</a>
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
