<?php

namespace App\Support;

class SiteContentRepository
{
    private string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?: dirname(__DIR__, 2).'/storage/app/site-content.json';
    }

    public function all(): array
    {
        if (!file_exists($this->path)) {
            return [];
        }

        $json = file_get_contents($this->path);
        $data = json_decode($json ?: '{}', true);

        return is_array($data) ? $data : [];
    }

    public function save(array $content): void
    {
        $directory = dirname($this->path);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            $this->path,
            json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE).PHP_EOL
        );
    }

    public function path(): string
    {
        return $this->path;
    }

    public function services(array $defaults): array
    {
        return $this->merge($defaults, $this->get('services', []));
    }

    public function areas(array $defaults): array
    {
        return $this->merge($defaults, $this->get('areas', []));
    }

    public function settings(): array
    {
        return $this->get('settings', []);
    }

    public function page(string $page, array $defaults = []): array
    {
        return $this->merge($defaults, $this->get('pages.'.$page, []));
    }

    public function faq(string $key, array $defaults): array
    {
        $faq = $this->get('faqs.'.$key, null);

        return is_array($faq) ? $faq : $defaults;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->all();

        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    private function merge(array $defaults, array $overrides): array
    {
        foreach ($overrides as $key => $value) {
            if (is_array($value) && isset($defaults[$key]) && is_array($defaults[$key])) {
                $defaults[$key] = $this->merge($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }
}
