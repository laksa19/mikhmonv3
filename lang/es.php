<?php
$langid="es"; 
$langname = "Spanish";
$language = "Language";
// Translator Fernando Sepulveda
$_about = "Acerca";
$_action = "Acción";
$_add = "Anadir Usuarios";
$_add_router = "Añadir Router";
$_add_user = "Añadir Usuario";
$_add_user_profile = "Añadir Perfil";
$_admin = "Admin";
$_admin_settings = "Configuración de administrador";
$_all = "Todo";
$_auto_reload = "Carga automática";
$_bluetooth_ac = "Imprimir código de acceso BT";
$_board_name = "Tablero ";
$_by_comment = "Por comentario";
$_cancel = "Cancelar";
$_character = "Caracteres";
$_close = "Cerrar";
$_comment = "Comentario";
$_confirm = "Confirmar";
$_connecting = "Conectando";
$_cpu_load = "Carga CPU";
$_currency = "Moneda";
$_dashboard = "Tablero";
$_data_limit = "Limite de Datos";
$_date ="Fecha";
$_days = "Días";
$_delete_data = "Borrar datos";
$_delete = "Eliminar";
$_dhcp_leases = "Arrendamientos DHCP";
$_dns_name = "Nombre DNS";
$_edit = "Editar";
$_edit_user = "Editar Usuarios";
$_end = "Fin";
$_expired = "Expirado";
$_expired_mode = "Modo Expirado";
$_extend_expired_date = "Extender fecha de vencimiento";
$_format_file_name = "Formatear nombre de archivo";
$_free_hdd = "Libre HDD";
$_free_memory = "Memoria Libre";
$_generate_code = "Generar Código";
$_generate = "Generar Voucher";
$_generate_user = "Generar Usuario";
$_grace_period = "Período de Gracia";
$_help = "Ayuda";
$_hosts = "Hosts";
$_hotspot_active = "Usuarios en Linea";
$_hotspot_cookies = "Cookies";
$_hotspot_log = "Hotspot Log";
$_hotspot_name = "Nombre Hotspot";
$_hotspot_users = "Usuarios Hotspot";
$_hours = "horas";
$_income = "Ingresos";
$_idle_timeout = "Tiempo de inactividad";
$_interface = "Inteface";
$_ip_bindings = "IP Bindings";
$_last_generate = "Ultimos Generados";
$_list_logo = "Lista Logo";
$_live_report = "Reporte en Vivo";
$_loading = "Cargando";
$_loading_interface = "Cargando Interface";
$_loading_theme = "Cargando theme";
$_lock_user = "Bloquear Usuario";
$_log = "Log";
$_logout = "Cerrar sesión";
$_messages = "Mensajes";
$_min = "min";
$_minutes = "minutos";
$_model = "Modelo";
$_name = "Nombre";
$_no = "No";
$_open = "Abrir";
$_package = "Paquete";
$_password = "Password";
$_please_login = "Por Favor Inicia Sesión";
$_ppp_active = "PPP Activos";
$_ppp_profiles = "Perfiles PPP";
$_ppp_secrets = "PPP Secrets";
$_prefix = "Prefijo";
$_price = "Precio";
$_print_default = "Por Defecto";
$_print = "Imprimir";
$_print_qr = "QR";
$_print_small = "Pequeña";
$_processing = "Procesando...";
$_profile = "Perfil";
$_qty = "Cantidad";
$_quick_print = "Impresión rápida";
$_random = "Aleatorio";
$_readme = "Leeme";
$_reboot = "¿Estás seguro de reiniciar?";
$_reduce_expired_date = "Reducir fecha de vencimiento";
$_remove = "Eliminar";
$_report = "Reporte";
$_reset_start_date = "Restablecer fecha de inicio";
$_resume = "Resumen";
$_router_list = "Lista de Router";
$_save = "Guardar";
$_search = "Buscar";
$_sec = "sec";
$_seconds = "segundos";
$_selected = "Seleccionar";
$_select_interface = "Seleccionar Interface";
$_selling_price = "Precio de venta";
$_selling_report = "Informe de ventas";
$_send_to_WA = "Enviar a WhatsApp";
$_session_name = "Nombre de la Sesión";
$_session = "Sesión";
$_session_settings = "Configuración de Sesión";
$_settings = "Ajustes";
$_share = "Compartir";
$_show_all = "Mostrar Todo";
$_shutdown = "Estas seguro de Apagar";
$_start = "Inicio";
$_system_date_time = "Fecha y Hora del Sistema";
$_system_off = "Apagar";
$_system_reboot = "Reiniciar";
$_system_scheduler = "Programador";
$_system = "Sistema";
$_template_editor = "Editor de Plantillas";
$_theme = "Tema";
$_this_month = "Este Mes";
$_time_limit = "Limite de Tiempo";
$_time = "Hora";
$_today = "Hoy";
$_total = "Total";
$_traffic_interface = "Interfaz de tráfico";
$_traffic_monitor = "Trafico Monitor";
$_traffic = "Trafico";
$_upload = "Cargar";
$_upload_logo = "Cargar Logo";
$_uptime = "Actividad";
$_uptime_user = "Actividad";
$_user_length = "Longitud del Codigo";
$_user_list = "Lista de Usuarios";
$_user_log = "Usuarios Log";
$_user_mode = "Modo Usuarios";
$_user_name = "Usuario";
$_user_pass = "Usuario & Password";
$_user_profile_list = "Lista de Perfiles";
$_user_profile = "Perfil del Usuario";
$_users = "Usuarios";
$_user_user = "Usuario = Password";
$_validity = "Validez";
$_voucher_code ="Codigo Voucher";
$_vouchers = "Vouchers";
$_yes = "Si";





