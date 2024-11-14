<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Wrap & Roll</title>
    <link rel="stylesheet" href="./css/contactoStyle.css">
  </head>

  <body>
    <!-- Sección de contacto -->
    <section id="contacto">
      <div class="card">
        <h2>Contacto</h2>
        <p>En <strong>Wrap & Roll</strong>, nos encantaría saber de ti. Si tienes alguna consulta, comentario o necesitas más información sobre nuestros productos, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte a llevar el auténtico sabor del kebab a tu negocio.</p>

        <form id="form-contacto">
          <label for="nombre">Tu Nombre</label>
          <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" required>

          <label for="email">Tu Correo Electrónico</label>
          <input type="email" id="email" name="email" placeholder="Escribe tu correo" required>

          <label for="mensaje">Tu Mensaje</label>
          <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje" required></textarea>

          <button type="submit">Enviar</button>
        </form>

        <p>También puedes contactarnos a través de nuestras redes sociales o llamarnos directamente al <strong>+34 123 456 789</strong>. ¡Estamos esperando tu mensaje!</p>
      </div>

        <!-- Mapa -->
        <div class="mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.2135311713782!2d-3.606161220654297!3d37.7850353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6e7b9b03688535%3A0xcc0e507bdb7fc9ac!2sZuni%20Kebab%20House!5e0!3m2!1ses!2ses!4v1731576440555!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        
    </section>
  </body>
</html>
