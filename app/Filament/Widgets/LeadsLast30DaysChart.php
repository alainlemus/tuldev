<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class LeadsLast30DaysChart extends ChartWidget
{
    protected ?string $heading = 'Leads de los últimos 30 días';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $from = Carbon::today()->subDays(29);

        $perDay = Lead::where('created_at', '>=', $from)
            ->get(['created_at'])
            ->countBy(fn (Lead $lead) => $lead->created_at->format('Y-m-d'));

        $days = collect(range(0, 29))->map(fn (int $i) => $from->copy()->addDays($i));

        return [
            'datasets' => [[
                'label' => 'Leads',
                'data' => $days->map(fn (Carbon $day) => $perDay->get($day->format('Y-m-d'), 0))->all(),
                'borderColor' => '#1FBFA9',
                'backgroundColor' => 'rgba(31,191,169,0.15)',
                'fill' => true,
                'tension' => 0.3,
            ]],
            'labels' => $days->map(fn (Carbon $day) => $day->format('d/m'))->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => ['legend' => ['display' => false]],
            'scales' => ['y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]]],
        ];
    }
}
