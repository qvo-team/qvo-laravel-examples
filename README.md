<h1 align="center">
  <a href="https://qvo.cl">
    <img src="https://cdn.rawgit.com/qvo-team/qvo-node-express-examples/master/sticker.png" alt="QVO Developers" width="200">
  </a>
  <br>
  Ejemplos QVO Laravel
  <br>
  <br>
</h1>


Este repositorio contiene una aplicación Laravel con ejemplos de funcionalidades de la [API QVO](https://docs.qvo.cl).

Los ejemplos incluidos son:

- **Cobrar a tarjeta**: Se muestra de manera simple la funcionalidad de un cobro puntual a tarjetas de débito o crédito mediante Webpay Plus.
- **Planes y suscripciones**: Se muestra de manera simple la funcionalidad de planes y suscripciones mediante un formulario selección de planes. Se asume que el cliente no existe y se registra en la plataforma eligiendo un plan. Se crearon previamente los planes en el sistema.
- **Botón de pago y Checkout**: Se muestra de manera simple la funcionalidad del botón de pago para un producto puntual.

La aplicación viene previamente configurada con credenciales para realizar pruebas de inmediato, pero puedes cambiarlas por tus propias credenciales en el archivo modificando la constante QVO_API_TOKEN de cada controlador.

> **OJO 👀:** Si utilizas las credenciales de tu cuenta y estas probando suscripciones, preocúpate que los planes (QVO_PLANS) usados en SubscriptionController coincidan con los planes creados en tu cuenta.

Para realizar pagos de prueba utiliza las credenciales provistas en [nuestra documentación](https://docs.qvo.cl/#pruebas-y-sandbox).

## Documentación

 - [Referencia API QVO](https://docs.qvo.cl)
 - [Guía Desarrolladores](https://qvo.cl/guia/hola-mundo/)

## Requisitos

- [Git](https://www.atlassian.com/git/tutorials/install-git)
- [Laravel](https://laravel.com/docs/5.6) ~> 5.6

## Instalación

```bash
git clone git@github.com:qvo-team/qvo-laravel-examples.git
cd qvo-laravel-examples
composer install
```

## Ejecución

```bash
php artisan serve
```

Ahora dirígete en tu navegador a `http://localhost:8000`
