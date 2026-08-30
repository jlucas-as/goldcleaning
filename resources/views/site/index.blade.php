@extends('site')
@section('main')
<section class="lp-hero" id="quote">
    <div class="lp-shell lp-hero-grid">
        <div class="lp-hero-copy">
            <span class="lp-eyebrow">Residential Cleaning in Marietta, GA</span>
            <h1>Come Home to a Cleaner, More Comfortable Space</h1>
            <p>
                Professional house cleaning for busy homeowners, renters and families in Marietta and nearby Metro Atlanta communities.
            </p>
            <p>
                Choose a one-time cleaning or set up weekly, bi-weekly or monthly service around your schedule.
            </p>
            <ul class="lp-checks">
                <li>Standard, deep and recurring cleaning</li>
                <li>Houses, apartments and condos</li>
                <li>Move-in and move-out cleaning</li>
                <li>Fast quote by text or phone</li>
            </ul>
            <div class="lp-actions">
                <a class="btn primary" href="#quote">Get My Free Quote</a>
                <a class="btn" data-track-call data-phone-tel href="tel:{{ $settings['phone_tel'] }}">Call Now</a>
            </div>
        </div>

        <!-- <div class="lp-hero-photo" aria-hidden="true">
            <img src="{{ url('public/img/hero-team.png') }}" alt="">
        </div> -->

        <div class="lp-quote-card">
            <h2>Get a Fast Cleaning Quote</h2>
            <p>Tell us a little about your home. Our team will contact you to confirm availability and pricing.</p>
            <form class="lp-short-form" data-lead-form action="{{ route('site.quote-submit') }}" method="post">
                <input type="hidden" name="source" value="ads_landing_page">
                <input type="hidden" name="gclid" data-campaign-field="gclid">
                <input type="hidden" name="utm_source" data-campaign-field="utm_source">
                <input type="hidden" name="utm_medium" data-campaign-field="utm_medium">
                <input type="hidden" name="utm_campaign" data-campaign-field="utm_campaign">
                <input type="hidden" name="utm_adgroup" data-campaign-field="utm_adgroup">
                <input type="hidden" name="utm_term" data-campaign-field="utm_term">
                <input type="hidden" name="page_url" data-page-url>
                <div class="lp-honeypot">
                    <label>Company website</label>
                    <input name="company_website" tabindex="-1" autocomplete="off">
                </div>
                <label>Name <input name="name" placeholder="Your full name" required></label>
                <label>Phone Number <input name="phone" placeholder="(678) 555-1234" required></label>
                <label>ZIP Code <input name="zip" placeholder="30060" required></label>
                <label>Cleaning Service
                    <select name="service" required>
                        <option value="">Select a service</option>
                        <option>Standard Cleaning</option>
                        <option>Deep Cleaning</option>
                        <option>Recurring Cleaning</option>
                        <option>Move-In / Move-Out</option>
                        <option>Apartment or Condo Cleaning</option>
                        <option>Not Sure</option>
                    </select>
                </label>
                <button class="btn primary" type="submit" data-track-submit>Check Availability</button>
                <p class="fine">By submitting this form, you agree to receive calls or text messages regarding your cleaning request.</p>
            </form>
        </div>
    </div>
</section>

<section class="lp-trust">
    <div class="lp-shell lp-trust-grid">
        <div><span>Local</span>Local Cleaning Team</div>
        <div><span>Flex</span>Flexible Scheduling</div>
        <div><span>Once</span>One-Time or Recurring Service</div>
        <div><span>Fast</span>Fast and Clear Quotes</div>
    </div>
</section>

