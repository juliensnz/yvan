# Yvan Documentation

##Introduction

This project is used to simplify the installation of a PIM (community or enterprise) for a Akeneo developer.

The principle of Yvan is simple, you want to install a PIM or work on a PIM ? 

If you want to have your dependencies up-to-date, you will have to do a composer install!
And this process will take far too long,

The solution, it’s Yvan, he will generate on a server a composer.lock with all the update dependencies of the repository, then he drop it in a Public folder.

After modification, he will send the file to your computer thanks to a command into Slack (Slash Command).

The aim of the project is to develop an PHP application with Symfony 4.


###Parameters and constants

The controller can receive six different possibilities input :

* Tree types : composer, yarn and all (all run the both).
* Two repositories : pim-community-dev and pim-enterprise-dev.

Working directory : WORKDIR = '../workdir'. In this directory we clone the repository temporarily during the process.

###Routing

The path is /lock/{repository}/{type}.

The controller is App\Controller\LockController::lock

The function lock is executed in the LockController.

The defaults parameters are repository: "pim-community-dev" and type: "composer".

###Architecture

The project is conforms to Symfony (v4) framework technical architecture.

There are :
* Controller : LockController -> lock() -> execute Generator
* Generator : LockGenerator -> generate() -> execute Service
* Services : GitService, ComposerService, YarnService and FileSystemService.
* Helper : ProcessRunner
* Business Exception : CopyFileException, GitCloneException and InstallException.

### Unit Test PHPSpec

There are 5 specs and 21 examples, one for each case.

###Dependency injection

    App\Controller\:
        resource: '../src/Controller'
        arguments:
            - '@App\Generator\LockGenerator'

    App\Generator\:
        resource: '../src/Generator'
        arguments:
            - '@App\Service\FileSystem'
            - '@App\Service\Git'
            - '@App\Service\Composer'
            - '@App\Service\Yarn'

    App\Service\:
        resource: '../src/Service/FileSystem.php'
        arguments:
            - '@Symfony\Component\Filesystem\Filesystem'

    App\Service\Git\:
        resource: '../src/Service/Git.php'
        arguments:
            - '@App\Helper\ProcessRunner'

    App\Service\Composer\:
        resource: '../src/Service/Composer.php'
        arguments:
            - '@App\Helper\ProcessRunner'

    App\Service\Yarn\:
        resource: '../src/Service/Yarn.php'
        arguments:
            - '@App\Helper\ProcessRunner'

Currently the application is available on the server : yvan.akeneo.com

##To do

The project is not finished, there are differents tasks which it's possible to do. The most important is the connection with Slack environment. 

* Give an another name for the folder called Lock in order to have not misunderstanding with the folder and the controller route /Lock.

* Display errors message for the Exception

* Add createFolder Exception

* Add deleteFolder Exception

* Have to connect the server with Slack in order to build a Slash Command who receive parameters with a WebHooks like :

```bash
slackbot : /lock pim-community-dev composer
```

#Information

Writing by Arthur Millet the 27 July 2018 in Akeneo.

Thanks for your reading and good luck.
