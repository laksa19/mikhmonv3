<?php
// Copy Paste ke template editor [Settings -> Template Editor].
// Ukuran voucher: 180px x 105px

// ---------- Duration (dari validity, atau timelimit jika validity kosong) ----------
$src = (isset($validity) && $validity != "") ? $validity : (isset($timelimit) ? $timelimit : "");
$w = 0; $d = 0; $h = 0;
if (preg_match_all('/(\d+)([wdh])/', $src, $m, PREG_SET_ORDER)) {
    foreach ($m as $part) {
        if ($part[2] == "w") { $w += (int) $part[1]; }
        elseif ($part[2] == "d") { $d += (int) $part[1]; }
        elseif ($part[2] == "h") { $h += (int) $part[1]; }
    }
}
$days = $w * 7 + $d;
$dur = "";
if ($days > 0) { $dur .= $days . " Day"; }
if ($h > 0) { $dur .= ($dur != "" ? " " : "") . $h . " Hour"; }
if ($dur == "") { $dur = $src; }

// ---------- Data ----------
$dataText = (isset($datalimit) && $datalimit != "" && $datalimit != "0") ? $datalimit : "Unlimited";

// ---------- Price ----------
$pp = explode(" ", trim($price));
$amount = round((float) (isset($pp[1]) ? $pp[1] : $pp[0]));
// ukuran angka harga menyesuaikan jumlah digit supaya tidak keluar banner
$plen = strlen((string) $amount);
if ($plen <= 2) { $pf = 19; $pc = 9; }
elseif ($plen == 3) { $pf = 15; $pc = 7; }
else { $pf = 11; $pc = 6; }

/*
Warna banner harga berdasarkan DURASI paket ($days), bukan harga.
Palet warna profesional & mencolok, satu warna khas per paket:
1 Hari, 3 Hari, 7 Hari, 10 Hari, 15 Hari, 30 Hari.
Tambah paket baru: copy satu baris elseif di bawah, lalu paste sebelum "else".
*/
if ($days == 1) {
    $color = "#0EA5E9"; // 1 Hari - Sky Blue
} elseif ($days == 3) {
    $color = "#10B981"; // 3 Hari - Emerald Green
} elseif ($days == 7) {
    $color = "#0D9488"; // 7 Hari - Deep Teal
} elseif ($days == 10) {
    $color = "#8B5CF6"; // 10 Hari - Violet Purple
} elseif ($days == 15) {
    $color = "#C026D3"; // 15 Hari - Fuchsia Magenta
} elseif ($days == 30) {
    $color = "#7C3AED"; // 30 Hari - Deep Red
}
// else color (default ungu sesuai desain, untuk durasi di luar daftar)
else {
    $color = "#7C3AED";
}

