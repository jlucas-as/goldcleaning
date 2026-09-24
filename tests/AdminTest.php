<?php

namespace Tests;

use App\Http\Controllers\AdminController;

class AdminTest extends TestCase
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

    public function test_admin_login_page_renders_in_lumen(): void
    {
        $this->get('/admin/login');

        $this->assertResponseOk();
        $this->assertStringContainsString('Entrar no painel', $this->response->getContent());
        $this->assertStringContainsString('name="_token"', $this->response->getContent());
    }

    public function test_legacy_leads_are_normalized_for_the_dashboard(): void
    {
        file_put_contents($this->leadFile, json_encode([
            'created_at' => '2026-01-01T12:00:00+00:00',
            'name' => 'Legacy Lead',
            'phone' => '(678) 555-1234',
            'zip' => '30060',
            'service' => 'Standard Cleaning',
        ]).PHP_EOL);

        $controller = new AdminController();
        $method = new \ReflectionMethod($controller, 'leads');
        $method->setAccessible(true);
        $result = $method->invoke($controller);
        $lead = $result['items'][0];

        $this->assertSame('Standard Cleaning', $lead['cleaning_type']);
        $this->assertSame('30060', $lead['zip_code']);
        $this->assertSame('', $lead['email']);
        $this->assertSame('', $lead['utm_source']);
        $this->assertSame('Nao informado', $lead['contact_method_label']);

        $editableContent = new \ReflectionMethod($controller, 'editableContent');
        $editableContent->setAccessible(true);
        $html = view('admin.dashboard', array_merge($editableContent->invoke($controller), [
            'saved' => false,
            'error' => null,
            'adminCsrfToken' => 'test-token',
        ]))->render();

        $this->assertStringContainsString('Legacy Lead', $html);
        $this->assertStringContainsString('Standard Cleaning', $html);
    }
}
