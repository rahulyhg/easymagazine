<?php

/*
    Copyright (C) 2009-2012  Fabio Mattei <burattino@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include ('configWriter.php');

$dbName = $_POST['dbname'];
$dbuser = $_POST['username'];
$dbpassword = $_POST['password'];
$dbhost = $_POST['dbhost'];
$tbprefix = $_POST['tbprefix'];
$email = $_POST['email'];

// Calculating the sub folder
$path = $_SERVER['PHP_SELF'];
$position = strpos($path, 'installation');
$folder = substr($path, 0, $position);

//Check for valid mysql connection
$conn = @mysql_connect($dbhost, $dbuser, $dbpassword);
if (!$conn || !is_resource($conn)) {
    header('Location: index.php?error=1');
}
@mysql_close($conn);

ConfigWriter::writeConfigFile($dbName, $dbuser, $dbpassword, $dbhost, $tbprefix, $folder);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
    <head>
        <title>Easy Magazine: Installation Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="MSSmartTagsPreventParsing" content="TRUE" />
        <link href="../admin/resources/css/stylelogin.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="corpoalto">&nbsp;
        </div>
        <div id="intestazione">
            <p class="logo">&nbsp;</p>
            <div class="menu">
                If, for some reason, Easy Magazine is not able to save the file
                <b>system/config.php</b>,
                please set the rights of the <b>easymagazine/system</b> folder and reload
                this page or edit the file
                by hand filling it with the following code:
                <br /><br />
                <CODE>
                    &lt;? <br />
                    define('FOLDER', '<?PHP echo$folder?>'); <br />
                    define('DB_NAME', '<?PHP echo$dbName?>');<br />
                    define('DB_USER', '<?PHP echo$dbuser?>');<br />
                    define('DB_PASSWORD', '<?PHP echo$dbpassword?>');<br />
                    define('DB_HOST', '<?PHP echo$dbhost?>');<br />
                    define('TBPREFIX', '<?PHP echo$tbprefix?>');<br />
                    ?&gt;<br />
                </CODE>
                <br />
                <form name="create" method="post" action="createdb.php">
                <input type="hidden" name="email" value="<?PHP echo $email ?>" />
                After that click here and <input type="submit" value="create the database" name="create the database" />
                </form>
                <br />
            </div>
        </div>
        <div id="corpo">&nbsp;
        </div>
    </body>
</html>