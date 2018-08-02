<<<<<<< HEAD
<?php
//把该文件放到WEB根目录下，运行一次可以清除当前目录及所有子目录中所有文件的BOM Header。
    if (isset($_GET['dir'])){ //设置文件目录
        $basedir=$_GET['dir'];
    }else{
        $basedir = '.';
    }
    $auto = 1;
    checkdir($basedir);
    function checkdir($basedir){
        if ($dh = opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..'){
                    if (!is_dir($basedir."/".$file)) {
                        echo "filename: $basedir/$file ".checkBOM("$basedir/$file")." <br>";
                    }else{
                        $dirname = $basedir."/".$file;
                        checkdir($dirname);
                    }
                }
            }
            closedir($dh);
        }
    }
    function checkBOM ($filename) {
        global $auto;
        $contents = file_get_contents($filename);
        $charset = substr($contents, 0, 1);
        $charset = substr($contents, 1, 1);
        $charset = substr($contents, 2, 1);
        if (ord($charset) == 239 && ord($charset) == 187 && ord($charset) == 191) {
            if ($auto == 1) {
                $rest = substr($contents, 3);
                rewrite ($filename, $rest);
                return ("<font color=red>BOM found, automatically removed.</font>");
            } else {
                return ("<font color=red>BOM found.</font>");
            }
        }
        else return ("BOM Not Found.");
    }
    function rewrite ($filename, $data) {
        $filenum = fopen($filename, "w");
        flock($filenum, LOCK_EX);
        fwrite($filenum, $data);
        fclose($filenum);
    }
=======
<?php
//把该文件放到WEB根目录下，运行一次可以清除当前目录及所有子目录中所有文件的BOM Header。
    if (isset($_GET['dir'])){ //设置文件目录
        $basedir=$_GET['dir'];
    }else{
        $basedir = '.';
    }
    $auto = 1;
    checkdir($basedir);
    function checkdir($basedir){
        if ($dh = opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..'){
                    if (!is_dir($basedir."/".$file)) {
                        echo "filename: $basedir/$file ".checkBOM("$basedir/$file")." <br>";
                    }else{
                        $dirname = $basedir."/".$file;
                        checkdir($dirname);
                    }
                }
            }
            closedir($dh);
        }
    }
    function checkBOM ($filename) {
        global $auto;
        $contents = file_get_contents($filename);
        $charset = substr($contents, 0, 1);
        $charset = substr($contents, 1, 1);
        $charset = substr($contents, 2, 1);
        if (ord($charset) == 239 && ord($charset) == 187 && ord($charset) == 191) {
            if ($auto == 1) {
                $rest = substr($contents, 3);
                rewrite ($filename, $rest);
                return ("<font color=red>BOM found, automatically removed.</font>");
            } else {
                return ("<font color=red>BOM found.</font>");
            }
        }
        else return ("BOM Not Found.");
    }
    function rewrite ($filename, $data) {
        $filenum = fopen($filename, "w");
        flock($filenum, LOCK_EX);
        fwrite($filenum, $data);
        fclose($filenum);
    }
>>>>>>> bf841b75f7a17bcbe0192419782a1ed7c86f8fa4
?>