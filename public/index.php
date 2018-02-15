<?php
function adminer_object() {

	class AdminerSoftware extends Adminer {

		function name() {
			return getenv("ADMINER_TITLE")?:parent::name();
		}

		function loginForm() {
		    $dburl = getenv("DATABASE_URL");
		    $url = parse_url($dburl);
            if(!$dburl || !$url){
                echo "no database configuration found. please set env vars with key 'DATABASE_URL'";
                return true;
            }
			?>
            <input type="hidden" name="auth[driver]" value="pgsql">
            <input type="hidden" name="auth[server]" value="<?=$url["host"]??""?>">
            <input type="hidden" name="auth[username]" value="<?=$url["user"]??""?>">
            <input type="hidden" name="auth[password]" value="<?=$url["pass"]??""?>">
            <input type="hidden" name="auth[db]" value="<?=substr($url["path"]??"",1)?>">
			<?php
			echo script("focus(qs('#username'));");
			echo "<p><input type='submit' value='" . lang('Login') . "'>\n";
			echo checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang('Permanent login')) . "\n";
		}
    }

	return new AdminerSoftware;
}

require __DIR__."/adminer-4.6.0.php";