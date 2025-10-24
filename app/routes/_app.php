<?php

app()->inertia('/', 'app');

app()->post('/log', 'ConsumptionLogController@log');
app()->get('/stat', 'StatisticController@index');