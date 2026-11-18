<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;

class UpdateIdea
{
    public function __construct(#[CurrentUser()] protected User $user)
    {
        //
    }

    public function handle(array $attributes, Idea $idea): void
    {
        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        $steps = collect($attributes['steps'] ?? [])->map(fn ($step) => ['description' => $step['description'], 'completed' => $step['completed']]);

        DB::transaction(function () use ($idea, $data, $steps) {
            $idea->update($data);
            $idea->steps()->delete();
            $idea->steps()->createMany($steps);
        });
    }
}
