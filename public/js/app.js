const BRAND = {
  name: "Gold Cleaning",
  city: "Marietta, GA",
  serviceRadius: "40 miles around Marietta",
  phoneDisplay: "(470) 982-9820",
  phoneTel: "+14709829820",
  phoneDigits: "14709829820",
  whatsappDigits: "14709829820",
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

document.addEventListener("DOMContentLoaded", function () {
  try {
    setBrand();
    mobileMenu();
    bindQuoteButtons();
  } catch (error) {
    console.error("Gold Cleaning JS error:", error);
  }
});
