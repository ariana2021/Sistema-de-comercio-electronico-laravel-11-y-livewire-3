<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slider;
use Carbon\Carbon;

class DailyOffersComponent extends Component
{
    public function render()
    {
        $today = Carbon::now()->toDateString();

        $offers = Slider::where('status', 1)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        return view('livewire.daily-offers-component', compact('offers'));
    }
}
