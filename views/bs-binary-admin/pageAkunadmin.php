<?php
class Page {
    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

    public function renderHeader() {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>" . $this->title . "</title>";
        echo "<link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>";
        echo "</head>";
        echo "<body>";
    }

    public function renderFooter() {
        echo "</body>";
        echo "</html>";
    }
}
?>
