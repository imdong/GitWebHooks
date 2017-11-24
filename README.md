# git_webhooks

Git WebHooks 自动部署功能

## 使用方法
修改 config.php 配置项目名称与地址即可.

在 Git 的 WebHooks 里面 调用地址?name=项目名称 即可

例如: http://www.loacl.com/githook.php?name=project_b


## 注意说明

需要为PHP开启 exec 权限，并关闭安全模式

修改 /php/etc/php.ini 文件
搜索 dafe_mode 并将其设置为 off （找不到则可以尝试跳过）
搜索 disable_functions 将 exec 从列表中去掉。

给予 php 以root权限执行命令且不需要密码的权限

编辑 /etc/sudoers
搜索 Defaults requiretty 并注释掉这一行(使用#进行注释)
添加 下面内容到 文件末尾(另起一行) 末尾的sh文件自行修改

www ALL=(root) NOPASSWD:/home/htdocs/webhooks/runShell.sh
