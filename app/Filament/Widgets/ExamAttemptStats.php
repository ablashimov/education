<?php

namespace App\Filament\Widgets;

use App\Models\ExamAttempt;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExamAttemptStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAttempts = ExamAttempt::count();
        $passingAttempts = ExamAttempt::where('score', '>=', 70)->count();
        $failedAttempts = ExamAttempt::where('score', '<', 70)->count();

        $passRate = $totalAttempts > 0 ? round(($passingAttempts / $totalAttempts) * 100) : 0;

        $recentAttempts = ExamAttempt::where('created_at', '>=', now()->subDays(7))->count();

        return [
            Stat::make('Загалом спроб', $totalAttempts)
                ->description('Всі спроби здачі екзаменів')
                ->icon('heroicon-o-document-text')
                ->url(fn (): string => route('filament.admin.resources.exam-attempts.index')),

            Stat::make('Успішних спроб', $passingAttempts)
                ->description('Спроби з балом 70% і вище')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->url(fn (): string => route('filament.admin.resources.exam-attempts.index', ['tableFilters[result_status][value]' => 'Passed'])),

            Stat::make('Невдалих спроб', $failedAttempts)
                ->description('Спроби з балом нижче 70%')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->url(fn (): string => route('filament.admin.resources.exam-attempts.index', ['tableFilters[result_status][value]' => 'Failed'])),

            Stat::make('Рівень успішності', $passRate . '%')
                ->description('Відсоток успішних спроб')
                ->color($passRate >= 70 ? 'success' : ($passRate >= 50 ? 'warning' : 'danger'))
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Спроб за тиждень', $recentAttempts)
                ->description('Спроби за останні 7 днів')
                ->icon('heroicon-o-clock'),

            Stat::make('Середній бал', ExamAttempt::avg('score') ? round(ExamAttempt::avg('score'), 1) . '%' : 'Немає даних')
                ->description('Середній бал по всіх спробах')
                ->icon('heroicon-o-academic-cap'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('viewAny', ExamAttempt::class) ?? false;
    }
}
