const BRAND = window.GOLD_CLEANING_BRAND || {
  name: "Gold Cleaning",
  city: "Marietta, GA",
  serviceRadius: "40 miles around Marietta",
  phoneDisplay: "(678) 330-3174",
  phoneTel: "+16783303174",
  phoneDigits: "16783303174",
  whatsappDigits: "16783303174",
  email: "hello@goldcleaning.com"
};

function waLink(message) {
  return `https://wa.me/${BRAND.whatsappDigits}?text=${encodeURIComponent(message)}`;
}

function buildSmsLink(message) {
  const encoded = encodeURIComponent(message);
  const isiPhone = /iPhone|iPad|iPod/i.test(navigator.userAgent);

  if (isiPhone) {
    return `sms:${BRAND.phoneDigits}&body=${encoded}`;
  }

  return `sms:${BRAND.phoneDigits}?body=${encoded}`;
}

function setBrand() {
  document.querySelectorAll("[data-brand]").forEach((el) => {
    el.textContent = BRAND.name;
  });

  document.querySelectorAll("[data-city]").forEach((el) => {
    el.textContent = BRAND.city;
  });

  document.querySelectorAll("[data-phone-display]").forEach((el) => {
    el.textContent = BRAND.phoneDisplay;
  });

  document.querySelectorAll("[data-phone-tel]").forEach((el) => {
    el.setAttribute("href", `tel:${BRAND.phoneTel}`);
  });

  document.querySelectorAll("[data-email]").forEach((el) => {
    el.textContent = BRAND.email;
  });

  document.querySelectorAll("[data-email-link]").forEach((el) => {
    el.setAttribute("href", `mailto:${BRAND.email}`);
  });

  document.querySelectorAll("[data-wa-quote]").forEach((el) => {
    el.setAttribute(
      "href",
      waLink("Hi Gold Cleaning, I would like a cleaning quote. My ZIP code is:")
    );
  });
}

function mobileMenu() {
  const burger = document.querySelector("[data-burger]");
  const menu = document.querySelector("[data-menu]");

  if (!burger || !menu) return;

  burger.addEventListener("click", () => {
    menu.classList.toggle("mobile-open");
  });
}

function getFormMessage(form) {
  if (!form) return "";

  if (!form.reportValidity()) return "";

  const fd = new FormData(form);

  const name = (fd.get("name") || "").toString().trim();
  const phone = (fd.get("phone") || "").toString().trim();
  const email = (fd.get("email") || "").toString().trim();
  const contactMethod = (fd.get("contact_method") || "").toString().trim();
  const city = (fd.get("city") || "").toString().trim();
  const beds = (fd.get("beds") || "").toString().trim();
  const baths = (fd.get("baths") || "").toString().trim();
  const service = (fd.get("service") || "").toString().trim();
  const frequency = (fd.get("frequency") || "").toString().trim();
  const preferredTime = (fd.get("preferred_time") || "").toString().trim();
  const zip = (fd.get("zip") || "").toString().trim();
  const notes = (fd.get("notes") || "").toString().trim();

  return `Hi Gold Cleaning, I would like a cleaning quote.

Name: ${name || "-"}
Phone: ${phone || "-"}
Email: ${email || "-"}
Preferred contact: ${contactMethod || "-"}
City: ${city || "-"}
ZIP code: ${zip || "-"}
Bedrooms: ${beds || "-"}
Bathrooms: ${baths || "-"}
Service: ${service || "-"}
One-time or recurring: ${frequency || "-"}
Preferred date/time: ${preferredTime || "-"}
Notes: ${notes || "-"}

Service area: ${BRAND.city} + ${BRAND.serviceRadius}`;
}

function sendWhatsAppForm(form) {
  const msg = getFormMessage(form);
  if (!msg) return;
  window.location.href = waLink(msg);
}

function sendSMSForm(form) {
  const msg = getFormMessage(form);
  if (!msg) return;
  window.location.href = buildSmsLink(msg);
}

function bindQuoteButtons() {
  document.querySelectorAll("[data-send-whatsapp]").forEach((waBtn) => {
    waBtn.addEventListener("click", function () {
      sendWhatsAppForm(waBtn.closest("[data-quote-form]"));
    });
  });

  document.querySelectorAll("[data-send-sms]").forEach((smsBtn) => {
    smsBtn.addEventListener("click", function () {
      sendSMSForm(smsBtn.closest("[data-quote-form]"));
    });
  });
}

function trackLeadAction(action, parameters = {}) {
  if (typeof window.gtag === "function") {
    window.gtag("event", action, {
      event_category: "lead",
      event_label: "ads_landing_page",
      ...parameters
    });
  }
}

