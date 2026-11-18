@props([ 'idea' => new App\Models\Idea() ])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit Idea' : 'Create Idea' }}">
    <form x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links)),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))),
            hasImage: false
        }"
        action="{{ $idea->exists ? route('ideas.update', $idea) : route('ideas.store') }}"
        method="POST"
        x-bind:enctype="hasImage ? 'multipart/form-data' : false">
        @csrf
        @if ($idea->exists)
            @method('PATCH')
        @endif
        <div class="space-y-4">
            <x-form.field label="Title" name="title" type="text" :value="$idea->title" required />
            <div>
                <label for="status" class="label">Status</label>
                <div class="flex gap-x-2">
                    @foreach (App\IdeaStatus::cases() as $status)
                        <button
                            type="button"
                            @click="status = @js($status->value)"
                            data-test="button-status-{{ $status->value }}"
                            class="btn flex-1 h-10"
                            :class="status === @js($status->value) ? '' : 'btn-outlined'"
                        >
                            {{ $status->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="status" :value="status" />
                </div>
                <x-form.error name="status"/>
            </div>
            <x-form.field label="Description" name="description" type="textarea" :value="$idea->description" />
            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>
                @if ($idea->image_path)
                    <div class="">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="Idea image" class="w-full h-48 object-cover" />
                        <button class="btn btn-outlined w-full" form="delete-image-form">Remove Image</button>
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" @change="hasImage = $event.target.files.length > 0" >
                <x-form.error name="image"></x-form>
            </div>
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Steps</legend>

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center space-y-2">
                            <input type="text" :name="`steps[${index}][description]`" x-model="step.description" class="input" readonly />
                            <input type="hidden" :name="`steps[${index}][completed]`" x-model="step.completed ? 1 : 0" class="input" readonly />
                            <button type="button" @click="steps.splice(index, 1)" aria-label="Remove Step">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff0000" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center space-y-2">
                        <input x-model="newStep" data-test="input-new-step" type="text" name="" id="new-step" class="input flex-1 space-y-2" autocomplete="step" spellcheck="false" />
                        <button type="button" @click="steps.push({description: newStep.trim(), completed: false}); newStep=''" :disabled="newStep.trim().length === 0" aria-label="Add Step button" data-test="button-add-step">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-code-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 12h6" />
                                <path d="M12 9v6" />
                                <path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" />
                                <path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" />
                            </svg>
                        </button>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links">
                        <div class="flex gap-x-2 items-center space-y-2">
                            <input type="text" name="links[]" x-model="link" class="input" readonly />
                            <button type="button" @click="links.splice(index, 1)" aria-label="Remove Link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff0000" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center space-y-2">
                        <input x-model="newLink" data-test="input-new-link" type="url" name="" id="new-link" placeholder="https://example.com" class="input flex-1 space-y-2" autocomplete="url" spellcheck="false" />
                        <button type="button" @click="links.push(newLink.trim()); newLink=''" :disabled="newLink.trim().length === 0" aria-label="Add Link button" data-test="button-add-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-code-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 12h6" />
                                <path d="M12 9v6" />
                                <path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" />
                                <path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" />
                            </svg>
                        </button>
                    </div>
                </fieldset>

            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" @click="$dispatch('close-modal', '{{ $idea->exists ? 'edit-idea' : 'create-idea' }}')" class="btn btn-outlined">Cancel</button>
                <button type="submit" class="btn" data-test="button-modal-create">{{ $idea->exists ? 'Edit' : 'Create' }}</button>
            </div>
        </div>
    </form>

    @if ($idea->image_path)
        <form action="{{ route('ideas.image.destroy', $idea) }}" method="POST" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
