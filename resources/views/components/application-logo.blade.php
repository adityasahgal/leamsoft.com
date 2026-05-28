<?php
$genSetting = \App\Models\Setting::first();
$brandName = $genSetting->site_name ?? $genSetting->name ?? config('app.name', 'LEAMSOFT');
$hasLogo = ! empty($genSetting->logo) && file_exists('storage/' . $genSetting->logo);
?>
<div>
    <a href="{{ url('/') }}" class="brand-link" target="_blank" rel="noopener">
        @if($hasLogo)
            <img src="{{ url('storage/' . $genSetting->logo) }}" alt="{{ $brandName }}"
                class="brand-image img-circle elevation-3" style="opacity: .8">
        @else
            <span class="brand-image img-circle elevation-3 d-inline-flex align-items-center justify-content-center"
                style="background:#fff; color:#343a40; font-weight:700; width:33px; height:33px; font-size:14px;">
                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($brandName, 0, 2)) }}
            </span>
        @endif
        <span class="brand-text font-weight-light">{{ $brandName }}</span>
    </a>
</div>