// ---------- Shade helper (untuk gradient footer dinamis berdasarkan $color) ----------
// Dibungkus function_exists supaya aman saat template ini di-include berkali-kali
// (satu kali per voucher) oleh Mikhmon — tanpa ini, voucher ke-2 akan fatal error
// "cannot redeclare function" dan proses render berhenti di voucher pertama.
if (!function_exists('jw_shade')) {
    function jw_shade($hex, $percent) {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $r = (int) max(0, min(255, $r + $r * $percent / 100));
        $g = (int) max(0, min(255, $g + $g * $percent / 100));
        $b = (int) max(0, min(255, $b + $b * $percent / 100));
        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }
}
// Tiga stop gradient footer: gelap -> menengah -> mendekati warna asli paket.
$footerStart = jw_shade($color, -70);
$footerMid   = jw_shade($color, -45);
$footerEnd   = jw_shade($color, -15);
?>
<!--mks-mulai-->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap');
    .jw, .jw * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; -webkit-text-size-adjust: none; }
    .jw { display: inline-block; position: relative; width: 180px; height: 105px; margin:4px 2px; overflow: hidden;
          border: 1px solid #111; border-radius: 5px; background: #F8FAFD;
          font-family: 'Inter', 'Segoe UI', Tahoma, Arial, sans-serif; color: #0A1A3F; vertical-align: top; }
    .jw .abs { position: absolute; }
    .jw .nw { white-space: nowrap; }
    .jw .qrcode { display: block; width: 36px; height: 36px; }
    .jw .qrcode img, .jw .qrcode canvas { width: 100% !important; height: 100% !important; display: block; }
</style>
<div class="jw">

    <!-- Logo + judul -->
    <svg class="abs" style="left:11px;top:3px;" width="18" height="16" viewBox="0 0 48 40" fill="none" stroke="#1F73E8" stroke-width="5.5" stroke-linecap="round">
        <path d="M3.3 17.6 A27 27 0 0 1 44.7 17.6"/>
        <path d="M10.2 23.4 A18 18 0 0 1 37.8 23.4"/>
        <path d="M17.1 29.2 A9 9 0 0 1 30.9 29.2"/>
        <circle cx="24" cy="35.5" r="3" fill="#1F73E8" stroke="none"/>
    </svg>
    <div class="abs nw" style="left:36px;top:3px;font-size:11px;font-weight:800;letter-spacing:-0.15px;line-height:14px;color:#0A1A3F;">JIHAD WIFI</div>
    <div class="abs nw" style="left:36px;top:15px;font-size:5.4px;font-weight:600;letter-spacing:0.85px;line-height:7px;color:#5B6B86;">HOTSPOT VOUCHER</div>

    <!-- Banner harga (bentuk dibuat dengan SVG supaya sudut kiri-bawah rapi) -->
    <div class="abs" style="right:0;top:0;width:69px;height:23.4px;">
        <svg class="abs" style="left:0;top:0;" width="69" height="23.4" viewBox="0 0 130 44">
            <defs>
                <linearGradient id="jwg" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#fff" stop-opacity="0.22"/>
                    <stop offset="1" stop-color="#000" stop-opacity="0.28"/>
                </linearGradient>
            </defs>
            <path d="M34 0 H130 V44 H18 Q-6.6 43.5 6 30 Z" fill="<?php echo $color; ?>"/>
            <path d="M34 0 H130 V44 H18 Q-6.6 43.5 6 30 Z" fill="url(#jwg)"/>
        </svg>
        <div class="abs nw" style="right:8px;top:0;height:23.4px;line-height:23.4px;color:#fff;font-weight:800;text-align:right;">
            <span style="font-size:<?php echo $pc; ?>px;position:relative;top:-3px;margin-right:1px;">৳</span><span style="font-size:<?php echo $pf; ?>px;letter-spacing:-0.5px;"><?php echo $amount; ?></span>
        </div>
    </div>

    <!-- Kotak voucher code -->
    <div class="abs" style="left:10.5px;top:25px;width:90px;height:25px;border-radius:4px;background:linear-gradient(180deg,#F0F3F9 0%,#E9EEF6 100%);"></div>
    <?php if ($v_opsi == "up") { ?>
    <div class="abs nw" style="left:14px;top:27px;font-size:4.5px;font-weight:700;letter-spacing:0.5px;line-height:6px;color:#5B6B86;">USERNAME</div>
    <div class="abs nw" style="left:14px;top:33px;font-size:8.5px;font-weight:800;letter-spacing:-0.15px;line-height:11px;color:#0A1A3F;"><?php echo $username; ?></div>
    <div class="abs nw" style="left:67px;top:27px;font-size:4.5px;font-weight:700;letter-spacing:0.5px;line-height:6px;color:#5B6B86;">PASSWORD</div>
    <div class="abs nw" style="left:67px;top:38px;font-size:8.5px;font-weight:800;letter-spacing:-0.15px;line-height:11px;color:#0A1A3F;"><?php echo $password; ?></div>
    <?php } else { ?>
    <div class="abs nw" style="left:14px;top:26px;font-size:4.5px;font-weight:700;letter-spacing:0.55px;line-height:6px;color:#5B6B86;">VOUCHER CODE</div>
    <div class="abs nw" style="left:13.5px;top:31px;font-size:13px;font-weight:800;letter-spacing:-0.1px;line-height:15px;color:#0A1A3F;"><?php echo $username; ?></div>
    <?php } ?>
    <div class="abs" style="left:14px;top:48px;width:85px;border-bottom:1px dashed #9AA8C0;"></div>

    <!-- Duration -->
    <svg class="abs" style="left:13px;top:53.5px;" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="5" width="18" height="16" rx="3"/>
        <path d="M8 2.5v4M16 2.5v4M3 10h18"/>
        <path d="M8 14h2M12 14h2M8 17.5h2M12 17.5h2" stroke-width="2.4"/>
    </svg>
    <div class="abs nw" style="left:25.5px;top:53px;font-size:4.8px;font-weight:600;line-height:6px;color:#5B6B86;">Duration :</div>
    <div class="abs nw" style="left:25.5px;top:58.5px;font-size:7.4px;font-weight:800;line-height:9.5px;color:<?php echo $color; ?>;"><?php echo $dur; ?></div>

    <!-- Pemisah -->
    <div class="abs" style="left:56px;top:53px;width:0.5px;height:11.5px;background:#C9D1DE;"></div>

    <!-- Data -->
    <svg class="abs" style="left:62px;top:54.5px;" width="11" height="9.5" viewBox="0 0 48 40" fill="none" stroke="#0B9A6B" stroke-width="5.5" stroke-linecap="round">
        <path d="M3.3 17.6 A27 27 0 0 1 44.7 17.6"/>
        <path d="M10.2 23.4 A18 18 0 0 1 37.8 23.4"/>
        <path d="M17.1 29.2 A9 9 0 0 1 30.9 29.2"/>
        <circle cx="24" cy="35.5" r="3" fill="#0B9A6B" stroke="none"/>
    </svg>
    <div class="abs nw" style="left:77px;top:53px;font-size:4.8px;font-weight:600;line-height:6px;color:#5B6B86;">Data :</div>
    <div class="abs nw" style="left:77px;top:58.5px;font-size:7.2px;font-weight:800;line-height:9.5px;color:#0B9A6B;"><?php echo $dataText; ?></div>

    <!-- Pill High Speed (warna dinamis mengikuti durasi, lebar mengikuti teks) -->
    <div class="abs" style="left:11px;top:70px;height:10px;display:flex;align-items:center;gap:2.5px;padding:0 5px 0 3.5px;border-radius:5px;background:<?php echo $color; ?>;">
        <svg width="7" height="7" viewBox="0 0 24 24" fill="#fff" style="display:block;flex:none;">
            <path d="M13.5 1 4 14h6.5L9.5 23 20 9.5h-6.8z"/>
        </svg>
        <span class="nw" style="font-size:4.4px;font-weight:800;letter-spacing:0.3px; color:#fff;">HIGH SPEED INTERNET</span>
    </div>

    <!-- QR code -->
    <div class="abs" style="left:129px;top:26px;width:42px;height:42px;border:1px solid <?php echo $color; ?>;border-radius:4.5px;background:#fff;">
        <div class="abs" style="left:2px;top:2px;"><?= $qrcode ?></div>
    </div>

    <!-- Open WiFi -->
    <svg class="abs" style="left:131px;top:70px;" width="6.5" height="6.5" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round">
        <circle cx="12" cy="12" r="10"/>
        <ellipse cx="12" cy="12" rx="4.2" ry="10"/>
        <path d="M2 12h20M4 7h16M4 17h16"/>
    </svg>
    <div class="abs nw" style="left:139px;top:69.5px;font-size:4.1px;font-weight:600;line-height:5px;color:#5B6B86;">Open WiFi</div>
    <div class="abs nw" style="left:139px;top:74px;font-size:5.4px;font-weight:800;line-height:6.5px;color:#0A1A3F;">jihad.wifi</div>

    <!-- Footer -->
    <div class="abs" style="left:0;bottom:0;width:100%;height:20px;background:linear-gradient(100deg,<?php echo $footerStart; ?> 0%,<?php echo $footerMid; ?> 55%,<?php echo $footerEnd; ?> 100%);"></div>
    <div class="abs" style="left:11.5px;bottom:0;height:20px;display:flex;align-items:center;gap:4px;">
        <div style="width:8px;height:8px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;flex:none;">
            <svg width="4.8" height="4.8" viewBox="0 0 24 24" fill="#0F2557" style="display:block;">
                <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>
            </svg>
        </div>
        <span class="nw" style="font-size:5px;font-weight:500;line-height:8px;color:#fff;">Connect & Enjoy Internet</span>
    </div>
    <div class="abs" style="right:6px;bottom:0;height:20px;display:flex;align-items:center;gap:2.5px;">
        <svg width="5.5" height="5.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:block;flex:none;">
            <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>
        </svg>
        <div style="width:0.5px;height:6px;background:rgba(255,255,255,0.75);flex:none;"></div>
        <span class="nw" style="font-size:6.1px;font-weight:700;letter-spacing:-0.05px;line-height:8px;color:#fff;">01646-348232</span>
    </div>

</div>
<!--mks-akhir-->