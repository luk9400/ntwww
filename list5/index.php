<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="refresh" content="300; url=http://localhost:8000/logout.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./styles.css" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <title>Lista 5</title>
</head>

<body>
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$']]
            },
            options: {
                skipHtmlTags: ["script", "style", "textarea"]
            }
        };
    </script>


    <div id="menu">
      <?php
        if (isset($_SESSION["username"])) {
      ?>
        <p>Witaj <?= $_SESSION["username"] ?>! </p>
        <form action="logout.php">
          <input type="submit" value="Wyloguj"/>
        </form>
      <?php
        } else {
      ?>
        <form action="registration.php">
          <input type="submit" value="Zarejestruj"/>
        </form>
        <form action="login.php">
          <input type="submit" value="Zaloguj"/>
        </form>
      <?php
        }
      ?>
    </div>

    <nav>
        <div>
            <a href='index.php'>Schemat Goldwasser-Micali</a>
            <a href='shamir.php'>Dzielenie sekretu</a>
        </div>
        <div>
            <a href='#goldwasser'>Schemat Goldwasser-Micali</a>
            <a href='#residue'>Reszta kwadratowa</a>
            <a href='#symbols'>Symbol Legendre'a i Jacobiego</a>
        </div>
    </nav>

    <header>
        <h1>Zakamarki kryptografii</h1>
    </header>

    <section id='goldwasser'>
        <h1>Schemat Goldwasser-Micali szyfrowania probabilistycznego</h1>
        <h4>Algorytm generowania kluczy</h4>
        <p>
            <ol type='a'>
                <li>Wybierz losowo dwie duże liczby pierwsze $p$ oraz $q$ (podobnego rozmiaru),</li>
                <li>Policz $n = pq$</li>
                <li>Wybierz $y \in \mathbb{Z}_n$, takie, że $y$ jest nieresztą kwadratową modulo $n$ i symbol Jacobiego
                    $\left( \frac{y}{n} = 1 \right)$ (czyli $y$ jest pseudokwadratem modulo $n$),</li>
                <li>Klucz publiczny stanowi para $(n, y)$, zaś odpowiadający mu klucz prywatny to para $(p, q)$.</li>
            </ol>
        </p>
        <h4>Algorytm szyfrowania</h4>
        <p>
            Chcąc zaszyfrować wiadomość $m$ przy uzyciu klucza publicznego $(n, y)$ wykonaj kroki:
            <ol type='a'>
                <li>Przedstaw $m$ w postaci łańcycha binarnego $m = m_1m_2...m_t$ długości $t$</li>
                <li>
                    <pre>
For $i$ from $1$ to $t$ do
    wybierz losowe $x \in \mathbb{Z}^*_n$
    If $m_i = 1$ then set $c_i \leftarrow yx^2$ mod $n$
    Otherwise set $c_i \leftarrow x^2$ mod $n$</pre>
                </li>
                <li>Kryptogram wiadomości $m$ stanowi $c = (c_1, c_2, ..., c_t)$</li>
            </ol>
        </p>
        <h4>Algorytm deszyfrowania</h4>
        <p>
            Chcąc odzyskać wiadomości z kryptogramu $c$ przy uzyciu klucza prywatnego $(p, q)$ wykonaj kroki:
            <ol type='a'>
                <li>
                    <pre>
