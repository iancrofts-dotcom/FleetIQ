<div class="dashboard" role="img" aria-label="Conceptual FleetIQ dashboard with illustrative fleet totals, due dates, defects, workshop jobs and recent activity.">
    <aside class="dash-sidebar" aria-hidden="true">
        <?php brand(); ?>
        <div class="dash-workspace">YOUR WORKSPACE <span>⌄</span></div>
        <?php foreach (['grid' => 'Overview', 'vehicle' => 'Vehicles', 'users' => 'Drivers', 'shield' => 'Compliance', 'calendar' => 'Calendar', 'document' => 'Documents', 'tool' => 'Workshop', 'chart' => 'Reports'] as $symbol => $label): ?>
        <div class="dash-nav <?= $label === 'Overview' ? 'selected' : '' ?>"><?php icon($symbol); ?><?= $label ?></div>
        <?php endforeach; ?>
        <div class="dash-profile"><span>FM</span><div>Fleet Manager<small>Workspace administrator</small></div></div>
    </aside>
    <div class="dash-content" aria-hidden="true">
        <div class="dash-topline"><span>Workspace <b>/ Overview</b></span><span class="dash-live">● Example workspace</span></div>
        <div class="dash-heading"><div><p class="dash-title">Your fleet at a glance</p><p>Here's what needs your attention today.</p></div><span class="dash-date"><?php icon('calendar'); ?> 14 September 2026</span></div>
        <div class="dash-stats">
            <div><span>Total vehicles <?php icon('vehicle'); ?></span><strong>48</strong><small>Across your fleet</small></div>
            <div><span>Due soon <?php icon('calendar'); ?></span><strong>8 <i class="stat-dot amber"></i></strong><small>In the next 30 days</small></div>
            <div><span>Overdue <?php icon('bell'); ?></span><strong>3 <i class="stat-dot red"></i></strong><small>Requires attention</small></div>
            <div><span>Workshop <?php icon('tool'); ?></span><strong>5</strong><small>Open repair jobs</small></div>
        </div>
        <div class="dash-panels">
            <div class="dash-panel"><div class="panel-title">Upcoming dates <span>Next 30 days</span></div>
                <div class="dash-table"><div class="table-row table-head"><span>VEHICLE / DRIVER</span><span>REQUIREMENT</span><span>STATUS</span></div>
                <div class="table-row"><b>FQ26 ABC<small>Ford Transit</small></b><span>MOT<small>18 Sep 2026</small></span><span class="badge amber">Due soon</span></div>
                <div class="table-row"><b>FQ24 DEF<small>Mercedes-Benz Sprinter</small></b><span>Service<small>22 Sep 2026</small></span><span class="badge amber">Due soon</span></div>
                <div class="table-row"><b>Example driver<small>Driver record</small></b><span>Driving licence<small>11 Sep 2026</small></span><span class="badge red">Overdue</span></div>
                <div class="table-row"><b>FQ25 GHI<small>DAF LF</small></b><span>Inspection<small>25 Sep 2026</small></span><span class="badge blue">Scheduled</span></div></div>
            </div>
            <div class="dash-panel"><div class="panel-title">Fleet status <span>48 vehicles</span></div><div class="fleet-status"><div class="donut"><div><strong>42</strong><small>On the road</small></div></div><div class="chart-key"><span><i></i>On the road <b>42</b></span><span><i></i>In workshop <b>5</b></span><span><i></i>Off road <b>1</b></span></div></div></div>
        </div>
        <div class="dash-bottom"><div><span class="mini-icon"><?php icon('tool'); ?></span><span><b>2 open defects</b><small>Review and assign a repair</small></span></div><div><span class="mini-icon green"><?php icon('check'); ?></span><span><b>Inspection completed</b><small>FQ26 ABC · Recent activity</small></span></div><span class="dash-view">Your fleet. Connected. <?php icon('arrow'); ?></span></div>
    </div>
</div>
