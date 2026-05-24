
<?php
$genSetting = \App\Models\Setting::first();
?>
<div>
    <a href="{{ url('/') }}" class="brand-link" target="__blank">
        <img src="{{ url('storage/' . $genSetting['logo']) }}" alt="Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminPanel</span>
    </a>
</div>