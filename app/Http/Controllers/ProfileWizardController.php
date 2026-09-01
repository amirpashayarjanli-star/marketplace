<?php

namespace App\Http\Controllers;

use App\Services\ProfileWizard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| ویزارد تکمیل پروفایل
|--------------------------------------------------------------------------
|
| کاربر بعد از ثبت‌نام اینجا میاد و مرحله‌به‌مرحله همه‌ی فیلدهایی که در سایت
| نمایش داده میشن رو خودش پر می‌کنه. هیچ فیلدی مقدار پیش‌فرض ساختگی نمی‌گیره.
|
| وقتی همه‌ی مراحل کامل شد → وضعیت pending، منتظر تایید ادمین.
| تا قبل از تایید ادمین، پروفایل در سایت دیده نمیشه (is_active = false).
|
*/

class ProfileWizardController extends Controller
{
    /**
     * انتخاب نوع حساب — اولین قدم، قبل از هر چیز دیگه.
     */
    public function chooseType()
    {
        $user = Auth::user();

        if ($user->type === 'customer') {
            return redirect()->route('service.setup');
        }

        if ($user->type) {
            return redirect()->route('profile.wizard');
        }

        return view('dashboard.wizard.type', [
            'types' => config('profile_steps'),
        ]);
    }


    public function saveType(Request $request)
    {
        $user = Auth::user();

        if ($user->type) {
            return redirect()->route('profile.wizard');
        }

        $validTypes = array_merge(array_keys(config('profile_steps')), ['customer']);

        $validated = $request->validate([
            'type' => ['required', 'in:' . implode(',', $validTypes)],
        ], [
            'type.required' => 'لطفاً نوع حساب خود را انتخاب کنید.',
            'type.in'       => 'نوع حساب انتخاب‌شده معتبر نیست.',
        ]);

        $user->update(['type' => $validated['type']]);

        // مشتری از مسیر ویزارد کسب‌وکارها جداست — فرم سبک خودشو داره
        if ($validated['type'] === 'customer') {
            return redirect()->route('service.setup');
        }

        return redirect()->route('profile.wizard');
    }


    /**
     * نمای کلی: همه‌ی مراحل، وضعیت هرکدام، و درصد تکمیل.
     */
    public function overview()
    {
        $user = Auth::user();

        if ($user->type === 'customer') {
            return redirect()->route('service.setup');
        }

        if (! $user->type) {
            return redirect()->route('profile.wizard.type');
        }

        $wizard = ProfileWizard::for($user);

        return view('dashboard.wizard.overview', [
            'wizard'   => $wizard,
            'steps'    => $wizard->steps(),
            'statuses' => $wizard->stepStatuses(),
            'percent'  => $wizard->percentComplete(),
            'next'     => $wizard->nextIncompleteStep(),
        ]);
    }


    /**
     * فرم یک مرحله.
     */
    public function editStep(string $step)
    {
        $user = Auth::user();

        if (! $user->type) {
            return redirect()->route('profile.wizard.type');
        }

        $wizard = ProfileWizard::for($user);

        if (! $wizard->step($step)) {
            abort(404);
        }

        return view('dashboard.wizard.step', [
            'wizard'    => $wizard,
            'stepKey'   => $step,
            'step'      => $wizard->step($step),
            'profile'   => $wizard->profile(),
            'stepKeys'  => $wizard->stepKeys(),
            'statuses'  => $wizard->stepStatuses(),
            'percent'   => $wizard->percentComplete(),
            'provinces' => config('provinces'),
        ]);
    }


    /**
     * ذخیره‌ی یک مرحله و رفتن به مرحله‌ی بعد.
     */
    public function saveStep(Request $request, string $step)
    {
        $user = Auth::user();

        if (! $user->type) {
            return redirect()->route('profile.wizard.type');
        }

        $wizard = ProfileWizard::for($user);
        $definition = $wizard->step($step);

        if (! $definition) {
            abort(404);
        }

        // پروفایل تاییدشده دیگر از این مسیر ویرایش نمی‌شود،
        // چون تغییرش باید دوباره از تایید ادمین رد شود.
        if ($user->status === 'approved') {
            return redirect()
                ->route('profile.wizard')
                ->with('error', 'پروفایل تایید شده از این مسیر قابل تغییر نیست.');
        }

        $validated = $request->validate(
            $wizard->rulesFor($step),
            [],
            $wizard->attributeNamesFor($step)
        );

        $profile = $wizard->profileOrNew();

        foreach ($definition['fields'] as $name => $field) {

            if ($field['type'] === 'image') {

                if ($request->hasFile($name)) {

                    // فایل قبلی را پاک می‌کنیم تا فضای هاست بی‌جهت پر نشود
                    if (! empty($profile->{$name})) {
                        Storage::disk('public')->delete($profile->{$name});
                    }

                    $profile->{$name} = $request->file($name)->store(
                        'profiles/' . $user->type,
                        'public'
                    );
                }

                continue;
            }

            $value = $validated[$name] ?? null;

            $profile->{$name} = is_string($value) ? trim($value) : $value;
        }

        $profile->save();

        // نام کاربر برای هدر و سلام داشبورد از نام پروفایلش همگام می‌شود
        // (ثبت‌نام دیگر نام نمی‌پرسد، این تنها جایی است که نام از کاربر گرفته می‌شود)
        if (! empty($profile->name) && $user->name !== $profile->name) {
            $user->update(['name' => $profile->name]);
        }

        // وضعیت را از نو حساب می‌کنیم چون رکورد تازه ذخیره شده
        $fresh = ProfileWizard::for($user->fresh());
        $next = $fresh->nextIncompleteStep();

        if ($next) {
            return redirect()
                ->route('profile.wizard.step', $next)
                ->with('success', 'مرحله «' . $definition['title'] . '» ذخیره شد.');
        }

        return redirect()
            ->route('profile.wizard')
            ->with('success', 'همه‌ی مراحل تکمیل شد. حالا می‌توانید پروفایل را برای بررسی ارسال کنید.');
    }


    /**
     * ارسال برای بررسی ادمین.
     */
    public function submit()
    {
        $user = Auth::user();
        $wizard = ProfileWizard::for($user);

        if (! $wizard->isComplete()) {
            return redirect()
                ->route('profile.wizard')
                ->with('error', 'هنوز همه‌ی مراحل کامل نشده است.');
        }

        if ($user->status === 'approved') {
            return redirect()->route('profile.wizard');
        }

        $user->update(['status' => 'pending']);

        return redirect()
            ->route('profile.wizard')
            ->with('success', 'پروفایل شما برای بررسی ارسال شد. پس از تایید مدیر، در سایت نمایش داده می‌شود.');
    }
}
