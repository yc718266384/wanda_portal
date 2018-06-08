<?php
/**
 * @param string $path 路径
 * @param array $extra 排除条件 字符串数组 类似于 ['css','git']
 * @param array $fileArray ，默认为[]
 * @return array ['files' = [...],'path'=>[..]] || []
 */
function read_dir1($path = '', $extra = [], &$fileArray = [])
{
    if (!$path || !is_dir($path)) {
        return $fileArray;
    }
    $path = str_replace('\\', '/', $path);
    $path = rtrim($path, '/');
    $handler = openDir($path);
    if (!$handler) {
        return $fileArray;
    }
    while (false !== $file = readDir($handler)) {
        if ($file !== '.' && $file !== '..') {
            $flag = true;
            foreach ($extra as $pattern) {
                //  echo  strpos($pattern, '*');
                if (false === strpos($pattern, '*')) {
                    if ($file === $pattern) {
                        $flag = false;
                        break;
                    }
                } else {
                    $pattern = str_replace('*', '[\s\S]*', $pattern);
                    if (preg_match('/' . $pattern . '/', $file)) {
                        $flag = false;
                        break;
                    }
                }
            }
            if ($flag) {
                if (is_dir($path . '/' . $file)) {
                    $fileArray['path'][] = $path . '/' . $file;
                    read_dir1($path . '/' . $file, $extra, $fileArray);
                } else {
                    $fileArray['files'][] = $path . '/' . $file;
                }
            }
        }
    }
    closeDir($handler);
    //写入文件
    return $fileArray;
}

/**
 * @param string $realPath 查询路径 最好是绝对路径
 * @param string $outPath 输出路径 最好是绝对路径
 * @paran string $outFileName        输出文件名  推荐php结尾
 * @param array $extra 排除条件 字符串数组 类似于 ['css','git']
 * @return boolean true | false
 */
function checkOutFiles($realPath = '', $outPath = '', $outFileName = '', $extra = [])
{
    if (!$realPath || !$outPath || !is_dir($realPath) || !is_dir($outPath)) {
        return false;
    }
    //一致性处理 必须要做的  window 和 linux路径统一
    $realPath = realpath($realPath);
    $realPath = str_replace('\\', '/', $realPath);
    $realPath = rtrim($realPath, '/');
    $outPath = realpath($outPath);
    $outPath = str_replace('\\', '/', $outPath);
    $outPath = rtrim($outPath, '/');
    $outfFileRealPath = $outPath . '/' . $outFileName;
    if (is_dir($outfFileRealPath)) {
        @unlink($outfFileRealPath);
    }
    $fileArr = read_dir1($realPath, $extra);
    if (empty($fileArr)) {
        return false;
    }
    try {
        //匹配相对路径并输出
        $files = $fileArr['files'];
        $str = '';
        foreach ($files as $fileName) {
            $str .= str_replace($realPath . '/', '', $fileName) . PHP_EOL;
        }
        file_put_contents($outfFileRealPath, $str);
        return true;
    } catch (\Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

if (checkOutFiles(__DIR__ . '/dist/htdocs', __DIR__ . '/dist/htdocs', 'file.cfg', [
    'readDir.php',
    '.git*',
    'assets',
    'mini*',
    '.ht*',
    '.idea',
    'file.cfg',
])) {
    echo 'success!';
} else {
    echo 'failed!';
};
