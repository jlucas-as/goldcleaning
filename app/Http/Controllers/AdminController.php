<?php

namespace App\Http\Controllers;

use App\Support\SiteContentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;

class AdminController extends Controller
{
    private const AUTH_COOKIE = 'gold_admin_auth';
    private const LOGIN_CSRF_COOKIE = 'gold_admin_login_csrf';
    private const AUTH_TTL = 28800;

    private SiteContentRepository $content;
    private array $pageLabels = [
        'home' => 'Home',
        'services' => 'Servicos',
        'service_areas' => 'Areas atendidas',
        'quote' => 'Orcamento',
        'contact' => 'Contato',
        'faq' => 'FAQ',
        'how_it_works' => 'Como funciona',
    ];

    public function __construct()
    {
        $this->content = new SiteContentRepository();
    }

    public function edit(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        return view('admin.dashboard', array_merge($this->editableContent(), [
            'saved' => $request->query('saved') === '1',
            'error' => null,
            'adminCsrfToken' => $this->adminCsrfToken($request),
        ]));
    }

    public function update(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        if (!$this->validAdminCsrf($request)) {
            return redirect('/admin/login?expired=1');
        }

        $this->content->save([
            'settings' => $this->cleanScalarArray((array) $request->input('settings', [])),
            'pages' => $this->cleanPages((array) $request->input('pages', [])),
            'faqs' => $this->cleanFaqs((array) $request->input('faqs', [])),
            'services' => $this->cleanServices((array) $request->input('services', [])),
            'areas' => $this->cleanAreas((array) $request->input('areas', [])),
            'before_after' => $this->cleanBeforeAfter((array) $request->input('before_after', []), (array) $request->file('before_after', [])),
        ]);

        return redirect('/admin?saved=1');
    }

    public function login(Request $request)
    {
        if ($this->isAdminAuthenticated($request)) {
            return redirect('/admin');
        }

        return $this->loginResponse($request, null, '', 200);
    }

    public function authenticate(Request $request)
    {
        $submittedToken = (string) $request->input('_token', '');
        $cookieToken = (string) $request->cookie(self::LOGIN_CSRF_COOKIE, '');

        if ($submittedToken === '' || $cookieToken === '' || !hash_equals($cookieToken, $submittedToken)) {
            return $this->loginResponse($request, 'Sua sessao de login expirou. Tente novamente.', (string) $request->input('username', ''), 419);
        }

        $configuredUser = (string) env('ADMIN_USERNAME', '');
        $configuredPassword = (string) env('ADMIN_PASSWORD', '');
        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');

        if ($configuredUser === '' || $configuredPassword === '') {
            return $this->loginResponse($request, 'Configure ADMIN_USERNAME e ADMIN_PASSWORD no arquivo .env.', $username, 503);
        }

        if (!hash_equals($configuredUser, $username) || !hash_equals($configuredPassword, $password)) {
            return $this->loginResponse($request, 'Usuario ou senha incorretos.', $username, 422);
        }

        $expiresAt = time() + self::AUTH_TTL;
        $response = redirect('/admin');
        $response->headers->setCookie($this->cookie(self::AUTH_COOKIE, $this->makeAuthToken($configuredUser, $expiresAt), $expiresAt, true));
        $response->headers->clearCookie(self::LOGIN_CSRF_COOKIE, '/');
        $response->headers->clearCookie(self::LOGIN_CSRF_COOKIE, '/admin');
        $response->headers->clearCookie(self::AUTH_COOKIE, '/admin');

        return $response;
    }

    public function logout(Request $request)
    {
        if (!$this->isAdminAuthenticated($request) || !$this->validAdminCsrf($request)) {
            return redirect('/admin/login?expired=1');
        }

        $response = redirect('/admin/login?logged_out=1');
        $response->headers->clearCookie(self::AUTH_COOKIE, '/');
        $response->headers->clearCookie(self::AUTH_COOKIE, '/admin');

        return $response;
    }

    private function editableContent(): array
    {
        $site = new SiteController();
        $leadData = $this->leads();

        return [
            'settings' => $this->siteSettings($site),
            'pages' => $this->pages(),
            'faqs' => $this->faqs(),
            'services' => $this->siteProperty($site, 'services'),
            'areas' => $this->siteProperty($site, 'areas'),
            'beforeAfter' => $this->beforeAfter(),
            'leads' => $leadData['items'],
            'leadStats' => $leadData['stats'],
            'pageLabels' => $this->pageLabels,
            'path' => $this->content->path(),
        ];
    }

