<!DOCTYPE html>
<!--
  Pagina per la modifica dei dati del veicolo fa uso della pagina salvaVeicolo.php per salvare i dati
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/style.css"  >
    </head>
    <body>
        <h1 class="center bgblack header_page">Modifica veicolo</h1>

        <div class = 'navbar bgblack maxwidth' id='menu'>
            <?php
                include("utils.php");
                session_start();
                createNavBar();
		            checkMeccPermissions();
            ?>
        </div>
        <script>
        function controllo()//Funzione che controlla che tutti i campi siano stati compilati
        {
          var str="";//str conterrà l'elenco dei campi da compilare
          if(document.getElementById("nome").value=="")
            str=str+"Inserire il nome\n";

          if(document.getElementById("targa").value=="")
            str=str+"Inserire la targa\n";

          if(document.getElementById("tipo").value=="")
            str=str+"Inserire il tipo\n";

          if(document.getElementById("cavalli").value=="")
            str=str+"Inserire i cavalli\n";

          if(document.getElementById("cilindrata").value=="")
            str=str+"Inserire la cilindrata";

          if(str=="")//Se tutti i campi sono compilati richiama salva()
            salva();
          else//Altrimenti mostra l'elenco dei campi da compilare
            alert(str);
        }

        function salva() {//Utilizzando ajax richiamerà la pagina salvaVeicolo.php
            //Prendo i nuovi dati da salvare
            var nome=document.getElementById("nome").value;
            var targa=document.getElementById("targa").value;
            var tipo=document.getElementById("tipo").value;
            var cavalli=document.getElementById("cavalli").value;
            var cilindrata=document.getElementById("cilindrata").value;
            var proprietario=document.getElementById("proprietario").value;
            var id=document.getElementById("id").innerHTML;//id verrà utilizzato da saòvaVeicolo.php per sapere di quale veicolo cambiare i dati

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("risp").innerHTML = this.responseText;//Messaggio di risposta

                  if(document.getElementById("risp").innerHTML=="<p>Modifica riuscita!</p>")//Se la modifica è andata a buon fine allora aggiorna l'elenco dei vecchi dati con i nuovi
                  {
                    document.getElementById("nome_v").innerHTML=document.getElementById("nome").value;
                    document.getElementById("targa_v").innerHTML=document.getElementById("targa").value;
                    document.getElementById("tipo_v").innerHTML=document.getElementById("tipo").value;
                    document.getElementById("cavalli_v").innerHTML=document.getElementById("cavalli").value;
                    document.getElementById("cilindrata_v").innerHTML=document.getElementById("cilindrata").value;
                    document.getElementById("proprietario_v").innerHTML=document.getElementById("proprietario").value;
                  }
                }
            }
            xhttp.open("GET", "salvaVeicolo.php?id=" + id + "&nome=" + nome + "&targa="+ targa+ "&tipo="+ tipo+ "&cavalli="+ cavalli+ "&cilindrata="+ cilindrata+ "&proprietario="+ proprietario, true);
            xhttp.send();
        }

        function copia()//Funzione che copia i vecchi dati nei campi di testo così da non riscrivere tutti i dati per cambiarne uno solo
        {
          document.getElementById("nome").value = document.getElementById("nome_v").innerHTML;
          document.getElementById("targa").value = document.getElementById("targa_v").innerHTML;
          document.getElementById("tipo").value = document.getElementById("tipo_v").innerHTML;
          document.getElementById("cavalli").value = document.getElementById("cavalli_v").innerHTML;
          document.getElementById("cilindrata").value = document.getElementById("cilindrata_v").innerHTML;
          document.getElementById("proprietario").value = document.getElementById("proprietario_v").innerHTML;
        }
        </script>

        <div class="bgwhite" style="height: 400px; padding:5%; width: 40%; margin: 0px auto ">
          <?php
            $myconn = connect();
            //Estrarrò l'id così da sapere su quale veicolo sto eseguendo l'operazione(non uso la targa perchè può essere cambiata)
            $targa = $_GET["targa"];
            $sql="SELECT id_veicolo
                  FROM veicolo
                  WHERE targa='".$targa."'";
            $ris = $myconn->query($sql);
            $id=$ris->fetch_assoc();
            echo "<p id='id'>ID: ".$id["id_veicolo"]."</p>";//Mosto l'id così da poterlo utilizzare con java script attraverso l'id del paragrafo
          ?>
          <form>
            <table style="border-collapse: collapse">
              <tr>
                <td style="width:3%">
                  <?php

                    $sql="SELECT nomeV,tipo,cavalli,cilindrata,id_cliente,nome,cognome
                          FROM veicolo
                          JOIN cliente
                          ON id_cliente=fk_id_cliente
                          WHERE id_veicolo='".$id["id_veicolo"]."'";
                          $ris = $myconn->query($sql);
                          $result=$ris->fetch_assoc();
                    //Stampo l'elenco dei vecchi dati
                    echo "<table>
                            <tr>
                              <td><p>Nome: </p></td><td><p id='nome_v'>".$result["nomeV"]."</p></td>
                            </tr>
                            <tr>
                              <td><p>Targa: </p></td><td><p id='targa_v'>".$targa."</p></td>
                            </tr>
                            <tr>
                              <td><p>Tipo: </p></td><td><p id='tipo_v'>".$result["tipo"]."</p></td>
                            </tr>
                            <tr>
                              <td><p>Cavalli: </p></td><td><p id='cavalli_v'>".$result["cavalli"]."</p></td>
                            </tr>
                            <tr>
                              <td><p>Cilindrata: </p></td><td><p id='cilindrata_v'>".$result["cilindrata"]."</p></td>
                            </tr>
                            <tr>
                              <td><p>Proprietario: </p></td></tr><tr><td colspan=2><p id='proprietario_v'>".$result["id_cliente"]."-".$result["nome"]." ".$result["cognome"]."</p></td>
                            </tr>
                        </table>";
                  ?>

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
                      <td><p>Nuova targa: </p></td><td style="width:50%"><input type="text" id="targa" name="targa" required></td>
                    </tr>
                    <tr>
                      <td><p>Nuovo tipo: </p></td><td style="width:50%"><input type="text" id="tipo" name="tipo" required></td>
                    </tr>
                    <tr>
                      <td><p>Nuovi cavalli: </p></td><td style="width:50%"><input type="text" id="cavalli" name="cavalli" required></td>
                    </tr>
                    <tr>
                      <td><p>Nuova cilindrata: </p></td><td style="width:50%"><input type="text" id="cilindrata" name="cilindrata" required></td>
                    </tr>
                    <tr>
                    <?php
                      $sql="SELECT id_cliente,nome,cognome
                            FROM cliente";
                            $ris = $myconn->query($sql);
                            $result=$ris->fetch_assoc();

                      echo "<td><p>Nuovo proprietario</p></td>";
                      echo "<td>";
                      //Creo una select per scegliere il nuovo proprietario utilizzo l'id per distinguere eventuali omonimi
                      echo "<select id='proprietario' name='proprietario'>";//Creazione select per selezionare il meccanico al quale cambiare i dati
                              while ($row = $ris->fetch_assoc()) {
                                echo "<option>" . $row["id_cliente"] . "-" . $row["nome"] . " " . $row["cognome"] . "</option>";
                              }
                      echo "</select>";
                      echo "</td>";
                    ?>
                  </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div>
                <input type="button" name ="button" value="Salva" onclick="controllo()">
            </div>
          </form>
          <p id="risp"></p>
        </div>
	</body>
</html>
