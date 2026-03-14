@extends('layouts.front')

@section('content')
    @php
        $sections = \App\Models\Section::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    @endphp

    @foreach($sections as $section)
        @php
            $translation = $section->translations
                ->where('language_id', $currentLanguage->id)
                ->first();

            if (!$translation) continue;

            $title = $translation->title ?? '';
            $subtitle = $translation->subtitle ?? '';
            $data = $translation->data ?? [];
        @endphp

        {{-- Hero Section --}}
        @if($section->type == 'hero')
            <section class="hero-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="display-4">{{ $title }}</h1>
                            <p class="lead">{{ $subtitle }}</p>
                            @if(!empty($data['button_text']) && !empty($data['button_url']))
                                <a href="{{ $data['button_url'] }}" class="btn btn-primary btn-lg">
                                    {{ $data['button_text'] }}
                                </a>
                            @endif
                        </div>
                        @if(!empty($data['image']))
                            <div class="col-md-6">
                                <img src="{{ Storage::url($data['image']) }}" alt="{{ $title }}" class="img-fluid rounded">
                            </div>
                        @endif
                    </div>
                </div>
            </section>

        {{-- Features Section --}}
        @elseif($section->type == 'features')
            <section class="features-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['features'] ?? [] as $feature)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 text-center">
                                    <div class="card-body">
                                        @if(!empty($feature['icon']))
                                            <i class="fas fa-{{ $feature['icon'] }} fa-3x mb-3 text-primary"></i>
                                        @endif
                                        <h5>{{ $feature['title'] ?? '' }}</h5>
                                        <p>{{ $feature['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Testimonials Section --}}
        @elseif($section->type == 'testimonials')
            <section class="testimonials-section py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['testimonials'] ?? [] as $testimonial)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        @if(!empty($testimonial['image']))
                                            <img src="{{ Storage::url($testimonial['image']) }}"
                                                 alt="{{ $testimonial['author'] ?? '' }}"
                                                 class="rounded-circle mb-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <p class="card-text">"{{ $testimonial['text'] ?? '' }}"</p>
                                        <footer class="blockquote-footer">{{ $testimonial['author'] ?? '' }}</footer>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Call to Action Section --}}
        @elseif($section->type == 'cta')
            <section class="cta-section py-5 text-white"
                     style="background: {{ $data['background_color'] ?? '#007bff' }}; {{ !empty($data['image']) ? 'background-image: url(' . Storage::url($data['image']) . '); background-size: cover; background-position: center;' : '' }}">
                <div class="container text-center">
                    <h2 class="display-5">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="lead">{{ $subtitle }}</p>
                    @endif
                    @if(!empty($data['button_text']) && !empty($data['button_url']))
                        <a href="{{ $data['button_url'] }}" class="btn btn-light btn-lg mt-3">
                            {{ $data['button_text'] }}
                        </a>
                    @endif
                </div>
            </section>

        {{-- Text Block Section --}}
        @elseif($section->type == 'text')
            <section class="text-section py-5">
                <div class="container">
                    <h2>{{ $title }}</h2>
                    @if($subtitle)
                        <p class="lead">{{ $subtitle }}</p>
                    @endif
                    <div class="content">
                        {!! nl2br(e($data['content'] ?? '')) !!}
                    </div>
                </div>
            </section>

        {{-- How It Works Section --}}
        @elseif($section->type == 'how-it-works')
            <section class="how-it-works-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['steps'] ?? [] as $index => $step)
                            <div class="col-md-4 mb-4 text-center">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width: 50px; height: 50px;">
                                    {{ $index + 1 }}
                                </div>
                                <h5>{{ $step['title'] ?? '' }}</h5>
                                <p>{{ $step['description'] ?? '' }}</p>
                                @if(!empty($step['icon']))
                                    <i class="fas fa-{{ $step['icon'] }} fa-2x text-primary"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Team Section --}}
        @elseif($section->type == 'team')
            <section class="team-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['members'] ?? [] as $member)
                            <div class="col-md-4 mb-4 text-center">
                                @if(!empty($member['image']))
                                    <img src="{{ Storage::url($member['image']) }}"
                                         alt="{{ $member['name'] ?? '' }}"
                                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <h5>{{ $member['name'] ?? '' }}</h5>
                                <p class="text-muted">{{ $member['position'] ?? '' }}</p>
                                <p>{{ $member['bio'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- FAQ Section --}}
        @elseif($section->type == 'faq')
            <section class="faq-section py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="accordion" id="faqAccordion">
                        @foreach($data['faq_items'] ?? [] as $index => $item)
                            <div class="card mb-2">
                                <div class="card-header" id="heading{{ $index }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $index }}" aria-expanded="false"
                                                aria-controls="collapse{{ $index }}">
                                            {{ $item['question'] ?? '' }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}"
                                     data-parent="#faqAccordion">
                                    <div class="card-body">
                                        {{ $item['answer'] ?? '' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Portfolio Section --}}
        @elseif($section->type == 'portfolio')
            <section class="portfolio-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['items'] ?? [] as $item)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if(!empty($item['image']))
                                        <img src="{{ Storage::url($item['image']) }}" class="card-img-top" alt="{{ $item['title'] ?? '' }}">
                                    @endif
                                    <div class="card-body">
                                        <h5>{{ $item['title'] ?? '' }}</h5>
                                        <p>{{ $item['description'] ?? '' }}</p>
                                        @if(!empty($item['link']))
                                            <a href="{{ $item['link'] }}" class="btn btn-outline-primary btn-sm">View</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Pricing Section --}}
        @elseif($section->type == 'pricing')
            <section class="pricing-section py-5">
                <div class="container">
                    <h2 class="text-center mb-3">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-center lead mb-5">{{ $subtitle }}</p>
                    @endif
                    <div class="row">
                        @foreach($data['plans'] ?? [] as $plan)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $plan['name'] ?? '' }}</h5>
                                        <h2 class="card-price">{{ $plan['price'] ?? '' }}</h2>
                                        <ul class="list-unstyled">
                                            @php
                                                $features = is_array($plan['features'] ?? null)
                                                    ? $plan['features']
                                                    : (isset($plan['features']) ? explode(',', $plan['features']) : []);
                                            @endphp
                                            @foreach($features as $feature)
                                                <li>{{ trim($feature) }}</li>
                                            @endforeach
                                        </ul>
                                        @if(!empty($plan['button_text']) && !empty($plan['button_url']))
                                            <a href="{{ $plan['button_url'] }}" class="btn btn-primary">
                                                {{ $plan['button_text'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection

@push('css')
<style>
    .step-number {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .card-price {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
    }
    .cta-section {
        position: relative;
        background-attachment: fixed;
    }
    .cta-section .btn-light {
        color: #007bff;
    }
    .faq-section .btn-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    .faq-section .btn-link:hover {
        text-decoration: underline;
    }
</style>
@endpush