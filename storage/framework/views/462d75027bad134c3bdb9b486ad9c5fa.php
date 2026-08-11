<section class="relative py-10 hero-section">


    <div class="container-app">


        <div class="relative overflow-hidden rounded-[40px] shadow-2xl hero-wrapper">



            

            <div class="hero-header-overlay">

                <?php echo $__env->make('sections.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>




            <img
                src="<?php echo e(asset('images/hero/hero.webp')); ?>"
                alt="آسانسور پرو"
                class="block w-full h-auto hero-image">





            

            <div class="hero-glow hero-glow-one"></div>

            <div class="hero-glow hero-glow-two"></div>





            

            <div class="absolute left-20 top-1/2 w-[42%] -translate-y-1/2">



                <span class="hero-reveal hero-delay-1 inline-flex rounded-full bg-white/80 px-4 py-2 text-sm font-bold text-blue-700 backdrop-blur">

                    مرجع صنعت آسانسور ایران

                </span>





                <h1 class="hero-reveal hero-delay-2 mt-6 text-6xl font-black leading-tight text-slate-900">


                    شروع هر پروژه از


                    <br>


                    <span class="text-blue-700">
                        آسانسور
                    </span>


                    <span class="text-yellow-500">
                        پرو
                    </span>


                </h1>





                <p class="hero-reveal hero-delay-3 mt-8 text-xl leading-9 text-slate-600">


                    شرکت‌های آسانسوری، تولیدکنندگان، فروشگاه‌ها،
                    تکنسین‌ها و پروژه‌های ساختمانی را در یکجا پیدا کنید.


                </p>





                <div class="hero-reveal hero-delay-4 mt-10 flex gap-4">


                    <a href="#"
                       class="rounded-full bg-blue-600 px-8 py-4 font-bold text-white transition hover:bg-blue-700">

                        شروع کنید

                    </a>




                    <a href="#"
                       class="rounded-full border border-slate-300 bg-white px-8 py-4 font-bold text-slate-700 transition hover:border-blue-600 hover:text-blue-600">

                        مشاهده شرکت‌ها

                    </a>


                </div>


            </div>





            

            <?php if (isset($component)) { $__componentOriginal126fa72f35d94cee5bb324b9474d7be5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal126fa72f35d94cee5bb324b9474d7be5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hero-dollar','data' => ['dollar' => $dollar]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hero-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dollar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dollar)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal126fa72f35d94cee5bb324b9474d7be5)): ?>
<?php $attributes = $__attributesOriginal126fa72f35d94cee5bb324b9474d7be5; ?>
<?php unset($__attributesOriginal126fa72f35d94cee5bb324b9474d7be5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal126fa72f35d94cee5bb324b9474d7be5)): ?>
<?php $component = $__componentOriginal126fa72f35d94cee5bb324b9474d7be5; ?>
<?php unset($__componentOriginal126fa72f35d94cee5bb324b9474d7be5); ?>
<?php endif; ?>




        </div>


    </div>


</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/sections/hero.blade.php ENDPATH**/ ?>