For $i$ from $1$ to $t$ do
    policz symbol Legendre'a $c_i = \left( \frac{c_i}{p} \right)$
    If $c_i = 1$ then set $m_i \leftarrow 0$
    Otherwise set $m_i \leftarrow 1$</pre>
                </li>
                <li>Zdeszyfrowana wiadomość to $m = m_1m_2...m_t$</li>
            </ol>
        </p>

        <div class="comments">
          
          <h2>Komentarze</h2>

          <ul>

          <?php
            $db = new SQLite3("database.db");
            $stmt = $db->prepare("select * from comments where aid=:aid");
            $stmt->bindValue(":aid", "goldwasser");
            
            $returned_set = $stmt->execute();
            while($row = $returned_set->fetchArray(SQLITE3_ASSOC)) {
              echo "<li class='comment'>";
              echo "<p>" . $row['COMMENT'] . "</p>";
              echo "<small> ~ " . $row['AUTHOR'] . "</small>";
              echo "</li>";
            }
          ?>

          </ul>

          <?php if (isset($_SESSION["username"])) { ?>
            <form method="POST" action="/comment.php" id="usrform">
              <input hidden=true name="article" value="goldwasser">
              <input type="text" name="content">
              <input type="submit" value="Wyślij">
            </form>
          <?php } ?>
        </div>
    </section>


    <section id='residue'>
        <h1>Reszta/niereszta kwadratowa</h1>
        <p>
            <b>Definicja.</b> Niech $a \in \mathbb{Z}_n$. Mówimy, że $a$ jest <i>resztą kwadratową modulo $n$ (kwadratem
                modulo $n$</i>, jeżeli istnieje $x \in \mathbb{Z}^*_n$ takie, że $x^2 \equiv a (\mod p)$. Jeżeli takie
            $x$
            nie istnieje, to wówczas $a$ nazywamy <i>nieresztą kwadratową modulo $n$</i>. Zbiór wszystkich reszt
            kwadratowych modulo $n$ oznaczamy $Q_n$, zaś zbiór wszystkich niereszt kwadratowych modulo $n$ oznaczamy
            $\bar{Q}_n$.
        </p>

        <div class="comments">
          
          <h2>Komentarze</h2>

          <ul>

          <?php
            $db = new SQLite3("database.db");
            $stmt = $db->prepare("select * from comments where aid=:aid");
            $stmt->bindValue(":aid", "residue");
            
            $returned_set = $stmt->execute();
            while($row = $returned_set->fetchArray(SQLITE3_ASSOC)) {
              echo "<li class='comment'>";
              echo "<p>" . $row['COMMENT'] . "</p>";
              echo "<small> ~ " . $row['AUTHOR'] . "</small>";
              echo "</li>";
            }
          ?>

          </ul>

          <?php if (isset($_SESSION["username"])) { ?>
            <form method="POST" action="/comment.php" id="usrform">
              <input hidden=true name="article" value="residue">
              <input type="text" name="content">
              <input type="submit" value="Wyślij">
            </form>
          <?php } ?>
        </div>
    </section>

    <section id='symbols'>
        <h1>Symbol Legendre'a i Jacobiego</h1>
        <p>
            <b>Defincja.</b> Niech $p$ będzie nieparzystą liczbą pierwszą, a $a$ liczbą całkowitą.<br>
            <i>Symbol Legendre'a</i> $\left( \frac{a}{p}\right)$ jest zdefiniowany jako:
            $$\left( \frac{a}{p} \right )= \left\{ \begin{array}{lll}
            & 0 & \textrm{jeżeli $p | a$}\\
            & 1 & \textrm{jeżeli $a \in Q_p$}\\
            & -1 & \textrm{jeżeli $a \in \bar{Q}_p$}\\
            \end{array} \right.
            $$
        </p>
        <p>
            <b>Własności symbolu Legendre'a.</b> Niech $a, b \in \mathbb{Z}$, zaś $p$ to nieparzysta liczba pierwsza.
            Wówczas:
            <ul>
                <li>$\left( \frac{a}{p} \right) \equiv a^{\frac{(p-1)}{2}} (\mod p)$</li>
                <li>$\left( \frac{ab}{p} \right) = \left( \frac{a}{p} \right) \left( \frac{b}{p} \right)$</li>
                <li>$a \equiv b (\mod p) \Rightarrow \left( \frac{a}{p} \right) = \left( \frac{b}{p} \right)$</li>
                <li>$\left( \frac{2}{p} \right) = (-1)^{\frac{(p^2 - 1)}{8}}$</li>
                <li>Jeżeli $q$ jest nieparzystą liczbą pierwszą inną od $p$ to:
                    $$\left( \frac{p}{q} \right) = \left( \frac{q}{p} \right) (-1)^{\frac{(p - 1)(q - 1)}{4}}$$
                </li>
            </ul>
        </p>
        <p>
            <b>Definicja.</b> Niec $n \geq 3$ będzie liczbą nieparzystą, a jej rozkład na czynniki pierwsze to $n =
            p^{e_1}_1 p^{e_2}_2 \ldots p^{e_k}_k$. <i>Symbol Jacobiego</i> $\left( \frac{a}{n} \right)$ jest
            zdefiniowany
            jako:
            $$\left( \frac{a}{n} \right) = \left( \frac{a}{p_1} \right)^{e_1} \left( \frac{a}{p_2} \right)^{e_2} \ldots
            \left( \frac{a}{p_k} \right)^{e_k} $$
            Jeżeli $n$ jest liczbą pierwszą, to symbol Jacobiego jest symbolem Legendre'a.
        </p>
        <p>
            <b>Własności symbolu Jacobiego.</b> Niech $a, b \in \mathbb{Z}$, zaś $m, n \geq 3$ to nieparzyste liczby
            całkowite. Wówczas:
            <ul>
                <li>$\left( \frac{a}{n} \right) = 0, 1$, albo -1. Ponadto $\left( \frac{a}{n} \right) = 0 \iff gcd(a, n)
                    \neq 1$</li>
                <li>$\left( \frac{ab}{n} \right) = \left( \frac{a}{n} \right) \left( \frac{b}{n} \right)$</li>
                <li>$\left( \frac{a}{mn} \right) = \left( \frac{a}{m} \right) \left( \frac{a}{n} \right)$</li>
                <li>$a \equiv b (\mod n) \Rightarrow \left( \frac{a}{n} \right) = \left( \frac{b}{n} \right)$</li>
                <li>$\left( \frac{1}{n} \right) = 1$</li>
                <li>$\left( \frac{-1}{n} \right) = (-1)^{\frac{(n - 1)}{2}}$</li>
                <li>$\left( \frac{2}{n} \right) = (-1)^{\frac{(n^2 - 1)}{8}}$</li>
                <li>$\left( \frac{m}{n} \right) = \left( \frac{n}{m} \right) (-1)^{\frac{(m - 1)(n - 1)}{4}}$</li>
            </ul>
            Z własności symbolu Jacobiego wynika, że jeżeli $n$ nieparzyste oraz $a$ nieparzyste i w postaci $a = 2^e
            a_1$,
            gdzie $a_1$ też nieparzyste to:
            $$\left( \frac{a}{n} \right) = \left( \frac{2^e}{n} \right) \left( \frac{a_1}{n} \right) = \left(
            \frac{2}{n}
            \right)^e \left( \frac{n \mod a_1}{a_1} \right) (-1)^{\frac{(a_1 - 1)(n - 1)}{4}}$$
        </p>
        <p>
            <b>Algorytm obliczania symbolu Jacobiego $\left( \frac{a}{n} \right)$ (i Legendre'a)</b> dla nieparzystej
            liczby
            całkowitej $n \geq 3$ oraz całkowitego $0 \leq a \le n$
            <pre>JACOBI($a, n$)</pre>
            <ol type='a'>
                <li>
                    <pre>
If $a = 0$ then return $0$</pre>
                </li>
                <li>
                    <pre>If $a = 1$ then return $1$</pre>
                </li>
                <li>
                    <pre>Write $a = 2^ea_1$, gdzie $a_1$ nieparzyste</pre>
                </li>
                <li>
                    <pre>If $e$ parzyste set $set \leftarrow 1$
Otherwise set $s \leftarrow 1$ if $n \equiv 1 $ or $7 ($mod$8)$, or set
$s \leftarrow -1$ if $n \equiv 3$ or $5 ($mod$8)$</pre>
                </li>
                <li>
                    <pre>If $n \equiv 3 ($mod$4)$ and $a_1 \equiv 3($mod$3)$ then set $s \leftarrow -s$</pre>
                </li>
                <li>
                    <pre>Set $n_1 \leftarrow n$mod$a_1$</pre>
                </li>
                <li>
                    <pre>If $a_1 = 1$ then return $s$
Otherwise reurn $s \cdot$JACOBI($n_1, a_1$)</pre>
                </li>
            </ol>
            Algorytm działa w czasie $\mathcal{O}((\lg n)^2)$ operacji bitowych.
        </p>

        <div class="comments">
          
          <h2>Komentarze</h2>

          <ul>

          <?php
            $db = new SQLite3("database.db");
            $stmt = $db->prepare("select * from comments where aid=:aid");
            $stmt->bindValue(":aid", "symbols");
            
            $returned_set = $stmt->execute();
            while($row = $returned_set->fetchArray(SQLITE3_ASSOC)) {
              echo "<li class='comment'>";
              echo "<p>" . $row['COMMENT'] . "</p>";
              echo "<small> ~ " . $row['AUTHOR'] . "</small>";
              echo "</li>";
            }
          ?>

          </ul>

          <?php if (isset($_SESSION["username"])) { ?>
            <form method="POST" action="/comment.php" id="usrform">
              <input hidden=true name="article" value="symbols">
              <input type="text" name="content">
              <input type="submit" value="Wyślij">
            </form>
          <?php } ?>
        </div>
    </section>

    <?php
        include('counter.php');
    ?>

    <p>
        Korzystając z tej strony zgadzasz się na wykorzystanie ciasteczek.
    </p>
</body>

</html>