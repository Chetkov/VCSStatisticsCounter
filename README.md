# VCSStatisticsCounter
Счетчик статистик VCS


## Установка
```
composer require "v.chetkov/vcs-statistics-counter:^1.0"
```

## Конфигурация
Пример:
```php
<?php

use Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes\AllowablePrefixesStrategy;

return [
    'vcs' => 'git',
    'authors' => [
        'Валерий Четков', 
        'Василий Пупкин',
        'Nikolia Zubrov',
        'Dmitriy Ignatenko',
    ],
    'branchFilter' => [
        'strategy' => AllowablePrefixesStrategy::class,
        'branchPrefixes' => [
            'to-',
        ],
        'vcsRemoteServerName' => 'origin',
    ],
    'rootDirectories' => [
        '/home/v.chetkov/projects/VCSStatisticsCounter/',
        '/home/v.chetkov/projects/Extractor/',
        '/home/v.chetkov/projects/Logger/',
    ],
];
```

## Использование
```php
<?php

use VCSStatisticsCounter\Model\Statistics;
use VCSStatisticsCounter\VCSStatisticsCounterFactory;

require_once 'vendor/autoload.php';

$vcsStatisticsCounterFactory = new VCSStatisticsCounterFactory();
$vcsStatisticsCounter = $vcsStatisticsCounterFactory->create(require __DIR__ . '/config/config.local.php');

$totalStatistic = $vcsStatisticsCounter->getTotalStatistic(new DateTime('2018-11-28'));

$topAuthorsByNumChangedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CHANGED_LINES);
foreach ($topAuthorsByNumChangedLines as $authorStatistics) {
    echo "\n{$authorStatistics->getName()}:\n";
    echo "изменённых файлов - {$authorStatistics->getNumChangedFiles()}\n";
    echo "изменённых строк - {$authorStatistics->getNumChangedLines()}\n";
    echo "удалённых строк - {$authorStatistics->getNumCreatedLines()}\n";
    echo "новых строк - {$authorStatistics->getNumDeletedLines()}\n";
}
```

Вывод:
```text
a.lisyanskij:
изменённых файлов - 417
изменённых строк - 21664
удалённых строк - 18007
новых строк - 3657

Валерий Четков:
изменённых файлов - 178
изменённых строк - 10383
удалённых строк - 7017
новых строк - 3366

Mike Malofeev:
изменённых файлов - 94
изменённых строк - 7781
удалённых строк - 2923
новых строк - 4858
```

Еще варианты:
```
//==================== ТОПЫ АВТОРОВ ====================

//ТОП-3 авторов по кол-ву измененных строк
$topAuthorsByNumChangedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CHANGED_LINES);

//ТОП-3 авторов по кол-ву новых строк
$topAuthorsByNumCreatedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CREATED_LINES);

//ТОП-3 авторов по кол-ву удалённых строк
$topAuthorsByNumDeletedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_DELETED_LINES);

//ТОП-3 авторов по кол-ву измененных файлов
$topAuthorsByNumChangedFiles = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CHANGED_FILES);


//==================== ТОПЫ РЕПОЗИТОРИЕВ ====================

//ТОП-3 репозиториев по кол-ву измененных строк
$topRepositoriesByNumChangedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CHANGED_LINES);

//ТОП-3 репозиториев по кол-ву новых строк
$topRepositoriesByNumCreatedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CREATED_LINES);

//ТОП-3 репозиториев по кол-ву удалённых строк
$topRepositoriesByNumDeletedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_DELETED_LINES);

//ТОП-3 репозиториев по кол-ву измененных файлов
$topRepositoriesByNumChangedFiles = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CHANGED_FILES
);
```