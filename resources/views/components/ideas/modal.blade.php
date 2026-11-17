@props([ 'name', 'title' => 'Ideas'])

<x-modal :name="$name" :title="$title">
    <form x-data="{status: 'pending'}" action="{{ route('ideas.store') }}" method="POST">
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
            <div class="flex justify-end space-x-4">
                <button type="button" @click="$dispatch('close-modal', '{{ $name }}')" class="btn btn-outlined">Cancel</button>
                <button type="submit" class="btn">Create</button>
            </div>
        </div>
    </form>
</x-modal>
