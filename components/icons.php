<?php
function icon(string $name, string $class = ''): void
{
    $paths = [
        'vehicle' => '<path d="M3 7h12v10H3zM15 11h4l3 4v2h-7M6 7V4h6v3"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>',
        'users' => '<circle cx="9" cy="7" r="3"/><path d="M3 21v-3a6 6 0 0 1 12 0v3M16 4a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v2"/>',
        'shield' => '<path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6zM8 12l3 3 5-6"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="3"/><path d="M7 3v5M17 3v5M3 11h18M7 15h3M14 15h3M7 18h3"/>',
        'document' => '<path d="M14 3H5v18h14V8zM14 3v5h5M8 12h8M8 16h6"/>',
        'tool' => '<path d="M14 6a6 6 0 0 0-7 7l-4 4a3 3 0 0 0 4 4l5-5a6 6 0 0 0 7-8l-4 4-3-3 4-4z"/>',
        'check' => '<path d="m5 12 4 4L19 6"/>',
        'inspection' => '<rect x="5" y="4" width="14" height="18" rx="2"/><path d="M9 4V2h6v2M8 13l3 3 5-6"/>',
        'chart' => '<path d="M4 3v18h18M8 16v-4M13 16V8M18 16V5"/>',
        'lock' => '<rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/>',
        'arrow' => '<path d="M4 12h16m-6-6 6 6-6 6"/>',
        'bell' => '<path d="M5 16V9a7 7 0 0 1 14 0v7l2 2H3zM9 21h6"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
        'desktop' => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 22h8M12 17v5"/>',
        'globe' => '<circle cx="12" cy="12" r="10"/><ellipse cx="12" cy="12" rx="4" ry="10"/><path d="M2 12h20"/>',
        'phone' => '<rect x="6" y="2" width="12" height="20" rx="3"/><path d="M10 18h4"/>',
    ];
    echo '<svg class="icon ' . escape($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? $paths['check']) . '</svg>';
}
function brand(): void
{ ?>
<span class="brand"><img src="assets/icons/favicon.svg" width="36" height="40" alt=""><span>Fleet<span class="brand-iq">IQ</span></span></span>
<?php }
