# Bilgilendirme

> aktif olarak dökümantasyonu yazmaya devam ediyorum. şimdilik baya uzun sürecek gibi. bitirdikten sonra ingilizce versiyonunu da paylaşırım.
>
> **son değişiklik**: 07.05.2026
>
> <br/>
> <br/>
>
> admin paneli olarak maalesef voyager kullandığım için repo içerisinde bir .sql dosyası da paylaşmam zorunlu. şimdilik paylaşabileceğim demo bir .sql dosyası yok. ilerde halledeceğim.
>
> <br/>
> <br/>

---

# 📋 MODÜL LİSTESİ

## Gelişmiş Modüller

Gelişmiş Modüller, kendilerine ait detay sayfaları olan modüllerdir. Site içerisinde kullanmayacağınız modülleri kesinlikle sistemden temizlemeniz gerekir. temizliği düzgün yapmazsanız, "_SitemapController_", "_GlobalSearchController_" ve "_SlugResolverService_" gibi servisler hatalı çalışır.

`pages`, `categories`, `products`, `blogs`, `news`, `projects`, `references`

## Basit Modüller

Basit Modüller genellikle site içerisindeki belirli alanlarda görsel içerik ve bileşen render etmek için kullanılır. yeni bir projeye başlarken kullanmayacağınız modülleri sistemden temizlemeniz önerilir.

`brands`, `certificates`, `contacts`, `counters`, `photos`, `popups`, `sliders`, `social_medias`, `testimonials`, `videos`, `faqs`

## Diğer

301 yönlendirmeleri yapabilmek için tüm sistemden bağımsız sabit bir modül.

`redirect_301s`

# ✨ YENİ BİR PROJEYE BAŞLARKEN;

## 🧹 TEMİZLİK ADIMLARI

**Not**: Bu şablonu ilk defa kullanıyorsanız, temizlik bitene kadar asla "_yeni bir modül eklemeyin_" veya "_mevcut bir modüle yeni alan eklemeyin_" sadece temizliğe odaklanın.

### _1. Adım_: "Veritabanı Temizliği"

Site içerisinde kullanmayacağınız modüllere ait tabloları `phpMyAdmin` üzerinden tamamen silin.

Elinizdeki modüllerin içerisine girip istemediğiniz alanları veritabanından silin. ya da sadece `Voyager BREAD` sekmesinden gizleyin. "_oem_no_", "_barcode_", "_banner_" vs.

### _2. Adım_: "Voyager Menu Builder"

Sildiğiniz modülleri, `Voyager Menu Builder` sekmesinden kaldırın.

### _3. Adım_: "Voyager BREAD"

Elinizdeki modüllerin içerisinde, websitesinin ihtiyacına göre "_oem_no_", "_barcode_", "_banner_" vs. sitede içeriği olmayan alanları gizleyin.

### _4. Adım_: "Voyager Dashboard"

Dashboard kısmında her modül için `aktif/pasif` sayaçları var. Kullanılmayan modülleri `$models = [ ... ]` içerisinden silin.

`resources/views/vendor/voyager/index.blade.php`

### _5. Adım_: "AppServiceProvider"

`app/Providers/AppServiceProvider.php` dosyasında, kullanmadığınız modülleri `$modelsToWatch = [ ... ]` içerisinden silin.

En üst kısımdaki "_Models_" importlarını da unutmayın.

### _6. Adım_: "SitemapController"

`app/Http/Controllers/SitemapController.php` dosyasında, kullanmadığınız modülleri `generate() { .... }` içerisinden silin.

En üst kısımdaki "_Models_" importlarını da unutmayın.

### _7. Adım_: "SlugResolverService"

`app/Services/SlugResolverService.php` dosyasında, temizlenmesi gereken 5 tane kod bloğu var. kesinlikle hata yapılmamalı.

**9. Satır**

