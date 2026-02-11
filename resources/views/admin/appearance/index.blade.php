@extends('layouts.admin')
@section('title', 'Appearance')
@section('page-title', 'Website Appearance')

@section('content')
<form method="POST" action="{{ route('admin.appearance.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">

            {{-- Logo & Branding --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-image me-2"></i>Logo & Branding</h5></div>
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 text-center">
                            @if(!empty($settings['site_logo']))
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="img-fluid mb-2" style="max-height: 80px;">
                                <br>
                                <label class="form-check-label small">
                                    <input type="checkbox" name="remove_logo" value="1" class="form-check-input"> Remove logo
                                </label>
                            @else
                                <div class="p-3 bg-light rounded text-muted"><i class="fas fa-image fa-2x"></i><br><small>No logo</small></div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Upload Logo</label>
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: PNG or SVG, max 2MB. Ideal height: 60-80px</small>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 text-center">
                            @if(!empty($settings['footer_logo']))
                                <img src="{{ asset('storage/' . $settings['footer_logo']) }}" alt="Footer Logo" class="img-fluid mb-2" style="max-height: 80px;">
                                <br>
                                <label class="form-check-label small">
                                    <input type="checkbox" name="remove_footer_logo" value="1" class="form-check-input"> Remove footer logo
                                </label>
                            @else
                                <div class="p-3 bg-light rounded text-muted"><i class="fas fa-image fa-2x"></i><br><small>No footer logo</small></div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Upload Footer Logo</label>
                            <input type="file" name="footer_logo" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: PNG or SVG, max 2MB. Ideal height: 60-120px</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Favicon</label>
                        <input type="file" name="site_favicon" class="form-control" accept=".png,.ico,.svg">
                        <small class="text-muted">PNG or ICO, max 512KB</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand Name (Navbar)</label>
                            <input type="text" name="header_brand_name" class="form-control" value="{{ $settings['header_brand_name'] ?? 'SHARE IJ' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand Subtitle</label>
                            <input type="text" name="header_brand_subtitle" class="form-control" value="{{ $settings['header_brand_subtitle'] ?? 'Share International Journal of Sustainable Engineering, Management & Social Sciences' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Theme Colors --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-palette me-2"></i>Theme Colors</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Primary Color</label>
                            <div class="input-group">
                                <input type="color" name="theme_primary_color" class="form-control form-control-color" value="{{ $settings['theme_primary_color'] ?? '#0d2b4e' }}" style="width:50px;">
                                <input type="text" class="form-control color-text" value="{{ $settings['theme_primary_color'] ?? '#0d2b4e' }}" readonly>
                            </div>
                            <small class="text-muted">Headers, footer, buttons</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Secondary / Accent Gold</label>
                            <div class="input-group">
                                <input type="color" name="theme_secondary_color" class="form-control form-control-color" value="{{ $settings['theme_secondary_color'] ?? '#d4a437' }}" style="width:50px;">
                                <input type="text" class="form-control color-text" value="{{ $settings['theme_secondary_color'] ?? '#d4a437' }}" readonly>
                            </div>
                            <small class="text-muted">Accents, highlights</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Link / Action Color</label>
                            <div class="input-group">
                                <input type="color" name="theme_accent_color" class="form-control form-control-color" value="{{ $settings['theme_accent_color'] ?? '#1a73e8' }}" style="width:50px;">
                                <input type="text" class="form-control color-text" value="{{ $settings['theme_accent_color'] ?? '#1a73e8' }}" readonly>
                            </div>
                            <small class="text-muted">Links, active elements</small>
                        </div>
                    </div>
                    <div class="alert alert-info small mb-0"><i class="fas fa-info-circle me-1"></i> Color changes apply immediately to the website after saving.</div>
                </div>
            </div>

            {{-- Header / Top Bar --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-window-maximize me-2"></i>Header / Top Bar</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Top Bar Text (optional)</label>
                        <input type="text" name="header_top_bar_text" class="form-control" value="{{ $settings['header_top_bar_text'] ?? '' }}" placeholder="e.g. Welcome to SHARE IJ | Now Accepting Papers for 2025">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ISSN Display Text</label>
                            <input type="text" name="header_issn" class="form-control" value="{{ $settings['header_issn'] ?? 'ISSN: Applied' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Frequency Display Text</label>
                            <input type="text" name="header_frequency" class="form-control" value="{{ $settings['header_frequency'] ?? 'Frequency: Monthly e-Journal' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Homepage Hero --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-star me-2"></i>Homepage Hero Section</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="hero_badge_text" class="form-control" value="{{ $settings['hero_badge_text'] ?? 'Peer-Reviewed | Open Access | Monthly e-Journal' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Title</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? 'Share International Journal of Sustainable Engineering, Management and Social Sciences' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Subtitle</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] ?? '(SHARE IJ)' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Description</label>
                        <textarea name="hero_description" class="form-control" rows="3">{{ $settings['hero_description'] ?? 'A multidisciplinary, peer-reviewed, open access scholarly publication dedicated to advancing research across engineering, management, and social sciences.' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button 1 Text</label>
                            <input type="text" name="hero_btn1_text" class="form-control" value="{{ $settings['hero_btn1_text'] ?? 'Submit Your Paper' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button 1 URL</label>
                            <input type="text" name="hero_btn1_url" class="form-control" value="{{ $settings['hero_btn1_url'] ?? '/register' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button 2 Text</label>
                            <input type="text" name="hero_btn2_text" class="form-control" value="{{ $settings['hero_btn2_text'] ?? 'Browse Archives' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Button 2 URL</label>
                            <input type="text" name="hero_btn2_url" class="form-control" value="{{ $settings['hero_btn2_url'] ?? '/volumes' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Content --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-shoe-prints me-2"></i>Footer Content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Footer About Text</label>
                        <textarea name="footer_about_text" class="form-control" rows="3">{{ $settings['footer_about_text'] ?? 'Share International Journal of Sustainable Engineering, Management and Social Sciences is a multidisciplinary, peer-reviewed, open access journal published by Share Study Hub.' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publisher Name</label>
                            <input type="text" name="footer_publisher_name" class="form-control" value="{{ $settings['footer_publisher_name'] ?? 'Share Study Hub' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Footer Email</label>
                            <input type="email" name="footer_email" class="form-control" value="{{ $settings['footer_email'] ?? 'editor@shareij.org' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Footer Address</label>
                        <textarea name="footer_address" class="form-control" rows="2">{{ $settings['footer_address'] ?? '121, Shripuram Colony, Gurjar Ki Thadi, Jaipur, India' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Copyright Text</label>
                        <input type="text" name="footer_copyright_text" class="form-control" value="{{ $settings['footer_copyright_text'] ?? '' }}" placeholder="Leave empty for default: © {year} {journal name}. Published by {publisher}. All rights reserved.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">License Text</label>
                        <input type="text" name="footer_license_text" class="form-control" value="{{ $settings['footer_license_text'] ?? 'Content licensed under Creative Commons Attribution 4.0 International License.' }}">
                    </div>
                </div>
            </div>

            {{-- Custom CSS & Code --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-code me-2"></i>Custom Code</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Custom CSS</label>
                        <textarea name="custom_css" class="form-control font-monospace" rows="5" placeholder="/* Add custom styles here */&#10;body { }">{{ $settings['custom_css'] ?? '' }}</textarea>
                        <small class="text-muted">Added inside &lt;style&gt; tag. No &lt;style&gt; tags needed.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Custom Head Code (Analytics, etc.)</label>
                        <textarea name="custom_head_code" class="form-control font-monospace" rows="4" placeholder="<!-- Google tag (gtag.js) -->">{{ $settings['custom_head_code'] ?? '' }}</textarea>
                        <small class="text-muted">Injected before &lt;/head&gt;. Use for analytics scripts, meta tags, etc.</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mb-4"><i class="fas fa-save me-2"></i>Save Appearance Settings</button>
        </div>

        {{-- Preview Sidebar --}}
        <div class="col-md-4">
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-eye me-2"></i>Live Preview</h5></div>
                <div class="card-body p-0">
                    <div id="colorPreview" style="border-radius: 0 0 8px 8px; overflow: hidden;">
                        <div style="background: var(--preview-primary, #0d2b4e); color: #fff; padding: 6px 12px; font-size: 0.7rem;">
                            <span id="prevTopBar">editor@shareij.org | ISSN: Applied</span>
                        </div>
                        <div style="background: #fff; padding: 10px 12px; border-bottom: 2px solid var(--preview-secondary, #d4a437);">
                            <strong id="prevBrand" style="color: var(--preview-primary, #0d2b4e); font-size: 0.9rem;">SHARE IJ</strong>
                            <span style="float:right; font-size: 0.75rem;">
                                <span style="color: var(--preview-accent, #1a73e8);">Home</span>
                                <span class="ms-2" style="color: #333;">About</span>
                                <span class="ms-2" style="color: #333;">Contact</span>
                            </span>
                        </div>
                        <div id="prevHero" style="background: linear-gradient(135deg, var(--preview-primary, #0d2b4e), var(--preview-accent, #1a73e8)); color: #fff; padding: 20px 12px; text-align: center;">
                            <small id="prevHeroBadge" style="background: rgba(255,255,255,0.15); padding: 2px 8px; border-radius: 4px; font-size: 0.65rem;">Peer-Reviewed | Open Access</small>
                            <div id="prevHeroTitle" style="font-size: 0.9rem; font-weight: 700; margin-top: 8px;">SHARE IJ</div>
                        </div>
                        <div style="background: #f8f9fa; padding: 15px 12px; font-size: 0.7rem; color: #666;">
                            <div class="mb-1">■ Sample content area</div>
                            <div class="mb-1">■ Cards and sections</div>
                            <div>■ Page body</div>
                        </div>
                        <div id="prevFooter" style="background: var(--preview-primary, #0d2b4e); color: rgba(255,255,255,0.8); padding: 12px; font-size: 0.65rem;">
                            <strong style="color: #fff;">SHARE IJ</strong><br>
                            <span id="prevFooterText">Open Access Journal</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h5></div>
                <div class="card-body small">
                    <ul class="mb-0">
                        <li class="mb-2">Upload a high-quality logo for best results on all screens.</li>
                        <li class="mb-2">Use dark primary color with contrasting gold/secondary for professional look.</li>
                        <li class="mb-2">Custom CSS overrides theme defaults — use carefully.</li>
                        <li class="mb-0">Leave fields empty to use system defaults.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // Live color preview
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', function() {
            const text = this.closest('.input-group').querySelector('.color-text');
            if (text) text.value = this.value;

            const name = this.name;
            const preview = document.getElementById('colorPreview');
            if (name === 'theme_primary_color') preview.style.setProperty('--preview-primary', this.value);
            if (name === 'theme_secondary_color') preview.style.setProperty('--preview-secondary', this.value);
            if (name === 'theme_accent_color') preview.style.setProperty('--preview-accent', this.value);
        });
    });

    // Live text preview
    const brandInput = document.querySelector('input[name="header_brand_name"]');
    if (brandInput) {
        brandInput.addEventListener('input', () => {
            document.getElementById('prevBrand').textContent = brandInput.value;
            document.getElementById('prevHeroTitle').textContent = brandInput.value;
        });
    }
</script>
@endsection
