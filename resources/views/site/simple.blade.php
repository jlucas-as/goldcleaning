@extends('site')
@section('main')
<section class="section">
    <span class="pill">Gold Cleaning</span>
    <h1>{{ $h1 }}</h1>
    <p class="lead">{{ $intro }}</p>
    <div class="hero-actions"><a class="btn primary" href="{{ route('site.quote') }}">Get a Fast Quote</a><a class="btn" href="{{ route('site.contact') }}">Contact Us</a></div>
</section>

<section class="section">
    <div class="grid grid-2">
        @foreach ($sections as $index => $section)
            <div class="step"><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $section[0] }}</h2><p>{{ $section[1] }}</p></div>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="local-panel"><div><h2 class="h2">Ready to start?</h2><p class="sub">A few practical details are enough to begin the quote conversation.</p></div><a class="btn primary" href="{{ route('site.quote') }}">Request a Quote</a></div>
</section>
@endsection
