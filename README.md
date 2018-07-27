# Yvan

This project is used to simplify the installation of a PIM (community or enterprise) for a Akeneo developer.
It's a PHP web application aimed at developer to generate un file.lock without execute the command "$type install" on their computers.


## Getting Started

Clone the project and after starting the server you can use the app : http://127.0.0.1:8000/lock/$akeneoRepository/$cmdType
Allowed Akeneo repository : pim-community-dev and pim-enterprise-dev.
Allowed commands types : composer, yarn and all (run the both).
At the end of the process the file is drop in a public folder (Lock/$akeneoRepository).

### Prerequisites

You need to install PHP > 7.1

## Installs Deps

```bash
composer.phar install
```

## Yvan URL Server

```bash
https://yvan.akeneo.com/
```

### Start local server

```bash
php bin/console server:run
```

### Running the PHPSpec tests

```bash
php -c ../conf.ini bin/phpspec run -vvv
```

## Built With

* [Symfony4](http://www.dropwizard.io/1.0.2/docs/) - The web framework used

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## When and why this project

This app is a summer internship project with the Akeneo Raccoons team.
We had done this one between june and july 2018.

## Authors

* **Arthur Millet** - [Akeneo](https://github.com/ArthurMillet)
* **Julien Sanchez** - [Akeneo](https://github.com/juliensnz)

## Deployment

You need help, call a IT guys in Akeneo.

## Documentation

For more informations please have a look here [documentation.md](https://github.com/ArthurMillet/yvan/Documentation.md).
