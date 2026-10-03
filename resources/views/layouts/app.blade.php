@if(session('error') || session('success'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3500)"
        x-show="show"
        x-transition
        class="fixed top-5 right-5 z-50 bg-white shadow-xl rounded-md px-4 py-3 border {{ session('error') ? 'border-red-600' : 'border-green-600' }}"
    >
        <div class="flex items-center gap-2">
            @if(session('error'))
                <span class="text-red-600 font-semibold">⚠️ {{ session('error') }}</span>
            @endif

            @if(session('success'))
                <span class="text-green-600 font-semibold">✔️ {{ session('success') }}</span>
            @endif
        </div>
    </div>
@endif