    private function leads(): array
    {
        $leadFile = env('APP_ENV') === 'testing' ? 'quote-leads.testing.jsonl' : 'quote-leads.jsonl';
        $path = storage_path('app/'.$leadFile);
        $items = [];
        $today = 0;
        $lastSevenDays = 0;
        $timezone = new \DateTimeZone('America/New_York');
        $todayStart = new \DateTimeImmutable('today', $timezone);
        $sevenDaysAgo = $todayStart->modify('-6 days');

        if (is_file($path) && is_readable($path)) {
            $file = new \SplFileObject($path, 'r');

            while (!$file->eof()) {
                $line = trim((string) $file->fgets());

                if ($line === '') {
                    continue;
                }

                $lead = json_decode($line, true);

                if (!is_array($lead)) {
                    continue;
                }

                $lead = array_merge([
                    'created_at' => '',
                    'name' => '',
                    'phone' => '',
                    'email' => '',
                    'cleaning_type' => $lead['service'] ?? '',
                    'frequency' => '',
                    'bedrooms' => '',
                    'bathrooms' => '',
                    'zip_code' => $lead['zip'] ?? '',
                    'preferred_contact_method' => '',
                    'source' => '',
                    'gclid' => '',
                    'utm_source' => '',
                    'utm_medium' => '',
                    'utm_campaign' => '',
                    'utm_adgroup' => '',
                    'utm_term' => '',
                    'utm_content' => '',
                    'page_url' => '',
                    'referrer' => '',
                ], $lead);

                try {
                    $createdAt = new \DateTimeImmutable((string) ($lead['created_at'] ?? 'now'));
                    $createdAt = $createdAt->setTimezone($timezone);
                } catch (\Exception) {
                    $createdAt = new \DateTimeImmutable('now', $timezone);
                }

                if ($createdAt >= $todayStart) {
                    $today++;
                }

                if ($createdAt >= $sevenDaysAgo) {
                    $lastSevenDays++;
                }

                $phoneDigits = preg_replace('/\D+/', '', (string) ($lead['phone'] ?? '')) ?? '';
                $lead['created_at_formatted'] = $createdAt->format('m/d/Y, g:i A');
                $lead['phone_digits'] = $phoneDigits;
                $lead['whatsapp_digits'] = strlen($phoneDigits) === 10 ? '1'.$phoneDigits : $phoneDigits;
                $lead['contact_method_label'] = $this->contactMethodLabel((string) ($lead['preferred_contact_method'] ?? ''));
                $items[] = $lead;
            }
        }

        $total = count($items);
        $items = array_reverse($items);

        return [
            'items' => array_slice($items, 0, 500),
            'stats' => [
                'total' => $total,
                'today' => $today,
                'last_seven_days' => $lastSevenDays,
            ],
        ];
    }

    private function contactMethodLabel(string $method): string
    {
        return [
            'text_message' => 'SMS',
            'phone_call' => 'Ligacao',
            'whatsapp' => 'WhatsApp',
            'email' => 'E-mail',
        ][$method] ?? 'Nao informado';
    }

    private function beforeAfter(): array
    {
        return array_replace_recursive([
            'section' => [
                'enabled' => '1',
                'eyebrow' => 'Before and after',
                'title' => 'See the Difference',
                'text' => 'Real cleaning results from homes served by Gold Cleaning.',
            ],
            'items' => [],
        ], $this->content->get('before_after', []));
    }

