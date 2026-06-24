@extends('site')
@section('main')
<section class="section">
    <span class="pill">{{ $page['hero_pill'] ?? 'House cleaning FAQ' }}</span>
    <h1>{{ $page['hero_h1'] ?? 'House Cleaning FAQ' }}</h1>
    <p class="lead">{{ $page['hero_lead'] ?? 'Answers to common questions about Gold Cleaning quotes, service areas, scheduling, and residential cleaning options near Marietta, GA.' }}</p>
</section>

<section class="section">
    <div class="faq-list">
        @foreach ($faqItems as $item)
            <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
        @endforeach
    </div>
</section>

<section class="section" style="text-align:center">
    <h2 class="h2">Still have a question?</h2>
    <div class="center-actions"><a class="btn primary" href="{{ route('site.quote') }}">Request a Quote</a><a class="btn" href="{{ route('site.contact') }}">Contact Gold Cleaning</a></div>
</section>
@endsection
