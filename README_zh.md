# Indigo

**Indigo** 是一个基于 [Laravel](https://laravel.com/)、[Materialize](http://materializecss.com/)、[Vue.js](https://vuejs.org/) 开发的个人博客项目。

> 其他语言版本: [English](https://github.com/MilesPong/indigo)，[简体中文](https://github.com/MilesPong/indigo/blob/master/README_zh.md)。

## 预览

![screenshot](https://user-images.githubusercontent.com/5867628/37555740-48334dc4-2a27-11e8-973f-f54f96d9e912.png)

## 功能特性

-  基本的博客功能，包括文章、页面、搜索、配置、归档等
-  Markdown 写作支持（编写、导出）
-  回收站功能
-  漂亮的 Material Design 风格，支持响应式
-  整合 Disqus 的评论
-  框架基于 Repository 设计模式构建
-  多驱动支持的浏览计数器
-  Google Drive 文件驱动备份支持
-  Mix 前后端资源分离编译
-  自动化部署 [Deployer](https://github.com/MilesPong/laravel-deployer/blob/indigo/README.md) 整合
-  本地化支持
-  [Docker](https://www.docker.com/) 开发环境支持

由于当前页面可能无法及时更新，更多特性请从持续更新的[变更日志](CHANGELOG.md)中查看。

## 环境要求

目前 **Laravel** 版本为**5.6**，相关基本环境要求请参考[官方文档](https://laravel.com/docs/5.6#server-requirements)说明。

除此之外，本项目另外整合了（或需要配合）大量第三方服务，因此，你可能还需要一些额外的配置来使得这个项目更加顺利地进行，主要的服务列举如下：

- [Algolia](https://www.algolia.com/) (全文索引)
- [Google Drive](https://drive.google.com/) (网盘)
- [Google Analytics](https://analytics.google.com) (流量统计)
- [Slack](https://slack.com/) (协作通讯工具)
- [Disqus](https://disqus.com/) (评论)
- [有道翻译](http://fanyi.youdao.com/openapi)

以上服务的配置请参考**安装说明**的**服务配置**部分或者查看源码对应部分。

## 安装

### 使用 Docker

> **为了避免在开发中遇到环境依赖错误等问题，这里建议采用  [Docker](https://www.docker.com/)  来进行部署。相关使用 Docker 的部署说明可以从[这里](https://github.com/MilesPong/docker-lnmp/blob/indigo/README.md)查看。**

### 配置

```
$ git clone https://github.com/MilesPong/indigo.git
$ cd indigo
$ cp .env.example .env
$ composer install
$ php artisan key:generate
```

修改数据库以及其他第三方服务配置

```
# 中文翻译，用于自动slug
YOUDAO_APP_KEY=
YOUDAO_APP_SECRET=

# Google Analytics
GOOGLE_ANALYTICS_ID=

# 默认禁用访客数据
ENABLE_VISITOR_LOG=false

# 评论驱动
COMMENT_DRIVER=
DISQUS_SHORT_NAME=

# 文件驱动
FILESYSTEM_DRIVER=public

# 用于接受备份失败的邮件通知接收
ADMIN_EMAIL=

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

# 全文索引服务
SCOUT_QUEUE=false
SCOUT_DRIVER=null
```

默认**日志通道**为 `stack`，意味默认将使用 `daily` 和 `slack` 通道，如果你没有配置 `slack`，请修改日志通道为其他，如 `single`。

不要忘记还要建立 `public` 文件系统的**软链接**：

```
$ php artisan storage:link
```

**任务调度**主要包括了**备份**和**保存计数器数据**，如果处于*生产环境*，则应该参考下面进行配置：

```
$ crontab -e
# 添加到末尾
# * * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```

### 数据迁移

```
$ php artisan migrate --seed
```

创建一个**管理员**账户：

```
$ php artisan user:add
```

开发环境中，你或者还需要导入一些**测试数据**：

```
$ php artisan db:seed --class=FakeDataSeeder
```

### 静态资源编译

```
$ npm install
$ npm run dev # Frontend
$ npm run admin-dev # Backend
```

**说明，如果在部署过程中遇到报错问题，请参考对应的日志尝试解决**

## 变更日志

项目的开发遵循 Git 的分支开发模式，一般 `master` 为稳定分支，`develop` 为开发分支。项目的主要功能或重大更新部分请参考每个 [`release`](https://github.com/MilesPong/indigo/releases) 的说明部分，或者你也可以在[这里](CHANGELOG.md)查看到所有的变更记录。

## 待办事项

请在这个 [Gist](https://gist.github.com/MilesPong/7529f9586fb7070a7f4c56360cdf9475) 里查看。

## 链接

-   [Materialize](http://materializecss.com/)
-   [Vue.js](https://vuejs.org/)
-   [Laravel](https://laravel.com/)

## 贡献

欢迎在 [Issue](https://github.com/MilesPong/indigo/issues) 提出你的宝贵意见或者直接向我发起 [Pull Requests](https://github.com/MilesPong/indigo/pulls) 合并请求。

## 感谢

此项目的开发过程中参考了很多优秀开源项目，感谢这些项目的作者们，为开源社区的发展提供了贡献。

## 协议

本项目基于 [MIT License](https://opensource.org/licenses/MIT) 开源协议进行授权。