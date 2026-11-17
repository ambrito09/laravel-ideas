@props([ 'name', 'title' => 'Ideas'])

<x-modal :name="$name" :title="$title">
    <form x-data="{status: 'pending', newLink: '', links: [] }" action="{{ route('ideas.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-form.field label="Title" name="title" type="text" required />
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
            <x-form.field label="Description" name="description" type="textarea" />
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
                <button type="button" @click="$dispatch('close-modal', '{{ $name }}')" class="btn btn-outlined">Cancel</button>
                <button type="submit" class="btn" data-test="button-modal-create">Create</button>
            </div>
        </div>
    </form>
</x-modal>
