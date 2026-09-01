<?php

namespace App\Filament\Admin\Support;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

/*
|--------------------------------------------------------------------------
| بخش مشترک پروفایل‌های دایرکتوری
|--------------------------------------------------------------------------
|
| شرکت، تولیدکننده، فروشگاه، تکنسین و کارفرما ستون‌های یکسانی دارند:
| نام و تماس و محل، به‌علاوه‌ی دو کلید is_active/is_verified که تعیین
| می‌کنند پروفایل در سایت دیده شود یا نه.
|
| این کلاس همان بخش مشترک را می‌سازد تا هر ریسورس فقط ستون‌های خاص
| خودش را اضافه کند، نه اینکه پنج نسخه‌ی کمی‌متفاوت از یک جدول داشته
| باشیم که برچسب‌هایشان با هم فرق کند.
|
*/
class DirectoryProfile
{
    /**
     * @param  array<int, \Filament\Tables\Columns\Column>  $extraColumns
     */
    public static function table(Table $table, array $extraColumns = [], bool $hasRating = true): Table
    {
        $columns = [

            TextColumn::make('name')
                ->label('نام')
                ->searchable()
                ->limit(35),

            TextColumn::make('mobile')
                ->label('موبایل')
                ->searchable()
                ->copyable()
                ->placeholder('—'),

            TextColumn::make('city')
                ->label('شهر')
                ->placeholder('—')
                ->searchable(),

        ];

        $columns = array_merge($columns, $extraColumns);

        if ($hasRating) {
            $columns[] = TextColumn::make('rating')
                ->label('امتیاز')
                ->formatStateUsing(fn ($state) => number_format((float) $state, 1))
                ->description(fn ($record) => $record->reviews_count . ' نظر')
                ->sortable();
        }

        $columns[] = IconColumn::make('is_active')
            ->label('در سایت')
            ->boolean();

        $columns[] = IconColumn::make('is_verified')
            ->label('تایید شده')
            ->boolean();

        $columns[] = TextColumn::make('created_at')
            ->label('ثبت')
            ->dateTime('Y/m/d')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);

        return $table
            ->defaultSort('created_at', 'desc')

            ->columns($columns)

            ->filters([

                TernaryFilter::make('is_active')
                    ->label('نمایش در سایت')
                    ->placeholder('همه')
                    ->trueLabel('نمایش داده می‌شود')
                    ->falseLabel('پنهان'),

                TernaryFilter::make('is_verified')
                    ->label('تایید')
                    ->placeholder('همه')
                    ->trueLabel('تایید شده')
                    ->falseLabel('تایید نشده'),

                SelectFilter::make('province')
                    ->label('استان')
                    ->options(fn () => $table->getModel()::query()
                        ->whereNotNull('province')
                        ->distinct()
                        ->pluck('province', 'province')
                        ->all()),

            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }


    /**
     * فیلدهای مشترک فرم. هر ریسورس آن‌ها را با فیلدهای خودش ترکیب می‌کند.
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function formSections(array $extraFields = [], bool $hasGate = true): array
    {
        $sections = [

            Section::make('شناسه')
                ->schema(array_merge([

                    TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('mobile')
                        ->label('موبایل')
                        ->tel()
                        ->maxLength(20),

                    TextInput::make('phone')
                        ->label('تلفن ثابت')
                        ->tel()
                        ->maxLength(30),

                ], $extraFields))
                ->columns(2),

            Section::make('محل')
                ->schema([

                    TextInput::make('province')
                        ->label('استان')
                        ->maxLength(100),

                    TextInput::make('city')
                        ->label('شهر')
                        ->maxLength(100),

                    Textarea::make('address')
                        ->label('آدرس')
                        ->rows(2)
                        ->columnSpanFull(),

                ])
                ->columns(2),

            Section::make('معرفی')
                ->schema([

                    Textarea::make('description')
                        ->label('توضیحات')
                        ->rows(4)
                        ->columnSpanFull(),

                ]),

        ];

        if ($hasGate) {

            $sections[] = Section::make('نمایش در سایت')
                ->description('تا وقتی «نمایش در سایت» خاموش باشد، پروفایل در دایرکتوری دیده نمی‌شود.')
                ->schema([

                    Toggle::make('is_active')
                        ->label('نمایش در سایت'),

                    Toggle::make('is_verified')
                        ->label('نشان تایید'),

                ])
                ->columns(2);

        }

        return $sections;
    }
}
