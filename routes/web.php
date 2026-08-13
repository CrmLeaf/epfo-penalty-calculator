<?php

declare(strict_types=1);

use Crmleaf\Payroll\Tools\EpfoPenaltyCalculator\Http\Controllers\EpfoPenaltyCalculatorController;
use Illuminate\Support\Facades\Route;

/*
 * Loaded by EpfoPenaltyCalculatorServiceProvider only when config('epfo-penalty-calculator.route.enabled')
 * is true, so requiring the package never adds a URL on its own.
 */

/** @var \Illuminate\Contracts\Config\Repository $config */
$config = app('config');

Route::middleware((array) $config->get('epfo-penalty-calculator.route.middleware', ['web']))
    ->prefix((string) $config->get('epfo-penalty-calculator.route.prefix', 'tools'))
    ->group(static function () use ($config): void {
        Route::match(['get', 'post'], '/epfo-penalty-calculator', EpfoPenaltyCalculatorController::class)
            ->name((string) $config->get('epfo-penalty-calculator.route.name', 'epfo-penalty-calculator'));
    });
