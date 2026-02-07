<!-- ⚙️ Store Settings -->
<div id="settings-section" class="p-6 bg-white dark:bg-gray-800 shadow rounded-xl mb-8">
  <div class="mb-6 border-b pb-4 border-gray-200 dark:border-gray-600">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
      ⚙️ <span>Store Settings</span>
    </h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your store profile, social links, and branding
      options.</p>
  </div>

  @if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('store.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Store Name -->
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Store Name</label>
        <input type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white" required>
      </div>

      <!-- Phone -->
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $store->phone) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
      </div>

      <!-- Address -->
      <div class="md:col-span-2">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Address</label>
        <input type="text" name="address" value="{{ old('address', $store->address) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
      </div>

      <!-- Social Links -->
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Instagram</label>
        <input type="url" name="instagram" value="{{ old('instagram', $store->instagram) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
      </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Facebook</label>
        <input type="url" name="facebook" value="{{ old('facebook', $store->facebook) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
      </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}"
          class="w-full px-4 py-2 border rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
      </div>

      <!-- Theme Selection -->
      <div>
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Theme</label>
        @php $currentTheme = old('theme', $store->theme ?? 'auto'); @endphp
        <select id="themeSelect" name="theme" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white">
          <option value="light" {{ $currentTheme === 'light' ? 'selected' : '' }}>🌞 Light</option>
          <option value="dark" {{ $currentTheme === 'dark' ? 'selected' : '' }}>🌙 Dark</option>
          <option value="auto" {{ $currentTheme === 'auto' ? 'selected' : '' }}>🌓 Auto</option>
        </select>
      </div>

      <!-- Logo Upload -->
      <div class="md:col-span-2">
        <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Store Logo</label>
        @if ($store->logo)
          <div class="mb-3 flex items-center gap-4">
            <img src="{{ asset('storage/' . $store->logo) }}" class="h-16 w-16 rounded-full border object-cover">
            <span class="text-sm text-gray-500 dark:text-gray-400">Current logo</span>
          </div>
        @endif
        <input type="file" name="logo" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white">
      </div>
    </div>

    <!-- Save Button -->
    <div class="text-right mt-6">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
        💾 Save Changes
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  function applyTheme(theme) {
    const root = document.documentElement;

    if (theme === 'dark') {
      root.classList.add('dark');
    } else if (theme === 'light') {
      root.classList.remove('dark');
    } else {
      // auto
      const mq = window.matchMedia('(prefers-color-scheme: dark)');
      root.classList.toggle('dark', mq.matches);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('themeSelect');
    if (!sel) return;

    // instant preview on change (NO SAVE)
    sel.addEventListener('change', () => {
      applyTheme(sel.value);
    });
  });
</script>
@endpush
