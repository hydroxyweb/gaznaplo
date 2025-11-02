<?php

app()->inertia('/', 'app');

app()->post('/log', 'ConsumptionLogController@log');
app()->get('/stat', 'StatisticController@index');
app()->get('/all-records', 'ConsumptionLogController@allRecords');
app()->get('/has-reported-record', 'StatisticController@curentMonthHasReportedRecord');