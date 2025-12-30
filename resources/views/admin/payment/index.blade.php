@extends('admin.layouts.base')

@section('title', 'Payment Settings')


@section('content')
<div class="mt-12 max-w-4xl mx-auto space-y-10">
  <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
    <span class="text-4xl">⚙️</span> Payment Method Settings
  </h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow border border-green-300">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.payment.settings.update') }}">
    @csrf

    <!-- Toggle Section -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
        <span class="text-2xl">🧩</span> Activate / Deactivate Payment Methods
      </h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @php
          $methods = [
            'enable_cliq' => 'CliQ Bank Transfer',
            'enable_credit' => 'Credit Card',
            'enable_apple' => 'Apple Pay',
            'enable_google' => 'Google Pay',
          ];
        @endphp

        @foreach($methods as $key => $label)
          <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-800 px-6 py-5 rounded-xl shadow-sm">
            <div>
              <div class="text-sm font-medium text-gray-800 dark:text-white">{{ $label }}</div>
              <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ data_get($settings, $key, false) ? 'Currently Activated' : 'Currently Deactivated' }}
              </div>
            </div>
            <button type="submit" name="toggle" value="{{ $key }}"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white text-sm font-semibold transition
              {{ data_get($settings, $key, false) ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
              @if(data_get($settings, $key, false))
                ❌ Deactivate
              @else
                ✅ Activate
              @endif
            </button>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Bank Transfer Section -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
        <span class="text-2xl">🏦</span> Bank Transfer Details
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
        
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
  <input type="text" name="bank_name" value="{{ old('bank_name') ?? data_get($settings, 'bank_name', '') }}"
    class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">IBAN / Account Number</label>
  <input type="text" name="iban" value="{{ old('iban') ?? data_get($settings, 'iban', '') }}"
    class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CliQ Name</label>
  <input type="text" name="cliq_name" value="{{ old('cliq_name') ?? data_get($settings, 'cliq_name', '') }}"
    class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CliQ Alias</label>
  <input type="text" name="cliq_alias" value="{{ old('cliq_alias') ?? data_get($settings, 'cliq_alias', '') }}"
    class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
</div>

      </div>
      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instruction Message</label>
        <textarea name="payment_note" rows="4"
          class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">{{ old('payment_note', data_get($settings, 'payment_note', '')) }}</textarea>
      
    </div>

    <!-- Credit Card Section -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">💳 Credit Card Settings</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">MID (Merchant ID)</label>
          <input type="text" name="mid" value="{{ old('mid', data_get($settings, 'mid', '')) }}"
            class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TID (Terminal ID)</label>
          <input type="text" name="tid" value="{{ old('tid', data_get($settings, 'tid', '')) }}"
            class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">IP Address</label>
          <input type="text" name="ip_address" value="{{ old('ip_address', data_get($settings, 'ip_address', '')) }}"
            class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
        </div>
        <div class="flex items-center mt-6">
          <input type="checkbox" name="enable_3d" id="enable_3d"
            class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
            {{ data_get($settings, 'enable_3d', false) ? 'checked' : '' }}>
          <label for="enable_3d" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Enable 3D Secure</label>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Processing Fee (%)</label>
          <input type="number" step="0.1" name="credit_fee" value="{{ old('credit_fee', data_get($settings, 'credit_fee', '')) }}"
            class="w-full mt-1 px-4 py-2 border rounded dark:bg-gray-800 dark:text-white">
        </div>
      </div>
    </div>

    <!-- Save Button -->
    <div class="text-right mt-6">
      <button type="submit"
        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow">
        💾 Save Payment Settings
      </button>
    </div>

  </form>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('button[name="toggle"]');
    toggles.forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        const key = this.value;
        const methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', 'toggle');
        methodInput.setAttribute('value', key);
        form.appendChild(methodInput);
        form.submit();
      });
    });
  });
</script>
@endpush

@endsection
