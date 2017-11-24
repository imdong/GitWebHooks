<?php
/**
 * Git WebHooks 项目配置
 *
 * @author ImDong <www@qs5.org>
 */

return [
    // 项目一2
    'project_a' => [
        'path' => '/home/htdocs/project_a/',
        'token' => '56b03be5503c17f44b862ccba63add48'
    ],
    // 项目二 分不同的分支
    'project_b' => [
        'path'     => '/home/htdocs/project_b/develop/',
        'develop'  => '/home/htdocs/project_b/develop/',
        'master'   => '/home/htdocs/project_b/master/',
        'releases' => '/home/htdocs/project_b/releases/',
        'token'    => 'a4bdd5465ab174a4ea03e7a0698f573c'
    ]
];
