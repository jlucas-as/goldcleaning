<?php

namespace App\Http\Controllers;

use App\Support\SiteContentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SiteController extends Controller
{
    private string $baseUrl = 'https://goldcleaning.net/v2';
    private SiteContentRepository $content;

    private array $services = [
        'standard-cleaning' => [
            'name' => 'Standard Cleaning',
            'title' => 'Standard Cleaning Services in Marietta, GA | Gold Cleaning',
            'description' => 'Keep your Marietta home consistently clean with Gold Cleaning standard cleaning for kitchens, bathrooms, dusting, floors, and routine upkeep. Request a quote.',
            'intro' => 'Standard cleaning is a practical choice for homes that need dependable upkeep without a full reset. Gold Cleaning focuses on the everyday areas that shape how your home feels: kitchens, bathrooms, living spaces, bedrooms, dusting, trash, and accessible floors.',
            'for' => ['Busy homeowners who want regular upkeep', 'Renters preparing for guests or inspections', 'Apartments and condos with high-traffic areas', 'Families who want help between deeper cleans'],
            'included' => ['Kitchen counters, sinks, and exterior appliances', 'Bathroom sinks, mirrors, toilets, tubs, and showers', 'Dusting reachable surfaces and furniture', 'Vacuuming and mopping accessible floors', 'Trash removal and room reset'],
            'quote' => ['Number of bedrooms and bathrooms', 'Current condition of the home', 'Pets, clutter, and special surfaces', 'Frequency of service and timing'],
            'addons' => ['Inside oven', 'Inside refrigerator', 'Interior windows', 'Laundry or linen change'],
        ],
        'recurring-cleaning' => [
            'name' => 'Recurring Cleaning',
            'title' => 'Recurring House Cleaning in Marietta, GA | Gold Cleaning',
            'description' => 'Weekly, bi-weekly, and monthly house cleaning in Marietta, GA. Gold Cleaning helps keep your home on a reliable schedule. Request recurring service.',
            'intro' => 'Recurring cleaning is for homes that work better with a steady rhythm. Weekly, bi-weekly, or monthly service helps prevent buildup and keeps kitchens, bathrooms, floors, and living areas easier to maintain.',
            'for' => ['Homeowners with packed weekly schedules', 'Families with kids, pets, or frequent guests', 'Professionals who want predictable upkeep', 'Clients who want consistency after a deep clean'],
            'included' => ['Routine kitchen and bathroom cleaning', 'Dusting, floors, trash, and touchpoints', 'Priority room rotation when requested', 'Notes for recurring preferences and access', 'Flexible scheduling by home needs'],
            'quote' => ['Visit frequency', 'Home size and layout', 'First visit condition', 'Add-ons requested during recurring visits'],
            'addons' => ['Pet hair focus', 'Inside appliances on rotation', 'Linen changes', 'Priority room detail'],
        ],
        'deep-cleaning' => [
            'name' => 'Deep Cleaning',
            'title' => 'Deep Cleaning Services in Marietta, GA | Gold Cleaning',
            'description' => 'Need a detailed deep clean in Marietta, GA? Gold Cleaning helps with buildup, bathrooms, kitchens, baseboards, move-ins, and one-time home resets. Request a quote.',
            'intro' => 'Deep cleaning is a more detailed reset for homes with buildup, first-time visits, post-busy-season mess, or areas that standard upkeep has not fully addressed. It is often the best starting point before recurring service.',
            'for' => ['First-time Gold Cleaning clients', 'Homes that have not been cleaned professionally in a while', 'Move-in preparation before unpacking', 'Bathrooms, kitchens, and baseboards needing extra attention'],
            'included' => ['Detailed kitchen and bathroom attention', 'Baseboards and reachable detail dusting', 'Cabinet fronts and high-touch surfaces', 'Corners, edges, and buildup-prone areas', 'Accessible floor vacuuming and mopping'],
            'quote' => ['Buildup level', 'Square footage and number of rooms', 'Pets and heavy-use areas', 'Requested add-ons such as appliances'],
            'addons' => ['Inside oven', 'Inside refrigerator', 'Cabinet interiors', 'Interior windows'],
        ],
        'move-in-move-out-cleaning' => [
            'name' => 'Move-In / Move-Out Cleaning',
            'title' => 'Move-In and Move-Out Cleaning in Marietta, GA | Gold Cleaning',
            'description' => 'Moving in or out near Marietta, GA? Gold Cleaning handles empty-home cleaning for renters, homeowners, landlords, and real estate turnovers.',
            'intro' => 'Move-in and move-out cleaning helps an empty home feel ready for the next chapter. Gold Cleaning focuses on kitchens, bathrooms, floors, cabinets, and the details that are easier to reach before furniture arrives.',
            'for' => ['Renters preparing for a final walkthrough', 'Homeowners listing or closing on a property', 'Landlords between tenants', 'Families moving into a home that needs a reset'],
            'included' => ['Kitchen and bathroom cleaning', 'Accessible cabinet and drawer wipe-downs when requested', 'Baseboards and floor attention', 'Closets and empty room surfaces', 'Trash and move-related dust cleanup'],
            'quote' => ['Whether the home is empty or furnished', 'Move deadline and access window', 'Appliance and cabinet interior needs', 'Condition after movers or prior occupants'],
            'addons' => ['Inside appliances', 'Cabinet interiors', 'Garage sweep', 'Post-renovation dust notes'],
        ],
        'airbnb-turnover-cleaning' => [
            'name' => 'Airbnb Turnover Cleaning',
            'title' => 'Airbnb Turnover Cleaning in Marietta, GA | Gold Cleaning',
            'description' => 'Gold Cleaning supports Airbnb and short-term rental turnover cleaning in Marietta and metro Atlanta with guest-ready kitchens, baths, linens, and resets.',
            'intro' => 'Short-term rental turnover cleaning needs speed, consistency, and attention to guest-facing details. Gold Cleaning helps hosts prepare homes between stays with clean bathrooms, kitchens, floors, linens, and visible touchpoints.',
            'for' => ['Airbnb and Vrbo hosts', 'Short-term rental managers', 'Guest suites and basement apartments', 'Hosts who need same-day turnover support when available'],
            'included' => ['Guest-ready bathrooms and kitchen surfaces', 'Bed and linen changes when provided', 'Trash removal and room reset', 'Floor vacuuming and mopping', 'Restock notes when requested'],
            'quote' => ['Check-out and check-in window', 'Laundry or linen expectations', 'Property size and guest capacity', 'Restocking and photo note needs'],
            'addons' => ['Laundry coordination', 'Supply restock notes', 'Extra bath detail', 'Guest damage or maintenance notes'],
        ],
        'apartment-condo-cleaning' => [
            'name' => 'Apartment & Condo Cleaning',
            'title' => 'Apartment and Condo Cleaning in Marietta, GA | Gold Cleaning',
            'description' => 'Gold Cleaning offers apartment and condo cleaning in Marietta, GA for renters, owners, roommates, pet homes, and move-in or move-out needs.',
            'intro' => 'Apartments and condos need cleaning that works around access, parking, elevators, pets, roommates, and compact layouts. Gold Cleaning keeps the process simple and focused on the areas you use most.',
            'for' => ['Apartment renters', 'Condo owners', 'Roommates sharing common areas', 'Move-in, move-out, and one-time cleaning clients'],
            'included' => ['Kitchen, bathroom, and living area cleaning', 'Bedroom surfaces and accessible floors', 'Trash and high-touch areas', 'Compact-space detail where buildup collects', 'Move-related cleaning when requested'],
            'quote' => ['Building access and parking', 'Bedrooms and bathrooms', 'Pets and roommate schedules', 'Move-in or routine service type'],
            'addons' => ['Inside refrigerator', 'Laundry or linens', 'Interior windows', 'Extra pet hair attention'],
        ],
    ];

    private array $areas = [
        'marietta-ga' => ['city' => 'Marietta', 'nearby' => ['Smyrna', 'Kennesaw', 'East Cobb', 'Powder Springs'], 'note' => 'Our core service area includes homes near Marietta Square, East Cobb, apartments, townhomes, and family neighborhoods across Cobb County.'],
        'smyrna-ga' => ['city' => 'Smyrna', 'nearby' => ['Marietta', 'Vinings', 'Mableton', 'Austell'], 'note' => 'Smyrna clients often need recurring maintenance, apartment cleaning, and move-out support near busy commute corridors and townhome communities.'],
        'kennesaw-ga' => ['city' => 'Kennesaw', 'nearby' => ['Marietta', 'Acworth', 'Woodstock', 'Dallas'], 'note' => 'In Kennesaw, we help families, students, renters, and homeowners keep high-traffic kitchens, baths, and living areas under control.'],
        'acworth-ga' => ['city' => 'Acworth', 'nearby' => ['Kennesaw', 'Woodstock', 'Dallas', 'Cartersville'], 'note' => 'Acworth requests commonly include family homes, move-in preparation, and recurring cleaning for larger layouts.'],
        'powder-springs-ga' => ['city' => 'Powder Springs', 'nearby' => ['Marietta', 'Austell', 'Mableton', 'Dallas'], 'note' => 'Powder Springs homes often benefit from deep cleaning, recurring upkeep, and move-related resets around busy family schedules.'],
        'austell-ga' => ['city' => 'Austell', 'nearby' => ['Smyrna', 'Mableton', 'Powder Springs', 'Douglasville'], 'note' => 'Austell clients can request standard, deep, move-out, and apartment cleaning with quotes based on ZIP code and home details.'],
        'mableton-ga' => ['city' => 'Mableton', 'nearby' => ['Smyrna', 'Austell', 'Vinings', 'Marietta'], 'note' => 'Mableton service is a good fit for homeowners, renters, townhomes, and short-term rentals needing clear scheduling.'],
        'vinings-ga' => ['city' => 'Vinings', 'nearby' => ['Smyrna', 'Mableton', 'Buckhead', 'Marietta'], 'note' => 'Vinings requests often include condos, townhomes, apartments, and recurring service for busy professionals.'],
        'woodstock-ga' => ['city' => 'Woodstock', 'nearby' => ['Kennesaw', 'Acworth', 'Canton', 'Roswell'], 'note' => 'Woodstock homeowners often ask for recurring service, deep cleaning, and move-in cleaning along north metro routes.'],
        'roswell-ga' => ['city' => 'Roswell', 'nearby' => ['Alpharetta', 'Sandy Springs', 'Woodstock', 'Johns Creek'], 'note' => 'Roswell service works well for larger homes, condos, short-term rentals, and one-time deep cleaning requests.'],
        'sandy-springs-ga' => ['city' => 'Sandy Springs', 'nearby' => ['Roswell', 'Dunwoody', 'Buckhead', 'Vinings'], 'note' => 'Sandy Springs clients commonly request condo cleaning, recurring home cleaning, and move-in or move-out help.'],
        'alpharetta-ga' => ['city' => 'Alpharetta', 'nearby' => ['Roswell', 'Johns Creek', 'Dunwoody', 'Norcross'], 'note' => 'Alpharetta homes may need flexible scheduling for recurring visits, detailed resets, and move-related cleaning.'],
        'canton-ga' => ['city' => 'Canton', 'nearby' => ['Woodstock', 'Acworth', 'Cartersville', 'Kennesaw'], 'note' => 'Canton availability can vary by route, so quote requests should include ZIP code and preferred timing.'],
        'dallas-ga' => ['city' => 'Dallas', 'nearby' => ['Acworth', 'Powder Springs', 'Kennesaw', 'Douglasville'], 'note' => 'Dallas cleaning requests often center on family homes, move-outs, deep cleaning, and recurring maintenance.'],
        'cartersville-ga' => ['city' => 'Cartersville', 'nearby' => ['Acworth', 'Canton', 'Kennesaw', 'Dallas'], 'note' => 'Cartersville is handled by route availability, especially for deep cleaning, move-out cleaning, and scheduled recurring work.'],
        'norcross-ga' => ['city' => 'Norcross', 'nearby' => ['Peachtree Corners', 'Dunwoody', 'Tucker', 'Johns Creek'], 'note' => 'Norcross clients can request apartment, condo, move-out, Airbnb, and routine cleaning based on access details.'],
        'dunwoody-ga' => ['city' => 'Dunwoody', 'nearby' => ['Sandy Springs', 'Brookhaven', 'Norcross', 'Tucker'], 'note' => 'Dunwoody service is suited to condos, apartments, townhomes, and family homes needing dependable upkeep.'],
        'johns-creek-ga' => ['city' => 'Johns Creek', 'nearby' => ['Alpharetta', 'Roswell', 'Norcross', 'Peachtree Corners'], 'note' => 'Johns Creek homeowners often request recurring cleaning, deep cleaning, and detailed resets for larger residences.'],
        'brookhaven-ga' => ['city' => 'Brookhaven', 'nearby' => ['Dunwoody', 'Chamblee', 'Buckhead', 'Decatur'], 'note' => 'Brookhaven requests commonly include condo cleaning, move-outs, recurring service, and guest-ready short-term rentals.'],
        'peachtree-corners-ga' => ['city' => 'Peachtree Corners', 'nearby' => ['Norcross', 'Johns Creek', 'Dunwoody', 'Tucker'], 'note' => 'Peachtree Corners clients often need flexible home, apartment, and move-related cleaning by ZIP code.'],
        'tucker-ga' => ['city' => 'Tucker', 'nearby' => ['Decatur', 'Norcross', 'Brookhaven', 'Dunwoody'], 'note' => 'Tucker cleaning requests include apartments, homes, move-outs, and detailed one-time resets.'],
        'decatur-ga' => ['city' => 'Decatur', 'nearby' => ['Brookhaven', 'Tucker', 'Chamblee', 'Stone Mountain'], 'note' => 'Decatur availability depends on routing, with common requests for deep cleans, apartments, and move-in or move-out service.'],
        'douglasville-ga' => ['city' => 'Douglasville', 'nearby' => ['Austell', 'Powder Springs', 'Dallas', 'Lithia Springs'], 'note' => 'Douglasville is best quoted with ZIP code, property size, service type, and preferred cleaning window.'],
    ];

    public function __construct()
    {
        $this->content = new SiteContentRepository();
        $settings = $this->content->settings();

        $this->baseUrl = rtrim($settings['base_url'] ?? $this->baseUrl, '/');
        $this->services = $this->content->services($this->services);
        $this->areas = $this->content->areas($this->areas);
    }

    public function index()
    {
        $page = $this->content->page('home', [
            'title' => 'House Cleaning Services in Marietta, GA | Gold Cleaning',
            'description' => 'Gold Cleaning provides residential cleaning in Marietta, GA and nearby Atlanta suburbs. Standard, deep, move-in/move-out, Airbnb, and recurring service.',
        ]);

        return view('site.index', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/',
            'landing' => true,
            'schema' => [$this->businessSchema(), $this->faqSchema($this->homeFaq())],
        ], array_merge(compact('page'), ['homeFaq' => $this->homeFaq()])));
    }

    public function services()
    {
        $page = $this->content->page('services', [
            'title' => 'Residential Cleaning Services in Marietta, GA | Gold Cleaning',
            'description' => 'Explore Gold Cleaning services in Marietta, GA including standard, recurring, deep, move-in/move-out, Airbnb turnover, apartment, and condo cleaning.',
        ]);

        return view('site.services', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/services',
        ], compact('page')));
    }

    public function service(string $slug)
    {
        if (!isset($this->services[$slug])) {
            return response('Not found', 404);
        }
        $service = $this->services[$slug];

        return view('site.service-detail', $this->viewData([
            'title' => $service['title'],
            'description' => $service['description'],
            'path' => '/services/'.$slug,
            'breadcrumbs' => [['Services', '/services'], [$service['name'], '/services/'.$slug]],
            'schema' => [$this->serviceSchema($service, '/services/'.$slug), $this->faqSchema($this->serviceFaq($service['name'])), $this->breadcrumbSchema([['Services', '/services'], [$service['name'], '/services/'.$slug]])],
        ], compact('service', 'slug')));
    }

    public function serviceAreas()
    {
        $page = $this->content->page('service_areas', [
            'title' => 'Service Areas for House Cleaning Near Marietta, GA | Gold Cleaning',
            'description' => 'Gold Cleaning serves Marietta, Smyrna, Kennesaw, Acworth, Powder Springs, Vinings, Woodstock, Roswell, Sandy Springs, Alpharetta, and nearby cities.',
        ]);

        return view('site.service-areas', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/service-areas',
        ], compact('page')));
    }

    public function serviceArea(string $slug)
    {
        if (!isset($this->areas[$slug])) {
            return response('Not found', 404);
        }
        $area = $this->areas[$slug];
        $city = $area['city'];

        return view('site.area-detail', $this->viewData([
            'title' => "House Cleaning Services in {$city}, GA | Gold Cleaning",
            'description' => "Gold Cleaning offers standard, deep, move-in/move-out, recurring, and Airbnb cleaning services in {$city}, GA. Request a fast local quote today.",
            'path' => '/service-areas/'.$slug,
            'breadcrumbs' => [['Service Areas', '/service-areas'], [$city.', GA', '/service-areas/'.$slug]],
            'schema' => [$this->areaSchema($city, '/service-areas/'.$slug), $this->faqSchema($this->areaFaq($city)), $this->breadcrumbSchema([['Service Areas', '/service-areas'], [$city.', GA', '/service-areas/'.$slug]])],
        ], compact('area', 'slug', 'city')));
    }

    public function quote()
    {
        $page = $this->content->page('quote', [
            'title' => 'Request a House Cleaning Quote in Marietta, GA | Gold Cleaning',
            'description' => 'Request a fast cleaning quote from Gold Cleaning for homes, apartments, move-outs, deep cleans, recurring service, and Airbnb turnovers near Marietta, GA.',
        ]);

        return view('site.quote', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/quote',
        ], compact('page')));
    }

    public function quoteSubmit(Request $request)
    {
        if (trim((string) $request->input('company_website', '')) !== '') {
            return redirect(route('site.thank-you'));
        }

        $lead = [
            'created_at' => date('c'),
            'name' => trim((string) $request->input('name', '')),
            'phone' => trim((string) $request->input('phone', '')),
            'zip' => trim((string) $request->input('zip', '')),
            'service' => trim((string) $request->input('service', '')),
            'source' => trim((string) $request->input('source', 'landing_page')),
            'gclid' => trim((string) $request->input('gclid', '')),
            'utm_source' => trim((string) $request->input('utm_source', '')),
            'utm_medium' => trim((string) $request->input('utm_medium', '')),
            'utm_campaign' => trim((string) $request->input('utm_campaign', '')),
            'utm_adgroup' => trim((string) $request->input('utm_adgroup', '')),
            'utm_term' => trim((string) $request->input('utm_term', '')),
            'page_url' => trim((string) $request->input('page_url', '')),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
        ];

        if ($lead['name'] === '' || $lead['phone'] === '' || $lead['zip'] === '') {
            return redirect(route('site.home').'#quote');
        }

        $dir = storage_path('app');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents(
            $dir.DIRECTORY_SEPARATOR.'quote-leads.jsonl',
            json_encode($lead, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE).PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

        return redirect(route('site.thank-you').'?lead=quote');
    }

    public function contact()
    {
        $page = $this->content->page('contact', [
            'title' => 'Contact Gold Cleaning in Marietta, GA',
            'description' => 'Call, text, WhatsApp, or email Gold Cleaning for residential cleaning quotes in Marietta, Cobb County, and nearby metro Atlanta cities.',
        ]);

        return view('site.contact', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/contact',
            'schema' => [$this->businessSchema()],
        ], compact('page')));
    }

    public function howItWorks()
    {
        $page = $this->content->page('how_it_works', [
            'title' => 'How Gold Cleaning Works | Marietta House Cleaning',
            'description' => 'Learn how to request a quote, confirm availability, prepare for your cleaning, and choose the right house cleaning service in Marietta, GA.',
            'h1' => 'How Gold Cleaning works',
            'intro' => 'A clear cleaning process helps your first visit feel simple and keeps expectations aligned from quote to follow-up.',
            'sections' => [
                ['Send the basics', 'Share your city, ZIP code, bedrooms, bathrooms, service type, preferred contact method, and notes about pets, access, or priority rooms.'],
                ['Confirm availability', 'Gold Cleaning follows up by your preferred contact method with timing, estimate details, and any questions needed for an accurate quote.'],
                ['Walk through priorities', 'Before the clean, we align on supplies, parking, access, surfaces, add-ons, and the rooms that matter most.'],
                ['Choose next steps', 'Book one-time service or move into weekly, bi-weekly, or monthly recurring cleaning after the first visit.'],
            ],
        ]);

        return view('site.simple', $this->viewData(array_merge($page, [
            'path' => '/how-it-works',
        ])));
    }

    public function faq()
    {
        $page = $this->content->page('faq', [
            'title' => 'House Cleaning FAQ | Gold Cleaning Marietta, GA',
            'description' => 'Answers to common questions about Gold Cleaning services, quotes, service areas, deep cleaning, recurring cleaning, move-outs, and Airbnb turnovers.',
        ]);

        return view('site.faq', $this->viewData([
            'title' => $page['title'],
            'description' => $page['description'],
            'path' => '/faq',
            'schema' => [$this->faqSchema($this->homeFaq())],
        ], array_merge(compact('page'), ['faqItems' => $this->content->faq('full', array_merge($this->homeFaq(), [
            ['Do you bring supplies?', 'Share your preference when requesting a quote. If your home needs specific products for stone, wood, stainless steel, or sensitive surfaces, include that in the notes.'],
            ['Can I book recurring service after a first clean?', 'Yes. Many homes start with a deep clean and then move to weekly, bi-weekly, or monthly maintenance.'],
        ]))])));
    }

    public function privacy()
    {
        return view('site.legal', $this->viewData([
            'title' => 'Privacy Policy | Gold Cleaning',
            'description' => 'Gold Cleaning privacy policy for quote requests, contact details, website usage, and customer communication.',
            'path' => '/privacy-policy',
            'h1' => 'Privacy Policy',
            'updated' => 'June 1, 2026',
        ]));
    }

    public function terms()
    {
        return view('site.legal', $this->viewData([
            'title' => 'Terms of Service | Gold Cleaning',
            'description' => 'Gold Cleaning terms of service for residential cleaning quotes, scheduling, access, cancellations, and customer responsibilities.',
            'path' => '/terms',
            'h1' => 'Terms of Service',
            'updated' => 'June 1, 2026',
            'terms' => true,
        ]));
    }

    public function thankYou()
    {
        return view('site.thank-you', $this->viewData([
            'title' => 'Thank You | Gold Cleaning',
            'description' => 'Thank you for contacting Gold Cleaning.',
            'path' => '/thank-you',
            'robots' => 'noindex,follow',
        ]));
    }

    public function sitemap()
    {
        $urls = array_merge(
            ['/', '/services', '/service-areas', '/quote', '/contact', '/how-it-works', '/faq', '/privacy-policy', '/terms'],
            array_map(fn ($slug) => '/services/'.$slug, array_keys($this->services)),
            array_map(fn ($slug) => '/service-areas/'.$slug, array_keys($this->areas))
        );

        $xml = view('site.sitemap', ['urls' => $urls, 'baseUrl' => $this->baseUrl])->render();
        return new Response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $body = "User-agent: *\nAllow: /v2/\nDisallow: /v2/thank-you\nSitemap: {$this->baseUrl}/sitemap.xml\n";
        return new Response($body, 200, ['Content-Type' => 'text/plain']);
    }

    private function viewData(array $meta, array $extra = []): array
    {
        $path = $meta['path'] ?? '/';
        $canonical = $path === '/' ? $this->baseUrl.'/' : $this->baseUrl.rtrim($path, '/');
        $settings = $this->settings();

        return array_merge([
            'meta' => array_merge([
                'robots' => 'index,follow',
                'canonical' => $canonical,
                'image' => $settings['image'] ?? $this->baseUrl.'/public/img/hero-team.png',
                'schema' => [],
            ], $meta),
            'services' => $this->services,
            'areas' => $this->areas,
            'baseUrl' => $this->baseUrl,
            'settings' => $settings,
        ], $meta, $extra);
    }

    private function settings(): array
    {
        return array_merge([
            'brand' => 'Gold Cleaning',
            'city' => 'Marietta, GA',
            'service_radius' => '40 miles around Marietta',
            'phone_display' => '(678) 330-3174',
            'phone_tel' => '+16783303174',
            'phone_digits' => '16783303174',
            'whatsapp_digits' => '16783303174',
            'email' => 'hello@goldcleaning.com',
            'base_url' => $this->baseUrl,
            'image' => $this->baseUrl.'/public/img/hero-team.png',
            'google_analytics_id' => 'G-SDQ77FVZ9D',
            'google_ads_id' => 'AW-18242560417',
        ], $this->content->settings());
    }

    private function homeFaq(): array
    {
        return $this->content->faq('home', [
            ['How do I get pricing?', 'Send the quote form with your home size, ZIP code, service type, and notes. We will follow up with an estimate based on the details you provide.'],
            ['Do you offer one-time cleaning?', 'Yes. You can request standard cleaning, deep cleaning or move-in and move-out cleaning without committing to recurring service.'],
            ['Can I schedule recurring cleaning?', 'Yes. Recurring cleaning may be scheduled weekly, bi-weekly or monthly, depending on availability.'],
            ['Do you bring cleaning supplies?', 'Tell us your preference when requesting your quote. Please mention any special products required for stone, wood, stainless steel or sensitive surfaces.'],
            ['Do I need to be home?', 'Access arrangements can be discussed before the appointment. Include gate, parking, pet or entry instructions when confirming the service.'],
            ['Do you clean homes with pets?', 'Tell us about your pets and any extra pet hair or access considerations when requesting the quote.'],
            ['What areas do you serve?', 'Gold Cleaning serves Marietta and nearby communities across Cobb County and the north Metro Atlanta area. Send your ZIP Code to confirm availability.'],
            ['How soon will I receive a response?', 'Send your request by form, phone or text. Our team will contact you to discuss availability and the information needed for your estimate.'],
        ]);
    }

    private function serviceFaq(string $service): array
    {
        return [
            ["How do I request {$service}?", 'Use the quote form, call, text, or WhatsApp Gold Cleaning with your ZIP code, home size, service type, and preferred timing.'],
            ["Is {$service} available outside Marietta?", 'Yes. Availability depends on route and schedule, but Gold Cleaning serves many nearby Cobb County and metro Atlanta cities.'],
            ['Do I need to be home during the cleaning?', 'Many clients provide access instructions. Share parking, pets, entry details, and any priorities before the appointment.'],
            ['Can I add special requests?', 'Yes. Include inside appliances, interior windows, linens, pet hair, or priority rooms in your quote request.'],
            ['What affects the final quote?', 'Home size, condition, service type, add-ons, access, timing, and frequency can all affect the estimate.'],
        ];
    }

    private function areaFaq(string $city): array
    {
        return [
            ["Do you offer house cleaning in {$city}, GA?", "Yes. Gold Cleaning serves {$city} by route availability for standard, deep, recurring, move-in/move-out, apartment, condo, and Airbnb cleaning."],
            ["Can I get a same-week quote in {$city}?", 'Send your ZIP code, service type, and preferred timing by WhatsApp, text, or the quote form so we can confirm availability.'],
            ["Do you clean apartments and condos in {$city}?", 'Yes. Share building access, parking, elevator details, bedrooms, bathrooms, and any pet or roommate notes.'],
            ["What services are popular in {$city}?", 'Common requests include standard cleaning, deep cleaning, recurring maintenance, move-out cleaning, and short-term rental turnover support.'],
        ];
    }

    private function businessSchema(): array
    {
        $settings = $this->settings();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'HouseCleaningService',
            'name' => $settings['brand'],
            'url' => $this->baseUrl.'/',
            'telephone' => $settings['phone_tel'],
            'email' => $settings['email'],
            'image' => $this->baseUrl.'/public/img/logo.png',
            'priceRange' => '$$',
            'areaServed' => array_values(array_map(fn ($area) => ['@type' => 'City', 'name' => $area['city'].', GA'], $this->areas)),
            'serviceType' => array_values(array_map(fn ($service) => $service['name'], $this->services)),
        ];
    }

    private function serviceSchema(array $service, string $path): array
    {
        $settings = $this->settings();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'].' in Marietta, GA',
            'description' => $service['description'],
            'url' => $this->baseUrl.$path,
            'provider' => ['@type' => 'HouseCleaningService', 'name' => $settings['brand'], 'telephone' => $settings['phone_tel']],
            'areaServed' => ['@type' => 'City', 'name' => 'Marietta, GA'],
        ];
    }

    private function areaSchema(string $city, string $path): array
    {
        $settings = $this->settings();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => 'House Cleaning Services in '.$city.', GA',
            'url' => $this->baseUrl.$path,
            'provider' => ['@type' => 'HouseCleaningService', 'name' => $settings['brand'], 'telephone' => $settings['phone_tel']],
            'areaServed' => ['@type' => 'City', 'name' => $city.', GA'],
        ];
    }

    private function faqSchema(array $faq): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item[1]],
            ], $faq),
        ];
    }

    private function breadcrumbSchema(array $items): array
    {
        array_unshift($items, ['Home', '/']);
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(fn ($item, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item[0],
                'item' => $this->baseUrl.rtrim($item[1], '/'),
            ], $items, array_keys($items)),
        ];
    }
}