function bindLeadTracking() {
  const params = new URLSearchParams(window.location.search);
  const keys = ["gclid", "utm_source", "utm_medium", "utm_campaign", "utm_adgroup", "utm_term", "utm_content"];

  document.querySelectorAll("[data-campaign-field]").forEach((field) => {
    const key = field.getAttribute("data-campaign-field");
    field.value = params.get(key) || localStorage.getItem(`gc_${key}`) || "";
  });

  keys.forEach((key) => {
    const value = params.get(key);
    if (value) localStorage.setItem(`gc_${key}`, value);
  });

  document.querySelectorAll("[data-page-url]").forEach((field) => {
    field.value = window.location.href;
  });

  document.querySelectorAll("[data-referrer]").forEach((field) => {
    field.value = document.referrer;
  });

  document.querySelectorAll("[data-track-call]").forEach((el) => {
    el.addEventListener("click", () => trackLeadAction("phone_call_click"));
  });

  document.querySelectorAll("[data-track-sms]").forEach((el) => {
    el.addEventListener("click", () => trackLeadAction("sms_click"));
  });

  document.querySelectorAll("[data-wa-quote]").forEach((el) => {
    el.addEventListener("click", () => trackLeadAction("whatsapp_click"));
  });

}

function formatUsPhone(value) {
  let digits = value.replace(/\D/g, "").slice(0, 11);
  if (digits.length === 11 && digits.startsWith("1")) digits = digits.slice(1);

  if (digits.length < 4) return digits;
  if (digits.length < 7) return `(${digits.slice(0, 3)}) ${digits.slice(3)}`;
  return `(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6, 10)}`;
}

