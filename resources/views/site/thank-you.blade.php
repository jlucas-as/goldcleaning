@extends('site')
@section('main')
<section class="section" style="text-align:center">
    <span class="pill">Gold Cleaning</span>
    <h1>Thank you - we received your request</h1>
    <p class="lead" style="margin-left:auto;margin-right:auto">Our team will respond soon with next steps. If you need to send photos, access notes, or timing details, WhatsApp is usually the fastest option.</p>
    <div class="center-actions">
        <a class="btn" href="tel:+16783303174">Call Now</a>
        <a class="btn primary" data-wa-quote href="#" target="_blank" rel="noreferrer">Send More Details on WhatsApp</a>
        <a class="btn" href="{{ route('site.home') }}">Back to Home</a>
    </div>
</section>
@endsection
