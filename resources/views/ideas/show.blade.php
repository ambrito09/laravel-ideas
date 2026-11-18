<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
            <a href="{{ route('ideas.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                </svg>
                Back to Ideas
            </a>
            <div class="flex items-center gap-x-2">
                <button class="btn btn-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-subtitles-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M11.5 19h-5.5a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v3" />
                        <path d="M7 15h5" />
                        <path d="M17 12h-3" />
                        <path d="M11 12h-1" />
                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39" />
                    </svg>
                    Edit
                </button>
                <form action="/ideas/{{ $idea->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7h16" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            <path d="M10 12l4 4m0 -4l-4 4" />
                        </svg>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8 space-y-6">
            @if ($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt="Idea image" class="w-full h-auto object-cover" />
                </div>
            @endif
            <h1 class="text-3xl font-bold">
                {{ $idea->status->statusIcon() }}
                {{ $idea->title }}
            </h1>
            <div class="border border-border rounded-lg bg-card p-4 md:text-sm block mt-4">
                <p>{{ $idea->description }}</p>

                <p class="mt-4 text-right">{{ $idea->created_at->diffForHumans() }}</p>
            </div>

            @if ($idea->steps->count())
                <div>
                    <h3 class="font-bold text-xl mt-4">Actionable Steps</h3>
                        <div>
                            @foreach ($idea->steps as $step)
                                {{-- <div class="border border-border rounded-lg bg-card p-4 md:text-sm block mt-2">
                                    <a href="{{ $step }}" target="_blank" rel="noopener noreferrer" class="flex text-emerald-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-emerald-500)" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link-share mr-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 15l6 -6" />
                                            <path d="M11 6l.463 -.536c1.953 -1.953 5.119 -1.952 7.072 .001c1.953 1.953 1.952 5.119 -.001 7.071l-.534 .464" />
                                            <path d="M12.736 18.356l-.133 .178c-1.974 1.953 -5.153 1.953 -7.127 0c-.945 -.934 -1.476 -2.207 -1.476 -3.535c0 -1.328 .532 -2.602 1.476 -3.536l.524 -.463" />
                                            <path d="M16 22l5 -5" />
                                            <path d="M21 21.5v-4.5h-4.5" />
                                        </svg>
                                        {{ $step->description }}
                                    </a>
                                </div> --}}
                                <x-card class="font-medium flex gap-x-3 items-center mt-4">
                                    <div class="">
                                        <form action="{{ route('steps.update', $step) }}" method="POST" class="flex gap-x-3 items-center">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" role="checkbox" class="size-5 flex item-center justify-center rounded-lg text-primary-foreground border border-primary {{ $step->completed ? 'bg-primary' : '' }}">&check;</button>
                                            <span class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</span>
                                        </form>
                                    </div>
                                </x-card>
                            @endforeach
                    </div>
                </div>
            @endif

            @if ($idea->links->count())
                <div>
                    <h3 class="font-bold text-xl mt-4">Links</h3>
                        <div>
                            @foreach ($idea->links as $link)
                                <div class="border border-border rounded-lg bg-card p-4 md:text-sm block mt-2">

                                    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="flex text-emerald-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-emerald-500)" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link-share mr-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 15l6 -6" />
                                            <path d="M11 6l.463 -.536c1.953 -1.953 5.119 -1.952 7.072 .001c1.953 1.953 1.952 5.119 -.001 7.071l-.534 .464" />
                                            <path d="M12.736 18.356l-.133 .178c-1.974 1.953 -5.153 1.953 -7.127 0c-.945 -.934 -1.476 -2.207 -1.476 -3.535c0 -1.328 .532 -2.602 1.476 -3.536l.524 -.463" />
                                            <path d="M16 22l5 -5" />
                                            <path d="M21 21.5v-4.5h-4.5" />
                                        </svg>
                                        {{ $link }}
                                    </a>
                                </div>
                            @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
