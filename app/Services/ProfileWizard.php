<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| ProfileWizard
|--------------------------------------------------------------------------
|
| همه‌ی منطق «پروفایل چقدر کامل شده» اینجاست و از config/profile_steps.php
| خونده میشه. فرم، اعتبارسنجی و نوار پیشرفت همگی از همین یک منبع میان.
|
*/

class ProfileWizard
{
    public function __construct(
        private User $user
    ) {}


    public static function for(User $user): self
    {
        return new self($user);
    }


    /**
     * تعریف کامل این نوع حساب. اگر کاربر هنوز نوعش رو انتخاب نکرده null برمی‌گردونه.
     */
    public function definition(): ?array
    {
        if (! $this->user->type) {
            return null;
        }

        return config('profile_steps.' . $this->user->type);
    }


    /**
     * رکورد پروفایل (Company، Technician و ...) — اگر هنوز ساخته نشده null.
     */
    public function profile(): ?Model
    {
        $definition = $this->definition();

        if (! $definition) {
            return null;
        }

        return $this->user->{$definition['relation']};
    }


    /**
     * اگر پروفایل هنوز وجود نداره، یک رکورد خالی می‌سازه تا مرحله‌به‌مرحله پر بشه.
     * هیچ فیلدی مقدار پیش‌فرض ساختگی نمی‌گیره.
     */
    public function profileOrNew(): Model
    {
        $existing = $this->profile();

        if ($existing) {
            return $existing;
        }

        $definition = $this->definition();

        $model = new $definition['model']();
        $model->user_id = $this->user->id;

        // صریحاً false، تا حتی اگر پیش‌فرض ستون در دیتابیس چیز دیگری بود،
        // پروفایل تازه هرگز بدون تایید ادمین در سایت نمایان نشود.
        if ($model->isFillable('is_active')) {
            $model->is_active = false;
        }
        if ($model->isFillable('is_verified')) {
            $model->is_verified = false;
        }

        return $model;
    }


    /** @return array<string, array> کلید مرحله => تعریف مرحله */
    public function steps(): array
    {
        return $this->definition()['steps'] ?? [];
    }


    public function stepKeys(): array
    {
        return array_keys($this->steps());
    }


    public function step(string $key): ?array
    {
        return $this->steps()[$key] ?? null;
    }


    /**
     * فیلدهایی که برای کامل شدن حتماً باید مقدار داشته باشن
     * (فیلدهای optional حساب نمیشن).
     */
    public function requiredFields(string $stepKey): array
    {
        $step = $this->step($stepKey);

        if (! $step) {
            return [];
        }

        return array_keys(
            array_filter(
                $step['fields'],
                fn (array $field) => empty($field['optional'])
            )
        );
    }


    /**
     * آیا این مرحله تکمیل شده؟ یعنی همه‌ی فیلدهای اجباریش مقدار دارن.
     */
    public function isStepComplete(string $stepKey): bool
    {
        $profile = $this->profile();

        if (! $profile) {
            return false;
        }

        foreach ($this->requiredFields($stepKey) as $field) {

            $value = $profile->{$field};

            if ($value === null || $value === '' || (is_string($value) && trim($value) === '')) {
                return false;
            }
        }

        return true;
    }


    /** @return array<string, bool> کلید مرحله => تکمیل شده یا نه */
    public function stepStatuses(): array
    {
        $statuses = [];

        foreach ($this->stepKeys() as $key) {
            $statuses[$key] = $this->isStepComplete($key);
        }

        return $statuses;
    }


    public function completedStepCount(): int
    {
        return count(array_filter($this->stepStatuses()));
    }


    public function totalStepCount(): int
    {
        return count($this->stepKeys());
    }


    public function percentComplete(): int
    {
        $total = $this->totalStepCount();

        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->completedStepCount() / $total) * 100);
    }


    public function isComplete(): bool
    {
        return $this->totalStepCount() > 0
            && $this->completedStepCount() === $this->totalStepCount();
    }


    /**
     * اولین مرحله‌ی ناقص — همون جایی که کاربر باید ادامه بده.
     */
    public function nextIncompleteStep(): ?string
    {
        foreach ($this->stepKeys() as $key) {

            if (! $this->isStepComplete($key)) {
                return $key;
            }
        }

        return null;
    }


    /**
     * قوانین اعتبارسنجی یک مرحله.
     *
     * برای فیلدهای تصویر، اگر قبلاً آپلود شده، دوباره اجباری نیست
     * (کاربر نباید موقع ویرایش مجبور بشه عکس رو دوباره بفرسته).
     */
    public function rulesFor(string $stepKey): array
    {
        $step = $this->step($stepKey);

        if (! $step) {
            return [];
        }

        $profile = $this->profile();
        $rules = [];

        foreach ($step['fields'] as $name => $field) {

            $rule = $field['rules'];

            $alreadyUploaded = $field['type'] === 'image'
                && $profile
                && ! empty($profile->{$name});

            if ($alreadyUploaded) {
                $rule = str_replace('required|', 'nullable|', $rule);
            }

            $rules[$name] = $rule;
        }

        return $rules;
    }


    /**
     * برچسب فارسی فیلدها، تا پیام‌های خطا قابل فهم باشن.
     */
    public function attributeNamesFor(string $stepKey): array
    {
        $step = $this->step($stepKey);

        if (! $step) {
            return [];
        }

        return array_map(
            fn (array $field) => $field['label'],
            $step['fields']
        );
    }
}
