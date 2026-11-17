@props(['name', 'title' => ''])

<div
  id="modal-form-container"
  x-data="{ show: false, name: @js($name) }"
  x-show="show"
  @open-modal.window="if($event.detail === name) show = true"
  @close-modal="show = false"
  @keydown.escape.window="show = false"
  x-transition:enter="all ease-out duration-550"
  x-transition:enter-start="-translate-x-100"
  x-transition:enter-end="translate-x-0"
  x-transition:leave="all ease-out duration-250"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0 -translate-x-100"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-3xl"
  style="display:none;"
  role="dialog"
  aria-modal="true"
  aria-labelledby="modal-{{ $name }}-title"
  :aria-hidden="!show"
  tabindex="-1"
  :inert="!show"
>
  <x-card class="shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto">
    <div class="flex justify-between items-center">
      <h2 id="modal-{{ $name }}-title" class="text-2xl font-bold mb-4">{{ $title }}</h2>
      <button
        @click="$dispatch('close-modal')"
        class="border border-border rounded-full p-1 cursor-pointer hover:border-red-500/30 hover:bg-red-300/20 hover:text-red-500/80">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M18 6l-12 12" />
            <path d="M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="mt-4">
      {{ $slot }}
    </div>
  </x-card>
</div>
