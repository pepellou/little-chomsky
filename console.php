<?php
/**
 * README
 * This configuration file is intended to be used as the main script for the PHP Telegram Bot Manager.
 * Uncommented parameters must be filled
 *
 * For the full list of options, go to:
 * https://github.com/php-telegram-bot/telegram-bot-manager#set-extra-bot-parameters
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

use Chomsky\Chomsky;
use Symfony\Component\Yaml\Yaml;

Chomsky::learnFromKnowledgeFolder();


echo "         __                                                  \n";
echo " _(\\    |@@|                                                  \n";
echo "(__/\\__ \\--/ __               Ola, son Chomskiño!               \n";
echo "   \\___|----|  |   __                                                  \n";
echo "       \\ }{ /\\ )_ / _\\        Pregúntame o que queiras.                 \n";
echo "       /\\__/\\ \\__O (__                                                  \n";
echo "      (--/\\--)    \\__/       (escribe /q para rematar)                \n";
echo "      _)(  )(_                                                  \n";
echo "     `---''---`                                                  \n";
echo "\n";
echo "\n";
echo " -----------------------------------------------------------\n";


$input = 'Ola';

while ($input != '/q') {
    echo "\n        [ti] $ ";
    $input = readline();
    echo " [chomskiño] $ ";
    echo Chomsky::talk($input);
}

echo "\n\n";