```
use App\Models\Page;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;

use App\Resolvers\PageResolver;
use App\Resolvers\ProductResolver;
use App\Resolvers\CategoryResolver;
use App\Resolvers\BlogResolver;
use App\Resolvers\NewsResolver;
use App\Resolvers\ProjectResolver;
use App\Resolvers\ReferenceResolver;
```

**30. Satır**

```
protected $resolverMap = [
    'page' => PageResolver::class,
    'category' => CategoryResolver::class,
    'product' => ProductResolver::class,
    'blog' => BlogResolver::class,
    'news' => NewsResolver::class,
    'project' => ProjectResolver::class,
    'reference' => ReferenceResolver::class,
];
```

**115. Satır**

```
$translation = DB::table('translations')
    ->whereIn('table_name', ['pages', 'categories', 'products', 'blogs', 'news', 'projects', 'references'])
```

**135. Satır**

```
protected function checkCrossLanguageRedirect($slug, $targetLocale)
{
    .
    .
    .
    switch ($translation->table_name)
    {
        case 'pages':
        case 'categories':
        case 'products':
        case 'blogs':
        case 'news':
        case 'projects':
        case 'references':
    }
}
```

**201. Satır**

```
protected function findMatches($slug, $locale)
{
    ...
}
```

### _8. Adım_: "GlobalSearchController"

`app/Http/Controllers/GlobalSearchController.php` dosyasında, temizlenmesi gereken 3 tane kod bloğu var.

**3. Satır**: `Models`

**42. Satır**: `'labels' => [ ... ] `

**70. Satır**: `return [ ... ]`

### _9. Adım_: "Ambiguity Page"

`resources/views/pages/ambiguity.blade.php` dosyasında, temizlenmesi gereken 2 tane kod bloğu var.

**51. Satır**

**102. Satır**

### _10. Adım_: "Cache Strategy"

`config/cache_strategy.php` dosyasını, isteğe bağlı olarak çöp kod bırakmamak için temizleyebilirsiniz.

**44. Satır**: `Resolvers`

**52. Satır**: `ViewModels`

### _11. Adım_: "NavigationService"

Navbar ve Footer alanları sabit olarak bütün sayfalarda render edildiği için, performans amaçlı olarak `AppServiceProvider.php` içerisinde Compose ediliyor.

Navbar ve Footer içerisinde varsayılan olarak "_social_medias_", "_news_" gibi modüller kullanılıyor. eğer bu modülleri sildiyseniz Navbar ve Footer'dan da bağlantılarını yok edin.

- `app/Services/NavigationService.php`

- `app/Http/View/Composers/NavigationComposer.php`

- `app/Http/View/Composers/FooterComposer.php`

### _12. Adım_: "Lang/ Klasörü"

`lang/` klasörünü, isteğe bağlı olarak çöp kod bırakmamak için temizleyebilirsiniz.

- `lang/tr/routes.php`
- `lang/en/routes.php`
- `lang/tr/ui.php`
- `lang/en/ui.php`

### _13. Adım_: "Çöp Dosyalar"

Kullanmayacağınız modüllere ait dosyaları tamamen yok edin.

- `app/Http/Controllers`

- `app/Resolvers`

- `app/ViewModels`

- `resources/views/pages`

### _14. Adım_: "Çöp Kodlar"

`app/Services/CatalogService.php` ve `app/ViewModels/PageViewModel.php` Dosyalarını hızlıca gözden geçirip, kullanılmayan modüllere ait fonksiyonları temizleyin.

### _15. Adım_: "ViewModels/ Klasörü"

Diyelim ki, `blogs` modülünde istemediğiniz bir alanı veritabanı üzerinden sildiniz. Sildiğiniz alana ait fonksiyonu `app/ViewModels/BlogViewModel.php` dosyasından da silin.

## ⚙️ MEVCUT MODÜLLERE YENİ ALAN EKLEME

diyelim ki, `products` modülüne bir "_price_" alanı ekleyeceğiz.

### _1. Adım_: "Tabloya Yeni Alan Ekleme"

