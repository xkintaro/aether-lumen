<?php

return [
    'sitemap' => [
        'key' => 'site.sitemap_xml',
        'ttl' => 604800,
    ],

    'menu' => [
        'key' => 'menu.%s',
        'ttl' => 604800,
    ],

    'footer_data' => [
        'key' => 'layout.footer_data.%s',
        'ttl' => 604800,
    ],

    'homepage' => [
        'key' => 'site.homepage.%s',
        'ttl' => 604800,
    ],

    'resolver_matches' => [
        'key' => 'resolver.matches.%s.%s',
        'ttl' => 86400,
    ],

    'resolver_redirect' => [
        'key' => 'resolver.redirect.%s.%s',
        'ttl' => 86400,
    ],

    'page_route' => [
        'key' => 'page_route_%s',
        'ttl' => 86400,
    ],

    'page_by_slugs' => [
        'key' => 'page_by_slugs.%s.%s',
        'ttl' => 86400,
    ],

    'page_resolver' => ['key' => 'resolver.page.%s.%s', 'ttl' => 86400],
    'product_resolver' => ['key' => 'resolver.product.%s.%s', 'ttl' => 86400],
    'category_resolver' => ['key' => 'resolver.category.%s.%s', 'ttl' => 86400],
    'blog_resolver' => ['key' => 'resolver.blog.%s.%s', 'ttl' => 86400],
    'news_resolver' => ['key' => 'resolver.news.%s.%s', 'ttl' => 86400],
    'project_resolver' => ['key' => 'resolver.project.%s.%s', 'ttl' => 86400],
    'reference_resolver' => ['key' => 'resolver.reference.%s.%s', 'ttl' => 86400],

    'category_vm_products' => ['key' => 'viewmodel.category.products.%s.%s', 'ttl' => 86400],
    'page_vm_children_content' => ['key' => 'viewmodel.page.children.%s.%s', 'ttl' => 86400],
    'page_vm_category_tree' => ['key' => 'viewmodel.page.category_tree.%s', 'ttl' => 86400],
    'page_vm_products' => ['key' => 'viewmodel.page.products.%s', 'ttl' => 86400],
    'page_vm_categories' => ['key' => 'viewmodel.page.categories.%s', 'ttl' => 86400],

    'page_vm_sliders' => ['key' => 'viewmodel.page.sliders.%s', 'ttl' => 86400],
    'page_vm_counters' => ['key' => 'viewmodel.page.counters.%s', 'ttl' => 86400],
    'page_vm_brands' => ['key' => 'viewmodel.page.brands.%s', 'ttl' => 86400],
    'page_vm_blogs' => ['key' => 'viewmodel.page.blogs.%s', 'ttl' => 86400],
    'page_vm_news' => ['key' => 'viewmodel.page.news.%s', 'ttl' => 86400],
    'page_vm_certificates' => ['key' => 'viewmodel.page.certificates.%s', 'ttl' => 86400],
    'page_vm_popups' => ['key' => 'viewmodel.page.popups.%s', 'ttl' => 86400],
    'page_vm_testimonials' => ['key' => 'viewmodel.page.testimonials.%s', 'ttl' => 86400],
    'page_vm_social_medias' => ['key' => 'viewmodel.page.social_medias.%s', 'ttl' => 86400],
    'page_vm_projects' => ['key' => 'viewmodel.page.projects.%s', 'ttl' => 86400],
    'page_vm_references' => ['key' => 'viewmodel.page.references.%s', 'ttl' => 86400],
    'page_vm_photos' => ['key' => 'viewmodel.page.photos.%s', 'ttl' => 86400],
    'page_vm_videos' => ['key' => 'viewmodel.page.videos.%s', 'ttl' => 86400],
    'page_vm_faqs' => ['key' => 'viewmodel.page.faqs.%s', 'ttl' => 86400],

    'filter_results' => [
        'key' => 'filter.results.%s',
        'ttl' => 3600,
    ],

    'global_search' => [
        'key' => 'global_search.%s.%s',
        'ttl' => 3600,
    ],

    'redirect_301' => [
        'key' => 'redirect_301s',
        'ttl' => null,
    ],
];
