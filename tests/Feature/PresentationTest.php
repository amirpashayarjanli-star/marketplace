<?php

use Illuminate\Support\Facades\Hash;

/*
| صفحه‌ی ارائه پشت رمز است. این تست‌ها می‌بندند که بدون رمز درست هیچ
| اسلایدی دیده نشود و قفل دوباره هم واقعاً قفل کند.
*/

beforeEach(function () {
    config(['presentation.password_hash' => Hash::make('secret-pass')]);
});

it('بدون رمز فقط فرم رمز را نشان می‌دهد', function () {

    $this->get(route('presentation.show'))
        ->assertOk()
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
        ->assertSee('شروع ارائه')
        ->assertDontSee('پشت صحنهٔ یک پیام');
});

it('رمز اشتباه را رد می‌کند و قفل می‌ماند', function () {

    $this->from(route('presentation.show'))
        ->post(route('presentation.unlock'), ['password' => 'wrong'])
        ->assertRedirect(route('presentation.show'))
        ->assertSessionHasErrors('password');

    $this->get(route('presentation.show'))
        ->assertDontSee('پشت صحنهٔ یک پیام');
});

it('با رمز درست اسلایدها باز می‌شوند', function () {

    $this->post(route('presentation.unlock'), ['password' => 'secret-pass'])
        ->assertRedirect(route('presentation.show'))
        ->assertSessionHasNoErrors();

    $this->get(route('presentation.show'))
        ->assertOk()
        ->assertSee('پشت صحنهٔ یک پیام')
        ->assertSee('پرسش و پاسخ');
});

it('دکمه‌ی قفل، ارائه را دوباره قفل می‌کند', function () {

    $this->post(route('presentation.unlock'), ['password' => 'secret-pass']);

    $this->post(route('presentation.lock'))
        ->assertRedirect(route('presentation.show'));

    $this->get(route('presentation.show'))
        ->assertSee('شروع ارائه')
        ->assertDontSee('پشت صحنهٔ یک پیام');
});
