<form data-quote-form action="mailto:hello@goldcleaning.com" method="post" enctype="text/plain" style="margin-top:14px">
    <div class="grid form-grid">
        <div class="field">
            <label for="name-{{ $id ?? 'main' }}">Name</label>
            <input id="name-{{ $id ?? 'main' }}" name="name" placeholder="Your name" required />
        </div>
        <div class="field">
            <label for="phone-{{ $id ?? 'main' }}">Phone</label>
            <input id="phone-{{ $id ?? 'main' }}" name="phone" placeholder="(470) 982-9820" required />
        </div>
    </div>

    <div class="grid form-grid">
        <div class="field">
            <label for="email-{{ $id ?? 'main' }}">Email</label>
            <input id="email-{{ $id ?? 'main' }}" type="email" name="email" placeholder="you@example.com" />
        </div>
        <div class="field">
            <label for="contact-{{ $id ?? 'main' }}">Preferred contact method</label>
            <select id="contact-{{ $id ?? 'main' }}" name="contact_method">
                <option>Text Message</option>
                <option>Phone Call</option>
                <option>WhatsApp</option>
                <option>Email</option>
            </select>
        </div>
    </div>

    <div class="grid form-grid">
        <div class="field">
            <label for="city-{{ $id ?? 'main' }}">City</label>
            <input id="city-{{ $id ?? 'main' }}" name="city" placeholder="Marietta" value="{{ $city ?? '' }}" required />
        </div>
        <div class="field">
            <label for="zip-{{ $id ?? 'main' }}">ZIP code</label>
            <input id="zip-{{ $id ?? 'main' }}" name="zip" placeholder="e.g. 30060" required />
        </div>
    </div>

    <div class="grid form-grid">
        <div class="field">
            <label for="beds-{{ $id ?? 'main' }}">Bedrooms</label>
            <input id="beds-{{ $id ?? 'main' }}" name="beds" placeholder="e.g. 3" />
        </div>
        <div class="field">
            <label for="baths-{{ $id ?? 'main' }}">Bathrooms</label>
            <input id="baths-{{ $id ?? 'main' }}" name="baths" placeholder="e.g. 2" />
        </div>
    </div>

    <div class="grid form-grid">
        <div class="field">
            <label for="service-{{ $id ?? 'main' }}">Service type</label>
            <select id="service-{{ $id ?? 'main' }}" name="service">
                @foreach ($services as $serviceSlug => $serviceItem)
                    <option @if (($selectedService ?? '') === $serviceItem['name']) selected @endif>{{ $serviceItem['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="frequency-{{ $id ?? 'main' }}">One-time or recurring</label>
            <select id="frequency-{{ $id ?? 'main' }}" name="frequency">
                <option>One-time</option>
                <option>Weekly</option>
                <option>Bi-weekly</option>
                <option>Monthly</option>
                <option>Not sure yet</option>
            </select>
        </div>
    </div>

    <div class="field">
        <label for="time-{{ $id ?? 'main' }}">Preferred date/time</label>
        <input id="time-{{ $id ?? 'main' }}" name="preferred_time" placeholder="Preferred day, time window, or deadline" />
    </div>

    <div class="field">
        <label for="notes-{{ $id ?? 'main' }}">Notes</label>
        <textarea id="notes-{{ $id ?? 'main' }}" name="notes" placeholder="Pets, priorities, access, parking, supplies, or add-ons."></textarea>
    </div>

    <p class="fine">
        By submitting, you agree to be contacted by text, call, WhatsApp, or email about your cleaning quote.
    </p>

    <div class="grid form-grid buttons-grid">
        <button class="btn primary" type="button" data-send-whatsapp>WhatsApp Quote</button>
        <button class="btn" type="button" data-send-sms>Text Us</button>
    </div>
</form>
