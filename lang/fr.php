<?php
$langid = "fr";
$langname = "Français";
$language = "Langue";

$_about = "A propos";
$_action = "Action";
$_add = "Ajouter";
$_add_router = "Ajouter un Router";
$_add_user = "Créer un Utilisateur";
$_add_user_profile = "Ajouter un Profile";
$_admin = "Admin";
$_admin_settings = "Paramètres Admin ";
$_all = "Tous";
$_auto_reload = "Chargement Auto";
$_bluetooth_ac = "Code d'accès pour imprimante BT";
$_board_name = "Nom du modèle";
$_by_comment = "Par Commentaire";
$_cancel = "Annuler";
$_character = "Charactères";
$_close = "Fermer";
$_comment = "Commentaires";
$_confirm = "Confirmer";
$_connecting = "Connexion";
$_cpu_load = "Chargement CPU";
$_currency = "Devise";
$_dashboard = "Tableau de bord";
$_data_limit = "Limite de donnée";
$_date = "Date";
$_days = "jours";
$_delete_data = "Supprimer les données";
$_delete = "Supprimer";
$_dhcp_leases = "DHCP Leases";
$_dns_name = "DNS Name";
$_edit = "Editer";
$_edit_user = "Editer un Utilisateur";
$_end = "Fin";
$_expired = "Expiré";
$_expired_mode = "Mode d'expiration";
$_extend_expired_date = "Etendre la date d'expiration";
$_format_file_name = "Formater le nom du fichier";
$_free_hdd = "Espace libre HDD";
$_free_memory = "Espace libre RAM";
$_generate_code = "Code Généré";
$_generate = "Générer";
$_generate_user = "Générer un Utilisateur";
$_grace_period = "Periode de grâce";
$_help = "Aide";
$_hosts = "Hosts";
$_hotspot_active = "Hotspot Active";
$_hotspot_cookies = "Cookies";
$_hotspot_log = "Journal Hotspot";
$_hotspot_name = "Nom du Hotspot";
$_hotspot_users = "Utilisateur Hotspot";
$_hours = "heures";
$_idle_timeout = "Temps d'attente";
$_income = "Entrant";
$_interface = "Interface";
$_ip_bindings = "IP Bindings";
$_last_generate = "Last Generate";
$_list_logo = "Liste de Logo";
$_live_report = "Live Report";
$_loading = "Chargement";
$_loading_interface = "Interface de chargement";
$_loading_theme = "Chargement de theme";
$_lock_user = "Bloquer l'utilisateur";
$_log = "Journal";
$_logout = "Déconnexion";
$_messages = "Messages";
$_min = "min";
$_minutes = "minutes";
$_model = "Modèle";
$_name = "Nom";
$_no = "Non";
$_open = "Ouvrir";
$_package = "Package";
$_password = "Mot de passe";
$_please_login = "Veuillez-vous connectez";
$_ppp_active = "PPP Active";
$_ppp_profiles = "PPP Profiles";
$_ppp_secrets = "PPP Secrets";
$_prefix = "Préfix";
$_price = "Prix";
$_print_default = "Défaut";
$_print = "Imprimer";
$_print_qr = "QR";
$_print_small = "Petit";
$_processing = "Taitement...";
$_profile = "Profile";
$_qty = "Qte";
$_quick_print = "Impression rapide";
$_random = "Aléatoire";
$_readme = "Lire intruction";
$_reboot = "Vous êtes sur de rédémarer";
$_reduce_expired_date = "Reduire la Date d'expiration";
$_remove = "Retirer";
$_report = "Rapport";
$_reset_start_date = "Réinitiatliser date début";
$_resume = "Resume";
$_router_list = "Liste des Routers";
$_save = "Sauvegarder";
$_search = "Chercher";
$_sec = "sec";
$_seconds = "secondes";
$_selected = "Selectionner";
$_select_interface = "Selectionner une Interface";
$_selling_price = "Prix de vente";
$_selling_report = "Rapport de vente";
$_send_to_WA = "Envoyer par WhatsApp";
$_session_name = "Nom de la Session";
$_session = "Session";
$_session_settings = "Paramètre de Session";
$_settings = "Paramètres";
$_share = "Partager";
$_show_all = "Afficher tout";
$_shutdown = "Es-tu sûr d'éteindre";
$_start = "Démarrer";
$_system_date_time = "System date & time";
$_system_off = "Eteindre";
$_system_reboot = "Redémarrer";
$_system_scheduler = "Scheduler";
$_system = "Système";
$_template_editor = "Editeur de template";
$_theme = "Thème";
$_this_month = "Ce mois";
$_time_limit = "Limite Temps";
$_time = "Temps";
$_today = "Ajourd'hui";
$_total = "Total";
$_traffic_interface = "Traffic Interface";
$_traffic_monitor = "Traffic Monitor";
$_traffic = "Traffic";
$_upload = "Téléversement";
$_upload_logo = "Importer un Logo";
$_uptime = "Uptime";
$_uptime_user = "Uptime";
$_user_length = "Taille du nom";
$_user_list = "Liste Utilisateurs";
$_user_log = "Log des Utilisateur";
$_user_mode = "Mode Utilisateur";
$_user_name = "Nom d'utilisateur";
$_user_pass = "Nom d'utilisateur & Mot de passe";
$_user_profile_list = "Liste Profile";
$_user_profile = "Profile Utilisateur";
$_users = "Utilisateurs";
$_user_user = "Nom d'utilisateur = Mot de passe";
$_validity = "Validité";
$_voucher_code = "Ticket Code";
$_vouchers = "Ticket";
$_yes = "Oui";
$_login_btn = "Connectez-vous";
$_themes = ["Sombre", "claire", "bleu", "vert", "rose"];

