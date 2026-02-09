@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Site Settings')
@section('content')
<div class="row">
    <div class="col-md-8">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            {{-- Journal Information --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-book-open me-2"></i>Journal Information</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Journal Name</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'SIJSEMSS' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Journal Abbreviation</label>
                            <input type="text" name="journal_abbreviation" class="form-control" value="{{ $settings['journal_abbreviation'] ?? 'SIJSEMSS' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Journal Full Title</label>
                        <input type="text" name="journal_full_title" class="form-control" value="{{ $settings['journal_full_title'] ?? 'Share International Journal of Sustainable Engineering, Management and Social Sciences' }}">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ISSN (Print)</label>
                            <input type="text" name="issn_print" class="form-control" value="{{ $settings['issn_print'] ?? '' }}" placeholder="XXXX-XXXX">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ISSN (Online)</label>
                            <input type="text" name="issn_online" class="form-control" value="{{ $settings['issn_online'] ?? '' }}" placeholder="XXXX-XXXX">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Publication Frequency</label>
                            <select name="publication_frequency" class="form-select">
                                <option value="Monthly" {{ ($settings['publication_frequency'] ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="Bi-Monthly" {{ ($settings['publication_frequency'] ?? '') == 'Bi-Monthly' ? 'selected' : '' }}>Bi-Monthly</option>
                                <option value="Quarterly" {{ ($settings['publication_frequency'] ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="Semi-Annual" {{ ($settings['publication_frequency'] ?? '') == 'Semi-Annual' ? 'selected' : '' }}>Semi-Annual</option>
                                <option value="Annual" {{ ($settings['publication_frequency'] ?? '') == 'Annual' ? 'selected' : '' }}>Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Journal Description / Tagline</label>
                        <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Publisher Information --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-building me-2"></i>Publisher Information</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publisher Name</label>
                            <input type="text" name="publisher_name" class="form-control" value="{{ $settings['publisher_name'] ?? 'Share Study Hub' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publisher Year Established</label>
                            <input type="text" name="publisher_year" class="form-control" value="{{ $settings['publisher_year'] ?? '2010' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Publisher Motto</label>
                        <input type="text" name="publisher_motto" class="form-control" value="{{ $settings['publisher_motto'] ?? 'Knowledge Shared is Knowledge Squared' }}">
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Information</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'editor@shareij.org' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $settings['country'] ?? 'India' }}">
                    </div>
                </div>
            </div>

            {{-- APC / Financial --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-rupee-sign me-2"></i>Article Processing Charges</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Indian Authors (INR)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" name="apc_inr" class="form-control" value="{{ $settings['apc_inr'] ?? '999' }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Foreign Authors (USD)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" name="apc_usd" class="form-control" value="{{ $settings['apc_usd'] ?? '40' }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Mode</label>
                            <input type="text" name="payment_mode" class="form-control" value="{{ $settings['payment_mode'] ?? 'UPI / Bank Transfer / PayPal' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Social Media --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Social Media Links</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-facebook text-primary"></i> Facebook</label>
                            <input type="url" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-twitter text-info"></i> Twitter / X</label>
                            <input type="url" name="social_twitter" class="form-control" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://x.com/...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-linkedin text-primary"></i> LinkedIn</label>
                            <input type="url" name="social_linkedin" class="form-control" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-google-scholar" style="color: #4285f4;"></i> Google Scholar</label>
                            <input type="url" name="social_scholar" class="form-control" value="{{ $settings['social_scholar'] ?? '' }}" placeholder="https://scholar.google.com/...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO & Meta --}}
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-search me-2"></i>SEO & Meta Tags</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ $settings['meta_description'] ?? '' }}</textarea>
                        <small class="text-muted">Recommended: 150-160 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="journal, research, SIJSEMSS, open access">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Google Analytics Tracking ID</label>
                        <input type="text" name="google_analytics_id" class="form-control" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Save All Settings</button>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Stats</h5></div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Total Papers:</strong> {{ \App\Models\Paper::count() }}</li>
                    <li class="mb-2"><strong>Published Papers:</strong> {{ \App\Models\Paper::where('status', 'published')->count() }}</li>
                    <li class="mb-2"><strong>Pending Papers:</strong> {{ \App\Models\Paper::where('status', 'pending')->count() }}</li>
                    <li class="mb-2"><strong>Total Users:</strong> {{ \App\Models\User::count() }}</li>
                    <li class="mb-2"><strong>Total Volumes:</strong> {{ \App\Models\Volume::count() }}</li>
                    <li class="mb-2"><strong>Blog Posts:</strong> {{ \App\Models\Post::count() }}</li>
                    <li class="mb-0"><strong>Unread Messages:</strong> {{ \App\Models\Message::where('is_read', false)->count() }}</li>
                </ul>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-server me-2"></i>System Info</h5></div>
            <div class="card-body small">
                <ul class="list-unstyled mb-0">
                    <li class="mb-1"><strong>Laravel:</strong> {{ app()->version() }}</li>
                    <li class="mb-1"><strong>PHP:</strong> {{ phpversion() }}</li>
                    <li class="mb-1"><strong>Environment:</strong> {{ app()->environment() }}</li>
                    <li class="mb-1"><strong>Mail Driver:</strong> {{ config('mail.default') }}</li>
                    <li class="mb-0"><strong>Cache Driver:</strong> {{ config('cache.default') }}</li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-link me-2"></i>Quick Links</h5></div>
            <div class="card-body">
                <a href="{{ route('admin.email-templates.index') }}" class="btn btn-outline-primary btn-sm w-100 mb-2"><i class="fas fa-mail-bulk me-1"></i> Email Templates</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm w-100 mb-2"><i class="fas fa-users me-1"></i> Manage Users</a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm w-100" target="_blank"><i class="fas fa-globe me-1"></i> View Website</a>
            </div>
        </div>
    </div>
</div>
@endsection