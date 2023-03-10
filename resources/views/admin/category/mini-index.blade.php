@extends('layouts11.backend')

@section('title','文章分类')

@section('header')
    <h1>
        文章分类
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @include('admin.alert.success')
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-header">
                    <div class="pull-right">
                        <div class="btn-group">
                            <a href="{{ route('admin.category.category-create') }}" class="btn btn-white tooltips"
                               data-toggle="tooltip" data-original-title="新增"><i
                                        class="glyphicon glyphicon-plus"></i></a>
                        </div>
                    </div><!-- pull-right -->
                </div>
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover">
                        <tr>
                            <th>序号</th>
                            <th>分类名</th>
                            <th>操作</th>
                        </tr>
                        @if ($categories)
                            <?php $line = 1  ?>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $line }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href='{{ route("admin.category.category-edit", ["id" => $category->objectId]) }}' class='btn btn-info btn-xs'>
                                            <i class="fa fa-pencil"></i> 修改</a>
                                        <a data-href='{{ route("admin.category.category-destroy", ["id" => $category->objectId]) }}'
                                           class='btn btn-danger btn-xs category-delete'><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>
                                </tr>
                                <?php $line++ ?>
                            @endforeach
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(function() {
            $(".category-delete").click(function(){
                var url = $(this).attr('data-href');
                Moell.ajax.delete(url);
            });
        });
    </script>
@endsection
