<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Cell 1: Repository Stats -->
        <div class="p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl shadow-sm flex flex-col justify-between hover:border-amber-500/30 transition-all duration-200" style="min-height: 180px;">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Métricas HCS</span>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Estado del Repositorio</h3>
                
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <span class="text-2xl font-extrabold font-mono text-gray-900 dark:text-white"><?php echo e($totalAgents); ?></span>
                        <span class="text-[10px] text-gray-400">Total Agentes</span>
                    </div>
                    <div class="flex flex-col border-l border-gray-100 dark:border-gray-800 pl-3">
                        <span class="text-2xl font-extrabold font-mono text-amber-500"><?php echo e($customAgents); ?></span>
                        <span class="text-[10px] text-gray-400">Custom</span>
                    </div>
                    <div class="flex flex-col border-l border-gray-100 dark:border-gray-800 pl-3">
                        <span class="text-2xl font-extrabold font-mono text-emerald-500"><?php echo e($totalUsers); ?></span>
                        <span class="text-[10px] text-gray-400">Pilotos</span>
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-4 pt-2 border-t border-gray-50 dark:border-gray-800/50">
                Agentes LLM sincronizados con el motor de inferencia HCS.
            </p>
        </div>

        <!-- Cell 2: Default Active Agent -->
        <div class="p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl shadow-sm flex flex-col justify-between hover:border-emerald-500/30 transition-all duration-200" style="min-height: 180px;">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Canal Activo</span>
                    <span class="px-2 py-0.5 text-[9px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 rounded-full border border-emerald-100 dark:border-emerald-900/30">PREDETERMINADO</span>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($defaultAgent): ?>
                    <h3 class="text-sm font-extrabold text-gray-900 dark:text-white truncate mb-1"><?php echo e($defaultAgent->name); ?></h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                        <?php echo e($defaultAgent->description ?: 'Agente activo por defecto en la consola.'); ?>

                    </p>
                    <div class="flex gap-2 mt-3 text-[10px] font-mono">
                        <span class="bg-gray-50 dark:bg-gray-800 text-gray-500 px-1.5 py-0.5 rounded border border-gray-100 dark:border-gray-800">Temp: <?php echo e($defaultAgent->temperature); ?></span>
                        <span class="bg-gray-50 dark:bg-gray-800 text-gray-500 px-1.5 py-0.5 rounded border border-gray-100 dark:border-gray-800">Autor: <?php echo e($defaultAgent->creator); ?></span>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-gray-400">No hay un agente configurado como predeterminado.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-4 pt-2 border-t border-gray-50 dark:border-gray-800/50">
                Las peticiones sin agente explícito caerán en este perfil.
            </p>
        </div>

        <!-- Cell 3: Sandbox Quicklink -->
        <div class="p-6 bg-gradient-to-br from-amber-500/10 to-red-500/5 dark:from-amber-950/20 dark:to-red-950/5 border border-amber-200/40 dark:border-amber-900/20 rounded-xl shadow-sm flex flex-col justify-between hover:border-amber-500/50 transition-all duration-200" style="min-height: 180px;">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Simulación HCS</span>
                    <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
                <h3 class="text-base font-black text-gray-900 dark:text-white mb-2">Cognitive Sandbox</h3>
                <p class="text-xs text-gray-600 dark:text-gray-300 leading-normal">
                    Regresa al simulador interactivo para probar la resistencia cognitiva ante las toxinas de la IA.
                </p>
            </div>
            
            <div class="mt-4">
                <a href="http://localhost:5173" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow-sm hover:shadow transition duration-150 no-underline">
                    <span>Abrir Simulador</span>
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH /Users/janet/herd/inoculacion-cognitiva/backend/resources/views/filament/widgets/hcs-overview-widget.blade.php ENDPATH**/ ?>