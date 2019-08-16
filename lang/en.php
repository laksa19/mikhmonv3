<?php
$langid="en"; 
$langname = "English";
$language = "Language";

$_about = "About";
$_action = "Action";
$_add = "Add";
$_add_router = "Add Router";
$_add_user = "Add User";
$_add_user_profile = "Add Profile";
$_admin = "Admin";
$_admin_settings = "Admin Settings";
$_all = "All";
$_auto_reload = "Auto load";
$_bluetooth_ac = "Print BT Access Code";
$_board_name = "Board Name";
$_by_comment = "By Comment";
$_cancel = "Cancel";
$_character = "Character";
$_close = "Close";
$_comment = "Comment";
$_confirm = "Confirm";
$_connecting = "Connecting";
$_cpu_load = "CPU Load";
$_currency = "Currency";
$_dashboard = "Dashboard";
$_data_limit = "Data Limit";
$_date ="Date";
$_days = "days";
$_delete_data = "Delete data";
$_delete = "Delete";
$_dhcp_leases = "DHCP Leases";
$_dns_name = "DNS Name";
$_edit = "Edit";
$_edit_user = "Edit User";
$_end = "End";
$_expired = "Expired";
$_expired_mode = "Expired Mode";
$_extend_expired_date = "Extend Expired Date";
$_format_file_name = "Format file name";
$_free_hdd = "Free HDD";
$_free_memory = "Free Memory";
$_generate_code = "Generate Code";
$_generate = "Generate";
$_generate_user = "Generate User";
$_grace_period = "Grace Period";
$_help = "Help";
$_hosts = "Hosts";
$_hotspot_active = "Hotspot Active";
$_hotspot_cookies = "Cookies";
$_hotspot_log = "Hotspot Log";
$_hotspot_name = "Hotspot Name";
$_hotspot_users = "Hotspot User";
$_hours = "hours";
$_idle_timeout = "Idle Timeout";
$_income = "Income";
$_interface = "Interface";
$_ip_bindings = "IP Bindings";
$_last_generate = "Last Generate";
$_list_logo = "List Logo";
$_live_report = "Live Report";
$_loading = "Loading";
$_loading_interface = "Loading Interface";
$_loading_theme = "Loading theme";
$_lock_user = "Lock User";
$_log = "Log";
$_logout = "Logout";
$_messages = "Messages";
$_min = "min";
$_minutes = "minutes";
$_model = "Model";
$_name = "Name";
$_no = "No";
$_open = "Open";
$_package = "Package";
$_password = "Password";
$_please_login = "Please Login";
$_ppp_active = "PPP Active";
$_ppp_profiles = "PPP Profiles";
$_ppp_secrets = "PPP Secrets";
$_prefix = "Prefix";
$_price = "Price";
$_print_default = "Default";
$_print = "Print";
$_print_qr = "QR";
$_print_small = "Small";
$_processing = "Processing...";
$_profile = "Profile";
$_qty = "Qty";
$_quick_print = "Quick Print";
$_random = "Random";
$_readme = "Read Me";
$_reboot = "Are you sure to reboot";
$_reduce_expired_date = "Reduce Expired Date";
$_remove = "Remove";
$_report = "Report";
$_reset_start_date = "Reset Start Date";
$_resume = "Resume";
$_router_list = "Router List";
$_save = "Save";
$_search = "Search";
$_sec = "sec";
$_seconds = "seconds";
$_selected = "Selected";
$_select_interface = "Select Interface";
$_selling_price = "Selling Price";
$_selling_report = "Selling Report";
$_send_to_WA = "Send to WhatsApp";
$_session_name = "Session Name";
$_session = "Session";
$_session_settings = "Session Settings";
$_settings = "Settings";
$_share = "Share";
$_show_all = "Show All";
$_shutdown = "Are you sure to shutdown";
$_start = "Start";
$_system_date_time = "System date & time";
$_system_off = "Shutdown";
$_system_reboot = "Reboot";
$_system_scheduler = "Scheduler";
$_system = "System";
$_template_editor = "Template Editor";
$_theme = "Theme";
$_this_month = "This month";
$_time_limit = "Time Limit";
$_time = "Time";
$_today = "Today";
$_total = "Total";
$_traffic_interface = "Traffic Interface";
$_traffic_monitor = "Traffic Monitor";
$_traffic = "Traffic";
$_upload = "Upload";
$_upload_logo = "Upload Logo";
$_uptime = "Uptime";
$_uptime_user = "Uptime";
$_user_length = "Name Length";
$_user_list = "User List";
$_user_log = "User Log";
$_user_mode = "User Mode";
$_user_name = "Username";
$_user_pass = "Username & Password";
$_user_profile_list = "Profile List";
$_user_profile = "User Profile";
$_users = "Users";
$_user_user = "Username = Password";
$_validity = "Validity";
$_voucher_code ="Voucher Code";
$_vouchers = "Vouchers";
$_yes = "Yes";





//details
$_format_time_limit = '
    Format '.$_time_limit.'.<br>
    [wdhm] Example : 30d = 30'.$_days.', 12h = 12'.$_hours.', 4w3d = 31'.$_days.'.
