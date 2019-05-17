<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav"> 
                <?php                     
                    if ( 
                        $this->ion_auth->is_admin() || 
                        $this->ion_auth->in_group($this->config->item('role_responsabile')) || 
                        $this->ion_auth->in_group($this->config->item('role_supervisore'))
                        ) { ?>
                    <li> <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/dashboard') ?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                <?php } ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Repertorio</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url('admin/qualificazione') ?>">Qualificazioni</a></li>
                        <li><a href="<?php echo base_url('admin/unitacompetenza') ?>">Unità di Competenza</a></li>
                        <li><a href="<?php echo base_url('admin/abilita') ?>">Abilità</a></li>
                        <li><a href="<?php echo base_url('admin/conoscenza') ?>">Conoscenze</a></li>
                        <li><a href="<?php echo base_url('admin/standardformativo') ?>">Standard Formativi</a></li>
                        <li><a href="<?php echo base_url('admin/unitaformativa') ?>">Unità Formative</a></li>
                        <?php 
                            if ( $this->ion_auth->is_admin() || 
                                 $this->ion_auth->in_group($this->config->item('role_supervisore')) ) { ?>
                            
                            <li><a href="<?php echo base_url('admin/export') ?>">Interscambio dati ATLANTE</a></li>
                        <?php } 
                            if ( $this->ion_auth->is_admin() || 
                                 $this->ion_auth->in_group($this->config->item('role_responsabile')) ||
                                 $this->ion_auth->in_group($this->config->item('role_supervisore'))
                                ) { ?>
                            
                            <li><a href="<?php echo base_url('admin/archiviopubblicazioni') ?>">Archivio pubblicazioni</a></li>
                        <?php } ?>                            
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Tabelle</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url('admin/tabelle/sep') ?>">Settore Economico Professionale</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/ada') ?>">A.D.A.</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/processo') ?>">Processo</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/sequenza_processo') ?>">Sequenze di processo</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/ateco_2007') ?>">Codici Ateco 2007</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/cp_2011') ?>">Codici Professioni ISTAT 2011</a></li>
                        <li><a href="<?php echo base_url('admin/tabelle/isced') ?>">Codici ISCED-F 2013</a></li>
                    </ul>
                </li>
                <?php if ($this->ion_auth->is_admin()) { ?>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Amministrazione</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url('admin/utenti') ?>">Utenti</a></li>
                        <li><a href="<?php echo base_url('admin/activitylog') ?>">Log Attività</a></li>
                    </ul>
                </li>  
                <?php } ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>