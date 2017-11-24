<?php
/**
 * Git WebHooks 处理
 *
 * @author ImDong <www@qs5.org>
 */

/**
 * 项目列表
 */
$projectList = require './config.php';

/**
 * 项目名称
 */
$name  = $_GET['name'] ?? '';

/**
 * 项目详情
 */
$projectInfo = $projectList[$name] ?? false;

// 项目不存在
if(!$projectInfo) die('Not Project');

/**
 * 项目路径
 */
$projectPath = $projectInfo['path'] ?? false;

/**
 * 事件类型
 */
$eventStr = $_SERVER['HTTP_X_GIT_OSCHINA_EVENT'] ?? 'Push Hook';
$event    = strtolower(str_ireplace(' ', '_', $eventStr));

// 判断是否 POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = file_get_contents("php://input");
    $jsonInfo = json_decode($postData, true);
    // 判断分支
    $refArr = explode('/', $jsonInfo['ref']);
    $branch = end($refArr);
    if(!empty($projectInfo[$branch])){
        $projectPath = $projectInfo[$branch];
    }
}

// 判断目录是否存在
if(!$projectPath) die('Project Not Path!');

// 判断事件类型
switch ($event) {
    // 推送消息
    case 'push_hook':
        $eventType = 'pull';
        break;

    default:
        die('Not Event');
        break;
}

// 测试还是真实回调
$isTest = true;
if(!empty($_SERVER['HTTP_X_GIT_OSCHINA_EVENT']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $isTest = false;
}

// 真实调用启用异步
if(!$isTest){
    // 设置断开连接继续执行
    ignore_user_abort(true);

    // 强制断开客户端连接
    header('Content-Length: 5');
    header('Connection: Close');
    echo "done.";
    echo str_repeat(' ', 65536);
}

/**
 * 执行命令行
 */
$shellStr = sprintf(
    '/usr/bin/sudo ./runShell.sh %s "%s"',
    $eventType, $projectPath
);

// 执行命令
exec($shellStr, $outStr, $retInt);

// 保存日志
$logStr = sprintf(
    "==== [%s] %s ====\nDate Time: %s\nProject Path: %s\n\n%s\n\n",
    $name, $eventStr, date('Y-m-d H:i:s'), $projectPath, implode("\n", $outStr)
);

// 调试模式就直接输出
if($isTest) die($logStr);

/**
 * 日志文件名
 */
$logFilename = sprintf('./log_%s.log', date('Ymd'));

// 写到文件
file_put_contents($logFilename, $logStr, FILE_APPEND);

echo "success.";
