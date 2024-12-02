<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AstrologerResource\Pages;
use App\Models\Astrologer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class AstrologerResource extends Resource
{
    protected static ?string $model = Astrologer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_no')
                            ->tel()
                            ->required()
                            ->maxLength(15),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\DateTimePicker::make('birth_date')
                            ->required(),
                        Forms\Components\FileUpload::make('profile_image')
                            ->image()
                            ->directory('astrologers'),
                        Forms\Components\Textarea::make('bio')
                            ->maxLength(65535)
                            ->columnSpanFull(),


                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->visible(fn ($context) => $context === 'create')
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn ($context) => $context === 'create')
                            ->visible(fn ($context) => $context === 'create'),
                    ])->columns(2),


                Forms\Components\Section::make('Professional Information')
                    ->schema([
                        Forms\Components\TextInput::make('primary_skill')
                            ->required(),
                        Forms\Components\TextInput::make('all_skill')
                            ->required(),
                        Forms\Components\TextInput::make('language_known')
                            ->required(),
                        Forms\Components\TextInput::make('experience_years')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('qualification'),
                        Forms\Components\Textarea::make('certification_details'),
                    ])->columns(2),

                Forms\Components\Section::make('Service Rates')
                    ->schema([
                        Forms\Components\TextInput::make('chat_rate')
                            ->numeric()
                            ->prefix('₹')
                            ->required(),
                        Forms\Components\TextInput::make('call_rate')
                            ->numeric()
                            ->prefix('₹')
                            ->required(),
                        Forms\Components\TextInput::make('video_call_rate')
                            ->numeric()
                            ->prefix('₹')
                            ->required(),
                        Forms\Components\TextInput::make('report_rate')
                            ->numeric()
                            ->prefix('₹')
                            ->required(),
                        Forms\Components\TextInput::make('commission_rate')
                            ->numeric()
                            ->suffix('%')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Verification')
                    ->schema([
                        Forms\Components\Toggle::make('is_verified')
                            ->required(),
                        Forms\Components\Select::make('account_status')
                            ->options([
                                'pending' => 'Pending',
                                'active' => 'Active',
                                'suspended' => 'Suspended',
                                'blocked' => 'Blocked',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('rejection_reason'),
                    ]),

//                Forms\Components\Section::make('Status & Verification')
//                    ->schema([
//                        Forms\Components\Toggle::make('is_verified')
//                            ->label('Verified Status')
//                            ->onColor('success')
//                            ->offColor('danger')
//                            ->required(),
//                        Forms\Components\Select::make('account_status')
//                            ->label('Account Status')
//                            ->options([
//                                'pending' => 'Pending',
//                                'active' => 'Active',
//                                'suspended' => 'Suspended',
//                                'blocked' => 'Blocked',
//                            ])
//                            ->required(),
//                        Forms\Components\Textarea::make('rejection_reason')
//                            ->label('Reason for Status Change')
//                            ->placeholder('Provide details if changing account status or verification')
//                            ->visibleOn('edit'), // Only show this field when editing
//                    ]),
            ]);
    }
    public static function mutateFormDataBeforeCreate($data): array
    {
        // Create user first
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);


        // Add user_id to astrologer data
        $data['user_id'] = $user->id;
        dd($data);
        // Remove password fields from astrologer data
        unset($data['password']);
        unset($data['password_confirmation']);

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_no')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('profile_image'),
                Tables\Columns\TextColumn::make('primary_skill'),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
                Tables\Columns\TextColumn::make('account_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'suspended' => 'danger',
                        'blocked' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->money('INR'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('account_status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'blocked' => 'Blocked',
                    ]),
                Tables\Filters\TernaryFilter::make('is_verified'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAstrologers::route('/'),
            'create' => Pages\CreateAstrologer::route('/create'),
            'edit' => Pages\EditAstrologer::route('/{record}/edit'),
        ];
    }
}
