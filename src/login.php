<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/login.css" media="screen"/>
  </head>
  <body>
  <section class="hero is-fullheigth">
  <div class="hero-body">
    <div class="container has-text-centered">
      <div class="column is-4 is-offset-4">
        <div class="box">
          <h1 class="title">Login</h1>
          <form action="">

            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="email" placeholder="Email">
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </p>
            </div>

            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="password" placeholder="Contraseña">
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Recordar
              </label>
            </div>

            <div class="field">
              <button class="button if-block is-info ">Login</button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
  </section>
  </body>
</html>