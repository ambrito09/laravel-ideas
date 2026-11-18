<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Step $step)
    {
        // auth
        $step->update(['completed' => ! $step->completed]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step): void
    {
        //
    }
}
