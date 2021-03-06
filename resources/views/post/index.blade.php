@extends("layout.main")
@section("content")
    <div class="col-sm-8 blog-main">
        <div>
            <div id="carousel-example" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example" data-slide-to="1"></li>
                    <li data-target="#carousel-example" data-slide-to="2"></li>
                </ol><!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="http://ww1.sinaimg.cn/large/44287191gw1excbq6tb3rj21400migrz.jpg" alt="..." />
                        <div class="carousel-caption">...</div>
                    </div>
                    <div class="item">
                        <img src="http://ww3.sinaimg.cn/large/44287191gw1excbq5iwm6j21400min3o.jpg" alt="..." />
                        <div class="carousel-caption">...</div>
                    </div>
                    <div class="item">
                        <img src="http://ww2.sinaimg.cn/large/44287191gw1excbq4kx57j21400migs4.jpg" alt="..." />
                        <div class="carousel-caption">...</div>
                    </div>
                </div>
                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="right carousel-control" href="#carousel-example" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
        <div style="height: 20px;">
        </div>
        <div>
            @foreach($posts as $post)
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
                    <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}}<a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></p>
                    {{-- toFormattedDateString()   百度时间格式carbon--}}
                    {!! str_limit($post->content, 100, '...') !!}   {{--字符截断，超出100个用...表示;  {{}}:直接输出内容;  {!!  !!}:内容经过html化，正常显示    --}}
                    <p class="blog-post-meta">赞 {{ $post->zans_count }}  | 评论 {{ $post->comments_count }}</p>
                </div>
            @endforeach


            {{--<ul class="pagination">

                <li class="disabled"><span>&laquo;</span></li>





                <li class="active"><span>1</span></li>
                <li><a href="http://127.0.0.1:8000/posts?page=2">2</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=3">3</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=4">4</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=5">5</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=6">6</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=7">7</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=8">8</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=9">9</a></li>
                <li><a href="http://127.0.0.1:8000/posts?page=10">10</a></li>


                <li><a href="http://127.0.0.1:8000/posts?page=2" rel="next">&raquo;</a></li>
            </ul>
            用一下link可代替，且实际可用
            --}}

            {{ $posts->links() }}

        </div><!-- /.blog-main -->
    </div>

@endsection

