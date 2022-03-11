## 项目介绍

快速搭建基于角色权限的管理后台，后端使用hyperf，后台前端基于vue-element-admin开发，前后端分离；

> 支持的给个stars, 有问题的提issue; 定期处理;

演示：`http://demo.colorful.ranblogs.com/admin`
> 账号/密码：admin/a1a1a1

目录：
```
api: 后端代码
admin: 后台前端代码
docker: docker使用到的映射目录和文件
```

## 版本信息
```
php: ">=7.3"

hyperf: "~2.2.0"

vue-element-admin: "4.4.0"
```

## 功能概述

- Jwt认证登录
- 修改密码
- 文件上传(支持本地和阿里云oss)
- 管理员管理
- 菜单管理
- 权限管理
- 角色管理
- 网站设置
- 文章管理
- 管理员操作日志

## 搭建和部署

检查安装docker和docker-compose, 然后执行下面操作即可：
```
git clone https://github.com/taoran1401/colorful-admin.git
cd colorful-admin
./docker-compose up
```

访问地址： `http://127.0.0.1:8080`


## 自定义

如果不想使用默认端口和映射目录可以通过修改`docker-compose.yml`来配置

修改nginx配置：`./docker/conf.d/`

当修改了后台前端代码后`build`项目，重新生成`dist`并给与权限, 命令如下：
```
npm run build:prod
chmod -R 777 dist
```

License
------------
`colorful-admin` is licensed under [The MIT License (MIT)](LICENSE).