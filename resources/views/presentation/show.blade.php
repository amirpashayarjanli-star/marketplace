@extends('presentation.layout')

@section('styles')
    body { overflow: hidden; background: #0b1120; }

    /*
    | صحنه همیشه ۱۲۸۰×۷۲۰ است و با transform به اندازه‌ی صفحه‌نمایش
    | کوچک/بزرگ می‌شود؛ پس روی پروژکتور، لپ‌تاپ و گوشی چیدمان یکی است.
    */
    .stage {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 1280px;
        height: 720px;
        transform-origin: center center;
        background: var(--paper);
        overflow: hidden;
        border-radius: 6px;
    }

    .slide {
        position: absolute;
        inset: 0;
        padding: 64px 80px 72px;
        display: flex;
        flex-direction: column;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-24px);
        transition: opacity .35s ease, transform .35s ease, visibility 0s linear .35s;
    }

    .slide.is-active {
        opacity: 1;
        visibility: visible;
        transform: none;
        transition: opacity .35s ease, transform .35s ease;
    }

    .slide.is-past { transform: translateX(24px); }

    .slide .notes { display: none; }

    .kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: 700;
        color: var(--brand);
    }

    .kicker::before {
        content: '';
        width: 28px;
        height: 4px;
        border-radius: 4px;
        background: currentColor;
    }

    h2 {
        margin: 0 0 32px;
        font-size: 46px;
        font-weight: 800;
        line-height: 1.3;
    }

    .lead { font-size: 26px; line-height: 1.8; color: var(--ink-soft); margin: 0; }

    .lead strong { color: var(--ink); }

    .grow { flex: 1; min-height: 0; }

    .row { display: flex; gap: 28px; }

    .col { flex: 1; min-width: 0; }

    .card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 22px;
        padding: 26px 30px;
        box-shadow: 0 10px 30px -18px rgba(15, 23, 42, .3);
    }

    .card h3 { margin: 0 0 14px; font-size: 28px; font-weight: 800; }

    .card p { margin: 0; font-size: 21px; line-height: 1.75; color: var(--ink-soft); }

    .facts { list-style: none; margin: 0; padding: 0; }

    .facts li {
        display: flex;
        gap: 12px;
        font-size: 21px;
        line-height: 1.6;
        padding: 7px 0;
        border-bottom: 1px dashed var(--line);
    }

    .facts li:last-child { border-bottom: 0; }

    .facts b { flex: 0 0 120px; color: var(--ink-faint); font-weight: 600; }

    .chip {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 18px;
        font-weight: 700;
        background: var(--brand-soft);
        color: var(--brand);
        margin: 0 0 6px 6px;
    }

    .layer-badge {
        display: inline-grid;
        place-items: center;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        margin-left: 12px;
        vertical-align: middle;
    }

    .layer-card { border-top: 6px solid var(--c); }

    .layer-card h3 { display: flex; align-items: center; }

    .layer-card .layer-badge { background: var(--c); }

    .hint {
        margin-top: auto;
        padding: 16px 22px;
        border-radius: 16px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        font-size: 20px;
        color: #9a3412;
    }

    /* ---------- اسلاید عنوان ---------- */

    .slide.title-slide {
        justify-content: center;
        background:
            radial-gradient(circle at 90% 10%, var(--brand-soft), transparent 40%),
            radial-gradient(circle at 5% 95%, #fce7f3, transparent 35%),
            var(--paper);
    }

    .title-slide h1 { margin: 0; font-size: 84px; font-weight: 900; line-height: 1.25; }

    .title-slide .sub {
        margin: 12px 0 48px;
        font-size: 40px;
        font-weight: 700;
        color: var(--brand);
    }

    .title-slide .people { display: flex; gap: 18px; }

    .title-slide .person {
        padding: 16px 24px;
        border-radius: 18px;
        background: var(--card);
        border: 1px solid var(--line);
        font-size: 22px;
    }

    .title-slide .person small { display: block; color: var(--ink-faint); font-size: 16px; }

    .title-stack {
        position: absolute;
        left: 90px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .title-stack span {
        display: block;
        width: 300px;
        height: 44px;
        border-radius: 12px;
        opacity: .9;
    }

    /* ---------- پشته‌ی لایه‌ها ---------- */

    .stack { display: flex; flex-direction: column; gap: 8px; }

    .stack .layer {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0 18px;
        height: 52px;
        border-radius: 14px;
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        background: var(--c);
    }

    .stack .layer .n {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: rgba(255, 255, 255, .25);
        font-size: 20px;
    }

    .stack .layer .en {
        margin-right: auto;
        font-size: 18px;
        font-weight: 500;
        opacity: .9;
        direction: ltr;
    }

    .stack .layer .en b { font-weight: 900; font-size: 22px; text-decoration: underline; }

    .mnemonic {
        direction: ltr;
        font-size: 24px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.6;
    }

    .mnemonic b { color: var(--brand); font-size: 30px; }

    /* ---------- نگاشت OSI به TCP/IP ---------- */

    .map { display: grid; grid-template-columns: 1fr 1fr 1.35fr; gap: 10px 22px; }

    .map .head { font-size: 20px; font-weight: 800; color: var(--ink-faint); padding-bottom: 4px; }

    .map .osi {
        display: flex;
        align-items: center;
        padding: 0 16px;
        height: 50px;
        border-radius: 12px;
        background: var(--c);
        color: #fff;
        font-size: 20px;
        font-weight: 700;
    }

    .map .tcp {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        border: 3px solid var(--c);
        background: color-mix(in srgb, var(--c) 10%, white);
        color: var(--c);
        font-size: 24px;
        font-weight: 800;
    }

    .map .proto {
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        gap: 6px;
        font-size: 18px;
        color: var(--ink-soft);
    }

    .map .proto span {
        padding: 3px 12px;
        border-radius: 8px;
        background: var(--card);
        border: 1px solid var(--line);
        direction: ltr;
    }

    /* ---------- دست‌دهی سه‌مرحله‌ای ---------- */

    .handshake { position: relative; height: 250px; margin-top: 8px; }

    .handshake .end {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 110px;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 20px;
        font-weight: 800;
    }

    .handshake .end::after {
        content: '';
        flex: 1;
        width: 4px;
        margin-top: 8px;
        border-radius: 4px;
        background: var(--line);
    }

    .handshake .client { right: 0; }

    .handshake .server { left: 0; }

    .handshake .msg {
        position: absolute;
        right: 70px;
        left: 70px;
        height: 3px;
        background: var(--c);
    }

    .handshake .msg span {
        position: absolute;
        left: 50%;
        top: -38px;
        transform: translateX(-50%);
        padding: 2px 14px;
        border-radius: 8px;
        background: var(--c);
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        direction: ltr;
        white-space: nowrap;
    }

    .handshake .msg::after {
        content: '';
        position: absolute;
        top: -8px;
        border: 9px solid transparent;
    }

    .handshake .to-server::after { left: -4px; border-right-color: var(--c); border-left: 0; }

    .handshake .to-client::after { right: -4px; border-left-color: var(--c); border-right: 0; }

    /* ---------- جدول ---------- */

    table.compare { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 21px; }

    table.compare th, table.compare td { padding: 13px 20px; text-align: right; border-bottom: 1px solid var(--line); }

    table.compare thead th { font-size: 22px; font-weight: 800; color: #fff; background: var(--ink); }

    table.compare thead th:first-child { border-radius: 0 14px 0 0; background: transparent; color: var(--ink-faint); }

    table.compare thead th:last-child { border-radius: 14px 0 0 0; }

    table.compare tbody th { color: var(--ink-faint); font-weight: 700; width: 24%; }

    table.compare tbody td { background: var(--card); }

    table.compare td.num { font-size: 28px; font-weight: 900; }

    .ports { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; }

    .port {
        text-align: center;
        padding: 22px 10px;
        border-radius: 20px;
        background: var(--card);
        border: 1px solid var(--line);
    }

    .port .name { font-size: 24px; font-weight: 800; direction: ltr; }

    .port .num { margin: 6px 0; font-size: 44px; font-weight: 900; color: var(--l7); }

    .port .what { font-size: 17px; color: var(--ink-soft); }

    /* ---------- کپسوله‌سازی ---------- */

    .encap { display: flex; flex-direction: column; gap: 12px; }

    .encap .line { display: flex; align-items: center; gap: 18px; }

    .encap .label { flex: 0 0 210px; font-size: 19px; font-weight: 700; color: var(--ink-soft); }

    .encap .label small { display: block; font-weight: 500; color: var(--ink-faint); font-size: 16px; }

    .encap .pdu { display: flex; direction: ltr; height: 50px; }

    .encap .pdu span {
        display: grid;
        place-items: center;
        padding: 0 16px;
        color: #fff;
        font-size: 17px;
        font-weight: 800;
        background: var(--c);
        border-left: 2px solid rgba(255, 255, 255, .6);
    }

    .encap .pdu span:first-child { border-radius: 10px 0 0 10px; border-left: 0; }

    .encap .pdu span:last-child { border-radius: 0 10px 10px 0; }

    .encap .pdu span:only-child { border-radius: 10px; }

    .encap .pdu .data { min-width: 190px; }

    .bits {
        direction: ltr;
        font-family: ui-monospace, Consolas, monospace;
        font-size: 22px;
        letter-spacing: .15em;
        color: var(--l1);
        font-weight: 700;
    }

    /* ---------- جمع‌بندی و پرسش ---------- */

    .big-quote {
        font-size: 40px;
        font-weight: 800;
        line-height: 1.6;
        text-align: center;
        margin: auto 0;
    }

    .big-quote em { font-style: normal; color: var(--brand); }

    .qa-slide { justify-content: center; align-items: center; text-align: center; }

    .qa-mark {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 130px;
        font-weight: 900;
        color: #fff;
        background: linear-gradient(135deg, var(--l5), var(--l7));
        margin-bottom: 30px;
    }

    .qa-slide h2 { margin-bottom: 10px; font-size: 60px; }

    .slide-no {
        position: absolute;
        left: 40px;
        bottom: 26px;
        font-size: 16px;
        color: var(--ink-faint);
    }

    /* ---------- نوار کنترل ---------- */

    .progress {
        position: fixed;
        top: 0;
        right: 0;
        height: 4px;
        background: var(--brand);
        transition: width .35s ease;
        z-index: 20;
    }

    .controls {
        position: fixed;
        left: 50%;
        bottom: 14px;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 6px;
        border-radius: 16px;
        background: rgba(15, 23, 42, .85);
        color: #fff;
        z-index: 30;
        opacity: .15;
        transition: opacity .25s ease;
    }

    .controls:hover, .controls:focus-within, body.show-ui .controls { opacity: 1; }

    .controls button {
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: inherit;
        cursor: pointer;
    }

    .controls button:hover { background: rgba(255, 255, 255, .15); }

    .controls button[aria-pressed="true"] { background: var(--brand); }

    .controls .counter { min-width: 76px; text-align: center; font-size: 15px; font-weight: 700; }

    .controls form { display: contents; }

    .controls .sep { width: 1px; height: 22px; background: rgba(255, 255, 255, .2); margin: 0 4px; }

    .notes-panel {
        position: fixed;
        right: 0;
        left: 0;
        bottom: 0;
        max-height: 42vh;
        overflow-y: auto;
        padding: 22px 28px 80px;
        background: rgba(255, 255, 255, .97);
        border-top: 4px solid var(--brand);
        box-shadow: 0 -12px 40px rgba(0, 0, 0, .35);
        font-size: 19px;
        line-height: 2;
        z-index: 25;
        transform: translateY(100%);
        transition: transform .3s ease;
    }

    body.show-notes .notes-panel { transform: none; }

    .notes-panel h4 { margin: 0 0 6px; font-size: 15px; color: var(--brand); }

    .notes-panel p { margin: 0 0 10px; }

    .notes-panel ol { margin: 0; padding-right: 24px; }

    .notes-panel li { margin-bottom: 8px; }

    .notes-panel li b { display: block; }

    .notes-panel .group { margin: 12px 0 4px; font-weight: 800; color: var(--ink-faint); }

    .help {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(2, 6, 23, .7);
        z-index: 40;
    }

    body.show-help .help { display: flex; }

    .help-box {
        background: #fff;
        border-radius: 20px;
        padding: 28px 34px;
        font-size: 18px;
        line-height: 2.1;
        min-width: 340px;
    }

    .help-box kbd {
        display: inline-block;
        min-width: 30px;
        padding: 0 8px;
        border-radius: 6px;
        border: 1px solid var(--line);
        background: var(--paper);
        text-align: center;
        font-family: inherit;
        direction: ltr;
    }
@endsection

@section('content')
    <div class="progress" id="progress"></div>

    <main class="stage" id="stage" aria-live="polite">

        {{-- ۱ --}}
        <section class="slide title-slide">
            <div>
                <div class="kicker">ارائهٔ کلاسی شبکه</div>
                <h1>مدل‌های لایه‌ای<br>شبکه</h1>
                <div class="sub"><span class="ltr">OSI</span> و <span class="ltr">TCP/IP</span></div>
                <div class="people">
                    <div class="person"><small>نفر اول</small>مدل <span class="ltr">OSI</span></div>
                    <div class="person"><small>نفر دوم</small><span class="ltr">TCP/IP</span> و مقایسه</div>
                </div>
            </div>
            <div class="title-stack" aria-hidden="true">
                <span style="background: var(--l7)"></span>
                <span style="background: var(--l6)"></span>
                <span style="background: var(--l5)"></span>
                <span style="background: var(--l4)"></span>
                <span style="background: var(--l3)"></span>
                <span style="background: var(--l2)"></span>
                <span style="background: var(--l1)"></span>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>سلام، وقت همه بخیر. موضوع ارائهٔ ما «مدل‌های لایه‌ای شبکه» است: اول مدل OSI و بعد مدل TCP/IP.</p>
            </aside>
        </section>

        {{-- ۲ --}}
        <section class="slide">
            <div class="kicker">مقدمه</div>
            <h2>پشت صحنهٔ یک پیام</h2>
            <div class="row grow">
                <div class="col">
                    <p class="lead">وقتی یک پیام در <strong>واتس‌اپ</strong> می‌فرستیم یا یک <strong>سایت</strong> را باز می‌کنیم، ده‌ها کار پشت صحنه انجام می‌شود.</p>
                    <div class="hint" style="margin-top: 40px">سؤال اصلی: این همه کار چطور <b>منظم و قابل فهم</b> می‌ماند؟</div>
                </div>
                <div class="col">
                    <ul class="facts card">
                        <li>پیدا کردن آدرس مقصد</li>
                        <li>تکه‌تکه کردن داده</li>
                        <li>رساندن داده به برنامهٔ درست</li>
                        <li>پیدا کردن بهترین مسیر</li>
                        <li>بررسی خطا و ارسال دوباره</li>
                        <li>تبدیل به سیگنال روی سیم یا هوا</li>
                    </ul>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>وقتی یک پیام در واتس‌اپ می‌فرستیم یا یک سایت را باز می‌کنیم، ده‌ها کار پشت صحنه انجام می‌شود. سؤال این است که این همه کار چطور منظم و قابل فهم می‌ماند.</p>
            </aside>
        </section>

        {{-- ۳ --}}
        <section class="slide">
            <div class="kicker">ایدهٔ اصلی</div>
            <h2>چرا مدل لایه‌ای؟ تقسیم کار!</h2>
            <p class="lead" style="margin-bottom: 34px">هر لایه <strong>فقط یک وظیفهٔ مشخص</strong> دارد؛ از لایهٔ پایینی سرویس می‌گیرد و به لایهٔ بالایی سرویس می‌دهد.</p>
            <div class="row">
                <div class="card col layer-card" style="--c: var(--l3)">
                    <h3>تعویض آسان</h3>
                    <p>یک لایه را عوض می‌کنیم، مثلاً از کابل به وای‌فای، و بقیهٔ لایه‌ها دست نمی‌خورند.</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l4)">
                    <h3>سازگاری</h3>
                    <p>تجهیزات شرکت‌های مختلف می‌توانند با هم کار کنند.</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l7)">
                    <h3>عیب‌یابی ساده</h3>
                    <p>مشکل را لایه‌به‌لایه پیدا می‌کنیم: اول کابل، بعد IP، بعد پورت.</p>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>جواب، تقسیم کار است. کار ارتباط را به چند لایه می‌شکنیم و هر لایه فقط یک وظیفهٔ مشخص دارد. هر لایه از لایهٔ پایینی سرویس می‌گیرد و به لایهٔ بالایی سرویس می‌دهد. مزیتش این است که می‌توانیم یک لایه را عوض کنیم، مثلاً از کابل به وای‌فای برویم، بدون اینکه بقیهٔ لایه‌ها تغییر کنند. همچنین تجهیزات شرکت‌های مختلف می‌توانند با هم کار کنند و عیب‌یابی هم ساده‌تر می‌شود.</p>
            </aside>
        </section>

        {{-- ۴ --}}
        <section class="slide">
            <div class="kicker">مدل <span class="ltr">OSI</span></div>
            <h2>هفت لایهٔ <span class="ltr">OSI</span></h2>
            <div class="row grow">
                <div class="col">
                    <ul class="facts">
                        <li><b>نام کامل</b><span><span class="ltr">Open Systems Interconnection</span></span></li>
                        <li><b>سازنده</b><span>سازمان <span class="ltr">ISO</span>، سال ۱۹۸۴</span></li>
                        <li><b>تعداد لایه</b>هفت لایه</li>
                        <li><b>نوع</b>مدل مرجع و آموزشی؛ چارچوبی برای فهمیدن شبکه، نه پروتکلی که مستقیم اجرا شود</li>
                    </ul>
                    <div class="hint">
                        برای حفظ کردن، از پایین به بالا:
                        <div class="mnemonic"><b>P</b>lease <b>D</b>o <b>N</b>ot <b>T</b>hrow <b>S</b>ausage <b>P</b>izza <b>A</b>way</div>
                    </div>
                </div>
                <div class="col">
                    <div class="stack">
                        <div class="layer" style="--c: var(--l7)"><span class="n">۷</span>کاربرد<span class="en"><b>A</b>pplication</span></div>
                        <div class="layer" style="--c: var(--l6)"><span class="n">۶</span>نمایش<span class="en"><b>P</b>resentation</span></div>
                        <div class="layer" style="--c: var(--l5)"><span class="n">۵</span>نشست<span class="en"><b>S</b>ession</span></div>
                        <div class="layer" style="--c: var(--l4)"><span class="n">۴</span>انتقال<span class="en"><b>T</b>ransport</span></div>
                        <div class="layer" style="--c: var(--l3)"><span class="n">۳</span>شبکه<span class="en"><b>N</b>etwork</span></div>
                        <div class="layer" style="--c: var(--l2)"><span class="n">۲</span>پیوند داده<span class="en"><b>D</b>ata Link</span></div>
                        <div class="layer" style="--c: var(--l1)"><span class="n">۱</span>فیزیکی<span class="en"><b>P</b>hysical</span></div>
                    </div>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>مدل OSI یعنی Open Systems Interconnection. سازمان ISO آن را در سال ۱۹۸۴ منتشر کرد. این مدل هفت لایه دارد و بیشتر یک مدل مرجع و آموزشی است؛ یعنی چارچوبی برای فهمیدن و توصیف شبکه، نه پروتکلی که مستقیم اجرا شود. لایه‌ها از پایین به بالا: فیزیکی، پیوند داده، شبکه، انتقال، نشست، نمایش و کاربرد. یک جملهٔ کمکی برای حفظ کردنش از پایین به بالا: «Please Do Not Throw Sausage Pizza Away».</p>
            </aside>
        </section>

        {{-- ۵ --}}
        <section class="slide">
            <div class="kicker">لایه‌های پایینی</div>
            <h2>لایهٔ ۱ و ۲: از سیگنال تا فریم</h2>
            <div class="row grow">
                <div class="card col layer-card" style="--c: var(--l1)">
                    <h3><span class="layer-badge">۱</span>فیزیکی</h3>
                    <ul class="facts">
                        <li><b>واحد داده</b>بیت</li>
                        <li><b>کار</b>تبدیل صفر و یک به سیگنال الکتریکی، نوری یا رادیویی</li>
                        <li><b>تجهیزات</b>کابل، فیبر نوری، هاب، ریپیتر</li>
                    </ul>
                </div>
                <div class="card col layer-card" style="--c: var(--l2)">
                    <h3><span class="layer-badge">۲</span>پیوند داده</h3>
                    <ul class="facts">
                        <li><b>واحد داده</b>فریم</li>
                        <li><b>کار</b>انتقال بین دو دستگاه در یک شبکهٔ محلی</li>
                        <li><b>آدرس</b><span><span class="ltr">MAC Address</span></span></li>
                        <li><b>تشخیص خطا</b><span><span class="ltr">CRC</span></span></li>
                        <li><b>دستگاه</b>سوییچ — نمونه‌ها: اترنت، وای‌فای</li>
                    </ul>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>لایهٔ ۱، فیزیکی، با بیت‌ها کار می‌کند: صفر و یک را به سیگنال الکتریکی، نوری یا رادیویی تبدیل می‌کند. کابل، فیبر نوری، هاب و ریپیتر در این لایه‌اند. لایهٔ ۲، پیوند داده، بیت‌ها را در قالب فریم بسته‌بندی می‌کند و انتقال بین دو دستگاه در یک شبکهٔ محلی را مدیریت می‌کند. آدرس این لایه MAC Address است، تشخیص خطا با CRC انجام می‌شود و سوییچ دستگاه اصلی آن است. اترنت و وای‌فای نمونه‌های این لایه‌اند.</p>
            </aside>
        </section>

        {{-- ۶ --}}
        <section class="slide">
            <div class="kicker">لایه‌های میانی</div>
            <h2>لایهٔ ۳ و ۴: مسیریابی و رساندن به برنامه</h2>
            <div class="row grow">
                <div class="card col layer-card" style="--c: var(--l3)">
                    <h3><span class="layer-badge">۳</span>شبکه</h3>
                    <ul class="facts">
                        <li><b>واحد داده</b><span>بسته (<span class="ltr">Packet</span>)</span></li>
                        <li><b>آدرس</b><span>آدرس منطقی <span class="ltr">IP</span></span></li>
                        <li><b>کار</b>مسیریابی: پیدا کردن بهترین مسیر بین شبکه‌های مختلف</li>
                        <li><b>دستگاه</b>روتر</li>
                    </ul>
                </div>
                <div class="card col layer-card" style="--c: var(--l4)">
                    <h3><span class="layer-badge">۴</span>انتقال</h3>
                    <ul class="facts">
                        <li><b>واحد داده</b><span>سگمنت (در <span class="ltr">TCP</span>)</span></li>
                        <li><b>آدرس</b>شمارهٔ پورت</li>
                        <li><b>کار</b>ارتباط سربه‌سر بین دو برنامه</li>
                        <li><b><span class="ltr">TCP</span></b>مطمئن و اتصال‌گرا</li>
                        <li><b><span class="ltr">UDP</span></b>سریع ولی بدون تضمین</li>
                    </ul>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>لایهٔ ۳، شبکه، دادهٔ خود را بسته یا Packet می‌نامد. کارش آدرس‌دهی منطقی با IP و مسیریابی است، یعنی پیدا کردن بهترین مسیر بین شبکه‌های مختلف. روتر دستگاه این لایه است. لایهٔ ۴، انتقال، ارتباط سربه‌سر بین دو برنامه را برقرار می‌کند. با شمارهٔ پورت مشخص می‌کند داده به کدام برنامه برسد. دو پروتکل اصلی دارد: TCP که مطمئن و اتصال‌گراست، و UDP که سریع ولی بدون تضمین است. واحد داده در TCP سگمنت است.</p>
            </aside>
        </section>

        {{-- ۷ --}}
        <section class="slide">
            <div class="kicker">لایه‌های بالایی</div>
            <h2>لایهٔ ۵ و ۶: جلسه و قالب داده</h2>
            <div class="row grow">
                <div class="card col layer-card" style="--c: var(--l5)">
                    <h3><span class="layer-badge">۵</span>نشست</h3>
                    <p>شروع، نگه‌داری و پایان یک <strong>جلسهٔ ارتباطی</strong> را مدیریت می‌کند.</p>
                    <div class="hint" style="margin-top: 26px">مثال: دانلود بعد از قطعی، از همان نقطه ادامه پیدا کند.</div>
                </div>
                <div class="card col layer-card" style="--c: var(--l6)">
                    <h3><span class="layer-badge">۶</span>نمایش</h3>
                    <p>به <strong>قالب داده</strong> می‌پردازد:</p>
                    <div style="margin: 18px 0">
                        <span class="chip">تبدیل کدگذاری</span>
                        <span class="chip">فشرده‌سازی</span>
                        <span class="chip">رمزنگاری</span>
                    </div>
                    <p>نمونه‌ها: فرمت <span class="ltr">JPEG</span> و رمزنگاری <span class="ltr">TLS</span></p>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>لایهٔ ۵، نشست، شروع، نگه‌داری و پایان یک جلسهٔ ارتباطی را مدیریت می‌کند؛ مثل اینکه دانلود بعد از قطعی از همان نقطه ادامه پیدا کند. لایهٔ ۶، نمایش، به قالب داده می‌پردازد: تبدیل کدگذاری‌ها، فشرده‌سازی و رمزنگاری. فرمت‌هایی مثل JPEG و رمزنگاری TLS را معمولاً به این لایه نسبت می‌دهند.</p>
            </aside>
        </section>

        {{-- ۸ --}}
        <section class="slide">
            <div class="kicker">نزدیک‌ترین لایه به کاربر</div>
            <h2>لایهٔ ۷ و مسیر داده در <span class="ltr">OSI</span></h2>
            <div class="row grow">
                <div class="card col layer-card" style="--c: var(--l7)">
                    <h3><span class="layer-badge">۷</span>کاربرد</h3>
                    <p>سرویس‌های شبکه را در اختیار برنامه‌ها می‌گذارد.</p>
                    <div style="margin: 18px 0">
                        <span class="chip ltr">HTTP</span>
                        <span class="chip ltr">DNS</span>
                        <span class="chip ltr">SMTP</span>
                        <span class="chip ltr">FTP</span>
                    </div>
                    <div class="hint">دقت: خود <b>مرورگر</b> لایهٔ ۷ نیست؛ پروتکل‌هایی که استفاده می‌کند در این لایه‌اند.</div>
                </div>
                <div class="col" style="display: flex; gap: 22px; align-items: stretch">
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 6px; text-align: center">
                        <b style="font-size: 20px">فرستنده</b>
                        <div class="stack" style="gap: 5px">
                            @foreach ([7 => '۷', 6 => '۶', 5 => '۵', 4 => '۴', 3 => '۳', 2 => '۲', 1 => '۱'] as $layer => $label)
                                <div class="layer" style="--c: var(--l{{ $layer }}); height: 38px; justify-content: center">{{ $label }}</div>
                            @endforeach
                        </div>
                        <b style="font-size: 30px; color: var(--ink-faint)">↓</b>
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 6px; text-align: center">
                        <b style="font-size: 20px">گیرنده</b>
                        <div class="stack" style="gap: 5px">
                            @foreach ([7 => '۷', 6 => '۶', 5 => '۵', 4 => '۴', 3 => '۳', 2 => '۲', 1 => '۱'] as $layer => $label)
                                <div class="layer" style="--c: var(--l{{ $layer }}); height: 38px; justify-content: center">{{ $label }}</div>
                            @endforeach
                        </div>
                        <b style="font-size: 30px; color: var(--ink-faint)">↑</b>
                    </div>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر اول</h4>
                <p>لایهٔ ۷، کاربرد، نزدیک‌ترین لایه به کاربر است و سرویس‌های شبکه را در اختیار برنامه‌ها می‌گذارد؛ پروتکل‌هایی مثل HTTP، DNS، SMTP و FTP. دقت کنید که خود مرورگر لایهٔ ۷ نیست، بلکه پروتکل‌هایی که استفاده می‌کند در این لایه‌اند. پس در فرستنده داده از لایهٔ ۷ به پایین می‌آید و در گیرنده از لایهٔ ۱ بالا می‌رود.</p>
                <p><b>تحویل به نفر دوم:</b> حالا دوستم مدل TCP/IP را توضیح می‌دهد؛ مدلی که اینترنت واقعاً با آن کار می‌کند.</p>
            </aside>
        </section>

        {{-- ۹ --}}
        <section class="slide">
            <div class="kicker">مدل <span class="ltr">TCP/IP</span></div>
            <h2>مدلی که اینترنت واقعاً با آن کار می‌کند</h2>
            <div class="row" style="margin-bottom: 34px">
                <div class="card col layer-card" style="--c: var(--l5)">
                    <h3>دههٔ ۱۹۷۰</h3>
                    <p>طراحی برای شبکهٔ <span class="ltr">ARPANET</span> وزارت دفاع آمریکا</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l4)">
                    <h3>۱ ژانویهٔ ۱۹۸۳</h3>
                    <p><span class="ltr">ARPANET</span> رسماً به <span class="ltr">TCP/IP</span> مهاجرت کرد</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l3)">
                    <h3>امروز</h3>
                    <p>اینترنت روی همین مدل ساخته شده است</p>
                </div>
            </div>
            <div class="big-quote" style="font-size: 34px; margin: 0">
                برخلاف <span class="ltr">OSI</span>: <em>اول پروتکل ساخته شد، بعد مدل.</em>
            </div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>ممنون. مدل OSI برای فهمیدن شبکه عالی است، اما چیزی که اینترنت امروز روی آن ساخته شده مدل TCP/IP است. این مدل در دههٔ ۱۹۷۰ برای شبکهٔ ARPANET وزارت دفاع آمریکا طراحی شد و اول ژانویهٔ ۱۹۸۳ ARPANET رسماً به آن مهاجرت کرد. برخلاف OSI، این مدل از دل پروتکل‌های واقعی بیرون آمده؛ یعنی اول پروتکل ساخته شد و بعد مدل.</p>
            </aside>
        </section>

        {{-- ۱۰ --}}
        <section class="slide">
            <div class="kicker">چهار لایه</div>
            <h2>لایه‌های <span class="ltr">TCP/IP</span> کنار <span class="ltr">OSI</span></h2>
            <div class="map">
                <div class="head"><span class="ltr">OSI</span></div>
                <div class="head"><span class="ltr">TCP/IP</span></div>
                <div class="head">پروتکل‌ها</div>

                <div class="osi" style="--c: var(--l7); grid-row: 2; grid-column: 1">۷ · کاربرد</div>
                <div class="osi" style="--c: var(--l6); grid-row: 3; grid-column: 1">۶ · نمایش</div>
                <div class="osi" style="--c: var(--l5); grid-row: 4; grid-column: 1">۵ · نشست</div>
                <div class="tcp" style="--c: var(--l7); grid-row: 2 / 5; grid-column: 2">کاربرد</div>
                <div class="proto" style="grid-row: 2 / 5; grid-column: 3"><span>HTTP</span><span>HTTPS</span><span>DNS</span><span>SMTP</span><span>SSH</span></div>

                <div class="osi" style="--c: var(--l4); grid-row: 5; grid-column: 1">۴ · انتقال</div>
                <div class="tcp" style="--c: var(--l4); grid-row: 5; grid-column: 2">انتقال</div>
                <div class="proto" style="grid-row: 5; grid-column: 3"><span>TCP</span><span>UDP</span></div>

                <div class="osi" style="--c: var(--l3); grid-row: 6; grid-column: 1">۳ · شبکه</div>
                <div class="tcp" style="--c: var(--l3); grid-row: 6; grid-column: 2">اینترنت</div>
                <div class="proto" style="grid-row: 6; grid-column: 3"><span>IP</span><span>ICMP (ping)</span></div>

                <div class="osi" style="--c: var(--l2); grid-row: 7; grid-column: 1">۲ · پیوند داده</div>
                <div class="osi" style="--c: var(--l1); grid-row: 8; grid-column: 1">۱ · فیزیکی</div>
                <div class="tcp" style="--c: var(--l2); grid-row: 7 / 9; grid-column: 2">دسترسی به شبکه</div>
                <div class="proto" style="grid-row: 7 / 9; grid-column: 3"><span>Ethernet</span><span>Wi-Fi</span><span>MAC</span><span>ARP</span></div>
            </div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>TCP/IP چهار لایه دارد: دسترسی به شبکه، اینترنت، انتقال و کاربرد. لایهٔ دسترسی به شبکه همان کار لایه‌های ۱ و ۲ OSI را انجام می‌دهد: انتقال فریم روی اترنت یا وای‌فای با آدرس MAC. پروتکل ARP هم برای پیدا کردن MAC از روی IP اینجا کار می‌کند. لایهٔ اینترنت معادل لایهٔ شبکه است: پروتکل IP برای آدرس‌دهی و مسیریابی، و ICMP که دستور ping از آن استفاده می‌کند.</p>
            </aside>
        </section>

        {{-- ۱۱ --}}
        <section class="slide">
            <div class="kicker">لایهٔ انتقال</div>
            <h2><span class="ltr">TCP</span> در برابر <span class="ltr">UDP</span></h2>
            <div class="row grow">
                <div class="card col layer-card" style="--c: var(--l4)">
                    <h3><span class="ltr">TCP</span> — مطمئن</h3>
                    <p style="margin-bottom: 6px">قبل از ارسال، «دست‌دهی سه‌مرحله‌ای»:</p>
                    <div class="handshake">
                        <div class="end client">کلاینت</div>
                        <div class="end server">سرور</div>
                        <div class="msg to-server" style="--c: var(--l4); top: 70px"><span>SYN</span></div>
                        <div class="msg to-client" style="--c: var(--l3); top: 140px"><span>SYN-ACK</span></div>
                        <div class="msg to-server" style="--c: var(--l5); top: 210px"><span>ACK</span></div>
                    </div>
                    <p style="font-size: 19px">حفظ ترتیب · ارسال دوبارهٔ بستهٔ گم‌شده · کنترل سرعت<br><b>برای:</b> وب، ایمیل، انتقال فایل</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l1)">
                    <h3><span class="ltr">UDP</span> — سریع</h3>
                    <ul class="facts">
                        <li>بدون اتصال و بدون تضمین</li>
                        <li>سربار کمتر، سرعت بیشتر</li>
                        <li><b style="flex-basis: auto">برای:</b>تماس صوتی، بازی آنلاین، پخش زنده</li>
                    </ul>
                    <div class="hint">جایی که <b>تأخیر</b> از گم شدن یک بستهٔ کوچک بدتر است.</div>
                </div>
            </div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>لایهٔ انتقال دو پروتکل اصلی دارد. TCP قبل از ارسال با «دست‌دهی سه‌مرحله‌ای» اتصال برقرار می‌کند: SYN، سپس SYN-ACK، سپس ACK. بعد ترتیب بسته‌ها را حفظ می‌کند، بستهٔ گم‌شده را دوباره می‌فرستد و سرعت را کنترل می‌کند. برای وب، ایمیل و انتقال فایل مناسب است. UDP بدون اتصال و بدون تضمین است، اما سربار کمتر و سرعت بیشتری دارد؛ برای تماس صوتی، بازی آنلاین و پخش زنده مناسب است، جایی که تأخیر از گم شدن یک بستهٔ کوچک بدتر است.</p>
            </aside>
        </section>

        {{-- ۱۲ --}}
        <section class="slide">
            <div class="kicker">لایهٔ کاربرد</div>
            <h2>سه لایهٔ بالای <span class="ltr">OSI</span> در یک لایه</h2>
            <p class="lead" style="margin-bottom: 40px">لایهٔ کاربرد در <span class="ltr">TCP/IP</span> کار <strong>نشست، نمایش و کاربرد</strong> را یک‌جا انجام می‌دهد. پروتکل‌های معروف و پورتشان:</p>
            <div class="ports">
                <div class="port"><div class="name">HTTP</div><div class="num">۸۰</div><div class="what">صفحهٔ وب</div></div>
                <div class="port"><div class="name">HTTPS</div><div class="num">۴۴۳</div><div class="what">وب امن</div></div>
                <div class="port"><div class="name">DNS</div><div class="num">۵۳</div><div class="what">نام دامنه ← IP</div></div>
                <div class="port"><div class="name">SMTP</div><div class="num">۲۵</div><div class="what">ارسال ایمیل</div></div>
                <div class="port"><div class="name">SSH</div><div class="num">۲۲</div><div class="what">ورود امن از راه دور</div></div>
            </div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>لایهٔ کاربرد در TCP/IP کار سه لایهٔ بالایی OSI یعنی نشست، نمایش و کاربرد را یک‌جا انجام می‌دهد. پروتکل‌ها: HTTP و HTTPS روی پورت ۸۰ و ۴۴۳، DNS روی پورت ۵۳، SMTP برای ارسال ایمیل روی پورت ۲۵، و SSH روی پورت ۲۲.</p>
            </aside>
        </section>

        {{-- ۱۳ --}}
        <section class="slide">
            <div class="kicker">مقایسه</div>
            <h2><span class="ltr">OSI</span> یا <span class="ltr">TCP/IP</span>؟</h2>
            <table class="compare">
                <thead>
                    <tr>
                        <th></th>
                        <th><span class="ltr">OSI</span></th>
                        <th><span class="ltr">TCP/IP</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th>تعداد لایه</th><td class="num">۷</td><td class="num">۴</td></tr>
                    <tr><th>نوع مدل</th><td>مرجع و نظری</td><td>عملی و پیاده‌شدهٔ اینترنت</td></tr>
                    <tr><th>پیدایش</th><td>اول مدل، بعد پروتکل</td><td>اول پروتکل، بعد مدل</td></tr>
                    <tr><th>مرزها</th><td>سرویس، رابط و پروتکل دقیق تعریف شده</td><td>انعطاف‌پذیرتر</td></tr>
                    <tr><th>کاربرد امروز</th><td>زبان مشترک متخصصان: «سوییچ لایهٔ ۳»، «لودبالانسر لایهٔ ۷»</td><td>همان چیزی که واقعاً اجرا می‌شود</td></tr>
                </tbody>
            </table>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>پس تفاوت‌های اصلی: OSI هفت لایه دارد و TCP/IP چهار لایه. OSI مدل مرجع و نظری است؛ TCP/IP مدل عملی و پیاده‌شدهٔ اینترنت. در OSI مرز سرویس، رابط و پروتکل خیلی دقیق تعریف شده، ولی TCP/IP انعطاف‌پذیرتر است. با این حال هنوز متخصصان شبکه با شمارهٔ لایه‌های OSI حرف می‌زنند؛ مثلاً می‌گویند «سوییچ لایهٔ ۳» یا «لودبالانسر لایهٔ ۷».</p>
            </aside>
        </section>

        {{-- ۱۴ --}}
        <section class="slide">
            <div class="kicker">یک مثال واقعی</div>
            <h2>کپسوله‌سازی: باز کردن یک سایت</h2>
            <div class="encap grow">
                <div class="line">
                    <div class="label">کاربرد<small>درخواست HTTP</small></div>
                    <div class="pdu"><span class="data" style="--c: var(--l7)">HTTP data</span></div>
                </div>
                <div class="line">
                    <div class="label">انتقال<small>سگمنت · پورت ۴۴۳</small></div>
                    <div class="pdu"><span style="--c: var(--l4)">TCP</span><span class="data" style="--c: var(--l7)">HTTP data</span></div>
                </div>
                <div class="line">
                    <div class="label">اینترنت<small>بسته · IP مبدأ و مقصد</small></div>
                    <div class="pdu"><span style="--c: var(--l3)">IP</span><span style="--c: var(--l4)">TCP</span><span class="data" style="--c: var(--l7)">HTTP data</span></div>
                </div>
                <div class="line">
                    <div class="label">دسترسی به شبکه<small>فریم · سرآیند و تریلر</small></div>
                    <div class="pdu"><span style="--c: var(--l2)">Frame</span><span style="--c: var(--l3)">IP</span><span style="--c: var(--l4)">TCP</span><span class="data" style="--c: var(--l7)">HTTP data</span><span style="--c: var(--l2)">FCS</span></div>
                </div>
                <div class="line">
                    <div class="label">روی سیم یا هوا<small>بیت‌ها</small></div>
                    <div class="bits">0110100101110010 0101100110…</div>
                </div>
            </div>
            <div class="hint">در سرور دقیقاً برعکس: هر لایه سرآیند خودش را برمی‌دارد ← <b>کپسوله‌زدایی</b></div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>فرض کنید آدرس یک سایت را در مرورگر می‌زنید. لایهٔ کاربرد یک درخواست HTTP می‌سازد. لایهٔ انتقال یک سرآیند TCP با پورت مقصد ۴۴۳ اضافه می‌کند و سگمنت می‌سازد. لایهٔ اینترنت سرآیند IP با آدرس مبدأ و مقصد اضافه می‌کند و بسته می‌سازد. لایهٔ دسترسی به شبکه سرآیند و تریلر فریم را اضافه می‌کند و بیت‌ها روی سیم یا هوا می‌روند. در سرور دقیقاً برعکس، هر لایه سرآیند خودش را برمی‌دارد؛ به این کار «کپسوله‌زدایی» می‌گویند.</p>
            </aside>
        </section>

        {{-- ۱۵ --}}
        <section class="slide">
            <div class="kicker">جمع‌بندی</div>
            <h2>خلاصه</h2>
            <div class="row">
                <div class="card col layer-card" style="--c: var(--l5)">
                    <h3><span class="ltr">OSI</span></h3>
                    <p>زبان مشترک ما برای <strong>فهمیدن و عیب‌یابی</strong> شبکه</p>
                </div>
                <div class="card col layer-card" style="--c: var(--l3)">
                    <h3><span class="ltr">TCP/IP</span></h3>
                    <p>همان چیزی که <strong>واقعاً اجرا می‌شود</strong></p>
                </div>
            </div>
            <div class="big-quote">
                هر دو یک ایده را دنبال می‌کنند:<br>
                <em>تقسیم یک کار پیچیده به لایه‌های ساده</em>
            </div>
            <aside class="notes">
                <h4>نفر دوم</h4>
                <p>خلاصه اینکه OSI زبان مشترک ما برای فهمیدن و عیب‌یابی شبکه است و TCP/IP همان چیزی است که واقعاً اجرا می‌شود. هر دو یک ایده را دنبال می‌کنند: تقسیم یک کار پیچیده به لایه‌های ساده. ممنون از توجه‌تان؛ اگر سؤالی دارید در خدمتیم.</p>
            </aside>
        </section>

        {{-- ۱۶ --}}
        <section class="slide qa-slide">
            <div class="qa-mark">؟</div>
            <h2>پرسش و پاسخ</h2>
            <p class="lead">ممنون از توجه‌تان</p>
            <aside class="notes">
                <h4>سؤالات احتمالی — جواب‌های آماده</h4>
                <div class="group">OSI (نفر اول)</div>
                <ol>
                    <li><b>اگر OSI در عمل استفاده نمی‌شود، چرا هنوز آن را یاد می‌دهند؟</b>چون زبان مشترک متخصصان شبکه است. عیب‌یابی لایه‌به‌لایه، مثل «اول کابل، بعد IP، بعد پورت»، از روی همین مدل انجام می‌شود و اصطلاحاتی مثل «فایروال لایهٔ ۷» هم از آن آمده‌اند.</li>
                    <li><b>فرق سوییچ و روتر چیست؟</b>سوییچ در لایهٔ ۲ کار می‌کند و با آدرس MAC فریم‌ها را داخل یک شبکهٔ محلی جابه‌جا می‌کند. روتر در لایهٔ ۳ کار می‌کند و با آدرس IP بسته‌ها را بین شبکه‌های مختلف مسیریابی می‌کند.</li>
                    <li><b>فرق آدرس MAC و آدرس IP چیست؟</b>MAC آدرس فیزیکی ۴۸ بیتی است که روی کارت شبکه ثبت شده و فقط در شبکهٔ محلی معنا دارد. IP آدرس منطقی است که بسته به شبکه تغییر می‌کند و برای رسیدن به مقصد در شبکه‌های دیگر استفاده می‌شود.</li>
                    <li><b>نام واحد داده در هر لایه چیست؟</b>لایهٔ ۱ بیت، لایهٔ ۲ فریم، لایهٔ ۳ بسته (Packet)، لایهٔ ۴ سگمنت در TCP و دیتاگرام در UDP، و لایه‌های ۵ تا ۷ داده (Data).</li>
                    <li><b>رمزنگاری در کدام لایه انجام می‌شود؟</b>در مدل OSI رمزنگاری وظیفهٔ لایهٔ ۶ یعنی نمایش است. در عمل TLS بین لایهٔ انتقال و کاربرد قرار می‌گیرد و جای دقیقش محل بحث است. رمزنگاری در لایه‌های دیگر هم وجود دارد، مثل IPsec در لایهٔ ۳ و WPA در لایهٔ ۲.</li>
                    <li><b>هاب در کدام لایه است و چه فرقی با سوییچ دارد؟</b>هاب در لایهٔ ۱ است و هر سیگنالی که می‌گیرد را به همهٔ پورت‌ها می‌فرستد. سوییچ آدرس MAC را می‌خواند و فریم را فقط به پورت مقصد می‌فرستد؛ پس برخورد و ترافیک اضافه کمتر است.</li>
                    <li><b>کپسوله‌سازی یعنی چه؟</b>یعنی هر لایه هنگام ارسال، اطلاعات کنترلی خودش را به‌صورت سرآیند به دادهٔ لایهٔ بالایی اضافه می‌کند. در گیرنده هر لایه سرآیند خودش را می‌خواند و برمی‌دارد.</li>
                    <li><b>لایهٔ نشست دقیقاً چه کاری می‌کند؟ یک مثال بزنید.</b>گفت‌وگو بین دو برنامه را باز، کنترل و بسته می‌کند و نقطه‌های همگام‌سازی می‌گذارد. مثلاً اگر وسط دانلود یک فایل بزرگ ارتباط قطع شود، می‌شود از آخرین نقطه ادامه داد.</li>
                    <li><b>اگر یک لایه خراب شود، بقیه چه می‌شوند؟</b>لایه‌های بالاتر به آن وابسته‌اند و کار نمی‌کنند. مثلاً اگر کابل قطع باشد، لایهٔ ۱ مشکل دارد و هیچ سایتی باز نمی‌شود، هرچند تنظیمات DNS درست باشد.</li>
                </ol>
                <div class="group">TCP/IP و مقایسه (نفر دوم)</div>
                <ol>
                    <li><b>چرا TCP/IP برنده شد و OSI نه؟</b>TCP/IP زودتر پیاده‌سازی شد، رایگان بود و در سیستم‌عامل یونیکس دانشگاه برکلی قرار گرفت. وقتی پروتکل‌های OSI آماده شدند، اینترنت روی TCP/IP ساخته شده بود.</li>
                    <li><b>چرا بعضی کتاب‌ها TCP/IP را پنج لایه می‌دانند؟</b>چون لایهٔ دسترسی به شبکه را به دو لایهٔ فیزیکی و پیوند داده تقسیم می‌کنند. این مدل ترکیبی در کتاب‌های آموزشی رایج است؛ مدل اصلی در RFC 1122 چهار لایه دارد.</li>
                    <li><b>دست‌دهی سه‌مرحله‌ای چیست و چرا لازم است؟</b>کلاینت SYN می‌فرستد، سرور SYN-ACK جواب می‌دهد و کلاینت ACK می‌فرستد. این کار مطمئن می‌شود هر دو طرف آماده‌اند و شماره‌های ترتیبی شروع را با هم هماهنگ می‌کنند.</li>
                    <li><b>چه زمانی UDP بهتر از TCP است؟</b>وقتی سرعت و تأخیر کم مهم‌تر از رسیدن تک‌تک بسته‌هاست: تماس صوتی و تصویری، بازی آنلاین، پخش زنده و بیشتر درخواست‌های DNS.</li>
                    <li><b>پورت چیست؟</b>عددی ۱۶ بیتی بین ۰ تا ۶۵۵۳۵ که مشخص می‌کند داده به کدام برنامه روی دستگاه برسد. IP خانه را مشخص می‌کند و پورت اتاق را.</li>
                    <li><b>DNS در کدام لایه است؟</b>در لایهٔ کاربرد. کارش تبدیل نام دامنه به آدرس IP است و معمولاً روی UDP و پورت ۵۳ کار می‌کند؛ برای پاسخ‌های بزرگ از TCP استفاده می‌کند.</li>
                    <li><b>IP مطمئن است یا نه؟</b>نه. IP بهترین تلاشش را می‌کند ولی رسیدن، ترتیب و سالم بودن بسته را تضمین نمی‌کند. این تضمین‌ها کار TCP در لایهٔ انتقال است.</li>
                    <li><b>ARP در کدام لایه است؟</b>بین لایهٔ ۲ و ۳ قرار دارد، چون آدرس IP را به MAC تبدیل می‌کند. در TCP/IP معمولاً جزو لایهٔ دسترسی به شبکه حساب می‌شود.</li>
                    <li><b>IPv4 و IPv6 چه فرقی دارند؟</b>IPv4 آدرس ۳۲ بیتی دارد، یعنی حدود ۴٫۳ میلیارد آدرس که تمام شده است. IPv6 آدرس ۱۲۸ بیتی دارد و تقریباً بی‌نهایت آدرس می‌دهد. هر دو در لایهٔ اینترنت کار می‌کنند.</li>
                    <li><b>وقتی یک سایت را باز می‌کنیم، کدام لایه‌ها درگیرند؟</b>همهٔ لایه‌ها: DNS و HTTP در کاربرد، TCP در انتقال، IP در اینترنت، و اترنت یا وای‌فای در دسترسی به شبکه.</li>
                </ol>
            </aside>
        </section>

    </main>

    <div class="notes-panel" id="notes-panel" aria-live="polite"></div>

    <nav class="controls" aria-label="کنترل ارائه">
        <button type="button" id="btn-prev" title="اسلاید قبلی (→)" aria-label="قبلی">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>
        <span class="counter" id="counter"></span>
        <button type="button" id="btn-next" title="اسلاید بعدی (←)" aria-label="بعدی">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <span class="sep"></span>
        <button type="button" id="btn-notes" title="متن ارائه (N)" aria-label="متن ارائه" aria-pressed="false">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
        </button>
        <button type="button" id="btn-full" title="تمام‌صفحه (F)" aria-label="تمام‌صفحه">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
        </button>
        <button type="button" id="btn-help" title="راهنما (?)" aria-label="راهنما">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3M12 17h.01"/></svg>
        </button>
        <form method="POST" action="{{ route('presentation.lock') }}">
            @csrf
            <button type="submit" title="قفل کردن ارائه" aria-label="قفل">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
            </button>
        </form>
    </nav>

    <div class="help" id="help">
        <div class="help-box">
            <b>میان‌برها</b><br>
            <kbd>←</kbd> یا <kbd>Space</kbd> اسلاید بعدی<br>
            <kbd>→</kbd> اسلاید قبلی<br>
            <kbd>F</kbd> تمام‌صفحه<br>
            <kbd>N</kbd> نمایش / پنهان کردن متن ارائه<br>
            <kbd>Home</kbd> / <kbd>End</kbd> اولین / آخرین اسلاید<br>
            کلیک روی نیمهٔ چپ صفحه: بعدی · نیمهٔ راست: قبلی
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            var stage = document.getElementById('stage');
            var slides = Array.prototype.slice.call(stage.querySelectorAll('.slide'));
            var notesPanel = document.getElementById('notes-panel');
            var counter = document.getElementById('counter');
            var progress = document.getElementById('progress');
            var notesButton = document.getElementById('btn-notes');
            var current = 0;
            var faDigits = '۰۱۲۳۴۵۶۷۸۹';

            function toFa(number) {
                return String(number).replace(/\d/g, function (d) { return faDigits[d]; });
            }

            function fit() {
                var scale = Math.min(window.innerWidth / 1280, window.innerHeight / 720);
                stage.style.transform = 'translate(-50%, -50%) scale(' + scale + ')';
            }

            function go(index) {
                current = Math.max(0, Math.min(slides.length - 1, index));

                slides.forEach(function (slide, i) {
                    slide.classList.toggle('is-active', i === current);
                    slide.classList.toggle('is-past', i < current);
                });

                var notes = slides[current].querySelector('.notes');
                notesPanel.innerHTML = notes ? notes.innerHTML : '';
                notesPanel.scrollTop = 0;

                counter.textContent = toFa(current + 1) + ' / ' + toFa(slides.length);
                progress.style.width = ((current + 1) / slides.length * 100) + '%';

                if (history.replaceState) {
                    history.replaceState(null, '', '#' + (current + 1));
                }
            }

            function toggleNotes() {
                var on = document.body.classList.toggle('show-notes');
                notesButton.setAttribute('aria-pressed', on ? 'true' : 'false');
            }

            function toggleFullscreen() {
                var doc = document;
                var root = doc.documentElement;

                if (doc.fullscreenElement || doc.webkitFullscreenElement) {
                    (doc.exitFullscreen || doc.webkitExitFullscreen).call(doc);
                } else if (root.requestFullscreen) {
                    root.requestFullscreen();
                } else if (root.webkitRequestFullscreen) {
                    root.webkitRequestFullscreen();
                }
            }

            document.getElementById('btn-next').addEventListener('click', function () { go(current + 1); });
            document.getElementById('btn-prev').addEventListener('click', function () { go(current - 1); });
            notesButton.addEventListener('click', toggleNotes);
            document.getElementById('btn-full').addEventListener('click', toggleFullscreen);
            document.getElementById('btn-help').addEventListener('click', function () { document.body.classList.toggle('show-help'); });
            document.getElementById('help').addEventListener('click', function () { document.body.classList.remove('show-help'); });

            /*
            | صفحه راست‌به‌چپ است، پس «جلو» یعنی چپ. کلیکرهای ارائه هم
            | PageDown/PageUp می‌فرستند.
            */
            document.addEventListener('keydown', function (event) {
                if (event.ctrlKey || event.metaKey || event.altKey) {
                    return;
                }

                var key = event.key;

                if (['ArrowLeft', 'ArrowDown', 'PageDown', ' ', 'Enter'].indexOf(key) !== -1) {
                    go(current + 1);
                } else if (['ArrowRight', 'ArrowUp', 'PageUp', 'Backspace'].indexOf(key) !== -1) {
                    go(current - 1);
                } else if (key === 'Home') {
                    go(0);
                } else if (key === 'End') {
                    go(slides.length - 1);
                } else if (key === 'f' || key === 'F' || key === 'ب') {
                    toggleFullscreen();
                } else if (key === 'n' || key === 'N' || key === 'د') {
                    toggleNotes();
                } else if (key === '?' || key === 'h' || key === 'H' || key === '؟') {
                    document.body.classList.toggle('show-help');
                } else if (key === 'Escape') {
                    document.body.classList.remove('show-help');
                } else {
                    return;
                }

                event.preventDefault();
            });

            stage.addEventListener('click', function (event) {
                var box = stage.getBoundingClientRect();
                go(event.clientX < box.left + box.width / 2 ? current + 1 : current - 1);
            });

            var touchStartX = null;

            document.addEventListener('touchstart', function (event) {
                touchStartX = event.touches[0].clientX;
            }, { passive: true });

            document.addEventListener('touchend', function (event) {
                if (touchStartX === null) {
                    return;
                }

                var dx = event.changedTouches[0].clientX - touchStartX;
                touchStartX = null;

                if (Math.abs(dx) > 50) {
                    go(dx > 0 ? current + 1 : current - 1);
                }
            }, { passive: true });

            var idleTimer;

            document.addEventListener('mousemove', function () {
                document.body.classList.add('show-ui');
                clearTimeout(idleTimer);
                idleTimer = setTimeout(function () { document.body.classList.remove('show-ui'); }, 2000);
            });

            window.addEventListener('resize', fit);

            fit();
            go((parseInt(location.hash.slice(1), 10) || 1) - 1);
        })();
    </script>
@endsection
