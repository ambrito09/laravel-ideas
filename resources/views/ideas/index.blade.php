<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Share your ideas with the community.</p>
        </header>

        <div class="flex justify-between items-center">
            <div>
                <a href="/ideas" class="btn btn-outlined">All <span class="text-xs pl-4">{{ $statusCount['all'] ?? 0 }}</span></a>
                @foreach (App\IdeaStatus::cases() as $status)
                    <a href="/ideas?status={{ $status->value }}" class="btn {{ request()->status === $status->value ? '' : 'btn-outlined' }}">
                        {{ $status->label() }}
                        <span class="text-xs pl-4">{{ $statusCount[$status->value] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
            <button
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                data-test="create-idea-button"
                class="btn btn-outlined">
                    New Idea
            </button>
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($ideas as $idea)
                    <x-idea-card href="/ideas/{{ $idea->id }}">
                        @if ($idea->image_path)
                            <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="Idea image" class="w-full h-auto object-cover" />
                            </div>
                        @endif
                        <h3 class="text-foreground text-lg">
                            <span class="inline-block px-2 text-xl font-medium">
                                {{ $idea->status->statusIcon() }}
                            </span>
                            {{ $idea->title }}
                        </h3>
                        <div class="mt-5 text-sm">{{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-idea-card>
                @empty
                    <p>No ideas yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Modal -->
        <x-ideas.modal name="create-idea" title="New Idea" />
    </div>
</x-layout>
