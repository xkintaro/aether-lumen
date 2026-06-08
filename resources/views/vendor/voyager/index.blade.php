@extends('voyager::master')

@section('page_title', __('admin.dashboard'))

@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="voyager-home"></i> {{ __('admin.dashboard') }}
    </h1>
</div>

@stop
@section('content')
@php
    function getActiveCount($model)
    {
        try {
            return $model::where('status', 1)->count();
        } catch (\Exception $e) {
            return $model::count();
        }
    }

    $models = [
        'products' => [
            'label' => __('admin.products'),
            'total' => \App\Models\Product::count(),
            'active' => getActiveCount(\App\Models\Product::class),
            'color' => '#48B0F7',
            'icon' => 'voyager-shop',
        ],
        'categories' => [
            'label' => __('admin.categories'),
            'total' => \App\Models\Category::count(),
            'active' => getActiveCount(\App\Models\Category::class),
            'color' => '#F55145',
            'icon' => 'voyager-archive',
        ],
        'pages' => [
            'label' => __('admin.pages'),
            'total' => \App\Models\Page::count(),
            'active' => getActiveCount(\App\Models\Page::class),
            'color' => '#10CFBD',
            'icon' => 'voyager-file-text',
        ],
        'news' => [
            'label' => __('admin.news'),
            'total' => \App\Models\News::count(),
            'active' => getActiveCount(\App\Models\News::class),
            'color' => '#FF9800',
            'icon' => 'voyager-news',
        ],
        'blogs' => [
            'label' => __('admin.blogs'),
            'total' => \App\Models\Blog::count(),
            'active' => getActiveCount(\App\Models\Blog::class),
            'color' => '#E65100',
            'icon' => 'voyager-browser',
        ],
        'projects' => [
            'label' => __('admin.projects'),
            'total' => \App\Models\Project::count(),
            'active' => getActiveCount(\App\Models\Project::class),
            'color' => '#673AB7',
            'icon' => 'voyager-folder',
        ],
        'references' => [
            'label' => __('admin.references'),
            'total' => \App\Models\Reference::count(),
            'active' => getActiveCount(\App\Models\Reference::class),
            'color' => '#009688',
            'icon' => 'voyager-plug',
        ],
        'testimonials' => [
            'label' => __('admin.testimonials'),
            'total' => \App\Models\Testimonial::count(),
            'active' => getActiveCount(\App\Models\Testimonial::class),
            'color' => '#E91E63',
            'icon' => 'voyager-bubble',
        ],
        'brands' => [
            'label' => __('admin.brands'),
            'total' => \App\Models\Brand::count(),
            'active' => getActiveCount(\App\Models\Brand::class),
            'color' => '#ABEDFF',
            'icon' => 'voyager-diamond',
        ],
        'photos' => [
            'label' => __('admin.photos'),
            'total' => \App\Models\Photo::count(),
            'active' => getActiveCount(\App\Models\Photo::class),
            'color' => '#4CAF50',
            'icon' => 'voyager-photos',
        ],
        'videos' => [
            'label' => __('admin.videos'),
            'total' => \App\Models\Video::count(),
            'active' => getActiveCount(\App\Models\Video::class),
            'color' => '#03A9F4',
            'icon' => 'voyager-video',
        ],
        'sliders' => [
            'label' => __('admin.sliders'),
            'total' => \App\Models\Slider::count(),
            'active' => getActiveCount(\App\Models\Slider::class),
            'color' => '#F8CB00',
            'icon' => 'voyager-tv',
        ],
        'certificates' => [
            'label' => __('admin.certificates'),
            'total' => \App\Models\Certificate::count(),
            'active' => getActiveCount(\App\Models\Certificate::class),
            'color' => '#FFC107',
            'icon' => 'voyager-certificate',
        ],
        'popups' => [
            'label' => __('admin.popups'),
            'total' => \App\Models\Popup::count(),
            'active' => getActiveCount(\App\Models\Popup::class),
            'color' => '#607D8B',
            'icon' => 'voyager-megaphone',
        ],
        'faqs' => [
            'label' => __('admin.faqs'),
            'total' => \App\Models\Faqs::count(),
            'active' => getActiveCount(\App\Models\Faqs::class),
            'color' => '#4CAF50',
            'icon' => 'voyager-question',
        ],
        'counters' => [
            'label' => __('admin.counters'),
            'total' => \App\Models\Counter::count(),
            'active' => getActiveCount(\App\Models\Counter::class),
            'color' => '#9966FF',
            'icon' => 'voyager-dashboard',
        ],
        'social_medias' => [
            'label' => __('admin.social_medias'),
            'total' => \App\Models\SocialMedia::count(),
            'active' => getActiveCount(\App\Models\SocialMedia::class),
            'color' => '#3F51B5',
            'icon' => 'voyager-phone',
        ],
        'redirect_301s' => [
            'label' => __('admin.redirect_301s'),
            'total' => \App\Models\Redirect301::count(),
            'active' => getActiveCount(\App\Models\Redirect301::class),
            'color' => '#F8CB00',
            'icon' => 'voyager-paper-plane',
        ],
    ];

    foreach ($models as $key => $data) {
        $models[$key]['passive'] = $data['total'] - $data['active'];
    }

    $user = \Illuminate\Support\Facades\Auth::user();
    $laravelVersion = app()->version();
    $phpVersion = phpversion();
    $serverIP = url('/');

 @endphp

