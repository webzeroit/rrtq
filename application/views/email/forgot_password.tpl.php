<html>
    <body>
        <p>
            Gentile utente,<br/>
            puoi reimpostare la tua password cliccando sul link qui sotto:
        </p>	
        <p><?php echo anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link'));?></p>      
        <p>
            Il tuo username è: <?php echo $identity; ?>
        </p>
        <br/>
        <p>Se non hai richiesto la reimpostazione della password puoi tranquillamente ignorare questa e-mail.</p>
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