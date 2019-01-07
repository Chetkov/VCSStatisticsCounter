# VCSStatisticsCounter
Счетчик статистик VCS


###Установка
```
composer require "v.chetkov/vcs-statistics-counter:^1.0"
```

###Конфигурация
Пример:
```php
<?php

return [
    'vcs' => 'git',
    'authors' => [
        'Валерий Четков', 
        'Василий Пупкин',
        'Nikolia Zubrov',
        'Dmitriy Ignatenko',
    ],
    'branchPrefixes' => [
        'to-',
    ],
    'rootDirectories' => [
        '/home/v.chetkov/projects/VCSStatisticsCounter/',
        '/home/v.chetkov/projects/Extractor/',
        '/home/v.chetkov/projects/Logger/',
    ],
    'vcsRemoteServerName' => 'origin',
];
```

###Использование
```php
<?php

use VCSStatisticsCounter\Model\Statistics;
use VCSStatisticsCounter\VCSStatisticsCounterFactory;

require_once 'vendor/autoload.php';

$vcsStatisticsCounterFactory = new VCSStatisticsCounterFactory();
$vcsStatisticsCounter = $vcsStatisticsCounterFactory->create(require __DIR__ . '/config/config.local.php');

$totalStatistic = $vcsStatisticsCounter->getTotalStatistic(new DateTime('2018-11-28'));

//==================== ТОПЫ АВТОРОВ ====================

//ТОП-3 авторов по кол-ву измененных строк
$topAuthorsByNumChangedLines = $totalStatistic->getTopAuthors(
    3,
    Statistics::SORT_TYPE_CHANGED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 авторов по кол-ву новых строк
$topAuthorsByNumCreatedLines = $totalStatistic->getTopAuthors(
    3,
    Statistics::SORT_TYPE_CREATED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 авторов по кол-ву удалённых строк
$topAuthorsByNumDeletedLines = $totalStatistic->getTopAuthors(
    3,
    Statistics::SORT_TYPE_DELETED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 авторов по кол-ву измененных файлов
$topAuthorsByNumChangedFiles = $totalStatistic->getTopAuthors(
    3,
    Statistics::SORT_TYPE_CHANGED_FILES,
    Statistics::SORT_DIRECTION_DESC
);


//==================== ТОПЫ РЕПОЗИТОРИЕВ ====================

//ТОП-3 репозиториев по кол-ву измененных строк
$topRepositoriesByNumChangedLines = $totalStatistic->getTopRepositories(
    3,
    Statistics::SORT_TYPE_CHANGED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 репозиториев по кол-ву новых строк
$topRepositoriesByNumCreatedLines = $totalStatistic->getTopRepositories(
    3,
    Statistics::SORT_TYPE_CREATED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 репозиториев по кол-ву удалённых строк
$topRepositoriesByNumDeletedLines = $totalStatistic->getTopRepositories(
    3,
    Statistics::SORT_TYPE_DELETED_LINES,
    Statistics::SORT_DIRECTION_DESC
);

//ТОП-3 репозиториев по кол-ву измененных файлов
$topRepositoriesByNumChangedFiles = $totalStatistic->getTopRepositories(
    3,
    Statistics::SORT_TYPE_CHANGED_FILES,
    Statistics::SORT_DIRECTION_DESC
);
```