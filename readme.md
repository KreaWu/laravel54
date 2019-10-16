该项目是基于laravel54框架搭建的仿简书网站项目；

开发工具：phpstorm+navicat

本项目内容包括
1.Laravel安装及启动

使用composer安装Laravel54：https://pkg.phpcomposer.com/
![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016104022666.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)
安装完成启动Laravel，并修改.env文件配置数据库。

2.Laravel的核心思想：服务容器、服务提供者、门脸模式
[https://laravel.com/api/5.4/](https://laravel.com/api/5.4/)
[https://learnku.com/docs/laravel/5.4](https://learnku.com/docs/laravel/5.4)

3.文章模块：

使用migration 创建文章数据表，ORM创建文章模型，并对项目中的文章模块进行增删改查的操作，使用第三方富文本编辑器对文章进行编辑。
项目中的时间格式：[https://carbon.nesbot.com/docs/](https://carbon.nesbot.com/docs/)
以及使用factory对文章数据表进行批量填充：[https://github.com/fzaninotto/Faker](https://github.com/fzaninotto/Faker)

4.用户模块：

用户注册、使用Auth门脸类实现登录、登出等，通过注册policy策略类对用户授权，实现文章权限控制。

![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016110047502.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)
![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016111230950.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)

5.评论模块/赞模块：

对文章进行评论/赞，实现模型关联，使用withCount实现评论/赞数量。
![Laravel模型关联](https://img-blog.csdnimg.cn/20191016111742262.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)

6.搜索模块：

使用elasticSearch搜索引擎对文章内容及标题进行搜索，[https://github.com/amikey/elasticsearch-rtf](https://github.com/amikey/elasticsearch-rtf)下载elasticsearch，
环境需要JDK8.0+，因此先配置环境[https://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html](https://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html)，官网下载并进行配置即可。
再安装Laravel需要的包：
![在这里插入图片描述](https://img-blog.csdnimg.cn/2019101611535252.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)
自定义Laravel的command：1.创建Command，2.编辑handle，3.挂载
通过自定义es:init命令实现搜索引擎索引和模板的建立；

7.个人中心模块：

渲染个人主页，实现关注/取关功能，利用多对多的关系表实现系列操作（users-fans-users）。

8.专题模块：

创建专题数据表及模型，关联周边模型；

1）由于专题模块属于公共页面，都会用到专题表中的数据，因此使用viewComposer实现公共区域；
![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016121349238.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)
在AppServiceProvider的boot中写入：
```
//注入视图组合器(由于每个页面都会有专题，因此在这边直接将topic数据注入每个页面)
        \View::composer('layout.sidebar', function ($view){
           $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });
```

2）利用laravel中的scope（范围）实现某人对某个专题的投稿，即属于自己的文章，但还未投到该专题的文章：

![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016121727579.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)

```
//使用scope
    //找出属于某个作者的所有文章
    public function scopeAuthorBy(Builder $query, $user_id){
        return $query->where('user_id', $user_id);
    }

    //找出！！不！！属于某个专题的文章
    //先将文章与topic关联
    public function postTopics(){
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }
    //再用scope找出！！不！！属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id){
        return $query->doesntHave('postTopics', 'and', function ($q) use($topic_id){
            $q->where('topic_id', $topic_id);
        });
    }
```

9.后台管理的搭建：

1）基础框架搭建：

使用adiminlte皮肤模板作为后台的view层模板，使用Auth和guard实现后台管理，Auth实现后台的登录。

2）人员管理模块：

实现对后台人员的增加和删除

3）文章审核模块：

修改文章数据表增加status字段，实现对文章状态（通过/不通过/待审核）的追踪，从而实现软删除，而不是硬删除。
使用全局scope：

```
//由于后台修改了表的结构，增加了status，
    //且前台读取数据也将会只读取状态为0和1的，
    //为了不修改前台的任何代码，在此用全局scope的方式，
    //使得前台每次读取posts中的数据时，都会经过下面的过滤

    //即重写boot方法
    protected static function boot(){
        parent::boot();
        static::addGlobalScope('avaiable', function(Builder $builder){//avaiable是该范围的名字,
            $builder->whereIn('status',[0,1]);  //$builder对范围进行具体的定义
    });
    }
```

4）权限管理：

使用Gate实现权限管理，用户-角色-权限，多对多的关联，充分利用集合的属性，取交集/并集/差集等，可轻松实现数据库操作。
![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016123326855.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)
在AuthServiceProvider.php的boot中注册每一个权限：

```
//对每一个权限定义门卫
        $permissions = \App\AdminPermission::all();
        foreach ($permissions as $permission){
            Gate::define($permission->name, function ($user) use($permission){
               return $user->hasPermission($permission);
            });
        }
```

5）专题模块：

对专题进行增删改查，因此路由可以直接使用laravel的Resource，
![在这里插入图片描述](https://img-blog.csdnimg.cn/20191016124610414.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0tyZWFXdQ==,size_16,color_FFFFFF,t_70)

```
//使用resource对专题的路由进行定义,使用resource可以直接定义增删改查一系列路由，当不需要增删改查中的某一些时，可以用only
 //包括：index,create,store,show,edit,update,destory
     Route::resource('topics', '\App\admin\Controllers\TopicController', ['only' => ['index', 'create', 'store', 'destory']]);
```

6）系统通知：

使用数据库队列实现系统通知，

在laravel中修改队列驱动为database；

创建数据库的对列表：php artisan queue:table;

创建任务：php artisan make:job SendMessage,并实现：


```
public function __construct(\App\Notice $notice)
    {
        $this->notice=$notice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //将消息发送给每一个用户
        $users = \App\User::all();
        foreach ($users as $user){
            $user->addNotice($this->notice);
        }
    }
```

在需要发送的地方创建dispatch分发:


```
//创建发送逻辑dispatch（队列发送消息，发送job）
        $this->dispatch(new \App\Jobs\SendMessage($notice));
```

最后启动queue: php artisan queue:work

(后台启动队列：nohup php artisan queue:work >> /地址)


总结：所有的数据库访问最好在后端完成，减少view层对数据库的访问，因此可以使用预加载的方式：with/load;
