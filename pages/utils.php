<?php
// crea dinamicamente la barra di navigazione a seconda dei privilegi che si hanno
// la barra e' inserita in un apposito div

function createNavBar() {
	// controlla se i privilegi non sono settati (e li imposta a 0, valore di default)
   	if(!isset($_SESSION['privilegi'])) {
		$_SESSION['privilegi'] = 0;
	}
	
	echo "<a href='index.php'> " . "Home" . "</a>";
	echo "<a href='profilo.php'> " . "Profilo" . "</a>";
	
	switch($_SESSION['privilegi']) {
		// non loggato
		case 0:
			echo "<a href='login.php'> " . "Login" . "</a>";
			break;

		// utente
		case 1:
			echo "<a href='storico.php'> " . "Storico Fatture / Operazioni" . "</a>";
			echo "<a href='logout.php'> " . "Logout" . "</a>";
			break;

		// meccanico
		case 2:
			echo "<a href='meccanicoOperazioni.php'> " . "Operazioni Meccanico" . "</a>";
			echo "<a href='RegistraVeicolo.php'> " . "Registra Veicolo" . "</a>";
			echo "<a href='logout.php'> " . "Logout" . "</a>";
			break;

		// amministrazione
		case 3:
			echo "<a href='RegistraMeccanico.php'> " . "Registra Meccanico" . "</a>";
		
			echo "<a href='modificaDatiMeccanico.php'> " . "Modifica Meccanico" . "</a>";
			
			echo "<a href='LicenziaMeccanico.php'> " . "Licenzia Meccanico" . "</a>";

			echo "<a href='RegistraCliente.php'> " . "Registra Cliente" . "</a>";
			
			echo "<a href='modificaDatiCliente.php'> ". "Modifica Cliente". "</a>";
			
			echo "<a href='disabilitaCliente.php'> " . "Disabilita Cliente" . "</a>";

			echo "<a href='RegistraProdottoDb.php'> " . "Registra Prodotto Db" . "</a>";
			echo "<a href='modificaProdotto.php'> " . "Modifica Prodotto Db" . "</a>";
			echo "<a href='RegistraIntervento.php'> " . "Registra Intervento" . "</a>";
			
			echo "<a href='logout.php'> " . "Logout" . "</a>";
		
			break;
	}


}



// funzioni di check
// vanno richiamate in ogni pagina dove si vuole controllare l'accesso

// ritorna true se l'accesso e' permesso
// false se non e' permesso

/*
	ACCESSI:
	accesso negato 		-> 	tutti
	accesso riuscito	->	tutti
	login -> negato se sei gia' loggato
	logout -> tutti
	profilo -> tutti
	
	regCliente 		-> ?
	regIntervento 	-> admin
	regMeccanico 	-> admin
	LicenziaMecc 	-> admin
	regProdDb 		-> admin
	
	collegaInterv	-> meccanico
	regProd 		-> meccanico
	regVeicolo 		-> meccanico
	meccOperazioni 	-> meccanico
	ricons è in operaz meccanico
*/

function checkNotLoggedPermissions() {
	$state = false;

	if($_SESSION['privilegi'] == 0) {
		$state = true;
	}
	else {
		// rimane false, cioe' non permesso
		header("Refresh:0; url=403.php");
	}

	return $state;
} 


function checkUserPermissions() {
	$state = false;

	if($_SESSION['privilegi'] == 1) {
		$state = true;
	}
	else {
		// rimane false, cioe' non permesso
		header("Refresh:0; url=403.php");
	}

	return $state;
} 

function checkMeccPermissions() {
	$state = false;

	if($_SESSION['privilegi'] == 2) {
		$state = true;
	}
	else {
		// rimane false, cioe' non permesso
		header("Refresh:0; url=403.php");
	}

	return $state;
} 

function checkAdminPermissions() {
	$state = false;

	if($_SESSION['privilegi'] == 3) {
		$state = true;

	}
	else {
		// rimane false, cioe' non permesso, redirect su 403
		header("Refresh:0; url=403.php");
	}

	return $state;
} 



function logout() {
	session_unset();
    session_destroy();
    header("Refresh:0; url=index.php");
}

function connect(){
        $myconn = new mysqli("localhost", "root", "", "officina");
        if ($myconn->connect_error) {
            echo("errore di connessione(" . $myconn->connect_errno . ")" . $myconn->connect_error);
        }else{

        }

        return $myconn;
}

// funzione generica per eseguire le query
// @return:	recordset o null se la query non e' andata a buon fine
// @params:	$myconn -> array contenente la connessione
//			$query 	-> query da eseguire

function execute($myconn, $query) {
	$ris = $myconn -> query($query);
	
	if(!$ris -> num_rows > 0) {
		$ris = null;
	}

	return $ris;
}

// funzione per stampare il ris di una query all'interno di una tabella
function showQueryTable($table){
	echo "<table class=\"stampa\">";
	for($i=0;$i<sizeof($table);$i++){
		echo "<tr>";
		for($j=0;$j<sizeof($table[$i]);$j++){
			echo "<td>";
			echo $table[$i][$j];
			echo "</tr>";
		}
		echo "</tr>";
	}
	echo "</table>";
}


?>
