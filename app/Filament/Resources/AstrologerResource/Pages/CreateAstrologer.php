<?php

namespace App\Filament\Resources\AstrologerResource\Pages;

use App\Filament\Resources\AstrologerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Models\Astrologer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class CreateAstrologer extends CreateRecord
{
    protected static string $resource = AstrologerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Create user first
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create astrologer with all the fields
        return Astrologer::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'profile_image' => $data['profile_image'] ?? null,
            'bio' => $data['bio'] ?? null,
            'primary_skill' => $data['primary_skill'],
            'all_skill' => $data['all_skill'],
            'language_known' => $data['language_known'],
            'experience_years' => $data['experience_years'],
            'qualification' => $data['qualification'] ?? null,
            'certification_details' => $data['certification_details'] ?? null,
            'chat_rate' => $data['chat_rate'],
            'call_rate' => $data['call_rate'],
            'video_call_rate' => $data['video_call_rate'],
            'report_rate' => $data['report_rate'],
            'commission_rate' => $data['commission_rate'],
            'is_verified' => $data['is_verified'],
            'account_status' => $data['account_status'],
            'rejection_reason' => $data['rejection_reason'] ?? null,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