    private function pages(): array
    {
        $defaults = [
            'home' => [
                'title' => 'House Cleaning Services in Marietta, GA | Gold Cleaning',
                'description' => 'Gold Cleaning provides residential cleaning in Marietta, GA and nearby Atlanta suburbs. Standard, deep, move-in/move-out, Airbnb, and recurring service.',
                'hero_pill' => 'Locally focused cleaning for Marietta, GA homes',
                'hero_h1' => 'Reliable house cleaning for busy homes in Marietta, GA.',
                'hero_lead' => 'Gold Cleaning helps homeowners, renters, apartment residents, and short-term rental hosts keep their spaces guest-ready, family-ready, and easier to live in. Request a one-time clean or set up recurring service around your routine.',
                'quote_card_title' => 'Request a Cleaning Quote',
                'quote_card_text' => 'Share the basics and we will follow up with availability and a clear estimate.',
                'services_title' => 'Cleaning services for real life in metro Atlanta',
                'services_text' => 'Choose the service that fits your home, timing, and priorities. Each quote is based on home size, condition, access, ZIP code, and requested add-ons.',
            ],
            'services' => [
                'title' => 'Residential Cleaning Services in Marietta, GA | Gold Cleaning',
                'description' => 'Explore Gold Cleaning services in Marietta, GA including standard, recurring, deep, move-in/move-out, Airbnb turnover, apartment, and condo cleaning.',
                'hero_pill' => 'Residential cleaning services in Marietta, GA',
                'hero_h1' => 'Cleaning options built around your home, schedule, and priorities.',
                'hero_lead' => 'Gold Cleaning serves Marietta and nearby Atlanta suburbs with flexible cleaning for houses, apartments, move-outs, and short-term rentals. Choose a one-time service or request recurring visits.',
                'quote_factors_title' => 'What affects your quote?',
                'quote_factors_text' => 'Every home is different. The most accurate estimate comes from a few practical details.',
                'services_title' => 'Services',
                'services_text' => 'Start with the service that best matches your situation. You can add notes for rooms, surfaces, pets, access instructions, or anything that needs extra attention.',
            ],
            'service_areas' => [
                'title' => 'Service Areas for House Cleaning Near Marietta, GA | Gold Cleaning',
                'description' => 'Gold Cleaning serves Marietta, Smyrna, Kennesaw, Acworth, Powder Springs, Vinings, Woodstock, Roswell, Sandy Springs, Alpharetta, and nearby cities.',
                'hero_pill' => 'Based in Marietta, GA',
                'hero_h1' => 'Cleaning service across Marietta, Cobb County, and nearby Atlanta suburbs.',
                'hero_lead' => 'Gold Cleaning serves homes, apartments, condos, and short-term rentals across the north metro Atlanta area. If your city is not listed, send your ZIP code and we will confirm availability quickly.',
                'areas_title' => 'Priority service areas',
                'areas_text' => 'Each city page includes local cleaning options, nearby areas, FAQs, and quote links.',
            ],
            'quote' => [
                'title' => 'Request a House Cleaning Quote in Marietta, GA | Gold Cleaning',
                'description' => 'Request a fast cleaning quote from Gold Cleaning for homes, apartments, move-outs, deep cleans, recurring service, and Airbnb turnovers near Marietta, GA.',
                'hero_pill' => 'Fast local quote',
                'hero_h1' => 'Request a house cleaning quote in Marietta, GA.',
                'hero_lead' => 'Tell us what you need, where the home is located, and how you prefer to be contacted. If there is no backend configured, this form opens WhatsApp or SMS with your details already prepared.',
            ],
            'contact' => [
                'title' => 'Contact Gold Cleaning in Marietta, GA',
                'description' => 'Call, text, WhatsApp, or email Gold Cleaning for residential cleaning quotes in Marietta, Cobb County, and nearby metro Atlanta cities.',
                'hero_pill' => 'Contact Gold Cleaning',
                'hero_h1' => 'Contact Gold Cleaning in Marietta, GA.',
                'hero_lead' => 'Call, text, WhatsApp, or email Gold Cleaning for residential house cleaning quotes in Marietta, Cobb County, and nearby metro Atlanta cities.',
            ],
            'faq' => [
                'title' => 'House Cleaning FAQ | Gold Cleaning Marietta, GA',
                'description' => 'Answers to common questions about Gold Cleaning services, quotes, service areas, deep cleaning, recurring cleaning, move-outs, and Airbnb turnovers.',
                'hero_pill' => 'House cleaning FAQ',
                'hero_h1' => 'House Cleaning FAQ',
                'hero_lead' => 'Answers to common questions about Gold Cleaning quotes, service areas, scheduling, and residential cleaning options near Marietta, GA.',
            ],
            'how_it_works' => [
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
            ],
        ];

        $pages = [];

        foreach ($defaults as $key => $page) {
            $pages[$key] = array_replace_recursive($page, $this->content->get('pages.'.$key, []));
        }

        return $pages;
    }

