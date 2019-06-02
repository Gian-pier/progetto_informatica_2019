<!--
  Pagina per cambiare i dati di un prodotto utilizza la pagina vecchiDatiProdotto.php per cambiare i dati visuallizati
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modifica dati prodotto</title>
        <link rel="stylesheet" href="../css/style.css"  >
    </head>
    <body onload="cambiaNome();cambiaCosto();cambiaIVA();cambiaCategoria()">
        <h1 class="center bgblack header_page"> Modifica dati prodotto </h1>

        <div class = 'navbar bgblack maxwidth' id='menu'>
            <?php
                include ("utils.php");
                session_start();
                createNavBar();
                checkAdminPermissions();
            ?>
        </div>

        <script>
            function cambiaNome() {//Funzione che mostra il nome attuale del prodotto. Richiama "vecchiDatiProdotto.php" e gli passa una variabile per distinguere il tipo di operazione che dovrà svolgere
              var nome = document.getElementById("selezionato").value;
              if(nome!="")
              {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("nome_v").innerHTML = this.responseText;
                    }
                }
                xhttp.open("GET", "vecchiDatiProdotto.php?nome=" + nome + "&controllo="+0, true);
                xhttp.send();
              }
              else
              {
                document.getElementById("nome_v").innerHTML = "";
              }
            }

            function cambiaCosto() {
              var nome = document.getElementById("selezionato").value;
              if(nome!="")
              {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("costo_v").innerHTML = this.responseText;
                    }
                }
                xhttp.open("GET", "vecchiDatiProdotto.php?nome=" + nome + "&controllo="+1, true);
                xhttp.send();
              }
              else
              {
                document.getElementById("costo_v").innerHTML = "";
              }
            }

            function cambiaIVA() {
              var nome = document.getElementById("selezionato").value;
              if(nome!="")
              {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("iva_v").innerHTML = this.responseText;
                    }
                }
                xhttp.open("GET", "vecchiDatiProdotto.php?nome=" + nome + "&controllo="+2, true);
                xhttp.send();
              }
              else
              {
                document.getElementById("iva_v").innerHTML = "";
              }
            }

            function cambiaCategoria() {
              var nome = document.getElementById("selezionato").value;
              if(nome!="")
              {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("categoria_v").innerHTML = this.responseText;
                    }
                }
                xhttp.open("GET", "vecchiDatiProdotto.php?nome=" + nome + "&controllo="+3, true);
                xhttp.send();
              }
              else
              {
                document.getElementById("categoria_v").innerHTML = "";
              }
            }

            function copia()//Funzione che copia i vecchi dati nei campi di testo così da non riscrivere tutti i dati per cambiarne uno solo
            {
              document.getElementById("nome").value = document.getElementById("nome_v").innerHTML;
              document.getElementById("costo").value = document.getElementById("costo_v").innerHTML;
              document.getElementById("iva").value = document.getElementById("iva_v").innerHTML;
              document.getElementById("categoria").value = document.getElementById("categoria_v").innerHTML;
            }
        </script>

        <!--
            L'aggiornamento dei dati viene fatto qui in modo che vengano aggiornati prima del caricamento dei dati,
            così quando si caricano prende i dati nuovi
        -->
        <?php
        $myconn = connect();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["btn"])){

              $id=explode("-",$_POST["selezionato"]);
              $nome = $_POST["nome"];
              $costo = $_POST["costo"];
              $iva = $_POST["iva"];
              $categoria = $_POST["categoria"];

              $sql="UPDATE prodotto
                  SET nome_prod = '".$nome.
                  "', costo_unitario = '".$costo.
                  "', aliquota_iva = '".$iva.
                  "', categoria = '".$categoria.
                  "' WHERE id_prodotto='".$id[0]."'";

              $ris = $myconn->query($sql);
            }
          }
          ?>

        <div class="bgwhite" style="height: 400px; padding:5%; width: 40%; margin: 0px auto ">
          <form action="" method="POST">
            <?php
              $query = "SELECT id_prodotto, nome_prod "
                      . "FROM prodotto";
                      $ris = $myconn->query($query);
                      echo "<p>Seleziona il prodotto: </p>";
                      //Creo una select per selezionare di quale prodotto cambiare i dati
                      echo "<select id='selezionato' name='selezionato' onchange='cambiaNome();cambiaCosto();cambiaIVA();cambiaCategoria()'>";//Creazione select per selezionare il meccanico al quale cambiare i dati
                      while ($row = $ris->fetch_assoc()) {
                        echo "<option>" . $row["id_prodotto"] . "-" . $row["nome_prod"] . "</option>";
                      }
              echo "</select>";
            ?>
      <table style="border-collapse: collapse">
        <tr>
          <td style="width:3%">
            <table>
              <tr>
                <td><p>Nome: </p></td><td><p id="nome_v"></p></td>
              </tr>
              <tr>
                <td><p>Costo: </p></td><td><p id="costo_v"></p></td>
              </tr>
              <tr>
                <td><p>IVA: </p></td><td><p id="iva_v"></p></td>
              </tr>
              <tr>
                <td><p>Categoria: </p></td><td><p id="categoria_v"></p></td>
              </tr>
            </table>
          </td>

          <td style="width:3%">
            <table style="border-collapse: collapse;width:10%">
              <tr>
                <td><input type="button" value="->" onclick="copia()"></td>
              </tr>
            </table>
          </td>
          <td style="width:50%">
            <table>
              <tr>
                <td><p>Nuovo nome: </p></td><td style="width:50%"><input type="text" id="nome" name="nome" required></td>
              </tr>
              <tr>
                <td><p>Nuovo costo: </p></td><td style="width:50%"><input type="text" id="costo" name="costo" required></td>
              </tr>
              <tr>
                <td><p>Nuova IVA: </p></td><td style="width:50%"><input type="text" id="iva" name="iva" required></td>
              </tr>
              <tr>
                <td><p>Nuova categoria: </p></td><td style="width:50%"><input type="text" id="categoria" name="categoria" required></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
            <div>
              <input type="submit" name ="btn" value="Salva">
          </div>
          <?php
          //Qui avverrò il controllo della buona riuscita dell'aggiornamento dei dati(lo faccio qui così che il messaggio compaia alla fine della pagina)
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (isset($_POST["btn"]))
              {
              if(!$ris){
                echo "<p>Errore nella modifica!</p>";
              }else{
                echo "<p>Modifica riuscita!</p>";
              }
            }
          }
          ?>
          </form>
        </div>
  </body>
</html>