//details
$_format_time_limit = '
    Format ' . $_time_limit . '.<br>
    [wdhm] Exemple : 30d = 30' . $_days . ', 12h = 12' . $_hours . ', 4w3d = 31' . $_days . '.
';
$_details_add_user = '
    ' . $_add_user . ' avec ' . $_time_limit . '.<br>
    Doit être ' . $_time_limit . ' < ' . $_validity . '.
';

$_details_user_profile = '
' . $_expired_mode . ' control chaque ticket du point d\'accès.<br>
Options : Suppression, Notifi1cation, Suppression & Notification, Notifitcation & Rapport.
<ul>
<li>Remove: L\'utilisateur sera supprimer à la date d\'expiration.</li>
<li>Notice: L\'utilisateur ne sera pas supprimer mais recevra une notification à l\'échéance.</li>
<li>Record: Sauvegarder de chaque ticket utilisé, pour calculer le montant total de ticket vendu.</li>
</ul>
</p>

        <p>' . $_lock_user . ' : Le ticket ne sera utilisé que sur un seul appareil.</p>
';

$_format_validity = '
Format ' . $_validity . '<br>
[wdhm] Example : 30d = 30' . $_days . ', 12h = 12' . $_hours . ', 30m = 30' . $_minutes . '<br>
5' . $_hours . ' 30' . $_minutes . ' = 5h30m';

$_format_ip_binding = '
    Format Upload/Download Max Limit<br>
    [k / M] Contoh : 512k, 1500k, 1M<br><br>
    Format ' . $_validity . '<br>
    [d] Exemple: 30d = 30' . $_days . '.<br>
';

$_help_report = '
<ul>
<li>Click CSV to download.</li>
<li>For filters per month, select Day and month, then click Filter.<br>
	<img width="70%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATUAAAAsCAYAAAAEsS/jAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAOlSURBVHhe7d09TtxAGMbxnCYSKOJDCggtqZIqHCRVpFwDiYJj0MARIq2i5QQUW6RH0CJST/x6bM/YM7Z38cfi1//iJ2F7PCvGfp+ZYQs+nH+7MACgBaEGQBVCDYAqhBoAVQg1AKoQagBUaQy1xdfv0fMA8F7VhtrBycLsH382Hz8dYgf2jxh74C2ioXZ4ujB7SVEdn33BjuQPKHYNmJtt6iEINdlyygrt+Ow8aIzxEGqA0ynUBMW0e4Qa4BBqChBqgEOoKUCoAQ6hpgChBjiEmgKEGuAQagoQaoBDqClAqAHOiKF2bZZP/8zLa+jhNtYem+oUardr8/J0by5j14AJGj3UggC7ujePBFsnhBrg7D7UhBTW69rc5MdZ0LnV3LNZXtlrN+vkeH3n3W/7fVxde+em7ffyj/e7W3Iu1lb0GmoNY2+vrc1y9eyue/deyvlSQN6Zh6SNe+bhat09N2nr9f3016yD51rtD3MwZD0MF2rpy5oVT7ByywohL5ZoAHrHCvz4+St4iHIu1lb0FmptY58HXjGp2JDJg6c51LK+vAkpbV+Epm0bXPf7Y1U5S0PWw4Ch1nSt+nKXZ+v0WmnlpoM/OzXNSqK3UIsojX0aat7KLeGvnIMQqjyrQKm/SNvK58lnaVqRY3ND1cPIoZbN3DmvWPyXW36uLZoJ82enpllJ9B9qNWPfU6il9xT9N4Ra6b2Qn8ufjfkYqh7G2X56BVW7rSkKUdrq2nr6ZEZqm5VEf6HWMvYdQ60Is2h/5ba5tE/pX9qW+sbcDFEP43xREFk5xIslKYZV0lbh1jMnM1LbrCS2eYhFSOTn/PFuG/tOoZY9M3+ltUGo2Tb2CwS2nvM2RD0ME2rpS+ud9wOuOPZm90w+60dDcma2eYjV8fVDqXXsW0LNtnfX05ArnlE1tOxx8/ZT2Pem9C0s0GD0UEuLpCR8WYttipCCqhRLqlqAM7ZVqCWC8W265o99W6hV7n9c3ZUnsjwkU9KPDTK7AqsLtdgKEKg3Yqj1TArE30bN2LahNjUSamw9sanJhpqsCGKz+hzpDjVZ4YereaDO9EIt+xscqzRHbahl21VWadjG9EINAbWhBrwBoaYAoQY4hJoChBrgEGoKEGqA0ynU3D8zjt+AcRBqgNMp1MTBycLsHfFf2neJUAOczqEmDk8X6Yot7wzj2k8mldh5AM1qQ03IVjR2HgDeq8ZQA4CpIdQAqEKoAVCFUAOgCqEGQBVCDYAiF+Y/bd3pxgv3MhEAAAAASUVORK5CYII=">
	</li>
	<li>Filter based on ' . $_prefix . ', fill ' . $_prefix . ' in the search input, then click filter.</li>
	<li>Filter based on ' . $_comment . ', fill in !!' . $_comment . ' in the  column, then click filter. Or click one of the comments. (Mikhmon Online).</li>
	<li>It is recommended to delete the sales report after download  the CSV report.</li>
	</ul>
';

$_delete_report = '
<ul>
		        <li>Supprimer le rapport de vente entrainera la suppression du journal d\'utilisation. </li>
		        <li>Il est recommandé de télécharger premièrement ' . $_user_log . '. </li>
		      </ul>
';
