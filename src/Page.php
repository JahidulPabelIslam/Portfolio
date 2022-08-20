<?php

namespace App;

use Exception;

class Page {

    /**
     * @var Site
     */
    private $site;

    /**
     * @var Renderer
     */
    private $renderer;

    private $data = [];

    private static $instance;

    private function __construct() {
        $this->site = Site::get();
        $this->renderer = new Renderer($this);

        $filePath = realpath(dirname($_SERVER["SCRIPT_FILENAME"]));
        if ($filePath !== realpath(PUBLIC_ROOT)) {
            $this->setId(basename($filePath));
        } else {
            $this->setId("home");
        }
    }

    public static function get(): Page {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setId(string $id): void {
        $this->data["id"] = $id;

        $this->setUpGlobalData();

        $extension = $this->site->useDevAssets() ? "js" : "min.js";

        $this->addScript("/assets/js/global.$extension");

        $pageScript = new File("/assets/js/$id.$extension");
        if ($pageScript->exists()) {
            $this->addScript($pageScript->getPath());
        }
    }

    /**
     * @param $method string
     * @param $arguments array
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $method, array $arguments) {
        if (strpos($method, "render") === 0 && is_callable([$this->renderer, $method])) {
            return call_user_func_array([$this->renderer, $method], $arguments);
        }

        throw new Exception("No method found for $method");
    }

    public function __set(string $field, $value) {
        if ($field === "id" && ($this->data[$field] ?? null) !== $value) {
            $this->setId($value);
            return;
        }

        $this->data[$field] = $value;
    }

    public function __get(string $field) {
        return $this->data[$field] ?? null;
    }

    public function __isset(string $field): bool {
        if (array_key_exists($field, $this->data)) {
            return isset($this->data[$field]);
        }

        return false;
    }

    private function getInlineStylesheetsForPage(): array {
        return [
            "/assets/css/above-the-fold." . ($this->site->useDevAssets() ? "css" : "min.css"),
        ];
    }

    private function getStylesheetsForPage(): array {
        return [];
    }

    public function getDeferredStylesheetsForPage(): array {
        $pageId = $this->data["id"];

        $extension = $this->site->useDevAssets() ? "css" : "min.css";

        $stylesheets = [
            ["src" => "/assets/css/global.$extension"],
        ];

        $pageScript = new File("/assets/css/$pageId.$extension");
        if ($pageScript->exists()) {
            $stylesheets[] = ["src" => $pageScript->getPath()];
        }

        // Only some pages use Font Awesome, so only add if it uses it
        $pagesUsingFA = [
            "home", "portfolio",
        ];
        if (in_array($pageId, $pagesUsingFA)) {
            $stylesheets[] = [
                "src" => "/assets/css/third-party/font-awesome.min.css",
                "version" => "5.10.0",
            ];
        }

        return $stylesheets;
    }

    private function setUpGlobalData(): void {
        $url = "/";

        $filePath = realpath(dirname($_SERVER["SCRIPT_FILENAME"]));
        if ($filePath !== realpath(PUBLIC_ROOT)) {
            $url = dirname($_SERVER["SCRIPT_NAME"]);
        }

        $this->data["indexed"] = $this->site->isProduction();
        $this->data["currentURL"] = $this->site->makeURL($url, false);
        $this->data["inlineStylesheets"] = $this->getInlineStylesheetsForPage();
        $this->data["stylesheets"] = $this->getStylesheetsForPage();
        $this->data["deferredStylesheets"] = $this->getDeferredStylesheetsForPage();
        $this->data["jsGlobals"] = [
            "breakpoints" => load(JPI_SITE_ROOT . "/config/breakpoints.json", false)->getArray(),
        ];
        $this->data["scripts"] = [];
        $this->data["inlineJS"] = "";
        $this->data["onLoadInlineJS"] = "";
        $this->data["jsTemplates"] = [];
    }

    public function addPageData(array $newPageData): void {
        $this->data = array_replace_recursive($this->data, $newPageData);
    }

    public function addJSGlobal(string $global, ?string $subKey, $value): void {
        if ($subKey) {
            $this->data["jsGlobals"][$global][$subKey] = $value;
        }
        else {
            $this->data["jsGlobals"][$global] = $value;
        }
    }

    public function addInlineJS(string $code, bool $isOnLoad = false): void {
        $code = trim($code);
        if ($isOnLoad) {
            $this->data["onLoadInlineJS"] .= $code;
        }
        else {
            $this->data["inlineJS"] .= $code;
        }
    }

    public function addScript(string $src, string $version = null): void {
        $this->data["scripts"][] = ["src" => $src, "version" => $version];
    }

    public function addJSTemplate(string $name, string $template): void {
        $this->data["jsTemplates"][$name] = $template;
    }
}
