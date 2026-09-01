<?php

namespace App\Filament\Admin\Resources\Auctions\Schemas;

use App\Models\Auction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AuctionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Select::make('source')
                ->label('منبع')
                ->options(Auction::SOURCES)
                ->default('external')
                ->required()
                ->live()
                ->helperText('«سامانه ستاد» برای مناقصه‌هایی که خودت از setadiran می‌آوری.'),

            Select::make('status')
                ->label('وضعیت')
                ->options(Auction::STATUSES)
                ->default('active')
                ->required()
                ->helperText('برای مناقصه‌های کارفرما، از دکمه‌ی «تایید و انتشار» در فهرست استفاده کن تا زمان شروع درست ثبت شود.'),

            TextInput::make('title')
                ->label('عنوان فراخوان')
                ->required()
                ->maxLength(150)
                ->columnSpanFull(),

            Select::make('scope')
                ->label('نوع کار')
                ->options(Auction::SCOPES)
                ->default('install')
                ->required(),

            Toggle::make('bids_enabled')
                ->label('ثبت پیشنهاد روی سایت فعال باشد')
                ->default(true),

            Textarea::make('description')
                ->label('شرح فراخوان')
                ->rows(5)
                ->columnSpanFull(),

            TextInput::make('province')
                ->label('استان')
                ->maxLength(60),

            TextInput::make('city')
                ->label('شهر')
                ->maxLength(60),

            /*
            | فیلدهای سامانه ستاد
            */
            TextInput::make('tender_no')
                ->label('شماره فراخوان')
                ->maxLength(120)
                ->visible(fn ($get) => $get('source') === 'external'),

            TextInput::make('organization')
                ->label('دستگاه مناقصه‌گزار')
                ->maxLength(200)
                ->visible(fn ($get) => $get('source') === 'external'),

            TextInput::make('category')
                ->label('طبقه‌بندی موضوعی')
                ->maxLength(200)
                ->visible(fn ($get) => $get('source') === 'external'),

            TextInput::make('source_url')
                ->label('لینک صفحه‌ی ستاد')
                ->url()
                ->maxLength(500)
                ->visible(fn ($get) => $get('source') === 'external')
                ->columnSpanFull(),

            DateTimePicker::make('published_at')
                ->label('تاریخ انتشار در ستاد')
                ->visible(fn ($get) => $get('source') === 'external'),

            TextInput::make('budget_max')
                ->label('سقف بودجه (تومان)')
                ->numeric()
                ->helperText('اختیاری — پیشنهاد بالاتر از این مبلغ پذیرفته نمی‌شود.'),

            DateTimePicker::make('starts_at')
                ->label('زمان شروع'),

            DateTimePicker::make('ends_at')
                ->label('پایان مهلت'),

            TextInput::make('anti_snipe_minutes')
                ->label('تمدید ضد اسنایپ (دقیقه)')
                ->numeric()
                ->default(config('proauction.anti_snipe_minutes', 10)),

            TextInput::make('fee_percent')
                ->label('درصد کارمزد هر پیشنهاد')
                ->numeric()
                ->step(0.01)
                ->default(config('proauction.fee_percent', 5))
                ->helperText('روی مزایده‌های در حال برگزاری تغییرش نده.'),

            /*
            | مشاوره‌ی پیش از انتشار (فقط مزایده‌ی کارفرما)
            */
            TextInput::make('consultation_fee')
                ->label('هزینه‌ی مشاوره (تومان)')
                ->numeric()
                ->default(0)
                ->visible(fn ($get) => $get('source') === 'onsite')
                ->helperText('اگر بزرگ‌تر از صفر باشد، تا پرداخت نشدن، مزایده منتشر نمی‌شود.'),

            DateTimePicker::make('consultation_paid_at')
                ->label('زمان پرداخت هزینه‌ی مشاوره')
                ->visible(fn ($get) => $get('source') === 'onsite'),

            DateTimePicker::make('consulted_at')
                ->label('زمان ثبت مشاوره')
                ->visible(fn ($get) => $get('source') === 'onsite'),

            Textarea::make('consultation_note')
                ->label('یادداشت مشاوره')
                ->rows(3)
                ->visible(fn ($get) => $get('source') === 'onsite')
                ->columnSpanFull(),

        ]);
    }
}
