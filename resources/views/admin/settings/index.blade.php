@extends('admin.layouts.base')

@section('title', 'Global Settings')

@section('content')
<div class="mt-12 max-w-5xl mx-auto space-y-10">

  <div class="flex items-center justify-between">
    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">⚙️ Global Settings</h2>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md shadow-sm border border-green-300">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-10">
    @csrf

    @php
      $sectionClasses = 'bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border dark:border-gray-700';
      $inputClasses = 'w-full mt-1 px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white';
      $labelClasses = 'block text-sm font-medium text-gray-700 dark:text-gray-300';
    @endphp

    <!-- General Settings -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">📟 General</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="{{ $labelClasses }}">Site Name</label>
          <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name ?? '') }}" class="{{ $inputClasses }}">
        </div>

        <div>
          <label class="{{ $labelClasses }}">Support Email</label>
          <input type="email" name="support_email" value="{{ old('support_email', $settings->support_email ?? '') }}" class="{{ $inputClasses }}">
        </div>

        <div class="md:col-span-2">
          <label class="{{ $labelClasses }}">Default Notification Image URL</label>
          <input type="url" name="default_fcm_image" value="{{ old('default_fcm_image', $settings->default_fcm_image ?? '') }}" class="{{ $inputClasses }}" placeholder="https://yourdomain.com/path/to/image.png">
          @if(!empty($settings->default_fcm_image))
            <img src="{{ $settings->default_fcm_image }}" class="mt-3 h-16 rounded shadow">
          @endif
        </div>
      </div>
    </div>

    <!-- Logos -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">🖼️ Branding</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="{{ $labelClasses }}">Site Logo</label>
          <input type="file" name="site_logo" class="mt-2 block w-full text-sm text-gray-500 dark:text-gray-300">
          @if(!empty($settings->site_logo))
            <img src="{{ asset('storage/' . $settings->site_logo) }}" alt="Logo" class="mt-2 h-12">
          @endif
        </div>

        <div>
          <label class="{{ $labelClasses }}">Favicon</label>
          <input type="file" name="site_favicon" class="mt-2 block w-full text-sm text-gray-500 dark:text-gray-300">
          @if(!empty($settings->site_favicon))
            <img src="{{ asset('storage/' . $settings->site_favicon) }}" alt="Favicon" class="mt-2 h-10 w-10">
          @endif
        </div>
      </div>
    </div>

    <!-- Delivery Options -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">🚚 Delivery Options</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="{{ $labelClasses }}">Available Delivery Times <span class="text-xs text-gray-400">(comma-separated)</span></label>
          <input type="text" name="delivery_times" value="{{ old('delivery_times', implode(',', $settings->delivery_times ?? [])) }}" class="{{ $inputClasses }}">
        </div>

        <div>
          <label class="{{ $labelClasses }}">Delivery Date Range (days ahead)</label>
          <input type="number" name="delivery_date_range" value="{{ old('delivery_date_range', count($settings->delivery_days ?? [])) }}" class="{{ $inputClasses }}">
        </div>
      </div>
    </div>

    <!-- Appearance -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">🎨 App Appearance</h3>

      <div class="w-full">
        <label class="{{ $labelClasses }}">Theme</label>
        <select name="theme" class="{{ $inputClasses }}">
          <option value="light" {{ ($settings->theme_color ?? '') === 'light' ? 'selected' : '' }}>🌞 Light</option>
          <option value="dark" {{ ($settings->theme_color ?? '') === 'dark' ? 'selected' : '' }}>🌚 Dark</option>
          <option value="auto" {{ ($settings->theme_color ?? '') === 'auto' ? 'selected' : '' }}>🌃 Auto</option>
        </select>
      </div>
    </div>

    <!-- Language & Footer -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">🌐 Language & Footer</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="{{ $labelClasses }}">Default App Language</label>
          <select name="default_language" class="{{ $inputClasses }}">
            <option value="en" {{ ($settings->default_language ?? '') === 'en' ? 'selected' : '' }}>🇺🇸 English</option>
            <option value="ar" {{ ($settings->default_language ?? '') === 'ar' ? 'selected' : '' }}>🇸🇦 Arabic</option>
            <option value="tr" {{ ($settings->default_language ?? '') === 'tr' ? 'selected' : '' }}>🇹🇷 Turkish</option>
            <option value="fr" {{ ($settings->default_language ?? '') === 'fr' ? 'selected' : '' }}>🇫🇷 French</option>
          </select>
        </div>

        <div>
          <label class="{{ $labelClasses }}">Footer Text</label>
          <input type="text" name="footer_text" value="{{ old('footer_text', $settings->footer_text ?? '') }}" class="{{ $inputClasses }}">
        </div>

        <div>
          <label class="{{ $labelClasses }}">Copyright</label>
          <input type="text" name="copyright" value="{{ old('copyright', $settings->copyright ?? '') }}" class="{{ $inputClasses }}">
        </div>
      </div>
    </div>

    <!-- Feature Toggles -->
    <div class="{{ $sectionClasses }}">
      <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
        🧪 <span>Feature Toggles</span>
      </h3>

      <div class="divide-y divide-gray-200 dark:divide-gray-700">
        <div class="flex items-center justify-between py-4 px-2 transition hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg group" title="Temporarily disables frontend access">
          <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
            <span class="text-xl group-hover:scale-110 transition-transform">🚧</span>
            <span class="text-base font-medium">Maintenance Mode</span>
          </div>

          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="maintenance_mode" class="sr-only peer"
              {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}
              onchange="if(confirm('Are you sure you want to toggle maintenance mode?')) this.form.submit(); else this.checked = !this.checked;">
            <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-red-600 transition"></div>
            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition transform peer-checked:translate-x-5"></div>
          </label>
        </div>
      </div>
    </div>

    <div class="text-right">
      <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow hover:bg-indigo-700 transition-all">
        💾 Save Settings
      </button>
    </div>

  </form>
</div>
@endsection