`phpMyAdmin` içerisinde products tablosu için bir "_price_" alanı oluşturun.

### _2. Adım_: "Voyager BREAD"

`Voyager BREAD` sekmesinde "_price_" alanı için FieldType ve diğer ayarlamaları yapın.

### _3. Adım_: "Voyager edit-add.blade"

Voyager edit-add formundaki tab yapısını düzenlemek için price alanının hangi kategoriye dahil edileceğini seçin.

`resources/views/vendor/voyager/bread/edit-add.blade.php`

```
$tabConfiguration = [ ... ]
```

### _4. Adım_ "ViewModel Dosyası"

Mevcut `ProductViewModel.php` dosyanızda "_price_" alanı için basit bir fonksiyon oluşturun.

```
public function getPrice()
{
    return $this->product->price;
}
```

**Neden Bunu Yapıyoruz?**

- **Mimari Standart ve Tutarlılık**: Sistem genelinde `getSeoTitle()` veya `getMetaDescription()` gibi karmaşık fallback mantığı gerektiren alanları standartlaştırıyor. Bu sayede tüm projelerde %100 tutarlı bir veri akışı sağlıyor ve geliştirici hatalarını sıfıra indiriyor.

- **Akıllı Fallback Mekanizması**: ViewModel sayesinde `getImage()` veya `getVideo()` gibi fonksiyonlar, öncelikle "_image_url_" gibi harici kaynakları kontrol eder; veri bulunamazsa otomatik olarak yerel yüklemelere (image/video) yönlenir. Bu mantık Blade tarafını kirletmeden arka planda çözülür.

- **Karmaşık Veri Yönetimi**: `getGallery()` gibi JSON dönen alanlar, Blade tarafına ulaşmadan önce otomatik olarak decode edilir. Hatta `getGallery(3)` örneğinde olduğu gibi, sadece ihtiyaç duyulan elemanı da döndürebilmenizi de sağlar.

**ViewModel Kullanmak İstemiyorsanız;**

İlk olarak kesinlikle `ViewModels` katmanı ile çalışmanızı öneriyorum. buna alışık değilseniz bile biraz kullandıktan sonra hemen alışacak ve seveceksiniz.

Ama eğer kullanmak istemiyorsanız `ViewModels` katmanında sadece `getModel()` fonksiyonlarını oluşturup, .blade tarafında alışık olduğunuz şekilde devam edebilirsiniz.

```
// ProductViewModel.php

public function getModel()
{
    return $this->product;
}
```

```
// product-detail.blade.php

@php
    $product = $viewModel->getModel();
@endphp

<p> {{ $product->price }} </p>

<p> {{ $product->getTranslatedAttribute('name') }} </p>
```

## ⚒️ SIFIRDAN BASİT MODÜL EKLEME

Diyelim ki, sıfırdan bir `testimonials` modülü yazacağız.

### _1. Adım_: "Tablo Oluşturma"

`phpMyAdmin` içerisinden veya bir migration yazarak, "testimonials" tablosu oluşturun ve içerisine gerekli alanları ekleyin.

`id`, `status`, `order`, `name`, `comment`, `image`, `image_url`, `created_at`, `updated_at`

**Not**: "_id_", "_status_", "_order_", "_created_at_" ve "_updated_at_" alanlarını kesinlikle oluşturacağınız bütün modüller için ekleyin. Bu hem tutarlılık için çok önemli hem de sistem genelindeki yardımcı fonksiyonların bu alanlara bağımlılığı bulunmaktadır

**Ne zaman bu alanları eklememelisiniz?** "_İletişim Formu_" veya "_Newsletter Aboneliği_" gibi sistemleri modüllere bağlamak isterseniz, "status" ve "order" alanlarına gerek yok.

### _2. Adım_: "Model Oluşturma"

