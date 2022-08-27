<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/bulma/bulma.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-bulma.png">
    <script src="js/main.js"></script>
</head>
<body>
    <div class="">

      <section class="is-relative section py-32 has-background-primary">
        <div class="container">
          <div class="has-mw-lg mx-auto px-14 py-12 has-background-white">
            <span class="is-block has-text-info has-text-weight-semibold is-uppercase has-letter-space">Registro</span>
            <h3 class="title is-size-4 has-text-primary">Cortes do BOTECO</h3>
            <form action="{{ url('signup') }}" method="POST">
                @csrf
              <div class="control mb-2">
                <input class="input pl-6 py-4 has-background-light has-text-primary"
                    type="name" placeholder="Username" name="username">
              </div>
              <div class="control mb-2">
                <input class="input pl-6 py-4 has-background-light has-text-primary"
                    type="email" placeholder="E-mail" name="email">
              </div>
              <div class="control mb-2">
                <input class="input pl-6 py-4 has-background-light has-text-primary"
                 type="password" placeholder="Senha" name="password">
              </div>
              {{-- <div class="control mb-6">
                <input class="input pl-6 py-4 has-background-light has-text-primary" type="password" placeholder="Repeat password">
              </div> --}}
              <button class="mt-10 button is-fullwidth is-warning" type="submit">Entrar</button>
            </form>
                @include('flash::message')
          </div>
        </div>
      </section>
    </div>
</body>
</html>