<section class="lp-section" id="services">
    <div class="lp-shell">
        <div class="lp-section-head">
            <h2>Cleaning Services That Fit Your Home and Schedule</h2>
            <p>Whether your home needs dependable routine care or a detailed reset, Gold Cleaning makes it easier to keep your space clean and comfortable.</p>
        </div>
        <div class="lp-service-grid">
            @foreach ([
                ['Standard Cleaning', 'A practical cleaning service for maintaining kitchens, bathrooms, bedrooms and living spaces.', 'Request Standard Cleaning'],
                ['Deep Cleaning', 'A more detailed cleaning for homes with buildup, neglected areas or spaces that have not been professionally cleaned recently.', 'Request Deep Cleaning'],
                ['Recurring Cleaning', 'Keep your home consistently clean with weekly, bi-weekly or monthly visits.', 'Check Recurring Availability'],
                ['Move-In / Move-Out', 'Prepare an empty home for a new beginning with attention to kitchens, bathrooms, floors and accessible cabinets.', 'Request Move Cleaning'],
            ] as $service)
                <article class="lp-service-card">
                    <div class="lp-card-icon">{{ substr($service[0], 0, 1) }}</div>
                    <h3>{{ $service[0] }}</h3>
                    <p>{{ $service[1] }}</p>
                    <a href="#quote">{{ $service[2] }}</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="lp-included">
    <div class="lp-shell">
        <div class="lp-section-head">
            <h2>What Can Be Included in Your Cleaning?</h2>
            <p>Each quote is customized according to the size, condition and priorities of your home.</p>
        </div>
        <div class="lp-included-grid">
            @foreach ([
                ['Kitchen', ['Countertops and sinks', 'Exterior of appliances', 'Cabinet exterior', 'Stovetop surfaces', 'Trash removal', 'Vacuuming and mopping']],
                ['Bathrooms', ['Toilets', 'Sinks and fixtures', 'Mirrors', 'Tubs and showers', 'Bathroom surfaces', 'Floors']],
                ['Bedrooms & Living Areas', ['Dusting reachable surfaces', 'Furniture surface cleaning', 'Trash removal', 'Vacuuming', 'Mopping accessible floors', 'General room reset']],
                ['Available Add-Ons', ['Inside oven', 'Inside refrigerator', 'Interior windows', 'Cabinet interiors', 'Laundry or linen changes', 'Additional pet hair cleaning']],
            ] as $group)
                <div class="lp-included-card">
                    <h3>{{ $group[0] }}</h3>
                    <ul>
                        @foreach ($group[1] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if (($beforeAfter['section']['enabled'] ?? '1') === '1' && !empty($beforeAfter['items']))
    <section class="lp-section">
        <div class="lp-shell">
            <div class="lp-section-head">
                <span class="lp-eyebrow">{{ $beforeAfter['section']['eyebrow'] ?? 'Before and after' }}</span>
                <h2>{{ $beforeAfter['section']['title'] ?? 'See the Difference' }}</h2>
                @if (!empty($beforeAfter['section']['text']))
                    <p>{{ $beforeAfter['section']['text'] }}</p>
                @endif
            </div>
            <div class="lp-before-grid real-results">
                @foreach ($beforeAfter['items'] as $item)
                    @continue(($item['enabled'] ?? '1') !== '1')
                    <article class="lp-result-card">
                        <div class="lp-result-media">
                            @if (!empty($item['before_image']))
                                <figure>
                                    <img src="{{ url($item['before_image']) }}" alt="Before {{ $item['title'] ?? 'cleaning service' }}">
                                    <span>Before</span>
                                </figure>
                            @endif
                            @if (!empty($item['after_image']))
                                <figure>
                                    <img src="{{ url($item['after_image']) }}" alt="After {{ $item['title'] ?? 'cleaning service' }}">
                                    <span>After</span>
                                </figure>
                            @endif
                        </div>
                        <div class="lp-result-copy">
                            @if (!empty($item['title']))
                                <h3>{{ $item['title'] }}</h3>
                            @endif
                            @if (!empty($item['description']))
                                <p>{{ $item['description'] }}</p>
                            @endif
                        </div>
                        @if (!empty($item['video']))
                            <video class="lp-result-video" src="{{ url($item['video']) }}" controls preload="metadata"></video>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="lp-section">
    <div class="lp-shell">
        <div class="lp-section-head">
            <h2>A Simple Way to Book Your Cleaning</h2>
        </div>
        <div class="lp-steps">
            <div><span>1</span><h3>Request Your Quote</h3><p>Send your ZIP Code, preferred service and contact information.</p></div>
            <div><span>2</span><h3>Confirm the Details</h3><p>We will contact you to discuss your home, priorities, scheduling and add-ons.</p></div>
            <div><span>3</span><h3>Enjoy a Cleaner Home</h3><p>Our team completes the agreed cleaning so you can worry less about the mess.</p></div>
        </div>
        <div class="lp-center"><a class="btn primary" href="#quote">Get My Cleaning Quote</a></div>
    </div>
</section>

<section class="lp-area-choice">
    <div class="lp-shell lp-area-grid">
        <div>
            <h2>Cleaning Services Near Marietta, GA</h2>
            <p>Gold Cleaning is based in Marietta and serves nearby communities throughout Cobb County and the north Metro Atlanta area.</p>
            <div class="lp-area-chips">
                @foreach (['Marietta', 'Smyrna', 'Kennesaw', 'Acworth', 'Powder Springs', 'East Cobb', 'Austell', 'Mableton', 'Vinings', 'Woodstock', 'Roswell', 'Sandy Springs', 'Alpharetta'] as $city)
                    <span>{{ $city }}</span>
                @endforeach
            </div>
            <p class="lp-small">Not sure whether your address is covered? Send your ZIP Code and we will confirm availability.</p>
            <a class="btn" href="#quote">Check My ZIP Code</a>
        </div>
        <div class="lp-room-card">
            <img src="{{ url('public/img/hero-team.png') }}" alt="Clean home interior">
        </div>
        <div>
            <h2>Why Homeowners Choose Gold Cleaning</h2>
            <p>Your home is personal. Our goal is to make the cleaning process clear, convenient and easier to fit into your routine.</p>
            <ul class="lp-checks compact">
                <li>Cleaning options based on your priorities</li>
                <li>One-time and recurring appointments</li>
                <li>Service for houses, apartments and condos</li>
                <li>Direct communication by phone or text</li>
                <li>Quotes based on your actual home and service needs</li>
            </ul>
        </div>
    </div>
</section>

<section class="lp-section" id="faq">
    <div class="lp-shell">
        <div class="lp-section-head"><h2>Frequently Asked Questions</h2></div>
        <div class="lp-faq-grid">
            @foreach ([
                ['How much does house cleaning cost?', 'Pricing depends on the size and condition of the home, the number of bedrooms and bathrooms, the type of service, the ZIP Code and any requested add-ons. Request a quote so we can provide an estimate based on your home.'],
                ['Do you offer one-time cleaning?', 'Yes. You can request standard cleaning, deep cleaning or move-in and move-out cleaning without committing to recurring service.'],
                ['Can I schedule recurring cleaning?', 'Yes. Recurring cleaning may be scheduled weekly, bi-weekly or monthly, depending on availability.'],
                ['Do you bring cleaning supplies?', 'Tell us your preference when requesting your quote. Please mention any special products required for stone, wood, stainless steel or sensitive surfaces.'],
                ['Do I need to be home?', 'Access arrangements can be discussed before the appointment. Include any gate, parking, pet or entry instructions when confirming the service.'],
                ['Do you clean homes with pets?', 'Tell us about your pets and any extra pet hair or access considerations when requesting the quote.'],
                ['What areas do you serve?', 'Gold Cleaning serves Marietta and nearby communities across Cobb County and the north Metro Atlanta area. Send your ZIP Code to confirm availability.'],
                ['How soon will I receive a response?', 'Send your request by form, phone or text. Our team will contact you to discuss availability and the information needed for your estimate.'],
            ] as $item)
                <details><summary>{{ $item[0] }}</summary><p>{{ $item[1] }}</p></details>
            @endforeach
        </div>
    </div>
</section>

<section class="lp-final">
    <div class="lp-shell lp-final-grid">
        <div>
            <h2>Ready for a Cleaner Home?</h2>
            <p>Request your cleaning quote and check availability in your area.</p>
        </div>
        <div class="lp-final-actions">
            <a class="btn primary" href="#quote">Get My Free Quote</a>
            <a class="btn" data-track-call data-phone-tel href="tel:{{ $settings['phone_tel'] }}">Call {{ $settings['phone_display'] }}</a>
        </div>
    </div>
</section>
@endsection
