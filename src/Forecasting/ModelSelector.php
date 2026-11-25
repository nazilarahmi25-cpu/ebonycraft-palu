<?php
declare(strict_types=1);

namespace App\Forecasting;

class ModelSelector
{
    public static function evaluateAll(TimeSeries $ts): array
    {
        $split = $ts->split(34); // 34 train, 12 test
        $trainVals    = $split['train']['values'];
        $trainPeriods = $split['train']['periods'];
        $testVals     = $split['test']['values'];
        $testPeriods  = $split['test']['periods'];

        // 1. Holt-Winters
        $hw = HoltWinters::gridSearch($trainVals);
        $hwFit = $hw->fit($trainVals);
        $hwBacktest = $hw->predict($hwFit, 12);
        $hwMetrics = Metrics::calculateAll($testVals, $hwBacktest);

        // 2. Seasonal Regression
        $reg = new SeasonalRegression();
        $reg->fit($trainVals, $trainPeriods);
        $regBacktest = $reg->predict(35, $testPeriods);
        $regMetrics = Metrics::calculateAll($testVals, $regBacktest);

        // 3. Seasonal Moving Average
        $sma = new SeasonalMovingAverage();
        $sma->fit($trainVals, $trainPeriods);
        $smaBacktest = $sma->predict(35, $testPeriods);
        $smaMetrics = Metrics::calculateAll($testVals, $smaBacktest);

        $models = [
            'holt_winters' => [
                'name'     => 'Holt-Winters',
                'model_key'=> 'holt_winters',
                'instance' => $hw,
                'backtest' => $hwBacktest,
                'metrics'  => $hwMetrics,
                'params'   => $hw->getParams(),
            ],
            'seasonal_regression' => [
                'name'     => 'Regresi Tren + Musiman',
                'model_key'=> 'seasonal_regression',
                'instance' => $reg,
                'backtest' => $regBacktest,
                'metrics'  => $regMetrics,
                'params'   => $reg->getParams(),
            ],
            'seasonal_ma' => [
                'name'     => 'Seasonal Moving Average',
                'model_key'=> 'seasonal_ma',
                'instance' => $sma,
                'backtest' => $smaBacktest,
                'metrics'  => $smaMetrics,
                'params'   => $sma->getParams(),
            ],
        ];

        // Select lowest MAPE, tie-break lowest NRMSE
        $selectedKey = 'holt_winters';
        $bestMape = INF;
        $bestNrmse = INF;

        foreach ($models as $key => $m) {
            $mape = $m['metrics']['mape'];
            $nrmse = $m['metrics']['nrmse'];
            if ($mape < $bestMape || (abs($mape - $bestMape) < 1.0 && $nrmse < $bestNrmse)) {
                $bestMape = $mape;
                $bestNrmse = $nrmse;
                $selectedKey = $key;
            }
        }

        foreach ($models as $key => &$m) {
            $m['is_selected'] = ($key === $selectedKey);
        }

        return [
            'models'       => $models,
            'selected_key' => $selectedKey,
            'test_periods' => $testPeriods,
            'test_actual'  => $testVals,
        ];
    }

    public static function refitAndForecast(string $modelKey, TimeSeries $ts, int $horizon = 12): array
    {
        $allVals    = $ts->getValues();
        $allPeriods = $ts->getPeriods();
        $n          = count($allVals);
        $lastPeriod = end($allPeriods);
        $futurePeriods = TimeSeries::generateFuturePeriods($lastPeriod, $horizon);

        if ($modelKey === 'holt_winters') {
            $model = HoltWinters::gridSearch($allVals);
            $fit = $model->fit($allVals);
            $future = $model->predict($fit, $horizon);
            $fitted = $fit['fitted'];
            $alpha = $model->getParams()['alpha'];
            $params = $model->getParams();
        } elseif ($modelKey === 'seasonal_regression') {
            $model = new SeasonalRegression();
            $fit = $model->fit($allVals, $allPeriods);
            $future = $model->predict($n + 1, $futurePeriods);
            $fitted = $fit['fitted'];
            $alpha = 0.2;
            $params = $model->getParams();
        } else {
            $model = new SeasonalMovingAverage();
            $fit = $model->fit($allVals, $allPeriods);
            $future = $model->predict($n + 1, $futurePeriods);
            $fitted = $fit['fitted'];
            $alpha = 0.2;
            $params = $model->getParams();
        }

        // Calculate residual standard deviation
        $stdDev = PredictionInterval::residualStdDev($allVals, $fitted);
        $intervals = PredictionInterval::calculate($future, $stdDev, $alpha);

        return [
            'model_key'      => $modelKey,
            'params'         => $params,
            'future_periods' => $futurePeriods,
            'intervals'      => $intervals,
            'fitted'         => $fitted,
        ];
    }
}
