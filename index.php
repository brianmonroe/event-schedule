<?php
$config = require 'config.php';
$today = (int)date('Ymd');

$events = array_filter($config['events'], fn($e) => (int)$e['date'] >= $today);
usort($events, fn($a, $b) => strcmp($a['date'], $b['date']));

// SVG icon map
function getIconSvg($type) {
    switch ($type) {
        case 'music':
            return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-2v13"/>
  <circle cx="6" cy="18" r="3" />
</svg>
SVG;
        case 'sports':
            return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 3H8v5a4 4 0 004 4h0a4 4 0 004-4V3zM8 21h8m-8 0v-4a4 4 0 018 0v4"/>
</svg>
SVG;
        case 'other':
        default:
            return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
</svg>
SVG;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($config['site_title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Hero -->
    <header class="bg-white shadow p-6 text-center">
        <img src="<?= htmlspecialchars($config['logo_path']) ?>" alt="Logo" class="mx-auto h-16 mb-2">
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($config['site_title']) ?></h1>
    </header>

    <!-- Events List -->
    <main class="max-w-2xl mx-auto mt-10 px-4">
        <?php if (count($events) === 0): ?>
            <p class="text-center text-gray-500">No upcoming events.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($events as $event): ?>
                    <li class="bg-white shadow p-4 rounded flex items-center space-x-4">
                        <div><?= getIconSvg($event['type']) ?></div>
                        <div>
                            <div class="text-lg font-semibold"><?= htmlspecialchars($event['title']) ?></div>
                            <div class="text-sm text-gray-600"><?= date('F j, Y', strtotime($event['date'])) ?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 mt-10 mb-4">
        All events subject to change.
    </footer>
</body>
</html>