//details
$_format_time_limit = '
    Formato '.$_time_limit.'.<br>
    [wdhm] Ejemplo : 30d = 30'.$_days.', 12h = 12'.$_hours.', 4w3d = 31'.$_days.'.
';
$_details_add_user = '
    '.$_add_user.' with '.$_time_limit.'.<br>
    Should '.$_time_limit.' < '.$_validity.'.
';

$_details_user_profile = '
'.$_expired_mode.' Es el control para el usuario del hotspot.<br>
Opciones : Eliminar, aviso, Eliminar y registrar, Aviso y registrar.
<ul>
<li>Eliminar: El usuario será eliminado cuando  expire..</li>
<li>Naviso: El usuario no se eliminará y recibirá una notificación después de la expiración del usuario.</li>
<li>Registrar: Guardar el precio de cada usuario de inicio de sesión. Para calcular las ventas totales de usuarios de hotspot..</li>
</ul>
</p>
        
        <p>'.$_lock_user.' : El nombre de usuario solo se puede utilizar en 1 dispositivo.</p>
';

$_format_validity = '
Formato '.$_validity.'<br>
[wdhm] Ejemplo : 30d = 30'.$_days.', 12h = 12'.$_hours.', 30m = 30'.$_minutes.'<br>
5'.$_hours.' 30'.$_minutes.' = 5h30m';

$_format_ip_binding = '
    Formato Upload/Download Max Limite<br>
    [k / M] Contoh : 512k, 1500k, 1M<br><br>
    Formato '.$_validity.'<br>
    [d] Ejemplo: 30d = 30'.$_days.'.<br>
';

$_help_report = '
<ul>
<li>Click para descargar CSV.</li>
<li>Para los filtros por mes, seleccione Día y mes, luego haga clic en Filtro.<br>
	<img width="70%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATUAAAAsCAYAAAAEsS/jAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAOlSURBVHhe7d09TtxAGMbxnCYSKOJDCggtqZIqHCRVpFwDiYJj0MARIq2i5QQUW6RH0CJST/x6bM/YM7Z38cfi1//iJ2F7PCvGfp+ZYQs+nH+7MACgBaEGQBVCDYAqhBoAVQg1AKoQagBUaQy1xdfv0fMA8F7VhtrBycLsH382Hz8dYgf2jxh74C2ioXZ4ujB7SVEdn33BjuQPKHYNmJtt6iEINdlyygrt+Ow8aIzxEGqA0ynUBMW0e4Qa4BBqChBqgEOoKUCoAQ6hpgChBjiEmgKEGuAQagoQaoBDqClAqAHOiKF2bZZP/8zLa+jhNtYem+oUardr8/J0by5j14AJGj3UggC7ujePBFsnhBrg7D7UhBTW69rc5MdZ0LnV3LNZXtlrN+vkeH3n3W/7fVxde+em7ffyj/e7W3Iu1lb0GmoNY2+vrc1y9eyue/deyvlSQN6Zh6SNe+bhat09N2nr9f3016yD51rtD3MwZD0MF2rpy5oVT7ByywohL5ZoAHrHCvz4+St4iHIu1lb0FmptY58HXjGp2JDJg6c51LK+vAkpbV+Epm0bXPf7Y1U5S0PWw4Ch1nSt+nKXZ+v0WmnlpoM/OzXNSqK3UIsojX0aat7KLeGvnIMQqjyrQKm/SNvK58lnaVqRY3ND1cPIoZbN3DmvWPyXW36uLZoJ82enpllJ9B9qNWPfU6il9xT9N4Ra6b2Qn8ufjfkYqh7G2X56BVW7rSkKUdrq2nr6ZEZqm5VEf6HWMvYdQ60Is2h/5ba5tE/pX9qW+sbcDFEP43xREFk5xIslKYZV0lbh1jMnM1LbrCS2eYhFSOTn/PFuG/tOoZY9M3+ltUGo2Tb2CwS2nvM2RD0ME2rpS+ud9wOuOPZm90w+60dDcma2eYjV8fVDqXXsW0LNtnfX05ArnlE1tOxx8/ZT2Pem9C0s0GD0UEuLpCR8WYttipCCqhRLqlqAM7ZVqCWC8W265o99W6hV7n9c3ZUnsjwkU9KPDTK7AqsLtdgKEKg3Yqj1TArE30bN2LahNjUSamw9sanJhpqsCGKz+hzpDjVZ4YereaDO9EIt+xscqzRHbahl21VWadjG9EINAbWhBrwBoaYAoQY4hJoChBrgEGoKEGqA0ynU3D8zjt+AcRBqgNMp1MTBycLsHfFf2neJUAOczqEmDk8X6Yot7wzj2k8mldh5AM1qQ03IVjR2HgDeq8ZQA4CpIdQAqEKoAVCFUAOgCqEGQBVCDYAiF+Y/bd3pxgv3MhEAAAAASUVORK5CYII=">
	</li>
	<li>Para filtros basados en'.$_prefix.', completar '.$_prefix.' en la entrada de búsqueda, luego haga clic en filtro.</li>
	<li>Filtre en base a los comentarios, complete el !!Comentario en la columna Buscar y luego haga clic en filtro O haga clic en uno de los comentarios. (Mikhmon Online).</li>
		        <li>Se recomienda eliminar el informe de ventas después de descargar el informe CSV.</li>
	</ul>
';

$_delete_report = '
<ul>
		        <li>Eliminar el informe de ventas también eliminará el registro de usuario. </li>
		        <li>Se recomienda descargar.'.$_user_log.' Primero. </li>
		      </ul>
';
