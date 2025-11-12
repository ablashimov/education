<?php

namespace App\Filament\Resources\Lessons\Schemas;

use App\Filament\Resources\Modules\RelationManagers\LessonsRelationManager;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('module_id')
                    ->label('Модуль')
                    ->relationship('module', 'title')
                    ->required()
                    ->hiddenOn(LessonsRelationManager::class),
                TextInput::make('title')
                    ->maxValue(255)
                    ->label('Назва')
                    ->required(),
                RichEditor::make('material')
                    ->label('Матеріал')
                    ->required()
                    ->fileAttachmentsDirectory('lessons')
                    ->fileAttachmentsAcceptedFileTypes(
                        [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image/jpeg',
                            'video/mpeg',
                            'video/mp4',
                            'webm',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'image/png',
                            'video/x-msvideo',
                            'image/bmp',

                        ]
                    )
                    ->fileAttachmentsMaxSize(64 * 1024) // 64MB in KB (64 * 1024 = 65536KB)
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->label('Порядок')
                    ->numeric()
                    ->required(),

//                Repeater::make('existing_files')
//                    ->label('Прикріплені файли')
//                    ->relationship('files')
//                    ->schema([
//                        TextInput::make('name')
//                            ->label('Оригінальна назва')
//                            ->disabled(),
//
//                        Placeholder::make('download')
//                            ->label('Завантажити')
//                            ->content(fn ($get) => new HtmlString(
//                                '<a href="' . Storage::disk(config('filesystems.default'))->url($get('path')) . '" target="_blank" rel="noopener">Відкрити файл</a>'
//                            )),
//                    ])
//                    ->columns(2)
//                    ->deletable(true),
                FileUpload::make('files')
                    ->label('Файли')
                    ->directory('lessons')
                    ->downloadable()
                    ->openable()
                    ->acceptedFileTypes(
                        [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image/jpeg',
                            'video/mpeg',
                            'video/mp4',
                            'webm',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'image/png',
                            'video/x-msvideo',
                            'image/bmp',
                        ]
                    )
                    ->moveFiles()
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file) => Str::uuid().'.'.$file->getClientOriginalExtension()
                    )
                    ->storeFileNamesIn('original_names')
                    ->formatStateUsing(function ($record) {
                        if (! $record) {
                            return [];
                        }

                        return $record->files->pluck('path')->toArray();
                    })
                    ->dehydrated(false)
                    ->maxSize(64 * 1024)
                    ->multiple(),
                KeyValue::make('settings')
                    ->label('Налаштування')
                    ->nullable(),
            ]);
    }
}
