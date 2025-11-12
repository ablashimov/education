<?php

namespace App\Filament\Resources\Lessons\Pages;

use App\Filament\Resources\Lessons\LessonResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function afterSave(): void
    {
        $record = $this->record;
        $files = $this->form->getComponent('files')?->getState();
        $originalNames = $this->form->getState()['original_names'] ?? [];

        if (! empty($files)) {
            $disk = Storage::disk(config('filesystems.default'));
            foreach ($files as $path) {
                $record->files()->create([
                    'path' => $path,
                    'name' => $originalNames[$path] ?? basename($path),
                    'mime_type' => $disk->mimeType($path),
                    'size' => $disk->size($path),
                ]);
            }
        }
    }
}
