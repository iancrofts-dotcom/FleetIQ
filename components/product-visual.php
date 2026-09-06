<figure class="product-visual">
    <?php if ($page['visual'] === 'mobile'): ?>
    <div class="product-devices">
        <div class="product-monitor">
            <div class="product-ui-bar"><?php brand(); ?><span>Windows</span></div>
            <div class="product-ui-body"><h2>Fleet overview</h2><div class="product-record-grid"><div><span>Vehicles</span><strong>Records & dates</strong></div><div><span>Workshop</span><strong>Jobs & history</strong></div></div></div>
        </div>
        <div class="product-monitor-stand" aria-hidden="true"></div>
        <div class="product-browser"><div class="product-ui-bar"><?php icon('globe'); ?><span>Web · Vehicle record</span></div><div class="product-ui-body"><strong>FQ26 ABC</strong><p>Ford Transit · MOT due 18 Sep 2026</p></div></div>
        <div class="product-handset"><span class="phone-speaker" aria-hidden="true"></span><?php brand(); ?><p class="eyebrow">ANDROID · DAILY CHECK</p><strong>FQ26 ABC</strong><p>Ford Transit</p><div class="phone-check"><?php icon('check'); ?> Lights & indicators</div><div class="phone-check"><?php icon('check'); ?> Tyres & wheels</div><div class="phone-check"><?php icon('check'); ?> Mirrors & glass</div><div class="phone-progress">3 of 8 checks complete</div></div>
    </div>
    <?php else: ?>
    <div class="product-ui product-ui-<?= escape($page['visual']) ?>">
        <div class="product-ui-bar"><?php brand(); ?><span><?= escape($page['nav']) ?></span></div>
        <div class="product-ui-body">
            <h2><?= escape($page['visualTitle']) ?></h2><p><?= escape($page['visualIntro']) ?></p>
            <dl class="product-record-grid">
                <?php foreach ($page['fields'] as $field): ?><div><dt><?= escape($field[0]) ?></dt><dd><?= escape($field[1]) ?></dd></div><?php endforeach; ?>
            </dl>
            <div class="product-activity"><h3><?= $page['visual'] === 'reports' ? 'Recorded activity' : ($page['visual'] === 'workshop' ? 'Job progress' : 'Records to review') ?></h3>
                <?php foreach ($page['rows'] as $row):
                    $statusClass = match ($row[2]) {
                        'Due soon', 'To review', 'Outstanding', 'Pending' => 'status-amber',
                        'Overdue' => 'status-red',
                        'Completed', 'Recorded', 'On file' => 'status-green',
                        default => '',
                    };
                ?><div class="product-activity-row"><div><strong><?= escape($row[0]) ?></strong><span><?= escape($row[1]) ?></span></div><span class="product-status <?= escape($statusClass) ?>"><?= escape($row[2]) ?></span></div><?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <figcaption class="visual-caption">Conceptual product view · Illustrative data</figcaption>
</figure>