';
$_details_add_user = '
    '.$_add_user.' with '.$_time_limit.'.<br>
    Should '.$_time_limit.' < '.$_validity.'.
';

$_details_user_profile = '
'.$_expired_mode.' is the control for the hotspot user.<br>
Options : Remove, Notice, Remove & Record, Notice & Record.
<ul>
<li>Remove: User will be deleted when expires.</li>
<li>Notice: User will not deleted and get notification after user expiration.</li>
<li>Record: Save the price of each user login. To calculate total sales of hotspot users.</li>
</ul>
</p>
        
        <p>'.$_lock_user.' : Username can only be used on 1 device only.</p>
';

$_format_validity = '
Format '.$_validity.'<br>
[wdhm] Example : 30d = 30'.$_days.', 12h = 12'.$_hours.', 30m = 30'.$_minutes.'<br>
5'.$_hours.' 30'.$_minutes.' = 5h30m';

$_format_ip_binding = '
    Format Upload/Download Max Limit<br>
    [k / M] Contoh : 512k, 1500k, 1M<br><br>
    Format '.$_validity.'<br>
    [d] Example: 30d = 30'.$_days.'.<br>
';

$_help_report = '
<ul>
<li>Click CSV to download.</li>
<li>For filters per month, select Day and month, then click Filter.<br>
	<img width="70%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATUAAAAsCAYAAAAEsS/jAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAOlSURBVHhe7d09TtxAGMbxnCYSKOJDCggtqZIqHCRVpFwDiYJj0MARIq2i5QQUW6RH0CJST/x6bM/YM7Z38cfi1//iJ2F7PCvGfp+ZYQs+nH+7MACgBaEGQBVCDYAqhBoAVQg1AKoQagBUaQy1xdfv0fMA8F7VhtrBycLsH382Hz8dYgf2jxh74C2ioXZ4ujB7SVEdn33BjuQPKHYNmJtt6iEINdlyygrt+Ow8aIzxEGqA0ynUBMW0e4Qa4BBqChBqgEOoKUCoAQ6hpgChBjiEmgKEGuAQagoQaoBDqClAqAHOiKF2bZZP/8zLa+jhNtYem+oUardr8/J0by5j14AJGj3UggC7ujePBFsnhBrg7D7UhBTW69rc5MdZ0LnV3LNZXtlrN+vkeH3n3W/7fVxde+em7ffyj/e7W3Iu1lb0GmoNY2+vrc1y9eyue/deyvlSQN6Zh6SNe+bhat09N2nr9f3016yD51rtD3MwZD0MF2rpy5oVT7ByywohL5ZoAHrHCvz4+St4iHIu1lb0FmptY58HXjGp2JDJg6c51LK+vAkpbV+Epm0bXPf7Y1U5S0PWw4Ch1nSt+nKXZ+v0WmnlpoM/OzXNSqK3UIsojX0aat7KLeGvnIMQqjyrQKm/SNvK58lnaVqRY3ND1cPIoZbN3DmvWPyXW36uLZoJ82enpllJ9B9qNWPfU6il9xT9N4Ra6b2Qn8ufjfkYqh7G2X56BVW7rSkKUdrq2nr6ZEZqm5VEf6HWMvYdQ60Is2h/5ba5tE/pX9qW+sbcDFEP43xREFk5xIslKYZV0lbh1jMnM1LbrCS2eYhFSOTn/PFuG/tOoZY9M3+ltUGo2Tb2CwS2nvM2RD0ME2rpS+ud9wOuOPZm90w+60dDcma2eYjV8fVDqXXsW0LNtnfX05ArnlE1tOxx8/ZT2Pem9C0s0GD0UEuLpCR8WYttipCCqhRLqlqAM7ZVqCWC8W265o99W6hV7n9c3ZUnsjwkU9KPDTK7AqsLtdgKEKg3Yqj1TArE30bN2LahNjUSamw9sanJhpqsCGKz+hzpDjVZ4YereaDO9EIt+xscqzRHbahl21VWadjG9EINAbWhBrwBoaYAoQY4hJoChBrgEGoKEGqA0ynU3D8zjt+AcRBqgNMp1MTBycLsHfFf2neJUAOczqEmDk8X6Yot7wzj2k8mldh5AM1qQ03IVjR2HgDeq8ZQA4CpIdQAqEKoAVCFUAOgCqEGQBVCDYAiF+Y/bd3pxgv3MhEAAAAASUVORK5CYII=">
	</li>
	<li>Filter based on '.$_prefix.', fill '.$_prefix.' in the search input, then click filter.</li>
	<li>Filter based on '.$_comment.', fill in !!'.$_comment.' in the  column, then click filter. Or click one of the comments. (Mikhmon Online).</li>
	<li>It is recommended to delete the sales report after download  the CSV report.</li>
	</ul>
';

$_delete_report = '
<ul>
		        <li>Deleting the Selling Report will delete the User Log as well. </li>
		        <li>It is recommended to download '.$_user_log.' first. </li>
		      </ul>
';