<?php

namespace App\Filament\Resources\AstrologerResource\Pages;

use App\Filament\Resources\AstrologerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAstrologers extends ListRecords
{
    protected static string $resource = AstrologerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
