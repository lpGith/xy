@inject('systemPresenter','App\Presenters\SystemPresenter')

@extends('layouts11.app')

@section('title',$systemPresenter->checkReturnValue('title',$article->title))

@section('description',$systemPresenter->checkReturnValue('seo_desc',$article->desc))

@section('keywords',$systemPresenter->checkReturnValue('seo_keyword',$article->keyword))

@inject('userPresenter','App\Presenters\UserPresenter')
<?php
$author = isset($user->id) ? $user : $userPresenter->getUserInfo();
?>

@section('style')
    <link rel="stylesheet" href="{{ asset('editor.md/css/editormd.preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('share.js/css/share.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('header-text')
    <input type="hidden" id="action">
    <input type="hidden" id="replyid">
    <div class="text-inner">
        <div class="row">
            <div class="col-md-12 to-animate fadeInUp animated">
                <h3 class="color-white">
                    {{ $article->title }}
                </h3>

                <p class=" m-t-25 color-white">
                    <i class="glyphicon glyphicon-calendar"></i>{{ date("Y-m-d" ,strtotime($article->created_at)) }}
                    @if($article->category)
                        <i class="glyphicon glyphicon-th-list"></i>
                        <a href="{{ route('category',['id'=>$article->cate_id]) }}" target="_blank">
                            {{ $article->category->name }}
                        </a>
                    @endif
                </p>
                @if($article->tag)
                    <p class="color-white">
                        <i class="glyphicon glyphicon-tags"></i>&nbsp;
                        @foreach( $article->tag as $tag )
                            <a href="{{ route('tag',['id'=>$tag->id]) }}" target="_blank">
                                {{ $tag->tag_name }}
                            </a>&nbsp;
                        @endforeach
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('admin.alert.success')
    <div class="markdown-body editormd-html-preview" style="padding:0;">
        {!! $article->html_content !!}
    </div>
    <div style="margin-top:20px;">
        <div id="share" class="social-share"></div>
    </div>
    <br><br>
    <p class="z-counter">
    <h4 style="display: inline-block;">?????? {{ $article->comment_count }}</h4>
    <a href="" onclick="return false" style="float:right" data-toggle="modal" data-target="#commentModal"><h4><span class="glyphicon glyphicon-pencil" ></span>????????????</h4></a>
    </p>
    <div class="z-comments" id="commentdiv">
        @foreach ($comments as $comment)
            <hr id="comment{{ $comment->id }}">
            @if( $comment->user_id == 1 )
                <img src="{{ asset('uploads/avatar')."/".$author->user_pic }}" class="img-circle z-avatar">
                <p class="z-name z-center-vertical">{{ $author->name }} <span class="label label-info z-label">??????</span></p>
            @elseif( $comment->website )
                <p class="z-avatar-text"><?php echo $comment['avatar_text'] ? $comment['avatar_text'] : '???' ?></p>
                <a href="{{ $comment->website }}" target="_blank">
                    <p class="z-name"><?php echo $comment['name'] ? $comment['name'] : '??????' ?></p>
                </a>
            @else
                <p class="z-avatar-text"><?php echo $comment['avatar_text'] ? $comment['avatar_text'] : '???' ?></p>
                <p class="z-name"><?php echo $comment['name'] ? $comment['name'] : '??????' ?></p>
            @endif
            <p class="z-content">{{ $comment->content }}</p>
            <p class="z-info">{{ $comment->created_at_diff }} ?? {{ $comment->city }} <span data-toggle="modal" data-target="#commentModal" data-replyid="{{ $comment->id }}" data-replyname="{{ $comment->name }}" data-commentid="{{ $comment->id }}" id="replyid{{ $comment->id }}" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p>
            <div class="z-reply" id="commentid{{ $comment->id }}">
                @foreach( $comment->replys as $reply )
                    @if( $reply->user_id == 1 )
                        <img src="{{ asset('uploads/avatar')."/".$author->user_pic }}" class="img-circle z-avatar">
                        <p class="z-name z-center-vertical">{{ $author->name }} <span class="label label-info z-label">??????</span></p>
                    @elseif( $reply->website )
                        <p class="z-avatar-text"><?php echo $reply['avatar_text'] ? $reply['avatar_text'] : '???' ?></p>
                        <a href="{{ $reply->website }}" target="_blank">
                            <p class="z-name"><?php echo $reply['name'] ? $reply['name'] : '??????' ?></p>
                        </a>
                    @else
                        <p class="z-avatar-text"><?php echo $reply['avatar_text'] ? $reply['avatar_text'] : '???' ?></p>
                        <p class="z-name"><?php echo $reply['name'] ? $reply['name'] : '??????' ?></p>
                    @endif
                    <p class="z-content">?????? <b>{{ $reply->target_name }}</b>???{{ $reply->content }}</p>
                    <p class="z-info">{{ $reply->created_at_diff }} ?? {{ $reply->city }} <span data-toggle="modal" data-target="#commentModal" data-replyid="{{ $comment->id }}" data-replyname="{{ $reply->name }}" data-commentid="{{ $reply->id }}" id="replyid{{ $comment->id }}" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p>
                @endforeach
            </div>
        @endforeach
    </div>
    {{--<strong>????????????</strong>--}}
    {{--@if($systemPresenter->getKeyValue('comment_script') !="")--}}
        {{--<div id="SOHUCS" sid="{{ route('article', ['id' => $article->id]) }}" ></div>--}}
        {{--{!! $systemPresenter->getKeyValue('comment_script') !!}--}}
    {{--@endif--}}


    <!-- comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">????????????</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form1">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputFile">??????</label>
                            <textarea class="form-control" id="contents" name="contents" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">??????</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="[??????] ???????????????" value="{{ $inputs->name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">??????</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="[??????] ??????????????????????????????????????????" value="{{ $inputs->email }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">????????????</label>
                            <input type="text" class="form-control" id="website" name="website" placeholder="[??????] ?????? http:// ??? https:// ???????????????" value="{{ $inputs->website }}">
                        </div>
                        <input type="text" id="parent_id" name="parent_id" style="display:none">
                        <input type="text" id="target_name" name="target_name" style="display:none">
                        <input type="text" id="comment_id" name="comment_id" style="display:none">
                        <input type="text" name="article_id" value="{{ $article->id }}" style="display:none">
                        <input type="submit" id="commentFormBtn"  style="display:none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">??????</button>
                    <button type="button" class="btn btn-primary" onclick="comment()">??????</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('share.js/js/jquery.share.min.js') }}"></script>

    <script>
        $('#commentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            if (button.data('replyid')) {
                var replyid = button.data('replyid')
                var replyname = button.data('replyname') ? button.data('replyname') : '??????'
                var commentid = button.data('commentid')
                var modal = $(this)
                modal.find('#parent_id').val(replyid)
                modal.find('#target_name').val(replyname)
                modal.find('#content').attr("placeholder", "?????? @"+replyname)
                modal.find('#comment_id').val(commentid)
                $('#action').val('reply');
                $('#replyid').val('commentid'+replyid);
            }else {
                var modal = $(this)
                modal.find('#parent_id').val(0)
                modal.find('#target_name').val('')
                modal.find('#content').attr("placeholder", "")
                $('#action').val('comment');
            }
        })

        $(function(){
            $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
        });

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });

        function comment() {
            $content=$('#contents').val();
            if($content==null || $content==''){
                document.getElementById('commentFormBtn').click();
                return false;
            }else{
                if($('#email').val()!=''){
                    var reg1 = /[a-zA-Z0-9]{1,10}@[a-zA-Z0-9]{1,5}/;
                    if(!reg1.test($('#email').val())){
                        document.getElementById('commentFormBtn').click();
                        return false;
                    }
                }
                $.ajax({
                    type: "POST",//????????????
                    dataType: "json",//????????????????????????????????????
                    url: "/comment" ,//url
                    data: $('#form1').serialize(),
                    success: function (result) {
                        console.log(result);//??????????????????????????????(?????????)
                        if (result.resultCode == 200) {
                            $('contents').val('');
                            $('#commentModal').modal('hide');

                            var action=$('#action').val();
                            if(action=='comment'){
                                document.all.commentdiv.insertAdjacentHTML("afterBegin",result.html);
                            }else{
                                var replyid=$('#replyid').val();
                                $('#'+replyid).append(result.html);
                            }
                            $.ajax({
                                type:'GET',
                                dataType:'json',
                                url:'/send',
                                data:{'comment_id':result.comment_id,'article_id':result.article_id},
                                success:function (res) {

                                },
                                error:function () {

                                }
                            });
                        }else{

                        }
                    },
                    error : function() {
                        alert("????????????????????????????????????");
                    }
                });
            }
        }
    </script>

@endsection
