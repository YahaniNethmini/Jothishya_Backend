<?php

namespace App\Filament\Resources\AstrologerResource\Pages;

use App\Filament\Resources\AstrologerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAstrologer extends EditRecord
{
    protected static string $resource = AstrologerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
