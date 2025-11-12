<?php

namespace App\Filament\Resources\Lessons\Pages;

use App\Filament\Resources\Lessons\LessonResource;
use App\Models\Lesson;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
//            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        /** @var Lesson $record */
        $record = $this->record;

        $files = $this->form->getComponent('files')?->getState();
        $originalNames = $this->form->getState()['original_names'] ?? [];
        $storage = \Storage::disk(config('filesystems.default'));


        $record->files
            ->reject(fn ($file) => in_array($file->path, $files))
            ->each(function ($file) use ($storage) {
                if ($storage->exists($file->path)) {
                    $storage->delete($file->path);
                }
                $file->delete();
            });

        foreach ($files as $path) {
            if (! $record->files()->where('path', $path)->exists()) {
                $record->files()->create([
                    'path' => $path,
                    'name' => $originalNames[$path] ?? basename($path),
                    'mime_type' => $storage->mimeType($path),
                    'size' => $storage->size($path),
                ]);
            }
        }
    }

}
