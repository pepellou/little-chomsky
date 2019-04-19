# little-chomsky
A telegram bot for USC German Philology students to get info on their subjects, teachers, exams, etc

## How to use locally

Clone the repository, if you haven't already:

    git clone git@github.com:pepellou/little-chomsky.git

Move to the folder and install dependencies:

    cd little-chomsky
    composer install

(NOTE: you might need to install composer if you never did: https://getcomposer.org/download/)


Run the console script:

    bin/console

Talk!


## How to use it on telegram

Just add the user `Chomskiño` on Telegram and start a conversation with it.

Note that this is deployed in a server, so for immediate feedback of your changes use locally instead.


## How to add knowledge

Knowledge is stored in `yaml` files under the `Knowledge` folder.

You can edit any of those files to add, edit or remove rules.

You can also add files to this folder, but for the bot to learn them you need to add every new file in the list at `Knowledge/list.yaml`

Because syntax is delicate in these files, to be sure you don't break anything, run the tests before and after your changes (especially after) with the following command:

    bin/test
