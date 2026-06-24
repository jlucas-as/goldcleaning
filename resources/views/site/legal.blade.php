@extends('site')
@section('main')
<section class="section">
    <span class="pill">Gold Cleaning</span>
    <h1>{{ $h1 }}</h1>
    <p class="lead">Last updated: {{ $updated }}</p>
</section>

<section class="section">
    <div class="card">
        <div class="pad legal-copy">
            @if (!empty($terms))
                <h2>Service quotes and scheduling</h2>
                <p>Quotes are based on the information provided by the customer, including home size, condition, service type, ZIP code, timing, access, and add-ons. Final details may change if the property condition or requested scope differs from the original request.</p>
                <h2>Customer responsibilities</h2>
                <p>Customers should provide safe access, parking details, pet instructions, surface notes, and any priority areas before service. Please secure valuables, fragile items, and personal documents before the appointment.</p>
                <h2>Communication</h2>
                <p>By requesting a quote, you agree that Gold Cleaning may contact you by call, text, WhatsApp, or email about your request. Standard carrier rates may apply for text messaging.</p>
                <h2>Cancellations and changes</h2>
                <p>If you need to adjust timing, access, or scope, contact Gold Cleaning as early as possible so availability can be reviewed.</p>
            @else
                <h2>Information we collect</h2>
                <p>Gold Cleaning may collect contact information, city, ZIP code, home details, service preferences, and notes submitted through forms, text, WhatsApp, phone, or email.</p>
                <h2>How information is used</h2>
                <p>Information is used to respond to quote requests, confirm availability, understand service needs, and communicate about cleaning appointments.</p>
                <h2>Website analytics</h2>
                <p>This website uses Google Analytics to understand page visits and website usage. Google may process device, browser, approximate location, and interaction data according to its own privacy policies. Visitors can limit analytics tracking through browser and privacy settings.</p>
                <h2>Sharing</h2>
                <p>Gold Cleaning does not sell personal information. Information may be shared only as needed to respond to requests, support service communication, or comply with applicable legal obligations.</p>
                <h2>Contact</h2>
                <p>For privacy questions, email <a data-email-link href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a> or call <a data-phone-tel href="tel:{{ $settings['phone_tel'] }}">{{ $settings['phone_display'] }}</a>.</p>
            @endif
        </div>
    </div>
</section>
@endsection
