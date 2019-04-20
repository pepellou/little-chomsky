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

Chomsky::learnFromKnowledgeFolder();

$term = `stty -g`;
system("stty -icanon -echo");

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

    $input = '';
    $enter = false;
    $escaped = false;
    $escape_sequence_left = null;
    $escape_sequence_right = null;

    while (!$enter && $c = fread(STDIN, 1)) {
        if (ord($c) == 10) {
            $enter = true;
            echo "\n";
        } else {
            if (ord($c) == 27) {
                $escaped = true;
                $escape_sequence_left = null;
                $escape_sequence_right = null;
            } elseif ($escaped) {
                if (is_null($escape_sequence_left)) {
                    $escape_sequence_left = ord($c);
                } else {
                    $escape_sequence_right = ord($c);
                    echo "^";
                    $escaped = false;
                }
            } else {
                if (ord($c) == 10) {
                    $input = substr($input, count($input) - 2);
system("stty '" . $term . "'");
                    echo chr(8);
system("stty -icanon -echo");
                } else {
                    echo $c;
                    $input = $input . $c;
                }
            }
        }
    }

    echo " [chomskiño] $ ";
    echo Chomsky::talk($input);
}

echo "\n\n";

system("stty '" . $term . "'");

