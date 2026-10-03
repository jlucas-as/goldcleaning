@php
    $formId = preg_replace('/[^a-z0-9-]+/', '-', strtolower($id ?? 'quote'));
    $serviceName = $selectedService ?? '';
    $defaultCleaningType = '';
    if (stripos($serviceName, 'standard') !== false) $defaultCleaningType = 'Standard Cleaning';
    if (stripos($serviceName, 'deep') !== false) $defaultCleaningType = 'Deep Cleaning';
    if (stripos($serviceName, 'move') !== false) $defaultCleaningType = 'Move-In / Move-Out';
    if (stripos($serviceName, 'airbnb') !== false) $defaultCleaningType = 'Airbnb Cleaning';
@endphp

<div class="lp-quote-card" id="{{ $anchorId ?? 'quote-'.$formId }}" data-quote-card>
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
        <input type="hidden" name="source" value="{{ $source ?? 'website_quote_form' }}">
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
            <label for="company-website-{{ $formId }}">Company website</label>
            <input id="company-website-{{ $formId }}" name="company_website" tabindex="-1" autocomplete="off">
        </div>

        <section class="lp-form-step is-active" data-form-step="1" aria-labelledby="cleaning-details-title-{{ $formId }}">
            <fieldset class="lp-choice-group" data-required-group="cleaning_type">
                <legend id="cleaning-details-title-{{ $formId }}">What type of cleaning do you need?</legend>
                <div class="lp-choice-grid lp-choice-grid-services">
                    @foreach (['Standard Cleaning', 'Deep Cleaning', 'Move-In / Move-Out', 'Airbnb Cleaning'] as $option)
                        <label class="lp-choice-card">
                            <input type="radio" name="cleaning_type" value="{{ $option }}" @if ($defaultCleaningType === $option) checked @endif required>
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
                <label for="quote-zip-{{ $formId }}">ZIP Code</label>
                <input id="quote-zip-{{ $formId }}" name="zip_code" type="text" inputmode="numeric" autocomplete="postal-code" placeholder="e.g. 30060" minlength="5" maxlength="10" pattern="[0-9]{5}(-[0-9]{4})?" required>
                <p class="lp-field-error" data-error-for="zip_code" role="alert"></p>
            </div>

            <button class="btn primary lp-form-primary" type="button" data-form-next>Continue <span aria-hidden="true">&rarr;</span></button>
        </section>

        <section class="lp-form-step" data-form-step="2" aria-labelledby="contact-details-title-{{ $formId }}" hidden>
            <span id="contact-details-title-{{ $formId }}" class="sr-only">Contact details</span>
            <div class="lp-field">
                <label for="quote-name-{{ $formId }}">Name</label>
                <input id="quote-name-{{ $formId }}" name="name" type="text" autocomplete="name" placeholder="Your name" maxlength="100" required>
                <p class="lp-field-error" data-error-for="name" role="alert"></p>
            </div>

            <div class="lp-field">
                <label for="quote-phone-{{ $formId }}">Phone</label>
                <input id="quote-phone-{{ $formId }}" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Phone number" maxlength="16" required>
                <p class="lp-field-error" data-error-for="phone" role="alert"></p>
            </div>

            <div class="lp-field">
                <label for="quote-email-{{ $formId }}">Email <span>(optional)</span></label>
                <input id="quote-email-{{ $formId }}" name="email" type="email" inputmode="email" autocomplete="email" placeholder="Email address" maxlength="150">
                <p class="lp-field-error" data-error-for="email" role="alert"></p>
            </div>

            <fieldset class="lp-choice-group" data-required-group="preferred_contact_method">
                <legend>Preferred contact method</legend>
                <div class="lp-choice-grid lp-contact-grid">
                    @foreach (['text_message' => 'Text Message', 'phone_call' => 'Phone Call', 'whatsapp' => 'WhatsApp', 'email' => 'Email'] as $value => $label)
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
