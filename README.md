# progetto_informatica_2019
Questa cartella serve per coordinare il lavoro utilizzando GitHub.  
È sufficiente creare un account.  
Per maggiori informazioni su come utilizzare GitHub consultare il seguente link:  
https://github.com/emergenzeHack/terremotocentro/wiki/002-Come-si-usa-Github  
https://github.com/emergenzeHack/terremotocentro/wiki/003-Come-si-apre-un-issue
  
Lista delle cose da fare:  
  - controllo sull'input  [fatto in parte by dag7dev]
  - il cliente deve poter vedere lo stato delle sue macchine in elaborazione  
  - gestire fattura  
  - commentare il codice  
  - registrazione delle credenziali dei clienti nel DB (compito amministrazione)
 
  ✅ navbar automatica (html + php). Il file verrà poi incluso in ogni head dei file. [by dag7dev]  
  ✅ controllo privilegi cookie per accesso alle pagine [by dag7dev]  
  ✅ evitare il tag center [by dag7dev]  
  ✅ collegare pagine [by dag7dev]  
 
Pagine mancanti:  
  Utenza Amministratore  
    ✅ Modifica Dati Meccanico[by GP]  
    ✅ Licenzia Meccanico[by LC]  
    ✅ Modifica Prodotto[by GP]  
    ✅ Modifica Cliente[by CM]  
    
  Utenza Meccanico  
    ✅ Modifica Dati Veicolo[by GP]  
      
  Utenza Cliente  
    ✅ Visualizza fatture e lista veicoli
  
pagine cancellati:  
- Cancella Veicolo(Non la facciamo un veicolo è lì e basta, comporterebbe perdita di dati sulle fatture e il resto)
- Cancella Prodotto(non la facciamo se ci chiedono perchè, aggiungi colonna stato=0 e modifica la query nell'insert perchè il prodotto non è più disponibile e quindi non va considerato, stato=1 dunque)
- Cancella cliente (idem, vedi cancella prodotto)

PERCHE' NON AVETE FATTO UNA PAGINA DOVE SI CALCOLA LA FATTURA?  
PERCHE' C'È UN SOFTWARE ESTERNO CHE LO FAI PER NOI!
