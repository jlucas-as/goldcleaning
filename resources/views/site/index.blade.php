@extends('site')
@section('main')
<section class="lp-hero">
    <div class="lp-shell lp-hero-grid">
        <div class="lp-hero-copy">
            <span class="lp-eyebrow">PROFESSIONAL HOUSE CLEANING IN MARIETTA, GA</span>
            <h1>A Spotless Home. More Time for What Matters.</h1>
            <p>Professional house cleaning for busy homeowners, renters and families in Marietta and nearby Metro Atlanta communities.</p>
            <p>Enjoy a beautifully clean home without the stress. Gold Cleaning provides professional house cleaning in Marietta and surrounding communities, with flexible one-time and recurring services.</p>
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

        <div class="lp-quote-card" id="quote" data-quote-card>
            <div class="lp-form-heading">
                <div class="lp-form-progress" aria-label="Form progress">
                    <span data-step-label>Step 1 of 2</span>
                    <span class="lp-progress-track" aria-hidden="true"><span data-progress-bar></span></span>
                </div>
                <h2 data-form-title tabindex="-1">Get Your Free Cleaning Estimate</h2>
                <p data-form-subtitle>Tell us about your home. It only takes a minute.</p>
            </div>

            <form class="lp-short-form lp-estimate-form" data-lead-form action="{{ route('site.quote-submit') }}" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="{{ $quoteCsrfToken }}">
                <input type="hidden" name="source" value="ads_landing_page">
                <input type="hidden" name="gclid" data-campaign-field="gclid">
                <input type="hidden" name="utm_source" data-campaign-field="utm_source">
                <input type="hidden" name="utm_medium" data-campaign-field="utm_medium">
                <input type="hidden" name="utm_campaign" data-campaign-field="utm_campaign">
                <input type="hidden" name="utm_adgroup" data-campaign-field="utm_adgroup">
                <input type="hidden" name="utm_term" data-campaign-field="utm_term">
                <input type="hidden" name="utm_content" data-campaign-field="utm_content">
                <input type="hidden" name="page_url" data-page-url>
                <input type="hidden" name="referrer" data-referrer>

                <div class="lp-honeypot" aria-hidden="true">
                    <label for="company-website">Company website</label>
                    <input id="company-website" name="company_website" tabindex="-1" autocomplete="off">
                </div>

                <section class="lp-form-step is-active" data-form-step="1" aria-labelledby="cleaning-details-title">
                    <fieldset class="lp-choice-group" data-required-group="cleaning_type">
                        <legend id="cleaning-details-title">What type of cleaning do you need?</legend>
                        <div class="lp-choice-grid lp-choice-grid-services">
                            @foreach (['Standard Cleaning', 'Deep Cleaning', 'Move-In / Move-Out', 'Airbnb Cleaning'] as $option)
                                <label class="lp-choice-card">
                                    <input type="radio" name="cleaning_type" value="{{ $option }}" required>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="lp-field-error" data-error-for="cleaning_type" role="alert"></p>
                    </fieldset>

                    <div class="lp-form-row">
                        <fieldset class="lp-choice-group" data-required-group="bedrooms">
                            <legend>Bedrooms</legend>
                            <div class="lp-choice-grid lp-choice-grid-compact">
                                @foreach (['Studio', '1', '2', '3', '4', '5+'] as $option)
                                    <label class="lp-choice-card">
                                        <input type="radio" name="bedrooms" value="{{ $option }}" required>
                                        <span>{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="lp-field-error" data-error-for="bedrooms" role="alert"></p>
                        </fieldset>

                        <fieldset class="lp-choice-group" data-required-group="bathrooms">
                            <legend>Bathrooms</legend>
                            <div class="lp-choice-grid lp-choice-grid-compact">
                                @foreach (['1', '2', '3', '4', '5+'] as $option)
                                    <label class="lp-choice-card">
                                        <input type="radio" name="bathrooms" value="{{ $option }}" required>
                                        <span>{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="lp-field-error" data-error-for="bathrooms" role="alert"></p>
                        </fieldset>
                    </div>

                    <fieldset class="lp-choice-group" data-required-group="frequency">
                        <legend>How often do you need cleaning?</legend>
                        <div class="lp-choice-grid">
                            @foreach (['One Time', 'Weekly', 'Bi-Weekly', 'Monthly'] as $option)
                                <label class="lp-choice-card">
                                    <input type="radio" name="frequency" value="{{ $option }}" required>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="lp-field-error" data-error-for="frequency" role="alert"></p>
                    </fieldset>

                    <div class="lp-field">
                        <label for="quote-zip">ZIP Code</label>
                        <input id="quote-zip" name="zip_code" type="text" inputmode="numeric" autocomplete="postal-code" placeholder="e.g. 30060" minlength="5" maxlength="10" pattern="[0-9]{5}(-[0-9]{4})?" required>
                        <p class="lp-field-error" data-error-for="zip_code" role="alert"></p>
                    </div>

                    <button class="btn primary lp-form-primary" type="button" data-form-next>Continue <span aria-hidden="true">&rarr;</span></button>
                </section>

                <section class="lp-form-step" data-form-step="2" aria-labelledby="contact-details-title" hidden>
                    <span id="contact-details-title" class="sr-only">Contact details</span>
                    <div class="lp-field">
                        <label for="quote-name">Name</label>
                        <input id="quote-name" name="name" type="text" autocomplete="name" placeholder="Your name" maxlength="100" required>
                        <p class="lp-field-error" data-error-for="name" role="alert"></p>
                    </div>

                    <div class="lp-field">
                        <label for="quote-phone">Phone</label>
                        <input id="quote-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Phone number" maxlength="16" required>
                        <p class="lp-field-error" data-error-for="phone" role="alert"></p>
                    </div>

                    <div class="lp-field">
                        <label for="quote-email">Email <span>(optional)</span></label>
                        <input id="quote-email" name="email" type="email" inputmode="email" autocomplete="email" placeholder="Email address" maxlength="150">
                        <p class="lp-field-error" data-error-for="email" role="alert"></p>
                    </div>

                    <fieldset class="lp-choice-group" data-required-group="preferred_contact_method">
                        <legend>Preferred contact method</legend>
                        <div class="lp-choice-grid lp-contact-grid">
                            @foreach ([
                                'text_message' => 'Text Message',
                                'phone_call' => 'Phone Call',
                                'whatsapp' => 'WhatsApp',
                                'email' => 'Email',
                            ] as $value => $label)
                                <label class="lp-choice-card">
                                    <input type="radio" name="preferred_contact_method" value="{{ $value }}" required>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="lp-field-error" data-error-for="preferred_contact_method" role="alert"></p>
                    </fieldset>

                    <div class="lp-submit-error" data-submit-error role="alert" aria-live="polite"></div>
                    <div class="lp-form-actions">
                        <button class="btn lp-form-back" type="button" data-form-back><span aria-hidden="true">&larr;</span> Back</button>
                        <button class="btn primary lp-form-primary" type="submit" data-track-submit>Get My Free Estimate</button>
                    </div>
                    <p class="fine">By submitting, you agree to receive calls or messages about your cleaning request. Message and data rates may apply.</p>
                </section>
            </form>
        </div>
    </div>
</section>

<section class="lp-trust">
    <div class="lp-shell lp-trust-grid">
        @foreach ([
            ['map-pin', 'Local Cleaning Team', 'Your neighbors, not a franchise.'],
            ['calendar-days', 'Flexible Scheduling', 'Pick the time that works for you.'],
            ['refresh-cw', 'One-Time or Recurring Cleaning', 'Care that fits your routine.'],
            ['zap', 'Fast and Clear Quotes', 'No surprises, no hidden fees.'],
        ] as $benefit)
            <div class="lp-trust-item">
                <svg class="lp-line-icon" aria-hidden="true"><use href="{{ url('public/img/lp-icons.svg') }}#{{ $benefit[0] }}"></use></svg>
                <div>
                    <strong>{{ $benefit[1] }}</strong>
                    <span>{{ $benefit[2] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="lp-section lp-services-showcase" id="services">
    <div class="lp-shell">
        <div class="lp-section-head lp-showcase-head">
            <h2>Cleaning Services That Fit Your Home and Schedule</h2>
            <p>Whether your home needs dependable routine care or a detailed reset, Gold Cleaning makes it easier to keep your space clean and comfortable.</p>
        </div>
        <div class="lp-service-grid">
            @foreach ([
                ['house', 'Standard Cleaning', 'A practical cleaning service for maintaining kitchens, bathrooms, bedrooms and living spaces.', 'Request Standard Cleaning', false],
                ['sparkles', 'Deep Cleaning', 'A more detailed cleaning for homes with buildup, neglected areas or spaces that have not been professionally cleaned recently.', 'Request Deep Cleaning', false],
                ['calendar-days', 'Recurring Cleaning', 'Keep your home consistently clean with weekly, bi-weekly or monthly visits.', 'Check Recurring Availability', true],
                ['truck', 'Move-In / Move-Out', 'Prepare an empty home for a new beginning with attention to kitchens, bathrooms, floors and accessible cabinets.', 'Request Move Cleaning', false],
            ] as $service)
                <article class="lp-service-card{{ $service[4] ? ' is-featured' : '' }}">
                    @if ($service[4])
                        <span class="lp-popular-badge">Most Popular</span>
                    @endif
                    <div class="lp-card-icon">
                        <svg class="lp-line-icon" aria-hidden="true"><use href="{{ url('public/img/lp-icons.svg') }}#{{ $service[0] }}"></use></svg>
                    </div>
                    <h3>{{ $service[1] }}</h3>
                    <p>{{ $service[2] }}</p>
                    <a class="btn{{ $service[4] ? ' primary' : '' }}" href="#quote">{{ $service[3] }} <span aria-hidden="true">&rarr;</span></a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="lp-included">
    <div class="lp-shell">
        <div class="lp-section-head lp-included-head">
            <h2>What Can Be Included in Your Cleaning?</h2>
            <p>Each quote is customized according to the size, condition and priorities of your home.</p>
        </div>
        <div class="lp-included-grid">
            @foreach ([
                ['cooking-pot', 'Kitchen', ['Countertops and sinks', 'Exterior of appliances', 'Cabinet exterior', 'Stovetop surfaces', 'Trash removal', 'Floors and mopping']],
                ['bath', 'Bathrooms', ['Toilets', 'Sinks and fixtures', 'Mirrors', 'Tubs and showers', 'Bathroom surfaces', 'Floors and mopping']],
                ['sofa', 'Bedrooms & Living Areas', ['Dusting reachable surfaces', 'Furniture surface cleaning', 'Trash removal', 'Vacuuming', 'Mopping accessible floors', 'Baseboards']],
                ['settings', 'Available Add-Ons', ['Inside oven', 'Inside refrigerator', 'Interior windows', 'Cabinet interiors', 'Laundry or linen changes', 'Additional room cleaning']],
            ] as $group)
                <div class="lp-included-card">
                    <div class="lp-included-title">
                        <span class="lp-included-icon">
                            <svg class="lp-line-icon" aria-hidden="true"><use href="{{ url('public/img/lp-icons.svg') }}#{{ $group[0] }}"></use></svg>
                        </span>
                        <h3>{{ $group[1] }}</h3>
                    </div>
                    <ul>
                        @foreach ($group[2] as $item)
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