`app/Models/Testimonial.php` dosyası oluşturun ve gerekli ayarlamaları yapın. şuanda sadece Translatable alanları ayarlayacağız.

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Testimonial extends Model
{
    use Translatable;

    protected $table = 'testimonials';

    protected $translatable = [
        'title',
        'comment'
    ];
}
```

### _3. Adım_: "Voyager BREAD"

`Voyager BREAD` üzerinden `testimonials` için BREAD oluşturduktan sonra gerekli FiledType ve diğer ayarlamaları yapın.

### _4. Adım_: "Voyager edit-add.blade"

`resources/views/vendor/voyager/bread/edit-add.blade.php` dosyasında `testimonials` tablosu için oluşturduğunuz alanları, Tab yapısı için istediğiniz gibi kategorize edin.

```
$tabConfiguration = [ ... ]
```

### _5. Adım_: "Voyager Dashboard"

`resources/views/vendor/voyager/index.blade.php` dosyasında yeni oluşturduğunuz "Model" dosyasını `$models = [ ... ]` içerisine ekleyin.

### _6. Adım_: "Lang/ Klasörü"

Voyager Dashboard'ında Sayaç başlıklarını gösterebilmek için aşağıdaki dosyalara eklemeler yapın.

- `lang/tr/admin.php`

```
'testimonials' => 'Müşteri Yorumları'
```

- `lang/en/admin.php`

```
'testimonials' => 'Testimonials'
```

**Not**: Sistem varsayılan olarak `/tr` ve `/en` dillerinde geliyor. yeni bir dil ekledikten sonra `/en` klasörünü kopyalayıp yeni dil için değiştirerek kullanabilirsiniz.

### _7. Adım_: "AppServiceProvider"

`app/Providers/AppServiceProvider.php` dosyasında `testimonials` için oluşturduğunuz modeli de diğer modeller gibi `$modelsToWatch = [ ... ]` içerisine ekleyin.

```
use App\Models\Testimonial;

$modelsToWatch = [
    Testimonial::class,
];
```

### _8. Adım_: "Cache Anahtarı"

`config/cache_strategy.php` dosyasında yeni bir anahtar oluşturun.

```
'page_vm_testimonials' => [
    'key' => 'viewmodel.page.testimonials.%s',
    'ttl' => 86400
],
```

Bu basit modül örneğinde anahtarın sonuna tek bir "**.%s**" parametresi ekledik.

Sisteme **['tr']** parametresi gönderilirse cache anahtarı: "**testimonials.tr**" olur.

Sisteme **['en']** parametresi gönderilirse cache anahtarı: "**testimonials.en**" olur.

### _9. Adım_: "ViewModel Dosyası"

`app/ViewModels/TestimonialViewModel.php` dosyası oluşturun.

```
<?php

namespace App\ViewModels;

use App\Models\Testimonial;
use App\Traits\ResolvesVoyagerFile;

class TestimonialViewModel
{
    use ResolvesVoyagerFile;

    protected $testimonial;
    protected $locale;
    protected $translation;

    public function __construct(Testimonial $testimonial, $locale)
    {
        $this->testimonial = $testimonial;
        $this->locale = $locale;
        $this->translation = $testimonial->translate($locale);
    }

    public function getModel()
    {
        return $this->testimonial;
    }

    public function getName()
    {
        return $this->testimonial->name ?? null;
    }

    public function getTitle()
    {
        return $this->translation->title ?? $this->testimonial->title ?? null;
    }

    public function getComment()
    {
        return $this->translation->comment ?? $this->testimonial->comment ?? null;
    }

    public function getImage(): ?string
    {
        if (!empty($this->testimonial->image_url)) {
            return $this->testimonial->image_url;
        }

        return $this->resolveFileUrl($this->testimonial->image) ?? null;
    }
}
```

### _10. Adım_: "CatalogService"

`app/Services/CatalogService.php` dosyasında merkezi bir `getTestimonials()` fonksiyonu oluşturun.

```
use App\Models\Testimonial;
use App\ViewModels\TestimonialViewModel;

