<?php
declare(strict_types=1);

require_once \dirname(__DIR__) . '/vendor/autoload.php';
$opts = \getopt('gdrpc::', [
    'git-diff', 'diff', 'report', 'pdf', 'check::'
]);

if ($argc < 3) {
    die("Please pass two phars to diff them.\n");
}

// The last two commands should be our two .phar files
/** @var string $pharB */
$pharB = \array_pop($argv);
/** @var string $pharA */
$pharA = \array_pop($argv);

$phars = [
    new \ParagonIE\Pharaoh\Pharaoh($pharA),
    new \ParagonIE\Pharaoh\Pharaoh($pharB)
];

$diff = new \ParagonIE\Pharaoh\PharDiff($phars[0], $phars[1]);

if (!empty($opts['c'])) {
    $diff->listChecksums($opts['c']);
} elseif (!empty($opts['check'])) {
    $diff->listChecksums($opts['check']);
} elseif (isset($opts['d']) || isset($opts['diff'])) {
    $diff->printGnuDiff();
} else {
    $diff->printGitDiff();
}
