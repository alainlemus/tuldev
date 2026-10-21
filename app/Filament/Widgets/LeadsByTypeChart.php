<?php

namespace App\Filament\Widgets;

use App\Enums\LeadType;
use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsByTypeChart extends ChartWidget
{
    protected ?string $heading = 'Prospectos por tipo de proyecto';

    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = Lead::query()
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $types = collect(LeadType::cases())->filter(fn (LeadType $type) => $counts->has($type->value));

        return [
            'datasets' => [[
                'data' => $types->map(fn (LeadType $type) => $counts[$type->value])->values()->all(),
                'backgroundColor' => ['#1FBFA9', '#5FE0CC', '#2A6E66', '#B7C0C9', '#8E99A4', '#3A434C', '#10201E'],
            ]],
            'labels' => $types->map(fn (LeadType $type) => $type->getLabel())->values()->all(),
        ];
    }
}
