<?php

namespace Tests;

class QuoteFormTest extends TestCase
{
    private string $leadFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leadFile = storage_path('app/quote-leads.testing.jsonl');

        if (is_file($this->leadFile)) {
            unlink($this->leadFile);
        }
    }

    protected function tearDown(): void
    {
        if (is_file($this->leadFile)) {
            unlink($this->leadFile);
        }

        parent::tearDown();
    }

    public function test_home_contains_two_step_form_and_csrf_cookie(): void
    {
        $this->get('/');

        $this->assertResponseOk();
        $this->assertStringContainsString('Step 1 of 2', $this->response->getContent());
        $this->assertStringContainsString('class="lp-quote-card" id="quote"', $this->response->getContent());
        $this->assertStringContainsString('name="cleaning_type"', $this->response->getContent());
        $this->assertNotEmpty($this->response->headers->getCookies());
    }

    public function test_quote_submission_requires_matching_csrf_token(): void
    {
        $this->json('POST', '/quote-submit', $this->validLead());

        $this->assertResponseStatus(419);
        $this->seeJsonContains(['success' => false]);
        $this->assertFileDoesNotExist($this->leadFile);
    }

    public function test_quote_submission_validates_us_contact_details(): void
    {
        [$token, $cookies] = $this->formSession();
        $lead = array_merge($this->validLead(), [
            'csrf_token' => $token,
            'zip_code' => '123',
            'phone' => '555',
            'email' => '',
            'preferred_contact_method' => 'email',
        ]);

        $this->call('POST', '/quote-submit', $lead, $cookies, [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
        ]);

        $this->assertResponseStatus(422);
        $payload = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('zip_code', $payload['errors']);
        $this->assertArrayHasKey('phone', $payload['errors']);
        $this->assertArrayHasKey('email', $payload['errors']);
        $this->assertFileDoesNotExist($this->leadFile);
    }

    public function test_valid_quote_is_saved_with_campaign_data(): void
    {
        [$token, $cookies] = $this->formSession();
        $lead = array_merge($this->validLead(), ['csrf_token' => $token]);

        $this->call('POST', '/quote-submit', $lead, $cookies, [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['success' => true]);
        $this->assertFileExists($this->leadFile);

        $savedLead = json_decode(trim((string) file_get_contents($this->leadFile)), true);
        $this->assertSame('Deep Cleaning', $savedLead['cleaning_type']);
        $this->assertSame('email', $savedLead['preferred_contact_method']);
        $this->assertSame('google', $savedLead['utm_source']);
        $this->assertSame('responsive_ad', $savedLead['utm_content']);
        $this->assertSame('https://example.test/campaign', $savedLead['referrer']);
    }

    public function test_honeypot_returns_success_without_saving_a_lead(): void
    {
        [$token, $cookies] = $this->formSession();
        $lead = array_merge($this->validLead(), [
            'csrf_token' => $token,
            'company_website' => 'https://spam.example',
        ]);

        $this->call('POST', '/quote-submit', $lead, $cookies, [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(['success' => true]);
        $this->assertFileDoesNotExist($this->leadFile);
    }

    private function formSession(): array
    {
        $this->get('/');
        preg_match('/name="csrf_token" value="([a-f0-9]+)"/', $this->response->getContent(), $matches);

        $this->assertNotEmpty($matches[1] ?? null);

        return [$matches[1], ['gc_quote_csrf' => $matches[1]]];
    }

    private function validLead(): array
    {
        return [
            'cleaning_type' => 'Deep Cleaning',
            'bedrooms' => '3',
            'bathrooms' => '2',
            'frequency' => 'Bi-Weekly',
            'zip_code' => '30060',
            'name' => 'Test Customer',
            'phone' => '(678) 555-1234',
            'email' => 'test@example.com',
            'preferred_contact_method' => 'email',
            'source' => 'ads_landing_page',
            'utm_source' => 'google',
            'utm_medium' => 'cpc',
            'utm_campaign' => 'marietta_cleaning',
            'utm_term' => 'house cleaning',
            'utm_content' => 'responsive_ad',
            'page_url' => 'https://example.test/',
            'referrer' => 'https://example.test/campaign',
        ];
    }
}
