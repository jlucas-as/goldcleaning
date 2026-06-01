@extends('site')
@section('main')
<section class="section">
    <span class="pill">House cleaning FAQ</span>
    <h1>House Cleaning FAQ</h1>
    <p class="lead">Answers to common questions about Gold Cleaning quotes, service areas, scheduling, and residential cleaning options near Marietta, GA.</p>
</section>

<section class="section">
    <div class="faq-list">
        @foreach ([['Do you serve areas outside Marietta?', 'Yes. Gold Cleaning serves Marietta and nearby communities including Smyrna, Kennesaw, Acworth, Woodstock, Roswell, Sandy Springs, East Cobb, Vinings, and more.'], ['Can I request a one-time clean?', 'Yes. You can request standard cleaning, deep cleaning, move-in/move-out cleaning, or Airbnb turnover without committing to recurring service.'], ['How do I get pricing?', 'Send the quote form with your home size, ZIP code, service type, and notes. We will follow up with an estimate based on the details you provide.'], ['Can I text instead of calling?', 'Yes. You can request your quote by WhatsApp or text message, and choose your preferred contact method in the form.'], ['Do you bring supplies?', 'Share your preference when requesting a quote. If your home needs specific products for stone, wood, stainless steel, or sensitive surfaces, include that in the notes.'], ['Can I book recurring service after a first clean?', 'Yes. Many homes start with a deep clean and then move to weekly, bi-weekly, or monthly maintenance.']] as $item)
            <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
        @endforeach
    </div>
</section>

<section class="section" style="text-align:center">
    <h2 class="h2">Still have a question?</h2>
    <div class="center-actions"><a class="btn primary" href="{{ route('site.quote') }}">Request a Quote</a><a class="btn" href="{{ route('site.contact') }}">Contact Gold Cleaning</a></div>
</section>
@endsection
