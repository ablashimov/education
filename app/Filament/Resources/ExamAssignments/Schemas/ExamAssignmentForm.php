<?php

namespace App\Filament\Resources\ExamAssignments\Schemas;

use App\Models\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('exam_id')
                    ->label('Запланований екзамен')
                    ->relationship('exam', 'title')
//                    ->searchable()
//                    ->preload()
//                    ->live()
//                    ->optionsLimit(20)
                    ->disabled()
                    ->required(),
                Select::make('group_id')
                    ->label('Група')
                    ->relationship('group', 'name')
                    ->disabled()
//                    ->searchable()
//                    ->preload()
//                    ->live()
//                    ->optionsLimit(20)
                    ->required(),
                Select::make('user_id')
                    ->label('Користувач')
//                    ->searchable()
//                    ->preload()
//                    ->live()
//                    ->optionsLimit(20)
                    ->relationship(
                        'user',
                        'name',
//                        modifyQueryUsing: function ($query, $get) {
//                            $query->whereHas('groups', fn($q) => $q->where('groups.id', $get('group_id')));
//                        }
                    )
                    ->disabled()
                    ->required(),
                Select::make('exam_result_status_id')
                    ->label('Статус')
                    ->relationship('resultStatus', 'name')
                    ->required(),
                TextInput::make('attempts_allowed')
                    ->label('Дозволена кількість спроб')
                    ->required()
                    ->numeric(),
            ]);
    }
}