    private function faqs(): array
    {
        $home = $this->content->faq('home', [
            ['Do you serve areas outside Marietta?', 'Yes. Gold Cleaning serves Marietta and nearby communities including Smyrna, Kennesaw, Acworth, Woodstock, Roswell, Sandy Springs, East Cobb, Vinings, and more.'],
            ['Can I request a one-time clean?', 'Yes. You can request standard cleaning, deep cleaning, move-in/move-out cleaning, or Airbnb turnover without committing to recurring service.'],
            ['How do I get pricing?', 'Send the quote form with your home size, ZIP code, service type, and notes. We will follow up with an estimate based on the details you provide.'],
            ['Can I text instead of calling?', 'Yes. You can request your quote by WhatsApp or text message, and choose your preferred contact method in the form.'],
        ]);

        return [
            'home' => $home,
            'full' => $this->content->faq('full', array_merge($home, [
                ['Do you bring supplies?', 'Share your preference when requesting a quote. If your home needs specific products for stone, wood, stainless steel, or sensitive surfaces, include that in the notes.'],
                ['Can I book recurring service after a first clean?', 'Yes. Many homes start with a deep clean and then move to weekly, bi-weekly, or monthly maintenance.'],
            ])),
        ];
    }

    private function siteSettings(SiteController $site): array
    {
        $method = new \ReflectionMethod($site, 'settings');
        $method->setAccessible(true);

        return $method->invoke($site);
    }

    private function siteProperty(SiteController $site, string $property): array
    {
        $reflection = new \ReflectionProperty($site, $property);
        $reflection->setAccessible(true);

        return $reflection->getValue($site);
    }

    private function cleanPages(array $pages): array
    {
        foreach ($pages as $key => $page) {
            $pages[$key] = $this->cleanScalarArray((array) $page);

            if (isset($page['sections'])) {
                $pages[$key]['sections'] = $this->cleanPairs((array) $page['sections'], 'title', 'text');
            }
        }

        return $pages;
    }

    private function cleanFaqs(array $faqs): array
    {
        foreach ($faqs as $key => $items) {
            $faqs[$key] = $this->cleanPairs((array) $items, 'question', 'answer');
        }

        return $faqs;
    }

    private function cleanServices(array $services): array
    {
        foreach ($services as $slug => $service) {
            $service = $this->cleanScalarArray((array) $service);

            foreach (['for', 'included', 'quote', 'addons'] as $listKey) {
                $service[$listKey] = $this->cleanLines($service[$listKey] ?? '');
            }

            $services[$slug] = $service;
        }

        return $services;
    }

    private function cleanAreas(array $areas): array
    {
        foreach ($areas as $slug => $area) {
            $area = $this->cleanScalarArray((array) $area);
            $area['nearby'] = $this->cleanLines($area['nearby'] ?? '');
            $areas[$slug] = $area;
        }

        return $areas;
    }

    private function cleanBeforeAfter(array $input, array $files): array
    {
        $items = [];

        foreach ((array) ($input['items'] ?? []) as $index => $item) {
            $item = $this->cleanScalarArray((array) $item);

            $beforeImage = $item['before_image_existing'] ?? '';
            $afterImage = $item['after_image_existing'] ?? '';
            $video = $item['video_existing'] ?? '';
            $itemFiles = (array) ($files['items'][$index] ?? []);

            if (!empty($itemFiles['before_image'])) {
                $beforeImage = $this->storeUpload($itemFiles['before_image'], ['jpg', 'jpeg', 'png', 'webp', 'gif']);
            }

            if (!empty($itemFiles['after_image'])) {
                $afterImage = $this->storeUpload($itemFiles['after_image'], ['jpg', 'jpeg', 'png', 'webp', 'gif']);
            }

            if (!empty($itemFiles['video'])) {
                $video = $this->storeUpload($itemFiles['video'], ['mp4', 'webm', 'mov']);
            }

            unset($item['before_image_existing'], $item['after_image_existing'], $item['video_existing']);

            $item['before_image'] = $beforeImage;
            $item['after_image'] = $afterImage;
            $item['video'] = $video;
            $item['enabled'] = !empty($item['enabled']) ? '1' : '0';

            if (($item['title'] ?? '') !== '' || $beforeImage !== '' || $afterImage !== '' || $video !== '') {
                $items[] = $item;
            }
        }

        return [
            'section' => $this->cleanScalarArray((array) ($input['section'] ?? [])),
            'items' => $items,
        ];
    }