function bindMultiStepQuoteForm() {
  document.querySelectorAll("[data-lead-form]").forEach((form) => {
    const card = form.closest("[data-quote-card]");
    const steps = Array.from(form.querySelectorAll("[data-form-step]"));
    const title = card.querySelector("[data-form-title]");
    const subtitle = card.querySelector("[data-form-subtitle]");
    const stepLabel = card.querySelector("[data-step-label]");
    const progressBar = card.querySelector("[data-progress-bar]");
    const submitError = form.querySelector("[data-submit-error]");
    const submitButton = form.querySelector('[type="submit"]');
    const phoneInput = form.querySelector('[name="phone"]');
    const emailInput = form.querySelector('[name="email"]');
    let started = false;

    const analyticsParameters = () => ({
      cleaning_type: form.querySelector('[name="cleaning_type"]:checked')?.value || "",
      frequency: form.querySelector('[name="frequency"]:checked')?.value || "",
      zip_code: form.elements.zip_code?.value || ""
    });

    const clearError = (name) => {
      const error = form.querySelector(`[data-error-for="${name}"]`);
      if (error) error.textContent = "";
      form.querySelectorAll(`[name="${name}"]`).forEach((field) => {
        field.classList.remove("is-invalid");
        field.removeAttribute("aria-invalid");
      });
      form.querySelector(`[data-required-group="${name}"]`)?.classList.remove("is-invalid");
    };

    const showError = (name, message) => {
      const fields = Array.from(form.querySelectorAll(`[name="${name}"]`));
      const error = form.querySelector(`[data-error-for="${name}"]`);
      if (error) error.textContent = message;
      fields.forEach((field) => {
        field.classList.add("is-invalid");
        field.setAttribute("aria-invalid", "true");
      });
      form.querySelector(`[data-required-group="${name}"]`)?.classList.add("is-invalid");
    };

    const validateStep = (stepNumber) => {
      const step = form.querySelector(`[data-form-step="${stepNumber}"]`);
      const requiredNames = [...new Set(
        Array.from(step.querySelectorAll("[required]")).map((field) => field.name)
      )];
      let firstInvalid = null;

      requiredNames.forEach((name) => {
        clearError(name);
        const fields = Array.from(step.querySelectorAll(`[name="${name}"]`));
        const isRadio = fields[0]?.type === "radio";
        const isValid = isRadio
          ? fields.some((field) => field.checked)
          : fields.every((field) => field.checkValidity());

        if (!isValid) {
          const messages = {
            cleaning_type: "Choose a cleaning type.",
            bedrooms: "Choose the number of bedrooms.",
            bathrooms: "Choose the number of bathrooms.",
            frequency: "Choose a cleaning frequency.",
            zip_code: "Enter a valid 5-digit ZIP Code.",
            name: "Enter your name.",
            phone: "Enter a valid US phone number.",
            email: "Enter a valid email address.",
            preferred_contact_method: "Choose how you would like us to contact you."
          };
          showError(name, messages[name] || "Complete this field.");
          firstInvalid ||= fields[0];
        }
      });

      if (stepNumber === 2) {
        const phoneDigits = phoneInput.value.replace(/\D/g, "");
        if (phoneDigits.length !== 10) {
          showError("phone", "Enter a valid US phone number.");
          firstInvalid ||= phoneInput;
        }

        const wantsEmail = form.querySelector('[name="preferred_contact_method"]:checked')?.value === "email";
        emailInput.required = wantsEmail;
        if ((wantsEmail && emailInput.value.trim() === "") || (emailInput.value && !emailInput.checkValidity())) {
          showError("email", wantsEmail && !emailInput.value ? "Email is required when Email is your preferred contact method." : "Enter a valid email address.");
          firstInvalid ||= emailInput;
        }
      }

      if (firstInvalid) {
        firstInvalid.focus();
        return false;
      }
      return true;
    };

    const setStep = (stepNumber) => {
      steps.forEach((step) => {
        const isActive = step.dataset.formStep === String(stepNumber);
        step.hidden = !isActive;
        step.classList.toggle("is-active", isActive);
      });

      stepLabel.textContent = `Step ${stepNumber} of 2`;
      progressBar.style.width = stepNumber === 1 ? "50%" : "100%";
      title.textContent = stepNumber === 1 ? "Get Your Free Cleaning Estimate" : "Almost done!";
      subtitle.textContent = stepNumber === 1
        ? "Tell us about your home. It only takes a minute."
        : "Where should we send your estimate?";
      card.dataset.currentStep = String(stepNumber);
      title.focus({ preventScroll: true });
    };

    form.addEventListener("focusin", () => {
      if (!started) {
        started = true;
        trackLeadAction("form_quote_started");
      }
    }, { once: true });

    form.addEventListener("input", (event) => {
      if (event.target === phoneInput) phoneInput.value = formatUsPhone(phoneInput.value);
      if (event.target.name === "zip_code") event.target.value = event.target.value.replace(/[^0-9-]/g, "").slice(0, 10);
      if (event.target.name) clearError(event.target.name);
    });

    form.addEventListener("change", (event) => {
      if (event.target.name) clearError(event.target.name);
      if (event.target.name === "preferred_contact_method") {
        emailInput.required = event.target.value === "email";
        emailInput.closest(".lp-field")?.classList.toggle("is-required", emailInput.required);
      }
    });

    form.querySelector("[data-form-next]")?.addEventListener("click", () => {
      if (!validateStep(1)) return;
      trackLeadAction("form_quote_step_1_completed", analyticsParameters());
      setStep(2);
    });

    form.querySelector("[data-form-back]")?.addEventListener("click", () => setStep(1));

    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      submitError.textContent = "";
      if (!validateStep(2)) return;

      submitButton.disabled = true;
      submitButton.textContent = "Sending...";

      try {
        const response = await fetch(form.action, {
          method: "POST",
          body: new FormData(form),
          headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest"
          },
          credentials: "same-origin"
        });
        const result = await response.json().catch(() => ({}));

        if (!response.ok || !result.success) {
          Object.entries(result.errors || {}).forEach(([name, message]) => showError(name, message));
          const stepOneFields = ["cleaning_type", "bedrooms", "bathrooms", "frequency", "zip_code"];
          if (Object.keys(result.errors || {}).some((name) => stepOneFields.includes(name))) setStep(1);
          throw new Error(result.message || "We could not send your request. Please try again.");
        }

        trackLeadAction("form_quote_submitted", analyticsParameters());
        card.innerHTML = `
          <div class="lp-form-success" role="status" aria-live="polite">
            <span class="lp-success-icon" aria-hidden="true">&#10003;</span>
            <h2>Thank you!</h2>
            <p>We've received your cleaning request.</p>
            <p>Our team will contact you shortly to provide your personalized estimate.</p>
            <strong>Prefer to talk now?</strong>
            <div class="lp-success-actions">
              <a class="btn primary" href="tel:${BRAND.phoneTel}">Call Us</a>
              <a class="btn" href="${buildSmsLink("Hi Gold Cleaning, I just submitted a cleaning estimate request.")}">Text Us</a>
              <a class="btn" href="${waLink("Hi Gold Cleaning, I just submitted a cleaning estimate request.")}" target="_blank" rel="noreferrer">WhatsApp</a>
            </div>
          </div>`;
      } catch (error) {
        submitError.textContent = error.message || "We could not send your request. Please try again.";
        submitButton.disabled = false;
        submitButton.textContent = "Get My Free Estimate";
      }
    });

    setStep(1);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  try {
    setBrand();
    mobileMenu();
    bindQuoteButtons();
    bindLeadTracking();
    bindMultiStepQuoteForm();
  } catch (error) {
    console.error("Gold Cleaning JS error:", error);
  }
});
