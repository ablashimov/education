<x-filament-panels::page>
    @php
        $attempt = $this->getRecord();
        $attempt->loadMissing(['answers.question', 'instance.assignment.exam', 'instance.user']);

        $score = (int) ($attempt->score ?? 0);
        $passing = $attempt->instance->assignment->exam->passing_score ?? 70;
        $status = ($attempt->score === null) ? 'Not graded' : ($score >= $passing ? 'Passed' : 'Failed');

        if ($score >= $passing) {
            $barColor = 'bg-emerald-500';
        } elseif ($score >= ($passing * 0.6)) {
            $barColor = 'bg-amber-500';
        } else {
            $barColor = 'bg-rose-500';
        }
    @endphp

    <div class="max-w-full">
        <h1 class="text-2xl font-extrabold mb-4">Перегляд — Спроба екзамену #{{ $attempt->id }}</h1>

        <x-filament::card class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                <!-- left: basic info -->
                <div class="md:col-span-2 space-y-2">
                    <div class="text-sm text-muted-foreground">Користувач: {{ $attempt->instance->user->name ?? '-' }}</div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                        <div>
                            <div class="text-xs text-muted-foreground">Екзамен: {{ $attempt->instance->assignment->exam->title ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Спроба: #{{ $attempt->instance->attempt_number ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Початок: {{ optional($attempt->started_at)->toDayDateTimeString() ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Відправлено: {{ optional($attempt->submitted_at)->toDayDateTimeString() ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-muted-foreground">Результат: {{ $attempt->score !== null ? $score . '%' : '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Час (hh:mm:ss): {{ \Carbon\CarbonInterval::seconds($attempt->elapsed_seconds ?? 0)->cascade()->format('%H:%I:%S') }}</div>
                        </div>
                    </div>
                </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Відповіді</h2>
                <div class="text-sm text-muted-foreground">Всього: {{ $attempt->answers->count() }}</div>
            </div>

            <div class="overflow-hidden rounded-md border border-slate-700">
                <table class="min-w-full divide-y divide-slate-700">
                    <thead class="bg-slate-900/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-300">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-300">Питання</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-300">Відповідь</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-300">Статус</th>
                    </tr>
                    </thead>
                    <tbody class="bg-slate-950/30 divide-y divide-slate-800">
                    @foreach ($attempt->answers as $idx => $answer)
                        <tr class="@if($idx % 2 === 0) bg-slate-900/20 @endif">
                            <td class="px-4 py-3 align-top text-sm text-slate-300">{{ $idx + 1 }}</td>

                            <td class="px-4 py-3 align-top text-sm">
                                <div class="font-medium text-slate-100">{{ Str::limit($answer->question?->text ?? '-', 200) }}</div>
                                @if(!empty($answer->question?->explanation))
                                    <div class="text-xs text-muted-foreground mt-1">{{ Str::limit($answer->question->explanation, 120) }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-3 align-top text-sm">
                                @if($answer->question_choice_id && $answer->choice)
                                    <div class="inline-flex items-center gap-2">
                                        <span class="inline-block px-3 py-1 text-xs rounded bg-slate-800/60 text-slate-200">{{ $answer->choice->text }}</span>
                                    </div>
                                @else
                                    <div class="text-sm text-slate-200">{{ Str::limit($answer->answer ?? '-', 250) }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-3 align-top text-sm">
                                @if ($answer->is_correct)
                                    <span class="inline-flex items-center rounded px-2 py-1 text-xs font-medium bg-emerald-600/10 text-emerald-300 text-red">✔ Вірно</span>
                                @elseif($answer->is_correct === null)
                                    <span class="inline-flex items-center rounded px-2 py-1 text-xs font-medium bg-rose-600/10 text-rose-300">Потребує перевірки</span>
                                @else
                                    <span class="inline-flex items-center rounded px-2 py-1 text-xs font-medium bg-rose-600/10 text-rose-300 text-red"> ✖ Невірно</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page>
