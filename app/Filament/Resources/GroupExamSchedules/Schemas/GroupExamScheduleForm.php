<?php

namespace App\Filament\Resources\GroupExamSchedules\Schemas;

use App\Models\Group;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class GroupExamScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->relationship('group', 'name')
                    ->label('Група')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(20)
                    ->live()
                    ->required(),
                Select::make('exam_id')
                    ->label('Екзамен')
                    ->relationship('exam', 'title', modifyQueryUsing: function ($query, $get) {
                        $group = Group::find($get('group_id'));
                        $query->where('course_id', $group?->course_id);
                    })
                    ->preload()
                    ->optionsLimit(20)
                    ->searchable()
                    ->required(),
                DateTimePicker::make('start_at')
                    ->label('Початок')
                    ->format('Y-m-d H:i')
                    ->required(),
                DateTimePicker::make('end_at')
                    ->label('Кінець')
                    ->format('Y-m-d H:i')
                    ->required(),
            ]);
    }
}