public function getTestimonials(string $locale, int $limit = null): Collection
{
    $testimonials = $this->cacheManager->remember('page_vm_testimonials', [$locale], function () use ($locale) {
        $raw = Testimonial::where('status', 1)->orderBy('order', 'asc')->with('translations')->get();
        return $raw->map(fn($item) => new TestimonialViewModel($item, $locale));
    });

    return $limit ? $testimonials->take($limit) : $testimonials;
}
```

**Neden Bunu Yapıyoruz?**

"_status_", "_order_", "_translations_", "_limit_" ve "_cache_" kontollerini merkezi bir fonksiyonda topluyoruz. Bu sayede sistemin farklı yerlerinde yapılabilecek olası mantık hatalarını (örneğin; pasif verilerin yanlışlıkla listelenmesi veya cache'in unutulması gibi) tamamen ortadan kaldırıyoruz."

### _11. Adım_: "PageViewModel"

Verileri `pages/` klasörüne gönderebilmek için `app/ViewModels/PageViewModel.php` dosyasında `getTestimonials()` fonksiyonu oluşturun.

```
public function getTestimonials($limit = null): Collection
{
    return $this->catalogService->getTestimonials($this->locale, $limit);
}
```

### _12. Adım_: "Site İçerisinde Kullanma"

Artık `resources/views/pages` içerisinde temiz ve formatlanmış `testimonials` modülüne erişebilirsiniz.

```
@php
    $testimonials = $viewModel->getTestimonials(3); // Limit 3
@endphp

@if($testimonials->isNotEmpty())

        <div class="grid">

            @foreach($testimonials as $item)

                <div class="box">

                        <b> {{ $item->getName() }} </b>

                        <p> {{ $item->getComment() }} </p>

                        <img src="{{ $item->getImage() }}" />

                </div>

            @endforeach

        </div>

@else

    <p> no added yet. </p>

@endif
```

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

---

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

## ⚒️ SIFIRDAN GELİŞMİŞ MODÜL EKLEME

bu kısma vakit buldukça devam edicem. 06.05.2026

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

---

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

# Helpers

**Dosya:** `app/Helpers/helpers.php`

Voyager'dan gelen dosya verilerini URL'ye dönüştüren global fonksiyonlar. Blade şablonlarında doğrudan kullanılır.

## `rvf($fileData)` — Resolve Voyager File

Voyager dosya verisini URL'ye çözümler. Setting key, JSON, ham yol ve harici URL destekler. Tek dosyada `string`, çoklu dosyada `array` döner.

```
<video src="{{ rvf('documents.intro_video') }}"></video>

<a href="{{ rvf($product->file_pdf) }}">Download</a>
```

## `rvfs($fileData)` — Resolve Voyager File Single

`rvf()` ile aynı mantık, ancak **her zaman tek URL** (`string|null`) döner. Çoklu sonuçlarda ilk elemanı alır.

```
<img src="{{ rvfs('site.logo') }}" />
```

# Traits

## ResolvesVoyagerFile

**Dosya:** `app/Traits/ResolvesVoyagerFile.php`

ViewModel sınıflarında Voyager dosya alanlarının URL çözümlemesini merkezileştiren trait. Tüm ViewModel'ler tarafından kullanılır.

### `resolveFileUrl($fileData): ?string`

Tekil dosya alanları (`image`, `banner`, `video`) için. JSON decode eder, `download_link` veya path'i `Voyager::image()` ile URL'ye çevirir.

```php
return $this->resolveFileUrl($this->blog->image);
```

### `resolveGalleryUrls($galleryJSON, ?int $index = null): Collection|string|null`

Galeri alanları (`image_gallery`, `video_gallery`) için. Hem basit path dizilerini hem `download_link` objeli dizileri destekler. `$index` verilirse o elemandaki URL'yi, verilmezse tüm URL'leri `Collection` olarak döner.

```php
return $this->resolveGalleryUrls($this->blog->image_gallery, $index);
```
