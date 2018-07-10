<html>
    <body>
        <p>
            Gentile utente,<br/>
            la registrazione alla piattaforma è avvenuta con successo.
        </p>	
        <p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/' . $id . '/' . $activation, lang('email_activate_link'))); ?></p>
        <p>
            Attivata l'utenza potrai accedere con le seguenti credenziali:<br/>
            __________________________________________________<br/><br/>
            <b>Username: </b><?php echo $identity ?><br/>
            <b>Password: </b><?php echo $password ?><br/>
            __________________________________________________
        </p>
        <p>Ti ricordiamo che e' importante conservare questi dati in modo sicuro e di effettuare il cambio password al primo accesso utilizzando l'apposita funzionalità.</p>
        <br/>    
        <br/>    
        <br/>        
        <hr/>
        <p>
            <b>ATTENZIONE</b>   
            <br/> 
            <small>
                Questo messaggio e' stato inviato per conto di Regione Campania da un indirizzo non abilitato a ricevere e‑mail. 
                Qualora non fosse il destinatario si prega di non rispondere alla presente ma di informarci immediatamente ed eliminare il messaggio, 
                con gli eventuali allegati, senza trattenerne copia. Qualsiasi utilizzo non autorizzato 
                del contenuto di questo messaggio costituisce violazione dell'obbligo di non prendere 
                cognizione della corrispondenza tra altri soggetti, salvo più grave illecito, ed espone 
                il responsabile alle relative conseguenze civili e penali.
            </small>
        </p>
    </body>
</html>