<div class="page-content container-fluid">
    @include('voyager::alerts')
    @if (setting('admin.dashboard_banner'))
        <img src="{{ Voyager::image(setting('admin.dashboard_banner')) }}" class="dashboard-banner" alt="Admin Banner" />
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-hero">
                <div class="hero-left">
                    <h2 class="hero-welcome-title">
                        {{ __('admin.welcome_user', ['name' => $user->name ?? 'Yönetici']) }}
                    </h2>
                    <p class="hero-welcome-desc">
                        {{ __('admin.welcome_description') }}
                    </p>
                    <div class="system-badges">
                        <div class="sys-badge" title="Laravel Framework Version">
                            <i class="voyager-code"></i> <span>Laravel {{ $laravelVersion }}</span>
                        </div>
                        <div class="sys-badge" title="PHP Version">
                            <i class="voyager-diamond"></i> <span>PHP {{ $phpVersion }}</span>
                        </div>
                        <a href="{{ $serverIP }}" target="_blank" class="sys-badge" title="Sunucu IP"
                            style="text-decoration: none;">
                            <i class="voyager-harddrive"></i> <span>{{ $serverIP }}</span>
                        </a>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="cache-card">
                        <div class="cache-header">
                            <div class="cache-icon-box">
                                <i class="voyager-rocket"></i>
                            </div>
                            <div class="cache-info">
                                <span class="cache-title">{{ __('admin.quick_actions') }}</span>
                                <span class="cache-subtitle">{{ __('admin.system_maintenance') }}</span>
                            </div>
                        </div>
                        <p class="cache-desc">
                            {{ __('admin.cache_clear_desc') }}
                        </p>
                        <a href="{{ route('admin.clear-cache') }}" class="btn-optimize">
                            <i class="voyager-refresh"></i> {{ __('admin.clear_cache') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($models as $key => $data)
            <div class="col-lg-3">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <i class="{{ $data['icon'] }} stat-icon" style="color: {{ $data['color'] }};"></i>
                        <span class="stat-label">{{ $data['label'] }}</span>
                    </div>
                    <div class="stat-chart-wrapper">
                        <canvas id="chart-{{ $key }}"></canvas>
                        <div class="stat-chart-center">
                            <span class="stat-total-val">{{ $data['total'] }}</span>
                            <span class="stat-total-lbl">{{ __('admin.total') }}</span>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <div class="stat-footer-item bordered-right">
                            <span class="stat-val" style="color: {{ $data['color'] }};">{{ $data['active'] }}</span>
                            <span class="stat-lbl">{{ __('admin.active') }}</span>
                        </div>
                        <div class="stat-footer-item">
                            <span class="stat-val passive-color">{{ $data['passive'] }}</span>
                            <span class="stat-lbl">{{ __('admin.passive') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
    var chartData = @json($models);
    Chart.defaults.global.defaultFontFamily = "'Open Sans', sans-serif";
    Chart.defaults.global.legend.display = false;
    Object.keys(chartData).forEach(function (key) {
        var data = chartData[key];
        var ctx = document.getElementById('chart-' + key).getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __('admin.active') }}', '{{ __('admin.passive') }}'],
                datasets: [{
                    data: [data.active, data.passive],
                    backgroundColor: [
                        data.color,
                        '#f1f1f1'
                    ],
                    borderWidth: 0,
                    hoverBorderWidth: 4,
                    hoverBorderColor: '#fff'
                }]
            },
            options: {
                cutoutPercentage: 75,
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: true,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[0].data[tooltipItem.index];
                            return ' ' + label + ': ' + value;
                        }
                    }
                }
            }
        });
    });
</script>
@stop