    private function storeUpload(mixed $file, array $allowedExtensions): string
    {
        if (!is_object($file) || !method_exists($file, 'isValid') || !$file->isValid()) {
            return '';
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            return '';
        }

        $directory = dirname(__DIR__, 3).'/public/uploads/before-after';

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $name = date('Ymd-His').'-'.bin2hex(random_bytes(4)).'.'.$extension;
        $file->move($directory, $name);

        return 'public/uploads/before-after/'.$name;
    }

    private function cleanScalarArray(array $items): array
    {
        foreach ($items as $key => $value) {
            if (is_array($value)) {
                continue;
            }

            $items[$key] = trim((string) $value);
        }

        return $items;
    }

    private function cleanPairs(array $items, string $firstKey, string $secondKey): array
    {
        $clean = [];

        foreach ($items as $item) {
            $first = trim((string) ($item[$firstKey] ?? ''));
            $second = trim((string) ($item[$secondKey] ?? ''));

            if ($first !== '' || $second !== '') {
                $clean[] = [$first, $second];
            }
        }

        return $clean;
    }

    private function cleanLines(string|array $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value), fn ($item) => $item !== ''));
        }

        return array_values(array_filter(array_map('trim', preg_split('/\R/', $value) ?: []), fn ($item) => $item !== ''));
    }

    private function authorizeAdmin(Request $request)
    {
        if ($this->isAdminAuthenticated($request)) {
            return null;
        }

        return redirect('/admin/login');
    }

    private function loginResponse(Request $request, ?string $error, string $username, int $status)
    {
        $token = bin2hex(random_bytes(24));
        $response = new Response(view('admin.login', [
            'csrfToken' => $token,
            'error' => $error,
            'username' => $username,
            'loggedOut' => $request->query('logged_out') === '1',
            'expired' => $request->query('expired') === '1',
            'credentialsMissing' => !env('ADMIN_USERNAME') || !env('ADMIN_PASSWORD'),
        ]), $status);
        $response->headers->setCookie($this->cookie(self::LOGIN_CSRF_COOKIE, $token, time() + 900, true));
        $response->headers->clearCookie(self::LOGIN_CSRF_COOKIE, '/admin');

        return $response;
    }

    private function isAdminAuthenticated(Request $request): bool
    {
        $token = (string) $request->cookie(self::AUTH_COOKIE, '');
        $parts = explode('.', $token, 2);

        if (count($parts) !== 2) {
            return false;
        }

        [$payload, $signature] = $parts;
        $expectedSignature = hash_hmac('sha256', $payload, $this->authSecret());

        if (!hash_equals($expectedSignature, $signature)) {
            return false;
        }

        $decoded = base64_decode(strtr($payload, '-_', '+/'), true);

        if ($decoded === false) {
            return false;
        }

        [$username, $expiresAt] = array_pad(explode('|', $decoded, 2), 2, '');

        return $username !== ''
            && hash_equals((string) env('ADMIN_USERNAME', ''), $username)
            && ctype_digit($expiresAt)
            && (int) $expiresAt >= time();
    }

    private function makeAuthToken(string $username, int $expiresAt): string
    {
        $payload = rtrim(strtr(base64_encode($username.'|'.$expiresAt), '+/', '-_'), '=');

        return $payload.'.'.hash_hmac('sha256', $payload, $this->authSecret());
    }

    private function authSecret(): string
    {
        return hash('sha256', (string) env('APP_KEY', '').'|'.(string) env('ADMIN_PASSWORD', '').'|gold-cleaning-admin');
    }

    private function adminCsrfToken(Request $request): string
    {
        return hash_hmac('sha256', (string) $request->cookie(self::AUTH_COOKIE, ''), $this->authSecret());
    }

    private function validAdminCsrf(Request $request): bool
    {
        $submittedToken = (string) $request->input('_admin_csrf', '');

        return $submittedToken !== '' && hash_equals($this->adminCsrfToken($request), $submittedToken);
    }

    private function cookie(string $name, string $value, int $expiresAt, bool $httpOnly): Cookie
    {
        return new Cookie(
            $name,
            $value,
            $expiresAt,
            '/',
            null,
            request()->isSecure(),
            $httpOnly,
            false,
            Cookie::SAMESITE_LAX
        );
    }
}
