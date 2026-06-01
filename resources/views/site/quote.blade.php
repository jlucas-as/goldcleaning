@extends('site')
@section('main')
<section class="section">
    <div class="grid grid-2 hero-bottom-grid">
        <div>
            <span class="pill">Fast local quote</span>
            <h1>Request a house cleaning quote in Marietta, GA.</h1>
            <p class="lead">Tell us what you need, where the home is located, and how you prefer to be contacted. If there is no backend configured, this form opens WhatsApp or SMS with your details already prepared.</p>
            <div class="hero-actions"><a class="btn" href="tel:+14709829820">Call Now</a><a class="btn" href="sms:+14709829820">Text Us</a><a class="btn primary" data-wa-quote href="#" target="_blank" rel="noreferrer">WhatsApp Quote</a></div>
        </div>
        <div class="card quote-card"><div class="pad"><div style="font-weight:900;font-size:22px">Cleaning quote details</div>@include('site.partials.quote-form', ['id' => 'quote'])</div></div>
    </div>
</section>

<section class="section">
    <div class="section-heading"><h2 class="h2">Helpful details to include</h2><p class="sub">The more practical the details, the faster we can confirm the right service and availability.</p></div>
    <div class="grid grid-3">
        <div class="step"><span>01</span><h3>Home details</h3><p>Bedrooms, bathrooms, city, ZIP code, home type, pets, and parking or access notes.</p></div>
        <div class="step"><span>02</span><h3>Service type</h3><p>Standard, recurring, deep, move-in/move-out, Airbnb turnover, apartment, or condo cleaning.</p></div>
        <div class="step"><span>03</span><h3>Priorities</h3><p>Bathrooms, kitchen buildup, baseboards, appliances, linens, pet hair, or move deadline.</p></div>
    </div>
</section>
@endsection
