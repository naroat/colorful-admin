## 项目介绍

快速搭建基于角色权限的管理后台，后端使用hyperf，后台前端基于vue-element-admin开发，前后端分离；

> 支持的给个stars, 有问题的提issue; 定期处理;

演示：`http://demo.colorful.ranblogs.com/admin`
> 账号/密码：admin/a1a1a1

目录：
```
api: 后端代码
admin: 后台前端代码
```

### 版本信息
```
php: ">=7.3"

hyperf: "~2.2.0"

vue-element-admin: "4.4.0"
```

### 功能概述

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


```
git clone https://github.com/taoran1401/colorful-admin.git
cd colorful-admin
./docker-compose up

cd admin
npm i
npm run build:prod
```
`docker-compose.yml`根据自己情况配置端口映射和名称

```
git clone https://github.com/taoran1401/colorful-admin.git
# 启动后端
cd colorful-admin/api
composer i
php bin/hyperf start
# 拷贝一份.env.example出来后自行配置env
cp .env.example .env

# 启动后台前端
cd colorful-admin/admin
npm install
npm run dev
```

```

```





### 手动搭建


License
------------
`colorful-admin` is licensed under [The MIT License (MIT)](LICENSE).