<?php

namespace App\Libraries;

use Config\Services;

class SeoLib
{
    protected $title;
    protected $request;
    protected $metaTags = [];
    protected $jsonLd = [];
    protected $openGraph = [];

    public function __construct()
    {
        $this->request = Services::request();
    }

    /**
     * Set meta title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Add meta tag
     */
    public function addMeta(string $name, string $content, string $type = 'name'): self
    {
        $this->metaTags[$name] = [
            'type'    => $type,
            'content' => $content
        ];
        return $this;
    }

    /**
     * Add Open Graph tag
     */
    public function addOpenGraph(string $property, string $content): self
    {
        $this->openGraph[$property] = $content;
        return $this;
    }

    /**
     * Add JSON-LD data
     */
    public function addJsonLd(array $data): self
    {
        $this->jsonLd[] = $data;
        return $this;
    }

    /**
     * Generate meta tags output
     */
    public function renderMetaTags(): string
    {
        $output = '';

        // Default meta tags
        $defaultMeta = [
            'title'       => $this->title,
            'description' => $this->metaTags['description']['content'] ?? '',
            'keywords'    => $this->metaTags['keywords']['content'] ?? '',
        ];

        // Generate title tag
        if (!empty($this->title)) {
            $output .= '<title>' . esc($this->title) . '</title>' . "\n";
        }

        // Generate standard meta tags
        foreach ($this->metaTags as $name => $tag) {
            $output .= '<meta ' . $tag['type'] . '="' . esc($name) . '" content="' . $tag['content'] . '">' . "\n";
        }

        // Generate Open Graph tags
        foreach ($this->openGraph as $property => $content) {
            $output .= '<meta property="' . esc($property) . '" content="' . esc($content) . '">' . "\n";
        }

        // Generate canonical URL
        $output .= '<link rel="canonical" href="' . esc(current_url()) . '">' . "\n";

        return $output;
    }

    /**
     * Generate JSON-LD output
     */
    public function renderJsonLd(): string
    {
        if (empty($this->jsonLd)) {
            return '';
        }

        $output = '';
        foreach ($this->jsonLd as $data) {
            $output .= '<script type="application/ld+json" '.csp_script_nonce().'>' . PHP_EOL;
            $output .= json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL;
            $output .= '</script>' . PHP_EOL;
        }

        return $output;
    }

    /**
     * Generate all SEO output
     */
    public function renderAll(): string
    {
        return $this->renderMetaTags() . $this->renderJsonLd();
    }
}